@extends('layouts.master')

@section('title', 'Settings')

@section('content')
{{-- ╔══════════════════════════════════════════════════════════╗
     ║  SETTINGS — Modern tabbed interface with sections        ║
     ╚══════════════════════════════════════════════════════════╝ --}}
<style>
  .settings-grid { 
    display:grid; grid-template-columns:240px 1fr; 
    gap:24px; align-items:start; 
  }
  @media (max-width:968px) { 
    .settings-grid { grid-template-columns:1fr; gap:16px; } 
    .settings-sidebar { order:2; }
  }
  
  .settings-sidebar { 
    position:sticky; top:80px; 
    background:#fff; border-radius:16px; 
    box-shadow:0 1px 3px rgba(0,0,0,0.08); 
    overflow:hidden; border:1px solid #f3f4f6; 
  }
  @media (max-width:968px) { .settings-sidebar { position:static; } }
  
  .tab-nav { display:flex; flex-direction:column; }
  .tab-link { 
    display:flex; align-items:center; gap:10px; 
    padding:14px 18px; font-size:0.85rem; font-weight:600; 
    color:#6b7280; text-decoration:none; 
    border-left:3px solid transparent; 
    transition:all 0.15s; cursor:pointer; 
  }
  .tab-link:hover { 
    background:#f8f9fa; color:#7b0f10; 
    text-decoration:none; 
  }
  .tab-link.active { 
    color:#7b0f10; background:#fff8f8; 
    border-left-color:#7b0f10; 
  }
  .tab-icon { width:16px; text-align:center; }
  
  .settings-content { 
    background:#fff; border-radius:16px; 
    box-shadow:0 1px 3px rgba(0,0,0,0.08); 
    border:1px solid #f3f4f6; 
  }
  .tab-panel { display:none; padding:24px; }
  .tab-panel.active { display:block; }
  .tab-panel h2 { 
    font-size:1.4rem; font-weight:800; color:#1a1209; 
    margin:0 0 16px; 
  }
  .tab-panel p { 
    color:#6b7280; margin:0 0 20px; 
    font-size:0.9rem; line-height:1.6; 
  }
  
  .form-group { margin-bottom:20px; }
  .form-label { 
    display:block; font-size:0.8rem; font-weight:600; 
    color:#374151; margin-bottom:6px; 
  }
  .form-input { 
    width:100%; padding:10px 14px; 
    border:1.5px solid #e5e7eb; border-radius:10px; 
    font-size:0.85rem; color:#1a1209; 
    outline:none; transition:all 0.15s; 
    background:#fafbfc; 
  }
  .form-input:focus { 
    border-color:#7b0f10; 
    box-shadow:0 0 0 3px rgba(123,15,16,0.08); 
    background:#fff; 
  }
  .form-input:read-only { 
    background:#f3f4f6; color:#9ca3af; 
    cursor:not-allowed; 
  }
  .form-select { 
    appearance:none; 
    background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e"); 
    background-repeat:no-repeat; 
    background-position:right 12px center; 
    background-size:16px; 
    padding-right:40px; 
  }
  .form-help { 
    font-size:0.75rem; color:#9ca3af; 
    margin-top:4px; 
  }
  
  .btn-primary { 
    background:#7b0f10; color:#fff; 
    border:none; border-radius:10px; 
    padding:12px 20px; font-size:0.85rem; font-weight:700; 
    cursor:pointer; transition:all 0.15s; 
  }
  .btn-primary:hover { 
    background:#5a0a0b; transform:translateY(-1px); 
    box-shadow:0 4px 12px rgba(123,15,16,0.25); 
  }
  .btn-secondary { 
    background:#f3f4f6; color:#6b7280; 
    border:none; border-radius:10px; 
    padding:10px 16px; font-size:0.8rem; font-weight:600; 
    cursor:pointer; transition:all 0.15s; 
  }
  .btn-secondary:hover { 
    background:#e5e7eb; color:#374151; 
  }
  .btn-danger { 
    background:#ef4444; color:#fff; 
    border:none; border-radius:10px; 
    padding:10px 16px; font-size:0.8rem; font-weight:600; 
    cursor:pointer; transition:all 0.15s; 
  }
  .btn-danger:hover { 
    background:#dc2626; transform:translateY(-1px); 
    box-shadow:0 4px 12px rgba(239,68,68,0.25); 
  }
  .btn-warning { 
    background:#f59e0b; color:#fff; 
    border:none; border-radius:10px; 
    padding:10px 16px; font-size:0.8rem; font-weight:600; 
    cursor:pointer; transition:all 0.15s; 
  }
  .btn-warning:hover { 
    background:#d97706; transform:translateY(-1px); 
    box-shadow:0 4px 12px rgba(245,158,11,0.25); 
  }
  
  .switch-group { 
    display:flex; justify-content:space-between; 
    align-items:flex-start; padding:16px 0; 
    border-bottom:1px solid #f3f4f6; 
  }
  .switch-group:last-child { border-bottom:none; }
  .switch-info { flex:1; }
  .switch-title { 
    font-size:0.9rem; font-weight:600; color:#1a1209; 
    margin:0 0 4px; 
  }
  .switch-desc { 
    font-size:0.8rem; color:#9ca3af; margin:0; 
  }
  .toggle-switch { 
    position:relative; display:inline-block; 
    width:48px; height:24px; flex-shrink:0; 
  }
  .toggle-switch input { opacity:0; width:0; height:0; }
  .toggle-slider { 
    position:absolute; cursor:pointer; 
    top:0; left:0; right:0; bottom:0; 
    background:#d1d5db; border-radius:24px; 
    transition:0.3s; 
  }
  .toggle-slider:before { 
    position:absolute; content:""; 
    height:18px; width:18px; left:3px; bottom:3px; 
    background:#fff; border-radius:50%; 
    transition:0.3s; 
  }
  input:checked + .toggle-slider { background:#7b0f10; }
  input:checked + .toggle-slider:before { transform:translateX(24px); }
  
  .danger-zone { 
    background:#fef2f2; border:1px solid #fecaca; 
    border-radius:16px; padding:20px; 
  }
  .danger-zone h2 { color:#991b1b; }
  .danger-item { 
    padding:16px 0; border-bottom:1px solid #fecaca; 
  }
  .danger-item:last-child { border-bottom:none; }
  .danger-title { 
    font-size:0.9rem; font-weight:600; color:#991b1b; 
    margin:0 0 4px; 
  }
  .danger-desc { 
    font-size:0.8rem; color:#b91c1c; margin:0 0 12px; 
  }
  
  .avatar-section { 
    display:flex; align-items:center; gap:16px; 
    padding:16px; background:#f8f9fa; 
    border-radius:12px; margin-bottom:20px; 
  }
  .avatar-current { 
    width:72px; height:72px; border-radius:50%; 
    border:3px solid #7b0f10; flex-shrink:0; 
  }
  .avatar-info h3 { 
    font-size:1rem; font-weight:700; color:#1a1209; 
    margin:0 0 4px; 
  }
  .avatar-info p { 
    font-size:0.8rem; color:#6b7280; margin:0 0 8px; 
  }
  
  @media (max-width:968px) {
    .tab-nav { flex-direction:row; overflow-x:auto; }
    .tab-link { 
      flex-shrink:0; border-left:none; border-bottom:3px solid transparent; 
      white-space:nowrap; 
    }
    .tab-link.active { border-left:none; border-bottom-color:#7b0f10; }
  }
</style>

<div class="px-4 md:px-6 py-5 max-w-6xl mx-auto">

  {{-- ── HEADER ── --}}
  <div class="mb-6">
    <h1 class="text-2xl font-black text-gray-900 mb-2">Settings</h1>
    <p class="text-gray-400">Manage your account preferences and privacy settings</p>
  </div>

  <div class="settings-grid">

    {{-- ══ SIDEBAR NAVIGATION ══ --}}
    <div class="settings-sidebar">
      <nav class="tab-nav">
        <a href="#account" class="tab-link active" onclick="switchTab('account', this)">
          <i class="fas fa-user tab-icon"></i> Account
        </a>
        <a href="#notifications" class="tab-link" onclick="switchTab('notifications', this)">
          <i class="fas fa-bell tab-icon"></i> Notifications
        </a>
        <a href="#privacy" class="tab-link" onclick="switchTab('privacy', this)">
          <i class="fas fa-shield-alt tab-icon"></i> Privacy & Security
        </a>
        <a href="#preferences" class="tab-link" onclick="switchTab('preferences', this)">
          <i class="fas fa-cog tab-icon"></i> Preferences
        </a>
        <a href="#danger" class="tab-link" onclick="switchTab('danger', this)" style="color:#dc2626;">
          <i class="fas fa-exclamation-triangle tab-icon"></i> Danger Zone
        </a>
      </nav>
    </div>

    {{-- ══ MAIN CONTENT AREA ══ --}}
    <div class="settings-content">

      {{-- ═══ ACCOUNT TAB ═══ --}}
      <div id="account" class="tab-panel active">
        <h2>Account Settings</h2>
        <p>Update your personal information and account details.</p>

        {{-- Avatar section --}}
        <div class="avatar-section">
          <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff&bold=true&size=72" 
               alt="Your avatar" class="avatar-current">
          <div class="avatar-info">
            <h3>Profile Picture</h3>
            <p>Your avatar is automatically generated from your name</p>
            <button class="btn-secondary">
              <i class="fas fa-camera mr-1"></i> Change Avatar
            </button>
          </div>
        </div>

        <form class="space-y-4">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" value="{{ auth()->user()->name }}" class="form-input" placeholder="Enter your full name">
          </div>
          
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" value="{{ auth()->user()->email }}" class="form-input" readonly>
            <p class="form-help">
              <i class="fas fa-lock mr-1"></i> Email is managed through your UB account and cannot be changed here
            </p>
          </div>
          
          <div class="form-group">
            <label class="form-label">Department</label>
            <select class="form-input form-select">
              <option>College of Engineering</option>
              <option>College of Business</option>
              <option>College of Liberal Arts</option>
              <option>College of Science</option>
              <option>College of Nursing</option>
              <option>College of Education</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label">Student ID</label>
            <input type="text" placeholder="Enter your student ID" class="form-input">
            <p class="form-help">Optional: Helps verify your UB student status</p>
          </div>
          
          <button type="submit" class="btn-primary">
            <i class="fas fa-save mr-2"></i> Save Changes
          </button>
        </form>
      </div>

      {{-- ═══ NOTIFICATIONS TAB ═══ --}}
      <div id="notifications" class="tab-panel">
        <h2>Notification Settings</h2>
        <p>Choose what notifications you'd like to receive and how you'd like to receive them.</p>

        <div class="space-y-0">
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Trade Notifications</p>
              <p class="switch-desc">Get notified when someone sends you a trade proposal</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Message Notifications</p>
              <p class="switch-desc">Get notified when you receive a new message</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Wishlist Updates</p>
              <p class="switch-desc">Get notified when wishlisted items become available or change</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Weekly Digest</p>
              <p class="switch-desc">Receive a weekly summary of your trading activity</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox">
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Marketing Communications</p>
              <p class="switch-desc">Receive tips, feature updates, and campus announcements</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox">
              <span class="toggle-slider"></span>
            </label>
          </div>
        </div>
      </div>

      {{-- ═══ PRIVACY TAB ═══ --}}
      <div id="privacy" class="tab-panel">
        <h2>Privacy & Security</h2>
        <p>Control your privacy settings and manage your account security.</p>

        <div class="space-y-0">
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Profile Visibility</p>
              <p class="switch-desc">Allow other users to see your public profile</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Show Online Status</p>
              <p class="switch-desc">Let others see when you're active on UBarter</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Trade History Visibility</p>
              <p class="switch-desc">Show your successful trades to build trust with other users</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
        </div>

        <div style="margin-top:32px; padding-top:24px; border-top:1px solid #f3f4f6;">
          <div class="form-group">
            <label class="form-label">Change Password</label>
            <p class="form-help" style="margin-top:0; margin-bottom:12px;">
              Your password is managed through the UB authentication system
            </p>
            <button class="btn-secondary">
              <i class="fas fa-key mr-2"></i> Update Password via UB Portal
            </button>
          </div>
          
          <div class="form-group">
            <label class="form-label">Two-Factor Authentication</label>
            <p class="form-help" style="margin-top:0; margin-bottom:12px;">
              Add an extra layer of security to your account
            </p>
            <button class="btn-secondary">
              <i class="fas fa-shield-alt mr-2"></i> Enable 2FA
            </button>
          </div>
        </div>
      </div>

      {{-- ═══ PREFERENCES TAB ═══ --}}
      <div id="preferences" class="tab-panel">
        <h2>Preferences</h2>
        <p>Customize your UBarter experience and interface preferences.</p>

        <div class="form-group">
          <label class="form-label">Language</label>
          <select class="form-input form-select">
            <option>English</option>
            <option>Filipino</option>
          </select>
        </div>
        
        <div class="form-group">
          <label class="form-label">Time Zone</label>
          <select class="form-input form-select">
            <option>Asia/Manila (UTC+8)</option>
          </select>
        </div>
        
        <div class="form-group">
          <label class="form-label">Items per Page</label>
          <select class="form-input form-select">
            <option>12 items</option>
            <option>24 items</option>
            <option>48 items</option>
          </select>
        </div>

        <div style="margin-top:24px;">
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Compact View</p>
              <p class="switch-desc">Use a more compact layout to see more items at once</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox">
              <span class="toggle-slider"></span>
            </label>
          </div>
          
          <div class="switch-group">
            <div class="switch-info">
              <p class="switch-title">Auto-refresh Chat</p>
              <p class="switch-desc">Automatically check for new messages every few seconds</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
        </div>
        
        <button class="btn-primary">
          <i class="fas fa-save mr-2"></i> Save Preferences
        </button>
      </div>

      {{-- ═══ DANGER ZONE TAB ═══ --}}
      <div id="danger" class="tab-panel">
        <div class="danger-zone">
          <h2>Danger Zone</h2>
          <p style="color:#991b1b;">These actions are permanent and cannot be undone. Please proceed with caution.</p>

          <div class="danger-item">
            <p class="danger-title">Deactivate Account</p>
            <p class="danger-desc">
              Temporarily deactivate your account. Your data will be preserved and you can reactivate anytime by logging back in.
            </p>
            <button class="btn-warning">
              <i class="fas fa-pause-circle mr-2"></i> Deactivate Account
            </button>
          </div>

          <div class="danger-item">
            <p class="danger-title">Delete Account</p>
            <p class="danger-desc">
              Permanently delete your account and all associated data including items, trades, messages, and reviews. This action cannot be undone.
            </p>
            <button class="btn-danger">
              <i class="fas fa-trash-alt mr-2"></i> Delete Account
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
function switchTab(tabId, element) {
  // Hide all panels
  document.querySelectorAll('.tab-panel').forEach(panel => {
    panel.classList.remove('active');
  });
  
  // Remove active class from all links
  document.querySelectorAll('.tab-link').forEach(link => {
    link.classList.remove('active');
  });
  
  // Show selected panel
  document.getElementById(tabId).classList.add('active');
  
  // Add active class to clicked link
  element.classList.add('active');
  
  // Prevent default link behavior
  return false;
}

// Handle URL hash for direct linking
window.addEventListener('DOMContentLoaded', function() {
  const hash = window.location.hash.substring(1);
  if (hash) {
    const targetTab = document.querySelector(`[onclick*="${hash}"]`);
    if (targetTab) {
      switchTab(hash, targetTab);
    }
  }
});
</script>
@endsection