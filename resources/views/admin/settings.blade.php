@extends('layouts.master')
@section('title', 'System Settings')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
.config-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;padding:20px;}
@media(max-width:900px){.config-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:600px){.config-grid{grid-template-columns:1fr;}}
.config-card{border-radius:12px;padding:18px;border:1px solid #f0f0f0;transition:box-shadow 0.15s;}
.config-card:hover{box-shadow:0 4px 12px rgba(0,0,0,0.08);}
.config-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;}
.config-title{font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 5px;}
.config-desc{font-size:0.72rem;color:#9ca3af;margin:0 0 14px;line-height:1.5;}
.config-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border:none;border-radius:8px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.15s;color:#fff;}
.config-btn:hover{opacity:0.85;transform:translateY(-1px);}

.form-label{display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:6px;}
.form-input{width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-size:0.85rem;outline:none;transition:border-color 0.15s;background:#fafafa;}
.form-input:focus{border-color:#7b0f10;background:#fff;}
.form-select{appearance:none;background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right 10px center;background-size:14px;padding-right:32px;}
.form-group{margin-bottom:16px;}
.save-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;background:#7b0f10;color:#fff;border:none;border-radius:10px;font-size:0.82rem;font-weight:700;cursor:pointer;transition:all 0.15s;}
.save-btn:hover{background:#5a0a0b;transform:translateY(-1px);box-shadow:0 4px 12px rgba(123,15,16,0.25);}

.switch-row{display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f3f4f6;}
.switch-row:last-child{border-bottom:none;}
.switch-info{}
.switch-title{font-size:0.85rem;font-weight:600;color:#1a1209;margin:0 0 2px;}
.switch-desc{font-size:0.72rem;color:#9ca3af;margin:0;}
.toggle{position:relative;display:inline-block;width:44px;height:22px;flex-shrink:0;}
.toggle input{opacity:0;width:0;height:0;}
.toggle-slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#d1d5db;border-radius:22px;transition:0.3s;}
.toggle-slider:before{position:absolute;content:"";height:16px;width:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:0.3s;}
input:checked + .toggle-slider{background:#7b0f10;}
input:checked + .toggle-slider:before{transform:translateX(22px);}

.status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:0.7rem;font-weight:700;}
</style>

<div class="aw">
  <div style="margin-bottom:4px;">
    <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 2px;">Admin Control Panel</h1>
  </div>

  
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ── 8.3 CONFIG CARDS ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#374151;">8.3</span>
      <h2>Configure Dashboard &amp; System Settings</h2>
    </div>
    <div class="config-grid">
      @foreach([
        ['fa-cog',           'Platform Configuration',  'Manage item categories, condition labels, and global platform defaults.',      '#374151', '#f9fafb'],
        ['fa-shield-alt',    'Moderation Rules',         'Set content policies, donation approval thresholds, and auto-moderation.',     '#7b0f10', '#fff8f8'],
        ['fa-bell',          'System Announcements',     'Broadcast platform-wide messages to all registered UB students.',             '#3b82f6', '#eff6ff'],
        ['fa-envelope',      'Email Notifications',      'Configure automated email triggers for approvals, suspensions, and alerts.',   '#8b5cf6', '#f5f3ff'],
        ['fa-database',      'Data Retention',           'Set how long trade history, messages, and logs are kept on the platform.',     '#0ea5e9', '#f0f9ff'],
        ['fa-life-ring',     'Support & Help Desk',      'Manage the student support queue and admin response templates.',               '#16a34a', '#f0fdf4'],
      ] as $c)
        <div class="config-card" style="background:{{ $c[4] }};">
          <div class="config-icon" style="background:{{ $c[3] }};">
            <i class="fas {{ $c[0] }}" style="color:#fff;font-size:0.95rem;"></i>
          </div>
          <p class="config-title">{{ $c[1] }}</p>
          <p class="config-desc">{{ $c[2] }}</p>
          <button class="config-btn" style="background:{{ $c[3] }};">
            <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i> Configure
          </button>
        </div>
      @endforeach
    </div>
  </div>

  {{-- ── PLATFORM SETTINGS FORM ── --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

    {{-- General --}}
    <div class="sec">
      <div class="sec-hd">
        <i class="fas fa-sliders-h" style="color:#374151;font-size:0.85rem;"></i>
        <h2>General Settings</h2>
      </div>
      <div style="padding:20px;">
        <div class="form-group">
          <label class="form-label">Platform Name</label>
          <input type="text" class="form-input" value="UBARTER 2.0">
        </div>
        <div class="form-group">
          <label class="form-label">Institution</label>
          <input type="text" class="form-input" value="University of Batangas">
        </div>
        <div class="form-group">
          <label class="form-label">Default Item Approval</label>
          <select class="form-input form-select">
            <option selected>Manual Review</option>
            <option>Auto-Approve All</option>
            <option>Auto-Approve Verified Users</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Max Images per Item</label>
          <select class="form-input form-select">
            <option>1 image</option>
            <option selected>3 images</option>
            <option>5 images</option>
          </select>
        </div>
        <button class="save-btn"><i class="fas fa-save"></i> Save General Settings</button>
      </div>
    </div>

    {{-- Feature Toggles --}}
    <div class="sec">
      <div class="sec-hd">
        <i class="fas fa-toggle-on" style="color:#7b0f10;font-size:0.85rem;"></i>
        <h2>Feature Toggles</h2>
      </div>
      <div style="padding:0 20px;">
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">Allow Barter Trades</p>
            <p class="switch-desc">Users can propose and accept barter exchanges</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">Allow Donations</p>
            <p class="switch-desc">Users can post items as free donations</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">Eco Leaderboard</p>
            <p class="switch-desc">Display sustainability rankings to users</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">Ratings & Reviews</p>
            <p class="switch-desc">Allow users to rate each other after trades</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">In-App Messaging</p>
            <p class="switch-desc">Enable the chat system between users</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
        <div class="switch-row">
          <div class="switch-info">
            <p class="switch-title">New User Registrations</p>
            <p class="switch-desc">Allow new UB students to register</p>
          </div>
          <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
      </div>
      <div style="padding:16px 20px;border-top:1px solid #f3f4f6;">
        <button class="save-btn"><i class="fas fa-save"></i> Save Toggles</button>
      </div>
    </div>

  </div>

  {{-- ── SYSTEM STATUS ── --}}
  <div class="sec">
    <div class="sec-hd">
      <i class="fas fa-heartbeat" style="color:#16a34a;font-size:0.85rem;"></i>
      <h2>System Status</h2>
      <span style="margin-left:auto;">
        <span class="status-badge" style="background:#dcfce7;color:#166534;">
          <span style="width:7px;height:7px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
          All Systems Operational
        </span>
      </span>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0;padding:0;">
      @foreach([
        ['Database',        'Online',  '#dcfce7', '#166534', 'fa-database'],
        ['File Storage',    'Online',  '#dcfce7', '#166534', 'fa-hdd'],
        ['UB SSO (Google)', 'Online',  '#dcfce7', '#166534', 'fa-shield-alt'],
        ['Email Service',   'Online',  '#dcfce7', '#166534', 'fa-envelope'],
      ] as $svc)
        <div style="padding:16px 20px;border-right:1px solid #f3f4f6;text-align:center;">
          <i class="fas {{ $svc[4] }}" style="font-size:1.2rem;color:#9ca3af;margin-bottom:8px;display:block;"></i>
          <p style="font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 4px;">{{ $svc[0] }}</p>
          <span class="status-badge" style="background:{{ $svc[2] }};color:{{ $svc[3] }};font-size:0.65rem;">
            {{ $svc[1] }}
          </span>
        </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
