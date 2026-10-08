@extends('layouts.master')

@section('title', 'Eco Leaderboard - UBarter 2.0')

@section('content')
<style>
*{box-sizing:border-box;}

.lb-wrap { max-width:1100px; margin:0 auto; padding:20px 16px 40px; }

/* ─── HERO BANNER ─── */
.lb-hero {
  background: linear-gradient(135deg, #14532d 0%, #166534 40%, #15803d 100%);
  border-radius: 20px;
  padding: 28px 32px;
  color: #fff;
  position: relative;
  overflow: hidden;
  margin-bottom: 20px;
}
.lb-hero::before {
  content:'';
  position:absolute; inset:0;
  background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  background-size:60px 60px;
}
.lb-hero-content { position:relative; z-index:1; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; }

/* ─── STAT CARDS ─── */
.stat-row { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
@media(max-width:900px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }
.stat-card { background:#fff; border-radius:14px; padding:16px 18px; box-shadow:0 1px 4px rgba(0,0,0,0.07); border-top:4px solid transparent; }

/* ─── PERIOD TABS ─── */
.period-tabs { display:flex; gap:6px; }
.period-btn {
  padding:7px 16px; border-radius:10px; font-size:0.75rem; font-weight:700;
  border:2px solid rgba(255,255,255,0.3); color:rgba(255,255,255,0.7);
  background:rgba(255,255,255,0.08); cursor:pointer; transition:all 0.15s;
}
.period-btn.active, .period-btn:hover {
  background:rgba(255,255,255,0.2); color:#fff; border-color:rgba(255,255,255,0.6);
}

/* ─── LEADERBOARD TABLE ─── */
.lb-card { background:#fff; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden; margin-bottom:20px; }
.lb-header { background:linear-gradient(90deg,#166534,#15803d); padding:16px 22px; }
.lb-header h2 { font-size:1rem; font-weight:800; color:#fff; margin:0 0 2px; }
.lb-header p { font-size:0.72rem; color:rgba(255,255,255,0.7); margin:0; }

.lb-row {
  display:flex; align-items:center; gap:16px;
  padding:14px 22px; border-bottom:1px solid #f9fafb;
  transition:background 0.12s;
}
.lb-row:hover { background:#f0fdf4; }
.lb-row.top-row { background:linear-gradient(90deg,rgba(245,197,24,0.05),transparent); }
.lb-row.my-row { background:linear-gradient(90deg,rgba(22,163,74,0.06),rgba(22,163,74,0.02)); border-left:3px solid #16a34a; }

/* rank badge */
.rank-badge {
  width:36px; height:36px; border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:1rem; flex-shrink:0;
}
.rank-num {
  width:36px; height:36px; border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:0.8rem; font-weight:800; flex-shrink:0;
  color:#fff;
}

/* avatar */
.lb-avatar { width:40px; height:40px; border-radius:50%; flex-shrink:0; border:2.5px solid #e5e7eb; }

/* name section */
.lb-info { flex:1; min-width:0; }
.lb-name { font-size:0.88rem; font-weight:700; color:#1a1209; margin:0 0 2px; }
.lb-sub  { font-size:0.68rem; color:#9ca3af; margin:0; }

/* progress */
.lb-progress-wrap { flex:1; max-width:200px; }
.lb-progress-track { height:7px; background:#e5e7eb; border-radius:999px; overflow:hidden; margin-bottom:3px; }
.lb-progress-fill  { height:100%; background:linear-gradient(90deg,#166534,#22c55e); border-radius:999px; transition:width 1s ease; }

/* right column */
.lb-right { text-align:right; flex-shrink:0; min-width:80px; }
.lb-kg    { font-size:1rem; font-weight:800; color:#166534; margin:0; }
.lb-delta { font-size:0.65rem; color:#9ca3af; margin:2px 0 0; }
.lb-delta.positive { color:#16a34a; }

/* ─── YOUR STATS + ACHIEVEMENTS ─── */
.bottom-grid { display:grid; grid-template-columns:1fr 320px; gap:16px; margin-bottom:20px; }
@media(max-width:900px){ .bottom-grid{ grid-template-columns:1fr; } }

.your-stats-card {
  background:linear-gradient(135deg,rgba(245,197,24,0.08),rgba(123,15,16,0.04));
  border:2px solid #f5c518;
  border-radius:16px; padding:22px;
}
.your-stat-num { font-size:1.8rem; font-weight:900; margin:0 0 2px; }
.your-stat-lbl { font-size:0.65rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em; }

.ach-card { background:#fff; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.07); padding:20px; }
.ach-row {
  display:flex; align-items:center; gap:12px;
  padding:10px; border-radius:10px; margin-bottom:6px;
  transition:background 0.12s;
}
.ach-row:hover { background:#f9fafb; }
.ach-row.locked { opacity:0.4; filter:grayscale(1); }

/* ─── TIPS ─── */
.tips-card {
  background:linear-gradient(90deg,#f0fdf4,#eff6ff);
  border-left:4px solid #22c55e;
  border-radius:16px; padding:20px;
}
</style>

<div class="lb-wrap">

  {{-- ── HERO ── --}}
  <div class="lb-hero">
    <div class="lb-hero-content">
      <div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
          <div style="width:38px;height:38px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-leaf" style="font-size:1.1rem;"></i>
          </div>
          <span style="font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.12em;opacity:0.75;">UBarter Platform</span>
        </div>
        <h1 style="font-size:1.7rem;font-weight:900;margin:0 0 6px;line-height:1.1;">Eco Leaderboard 🌿</h1>
        <p style="font-size:0.82rem;opacity:0.8;margin:0;line-height:1.5;">See who's making the biggest environmental impact through campus bartering!</p>
      </div>
      <div>
        <div class="period-tabs">
          <button class="period-btn active">This Week</button>
          <button class="period-btn">This Month</button>
          <button class="period-btn">All Time</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ── STATS ROW ── --}}
  <div class="stat-row">
    <div class="stat-card" style="border-top-color:#22c55e;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Total Waste Diverted</p>
      <p style="font-size:1.8rem;font-weight:900;color:#166534;margin:0;line-height:1;">2,847<span style="font-size:1rem;font-weight:700;opacity:0.7;margin-left:3px;">kg</span></p>
      <p style="font-size:0.65rem;color:#9ca3af;margin:4px 0 0;">Since UBarter launch</p>
    </div>
    <div class="stat-card" style="border-top-color:#f5c518;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Active Participants</p>
      <p style="font-size:1.8rem;font-weight:900;color:#7b0f10;margin:0;line-height:1;">342</p>
      <p style="font-size:0.65rem;color:#9ca3af;margin:4px 0 0;">Students trading items</p>
    </div>
    <div class="stat-card" style="border-top-color:#7b0f10;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Trades Completed</p>
      <p style="font-size:1.8rem;font-weight:900;color:#7b0f10;margin:0;line-height:1;">891</p>
      <p style="font-size:0.65rem;color:#9ca3af;margin:4px 0 0;">Successful exchanges</p>
    </div>
    <div class="stat-card" style="border-top-color:#3b82f6;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Your Ranking</p>
      <p style="font-size:1.8rem;font-weight:900;color:#2563eb;margin:0;line-height:1;">#47</p>
      <p style="font-size:0.65rem;color:#9ca3af;margin:4px 0 0;">Keep trading to climb!</p>
    </div>
  </div>

  {{-- ── LEADERBOARD TABLE ── --}}
  <div class="lb-card">
    <div class="lb-header">
      <h2>🏆 Top Eco Warriors — This Week</h2>
      <p>Ranked by kilograms of waste diverted from campus landfills</p>
    </div>

    @php
      $leaders = [
        [1,'🥇','Alex Chen','ECE','28.5 kg',100,'+8.2 kg','Consistent donor · 12 trades','rank-1'],
        [2,'🥈','Maria Santos','BSN','24.0 kg',84,'+5.1 kg','Group trades organizer · 8 trades','rank-2'],
        [3,'🥉','James Reyes','IT','22.3 kg',78,'+3.9 kg','Tech enthusiast · 7 trades','rank-3'],
        [4,'4','Sofia Garcia','CAS','20.5 kg',72,'+2.8 kg','Active negotiator · 10 trades',''],
        [5,'5','John Dela Cruz','ME','18.6 kg',65,'+4.2 kg','New trader · 5 trades',''],
        [6,'6','Ana Lim','BUS','16.1 kg',57,'+1.5 kg','Business student · 4 trades',''],
        [7,'7','Rico Tan','EE','15.3 kg',54,'+2.1 kg','Electrical engineer · 6 trades',''],
      ];
      $rankColors = ['','','',
        'background:linear-gradient(135deg,#3b82f6,#1d4ed8)',
        'background:linear-gradient(135deg,#8b5cf6,#6d28d9)',
        'background:linear-gradient(135deg,#ec4899,#be185d)',
        'background:linear-gradient(135deg,#14b8a6,#0f766e)',
      ];
      $deptColors = ['ECE'=>'#dbeafe:#1d4ed8','BSN'=>'rgba(123,15,16,0.08):#7b0f10','IT'=>'#dbeafe:#1d4ed8','CAS'=>'#f3e8ff:#7c3aed','ME'=>'#fee2e2:#991b1b','BUS'=>'#fef9c3:#92400e','EE'=>'#d1fae5:#065f46'];
    @endphp

    @foreach($leaders as $i => $l)
      @php
        $isTop = $l[0] <= 3;
        $dc = explode(':', $deptColors[$l[3]] ?? '#f3f4f6:#374151');
        $bg = $dc[0]; $fg = $dc[1];
      @endphp
      <div class="lb-row {{ $isTop ? 'top-row' : '' }}">
        {{-- Rank --}}
        @if($l[0] <= 3)
          <div class="rank-badge">{{ $l[1] }}</div>
        @else
          <div class="rank-num" style="{{ $rankColors[$l[0]] ?? 'background:#9ca3af' }};">{{ $l[1] }}</div>
        @endif

        {{-- Avatar --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode($l[2]) }}&background={{ $l[0]<=3?'f5c518':'7b0f10' }}&color={{ $l[0]<=3?'7b0f10':'fff' }}&bold=true&size=40"
             alt="{{ $l[2] }}" class="lb-avatar"
             style="{{ $l[0]===1 ? 'border-color:#f5c518;' : '' }}">

        {{-- Info --}}
        <div class="lb-info">
          <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;">
            <p class="lb-name">{{ $l[2] }}</p>
            <span style="font-size:0.6rem;font-weight:700;padding:2px 7px;border-radius:999px;background:{{ $bg }};color:{{ $fg }};">{{ $l[3] }}</span>
            @if($l[0] === 1)
              <span style="font-size:0.58rem;font-weight:700;background:#fef9c3;color:#92400e;padding:2px 7px;border-radius:999px;">👑 Leader</span>
            @endif
          </div>
          <p class="lb-sub">{{ $l[7] }}</p>

          {{-- progress bar --}}
          <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
            <div class="lb-progress-track" style="flex:1;max-width:180px;">
              <div class="lb-progress-fill" style="width:{{ $l[5] }}%;"></div>
            </div>
            <span style="font-size:0.62rem;font-weight:700;color:#6b7280;">{{ $l[4] }}</span>
          </div>
        </div>

        {{-- Right --}}
        <div class="lb-right">
          <p class="lb-kg">{{ $l[4] }}</p>
          <p class="lb-delta positive">{{ $l[6] }} <span style="color:#9ca3af;">this week</span></p>
        </div>
      </div>
    @endforeach
  </div>

  {{-- ── YOUR STATS + ACHIEVEMENTS ── --}}
  <div class="bottom-grid">

    {{-- Your Stats --}}
    <div class="your-stats-card">
      <h2 style="font-size:0.95rem;font-weight:800;color:#7b0f10;margin:0 0 16px;display:flex;align-items:center;gap:7px;">
        <i class="fas fa-user-circle"></i> Your Impact Stats
      </h2>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;">
        @foreach([['#47','#7b0f10','Your Rank'],['14.5 kg','#16a34a','Waste Diverted'],['12','#f5c518','Items Traded'],['4.9/5','#3b82f6','Trust Score']] as $s)
          <div style="background:rgba(255,255,255,0.7);border-radius:12px;padding:14px;">
            <p class="your-stat-num" style="color:{{ $s[1] }};">{{ $s[0] }}</p>
            <p class="your-stat-lbl">{{ $s[2] }}</p>
          </div>
        @endforeach
      </div>
      <div style="margin-top:14px;padding:12px;background:rgba(255,255,255,0.6);border-radius:12px;">
        <p style="font-size:0.72rem;color:#6b7280;margin:0 0 6px;font-weight:600;">Progress to #40</p>
        <div style="height:8px;background:#e5e7eb;border-radius:999px;overflow:hidden;">
          <div style="width:58%;height:100%;background:linear-gradient(90deg,#7b0f10,#f5c518);border-radius:999px;"></div>
        </div>
        <p style="font-size:0.65rem;color:#9ca3af;margin:4px 0 0;">5.3 kg more to reach rank #40</p>
      </div>
    </div>

    {{-- Achievements --}}
    <div class="ach-card">
      <h3 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:7px;">
        <i class="fas fa-trophy" style="color:#f5c518;"></i> Achievements
      </h3>
      @foreach([
        ['🌱','First Trade','Completed your first exchange!',false,'#dcfce7'],
        ['🌿','Eco Advocate','10 successful trades',false,'#dcfce7'],
        ['🌳','Power Trader','25 trades completed',false,'#fef9c3'],
        ['🏆','Eco Legend','Divert 50 kg of waste',true,'#f3f4f6'],
        ['👑','Hall of Fame','Reach Top 10 ranking',true,'#f3f4f6'],
      ] as $ach)
        <div class="ach-row {{ $ach[3] ? 'locked' : '' }}" style="background:{{ !$ach[3] ? $ach[4] : '' }};">
          <span style="font-size:1.3rem;flex-shrink:0;">{{ $ach[0] }}</span>
          <div style="flex:1;min-width:0;">
            <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0;">{{ $ach[1] }}</p>
            <p style="font-size:0.65rem;color:{{ $ach[3] ? '#9ca3af' : '#6b7280' }};margin:1px 0 0;">{{ $ach[2] }}</p>
          </div>
          @if(!$ach[3])
            <i class="fas fa-check-circle" style="color:#16a34a;font-size:0.9rem;flex-shrink:0;"></i>
          @else
            <i class="fas fa-lock" style="color:#d1d5db;font-size:0.8rem;flex-shrink:0;"></i>
          @endif
        </div>
      @endforeach
    </div>
  </div>

  {{-- ── TIPS ── --}}
  <div class="tips-card">
    <h3 style="font-size:0.9rem;font-weight:800;color:#166534;margin:0 0 14px;display:flex;align-items:center;gap:7px;">
      <i class="fas fa-lightbulb" style="color:#22c55e;"></i> How to Boost Your Eco Impact
    </h3>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
      @foreach(['Post items you no longer need — reduce campus waste!','Complete trades weekly — consistency boosts your ranking','Leave honest reviews — build community trust','Organize group trades — bigger impact together'] as $tip)
        <div style="display:flex;align-items:flex-start;gap:8px;">
          <div style="width:18px;height:18px;background:#22c55e;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
            <i class="fas fa-check" style="color:#fff;font-size:0.55rem;"></i>
          </div>
          <span style="font-size:0.75rem;color:#374151;line-height:1.4;">{{ $tip }}</span>
        </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
