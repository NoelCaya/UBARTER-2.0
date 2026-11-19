<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') - UBarter 2.0</title>

  {{-- ── PWA META TAGS ── --}}
  <meta name="application-name" content="UBarter 2.0">
  <meta name="description" content="The official barter marketplace of the University of Batangas">

  {{-- Theme --}}
  <meta name="theme-color" content="#7b0f10">
  <meta name="msapplication-navbutton-color" content="#7b0f10">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  {{-- iOS PWA --}}
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="UBarter">
  <meta name="mobile-web-app-capable" content="yes">

  {{-- Splash / Icons --}}
  <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="192x192" href="/images/icons/icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/icon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/icon-72x72.png">

  {{-- Manifest --}}
  <link rel="manifest" href="/manifest.json">

  {{-- Open Graph --}}
  <meta property="og:title" content="UBarter 2.0">
  <meta property="og:description" content="Barter marketplace for UB students">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ config('app.url') }}">
  <meta property="og:image" content="/images/icons/icon-512x512.png">

  {{-- Assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    html { scroll-behavior: smooth; }
    body { color: #1a1209; margin: 0; padding: 0; overflow-x: hidden; }

    #main-content {
      padding-top: 4rem;
      min-height: 100vh;
      background: #f9fafb;
      /* Safe area for notched phones */
      padding-bottom: env(safe-area-inset-bottom);
    }
    @media (min-width: 768px) {
      #main-content { margin-left: 240px; }
    }

    /* ── PWA Install Banner ── */
    #pwa-install-banner {
      display: none;
      position: fixed;
      bottom: 0; left: 0; right: 0;
      z-index: 9999;
      background: #fff;
      border-top: 1px solid #f3f4f6;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.12);
      padding: 14px 20px calc(14px + env(safe-area-inset-bottom));
      align-items: center;
      gap: 12px;
    }
    #pwa-install-banner.show { display: flex; }
    .pwa-banner-icon {
      width: 44px; height: 44px; border-radius: 10px;
      background: #7b0f10; color: #fff;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; font-size: 1.1rem;
    }
    .pwa-banner-text { flex: 1; min-width: 0; }
    .pwa-banner-text strong {
      display: block; font-size: 0.88rem;
      font-weight: 800; color: #1a1209;
    }
    .pwa-banner-text span {
      font-size: 0.72rem; color: #6b7280;
    }
    .pwa-install-btn {
      background: #7b0f10; color: #fff;
      border: none; border-radius: 10px;
      padding: 9px 16px; font-size: 0.78rem;
      font-weight: 700; cursor: pointer;
      white-space: nowrap; flex-shrink: 0;
      transition: background 0.15s;
    }
    .pwa-install-btn:hover { background: #5a0a0b; }
    .pwa-dismiss-btn {
      background: none; border: none;
      color: #9ca3af; font-size: 1.1rem;
      cursor: pointer; padding: 4px;
      flex-shrink: 0;
    }

    /* ── Update available toast ── */
    #pwa-update-toast {
      display: none;
      position: fixed;
      top: 70px; right: 16px;
      z-index: 9999;
      background: #1a1209;
      color: #fff;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 0.82rem;
      font-weight: 600;
      box-shadow: 0 4px 16px rgba(0,0,0,0.2);
      align-items: center;
      gap: 10px;
      max-width: 300px;
    }
    #pwa-update-toast.show { display: flex; }
    .pwa-update-btn {
      background: #7b0f10; color: #fff;
      border: none; border-radius: 7px;
      padding: 5px 12px; font-size: 0.75rem;
      font-weight: 700; cursor: pointer;
      white-space: nowrap;
    }
  </style>
</head>
<body class="bg-gray-50 antialiased">

  {{-- Navigation --}}
  @include('components.navbar')

  {{-- Sidebar --}}
  @if(auth()->check())
    @include('components.sidebar')
  @endif

  {{-- Main Content --}}
  <main id="main-content">
    @yield('content')
  </main>

  {{-- ── PWA Install Banner ── --}}
  <div id="pwa-install-banner">
    <div class="pwa-banner-icon">
      <i class="fas fa-store"></i>
    </div>
    <div class="pwa-banner-text">
      <strong>Install UBarter</strong>
      <span>Add to home screen for quick access</span>
    </div>
    <button class="pwa-install-btn" id="pwa-install-btn">Install</button>
    <button class="pwa-dismiss-btn" id="pwa-dismiss-btn" aria-label="Dismiss">✕</button>
  </div>

  {{-- ── Update Available Toast ── --}}
  <div id="pwa-update-toast">
    <span>🔄 Update available</span>
    <button class="pwa-update-btn" id="pwa-update-btn">Reload</button>
  </div>

  {{-- ── Service Worker + PWA Logic ── --}}
  <script>
    // ─── Register Service Worker ─────────────────────────────────────────────
    let swRegistration = null;
    let newWorker      = null;

    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { scope: '/' })
          .then(reg => {
            swRegistration = reg;

            // Check for updates
            reg.addEventListener('updatefound', () => {
              newWorker = reg.installing;
              newWorker?.addEventListener('statechange', () => {
                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                  document.getElementById('pwa-update-toast').classList.add('show');
                }
              });
            });
          })
          .catch(err => console.warn('SW registration failed:', err));

        navigator.serviceWorker.addEventListener('controllerchange', () => {
          window.location.reload();
        });
      });
    }

    // Reload on update
    document.getElementById('pwa-update-btn')?.addEventListener('click', () => {
      newWorker?.postMessage({ action: 'skipWaiting' });
    });

    // ─── Install Prompt (Android Chrome / Edge) ───────────────────────────────
    let deferredPrompt = null;

    window.addEventListener('beforeinstallprompt', e => {
      e.preventDefault();
      deferredPrompt = e;

      // Don't show if already dismissed or installed
      if (localStorage.getItem('pwa-banner-dismissed')) return;
      if (window.matchMedia('(display-mode: standalone)').matches) return;

      document.getElementById('pwa-install-banner').classList.add('show');
    });

    document.getElementById('pwa-install-btn')?.addEventListener('click', async () => {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      const { outcome } = await deferredPrompt.userChoice;
      deferredPrompt = null;
      document.getElementById('pwa-install-banner').classList.remove('show');
      if (outcome === 'accepted') {
        localStorage.setItem('pwa-banner-dismissed', '1');
      }
    });

    document.getElementById('pwa-dismiss-btn')?.addEventListener('click', () => {
      document.getElementById('pwa-install-banner').classList.remove('show');
      localStorage.setItem('pwa-banner-dismissed', '1');
    });

    // ─── iOS Safari install hint (no beforeinstallprompt on iOS) ─────────────
    const isIos     = /iphone|ipad|ipod/i.test(navigator.userAgent);
    const isInApp   = window.matchMedia('(display-mode: standalone)').matches;
    const dismissed = localStorage.getItem('pwa-ios-dismissed');

    if (isIos && !isInApp && !dismissed) {
      const banner = document.getElementById('pwa-install-banner');
      banner.querySelector('.pwa-banner-text strong').textContent = 'Install UBarter on iOS';
      banner.querySelector('.pwa-banner-text span').textContent =
        'Tap the Share button then "Add to Home Screen"';
      banner.querySelector('#pwa-install-btn').style.display = 'none';
      banner.classList.add('show');

      document.getElementById('pwa-dismiss-btn')?.addEventListener('click', () => {
        localStorage.setItem('pwa-ios-dismissed', '1');
      }, { once: true });
    }
  </script>

</body>
</html>
