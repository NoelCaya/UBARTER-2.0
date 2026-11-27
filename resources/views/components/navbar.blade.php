<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 w-full bg-white border-b-2 border-[#7b0f10] shadow-sm" style="height: 4rem; z-index: 1000;">
    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex items-center space-x-2.5 hover:opacity-80 transition">
                    <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo" class="w-9 h-9 object-contain rounded-full border-2 border-[#7b0f10]" style="max-width:36px;max-height:36px;">
                    <div class="hidden sm:block leading-tight">
                        <span class="text-base font-bold text-[#7b0f10] block">UBARTER</span>
                        <span class="text-xs text-gray-500 block">University of Batangas</span>
                    </div>
                </a>
            </div>

            <!-- Center — Search bar (authenticated only) -->
            @if(auth()->check())
                <div class="hidden md:flex flex-1 mx-6 max-w-sm">
                    <form method="GET" action="{{ route('items.search') }}" class="relative w-full">
                        <input type="text" name="q" placeholder="Search items..."
                               class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7b0f10] transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Right Section -->
            <div class="flex items-center space-x-2">
                @auth
                    <!-- Notifications Bell — real count (#16) -->
                    <div class="relative">
                        <button id="notificationsBtn"
                                class="relative p-2 text-gray-500 hover:text-[#7b0f10] hover:bg-gray-100 rounded-full transition"
                                title="Notifications">
                            <i class="far fa-bell text-lg"></i>
                            <span id="notifBadge"
                                  class="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-white flex items-center justify-center"
                                  style="font-size:0.55rem;font-weight:800;display:none;">0</span>
                        </button>

                        <div id="notificationsDropdown"
                             class="hidden absolute right-0 top-full mt-2 z-50 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-bold text-gray-900 text-sm">Notifications</h3>
                                <button onclick="markAllRead()" class="text-xs text-[#7b0f10] font-bold hover:underline">Mark all read</button>
                            </div>
                            <div id="notifList" class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                <div class="px-4 py-6 text-center text-gray-400 text-sm">No notifications yet</div>
                            </div>
                            <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50 text-center">
                                <span class="text-xs text-gray-400">Updates every 5 seconds</span>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm text-[#7b0f10] font-bold hover:text-[#5a0a0b] transition">Login</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition text-sm font-bold">Register</a>
                @endauth
            </div>

        </div>
    </div>
</nav>

@auth
<script>
// ── Notification icons per type ──────────────────────────────────────────────
const NOTIF_ICONS = {
    message:                  { icon: 'fa-comment',          bg: '#dbeafe', color: '#2563eb' },
    new_trade:                { icon: 'fa-exchange-alt',     bg: 'rgba(123,15,16,0.1)', color: '#7b0f10' },
    trade_accepted:           { icon: 'fa-handshake',        bg: '#dcfce7', color: '#16a34a' },
    trade_rejected:           { icon: 'fa-times-circle',     bg: '#fee2e2', color: '#dc2626' },
    trade_completed:          { icon: 'fa-check-circle',     bg: '#dcfce7', color: '#16a34a' },
    trade_completion_pending: { icon: 'fa-hourglass-half',   bg: '#fef9c3', color: '#92400e' },
    item_approved:            { icon: 'fa-check-circle',     bg: '#dcfce7', color: '#16a34a' },
    item_rejected:            { icon: 'fa-ban',              bg: '#fee2e2', color: '#dc2626' },
    account_suspended:        { icon: 'fa-user-slash',       bg: '#fee2e2', color: '#dc2626' },
    account_reactivated:      { icon: 'fa-user-check',       bg: '#dcfce7', color: '#16a34a' },
    report_response:          { icon: 'fa-flag',             bg: '#fff7ed', color: '#c2410c' },
    report_resolved:          { icon: 'fa-check-circle',     bg: '#dcfce7', color: '#16a34a' },
    report_dismissed:         { icon: 'fa-times-circle',     bg: '#f3f4f6', color: '#6b7280' },
};

function renderNotifications(data) {
    const badge = document.getElementById('notifBadge');
    const list  = document.getElementById('notifList');

    // Update badge
    if (data.count > 0) {
        badge.style.display = 'flex';
        badge.textContent   = data.count > 9 ? '9+' : data.count;
    } else {
        badge.style.display = 'none';
    }

    // Update dropdown list
    if (!data.notifications.length) {
        list.innerHTML = '<div class="px-4 py-6 text-center text-gray-400 text-sm">No notifications yet</div>';
        return;
    }

    list.innerHTML = data.notifications.map(n => {
        const icon = NOTIF_ICONS[n.type] || { icon: 'fa-bell', bg: '#f3f4f6', color: '#374151' };
        const unreadStyle = n.read ? '' : 'background:#fafafa;';
        const url  = n.url || '#';
        return `
        <a href="${url}" onclick="markRead(${n.id}, this)" data-id="${n.id}"
           class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition no-underline"
           style="${unreadStyle}text-decoration:none;color:inherit;">
            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                 style="background:${icon.bg}">
                <i class="fas ${icon.icon} text-xs" style="color:${icon.color}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 m-0">${n.title}</p>
                <p class="text-xs text-gray-500 mt-0.5 m-0">${n.body}</p>
                <p class="text-xs text-gray-400 mt-1 m-0">${n.time}</p>
            </div>
            ${!n.read ? '<div class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-2"></div>' : ''}
        </a>`;
    }).join('');
}

function markRead(id, el) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
    });
    // Remove unread dot immediately
    el?.querySelector('.bg-red-500.rounded-full')?.remove();
    el.style.background = '';
}

function markAllRead() {
    fetch('/notifications/read-all', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
    }).then(() => pollNotifications());
}

// Poll every 5 seconds for near-real-time updates
function pollNotifications() {
    fetch('/notifications/poll')
        .then(r => r.json())
        .then(renderNotifications)
        .catch(() => {});
}

pollNotifications(); // initial load
setInterval(pollNotifications, 5000);

// Toggle dropdown
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('notificationsBtn');
    const drop = document.getElementById('notificationsDropdown');

    btn?.addEventListener('click', function(e) {
        e.stopPropagation();
        drop.classList.toggle('hidden');
        // Mark all read when opening
        if (!drop.classList.contains('hidden')) {
            setTimeout(markAllRead, 2000);
        }
    });
    document.addEventListener('click', () => drop?.classList.add('hidden'));
    drop?.addEventListener('click', e => e.stopPropagation());
});
</script>
@endauth
