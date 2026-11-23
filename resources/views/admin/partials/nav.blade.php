{{-- Admin sub-navigation — included at top of every admin page --}}
<div style="background:#fff;border-bottom:1px solid #f3f4f6;padding:0 20px;margin-bottom:20px;display:flex;align-items:center;gap:4px;overflow-x:auto;">
    @php
        $adminNav = [
            ['admin.dashboard',  'fa-chart-bar',          'Overview'],
            ['admin.users',      'fa-users',               'User Management'],
            ['admin.donations',  'fa-hand-holding-heart',  'Donations'],
            ['admin.donations.claims', 'fa-hand-paper',    'Claim Requests'],
            ['admin.barters',    'fa-exchange-alt',        'Barter Monitor'],
            ['admin.reports',    'fa-flag',                'Reports'],
            ['admin.settings',   'fa-cog',                 'Settings'],
        ];
    @endphp
    @foreach($adminNav as $nav)
        @php $active = request()->routeIs($nav[0]); @endphp
        <a href="{{ route($nav[0]) }}"
           style="display:inline-flex;align-items:center;gap:7px;
                  padding:12px 16px;white-space:nowrap;
                  font-size:0.8rem;font-weight:700;text-decoration:none;
                  border-bottom:3px solid {{ $active ? '#7b0f10' : 'transparent' }};
                  color:{{ $active ? '#7b0f10' : '#6b7280' }};
                  transition:color 0.15s;"
           onmouseover="if(!{{ $active ? 'true' : 'false' }})this.style.color='#374151'"
           onmouseout="if(!{{ $active ? 'true' : 'false' }})this.style.color='#6b7280'">
            <i class="fas {{ $nav[1] }}" style="font-size:0.75rem;"></i>
            {{ $nav[2] }}
        </a>
    @endforeach
    {{-- Messages link with unread count --}}
    @php
        $navMsgUnread = auth()->check()
            ? \App\Models\Message::whereHas('conversation', function($q){
                $q->where('user_one_id', auth()->id())->orWhere('user_two_id', auth()->id());
              })->where('sender_id', '!=', auth()->id())->whereNull('read_at')->count()
            : 0;
        $navMsgActive = request()->routeIs('chat.*');
    @endphp
    <a href="{{ route('chat.index') }}"
       style="display:inline-flex;align-items:center;gap:7px;
              padding:12px 16px;white-space:nowrap;position:relative;
              font-size:0.8rem;font-weight:700;text-decoration:none;
              border-bottom:3px solid {{ $navMsgActive ? '#7b0f10' : 'transparent' }};
              color:{{ $navMsgActive ? '#7b0f10' : '#6b7280' }};
              transition:color 0.15s;"
       onmouseover="if(!{{ $navMsgActive ? 'true' : 'false' }})this.style.color='#374151'"
       onmouseout="if(!{{ $navMsgActive ? 'true' : 'false' }})this.style.color='#6b7280'">
        <i class="fas fa-comments" style="font-size:0.75rem;"></i>
        Messages
        @if($navMsgUnread > 0)
            <span style="background:#ef4444;color:#fff;font-size:0.6rem;font-weight:800;padding:1px 5px;border-radius:999px;line-height:1.4;margin-left:2px;">
                {{ $navMsgUnread > 9 ? '9+' : $navMsgUnread }}
            </span>
        @endif
    </a>
</div>
