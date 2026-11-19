// UBarter 2.0 — Service Worker
const CACHE_VERSION  = 'ubarter-v1';
const STATIC_CACHE   = `${CACHE_VERSION}-static`;
const DYNAMIC_CACHE  = `${CACHE_VERSION}-dynamic`;

// Core assets to cache on install
const STATIC_ASSETS = [
  '/',
  '/dashboard',
  '/items/browse',
  '/offline',
  '/manifest.json',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
];

// ─── INSTALL ─────────────────────────────────────────────────────────────────
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(STATIC_CACHE).then(cache => {
      return cache.addAll(STATIC_ASSETS).catch(() => {
        // Silently fail for assets that don't exist yet
      });
    })
  );
  self.skipWaiting();
});

// ─── ACTIVATE ────────────────────────────────────────────────────────────────
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys
          .filter(key => key !== STATIC_CACHE && key !== DYNAMIC_CACHE)
          .map(key => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

// ─── FETCH ───────────────────────────────────────────────────────────────────
self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-GET, non-http requests, and POST/admin routes
  if (request.method !== 'GET') return;
  if (!url.protocol.startsWith('http')) return;
  if (url.pathname.startsWith('/admin')) return;

  // API / data requests — network first, fallback to cache
  if (
    url.pathname.startsWith('/chat/poll') ||
    url.pathname.startsWith('/api/')
  ) {
    event.respondWith(networkFirst(request));
    return;
  }

  // HTML pages — network first, fallback to cache, fallback to offline page
  if (request.headers.get('Accept')?.includes('text/html')) {
    event.respondWith(
      fetch(request)
        .then(response => {
          const clone = response.clone();
          caches.open(DYNAMIC_CACHE).then(cache => cache.put(request, clone));
          return response;
        })
        .catch(() => {
          return caches.match(request).then(cached => {
            return cached || caches.match('/offline');
          });
        })
    );
    return;
  }

  // Static assets (CSS, JS, images, fonts) — cache first
  event.respondWith(
    caches.match(request).then(cached => {
      if (cached) return cached;
      return fetch(request).then(response => {
        if (response.ok) {
          const clone = response.clone();
          caches.open(DYNAMIC_CACHE).then(cache => cache.put(request, clone));
        }
        return response;
      });
    })
  );
});

// ─── HELPERS ─────────────────────────────────────────────────────────────────
async function networkFirst(request) {
  try {
    const response = await fetch(request);
    const cache    = await caches.open(DYNAMIC_CACHE);
    cache.put(request, response.clone());
    return response;
  } catch {
    const cached = await caches.match(request);
    return cached || new Response(JSON.stringify({ error: 'Offline' }), {
      headers: { 'Content-Type': 'application/json' }
    });
  }
}

// ─── PUSH NOTIFICATIONS (future-ready) ───────────────────────────────────────
self.addEventListener('push', event => {
  if (!event.data) return;
  const data = event.data.json();
  self.registration.showNotification(data.title || 'UBarter', {
    body:  data.body  || 'You have a new notification',
    icon:  '/images/icons/icon-192x192.png',
    badge: '/images/icons/icon-72x72.png',
    data:  { url: data.url || '/dashboard' },
  });
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data?.url || '/dashboard')
  );
});
