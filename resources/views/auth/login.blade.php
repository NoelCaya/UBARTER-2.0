<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UBarter 2.0 — University of Batangas</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --ub-maroon: #7b0f10;
      --ub-maroon-dark: #5a0a0b;
      --ub-maroon-light: rgba(123,15,16,0.08);
      --ub-gold: #f5c518;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }

    /* ── PAGE SHELL ── */
    .login-page {
      min-height: 100vh;
      display: grid;
      grid-template-rows: auto 1fr auto;
      background: #fafafa;
      position: relative;
    }

    /* Geometric decorative blobs */
    .bg-blob {
      position: fixed;
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 0;
    }
    .bg-blob-1 {
      width: 600px; height: 600px;
      background: rgba(123,15,16,0.07);
      top: -200px; right: -150px;
    }
    .bg-blob-2 {
      width: 400px; height: 400px;
      background: rgba(245,197,24,0.08);
      bottom: -100px; left: -100px;
    }

    /* ── NAVBAR ── */
    .ub-nav {
      position: relative;
      z-index: 10;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(12px);
      border-bottom: 2px solid var(--ub-maroon);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.5rem;
      height: 3.75rem;
    }
    .ub-brand {
      display: flex; align-items: center; gap: 0.6rem;
      text-decoration: none; color: inherit;
    }
    .ub-brand img {
      width: 34px; height: 34px; border-radius: 50%;
      border: 2px solid var(--ub-maroon); object-fit: cover;
    }
    .ub-brand-name { font-weight: 800; font-size: 1rem; color: var(--ub-maroon); display: block; line-height: 1.1; }
    .ub-brand-sub  { font-size: 0.65rem; color: #888; display: block; }
    .ub-nav-links  { display: flex; align-items: center; gap: 0.25rem; }
    .ub-nav-link {
      padding: 0.35rem 0.75rem; font-size: 0.8rem; font-weight: 500;
      color: #444; text-decoration: none; border-radius: 8px;
      transition: background 0.15s, color 0.15s;
    }
    .ub-nav-link:hover { background: var(--ub-maroon-light); color: var(--ub-maroon); }
    @media (max-width: 600px) { .ub-nav-link { display: none; } }

    /* ── HERO / BODY ── */
    .login-body {
      position: relative; z-index: 1;
      display: flex; align-items: center; justify-content: center;
      padding: 2.5rem 1rem;
    }

    /* ── SPLIT CARD ── */
    .login-card-wrap {
      display: flex;
      width: 100%;
      max-width: 900px;
      min-height: 520px;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 8px 48px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.06);
      overflow: hidden;
    }

    /* Left brand panel */
    .login-brand-panel {
      flex: 1;
      background: linear-gradient(145deg, var(--ub-maroon) 0%, #3d0607 100%);
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      color: #fff;
      position: relative;
      overflow: hidden;
    }
    .login-brand-panel::before {
      content: '';
      position: absolute;
      top: -80px; right: -80px;
      width: 300px; height: 300px;
      background: rgba(245,197,24,0.12);
      border-radius: 50%;
    }
    .login-brand-panel::after {
      content: '';
      position: absolute;
      bottom: -60px; left: -60px;
      width: 220px; height: 220px;
      background: rgba(255,255,255,0.05);
      border-radius: 50%;
    }
    .brand-logo-row {
      display: flex; align-items: center; gap: 0.75rem;
      position: relative; z-index: 1;
    }
    .brand-logo-row img {
      width: 48px; height: 48px; border-radius: 50%;
      border: 2.5px solid rgba(245,197,24,0.6);
    }
    .brand-logo-name  { font-size: 1.4rem; font-weight: 800; display: block; }
    .brand-logo-sub   { font-size: 0.75rem; opacity: 0.7; display: block; }
    .brand-headline {
      position: relative; z-index: 1;
    }
    .brand-headline h1 {
      font-size: 2rem; font-weight: 900; line-height: 1.2;
      margin: 0 0 1rem;
    }
    .brand-headline h1 span { color: var(--ub-gold); }
    .brand-headline p {
      font-size: 0.875rem; opacity: 0.75; line-height: 1.7;
      margin: 0 0 1.5rem;
    }
    .brand-pills {
      display: flex; flex-wrap: wrap; gap: 0.5rem;
      position: relative; z-index: 1;
    }
    .brand-pill {
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.18);
      border-radius: 999px;
      padding: 0.3rem 0.9rem;
      font-size: 0.72rem; font-weight: 600;
      display: flex; align-items: center; gap: 0.4rem;
    }
    .brand-trust {
      position: relative; z-index: 1;
      font-size: 0.7rem; opacity: 0.6;
      display: flex; align-items: center; gap: 0.4rem;
    }

    /* Right form panel */
    .login-form-panel {
      width: 380px;
      padding: 2.75rem 2.25rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-eyebrow {
      font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 0.1em; color: var(--ub-maroon);
      display: flex; align-items: center; gap: 0.4rem;
      margin-bottom: 0.75rem;
    }
    .form-title {
      font-size: 1.6rem; font-weight: 800;
      color: #1a1209; margin: 0 0 0.25rem;
    }
    .form-sub {
      font-size: 0.82rem; color: #6b7280; margin: 0 0 2rem;
    }
    .gold-accent {
      width: 36px; height: 3px;
      background: var(--ub-gold); border-radius: 2px;
      margin-bottom: 2rem;
    }

    /* SSO Button */
    .btn-sso {
      display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      width: 100%;
      padding: 0.875rem 1.25rem;
      background: var(--ub-maroon);
      color: #fff;
      border: none; border-radius: 14px;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem; font-weight: 700;
      cursor: pointer; text-decoration: none;
      transition: background 0.2s, transform 0.15s, box-shadow 0.15s;
      box-shadow: 0 4px 16px rgba(123,15,16,0.25);
      margin-bottom: 1.5rem;
    }
    .btn-sso:hover {
      background: var(--ub-maroon-dark);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(123,15,16,0.35);
      color: #fff; text-decoration: none;
    }
    .btn-sso:active { transform: translateY(0); }
    .btn-sso .sso-icon {
      width: 28px; height: 28px;
      background: rgba(255,255,255,0.2);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem; flex-shrink: 0;
    }

    /* Divider */
    .or-divider {
      display: flex; align-items: center; gap: 0.75rem;
      margin-bottom: 1.5rem;
    }
    .or-divider::before, .or-divider::after {
      content: ''; flex: 1; height: 1px; background: #e5e7eb;
    }
    .or-divider span { font-size: 0.72rem; color: #9ca3af; font-weight: 600; white-space: nowrap; }

    /* Admin toggle */
    .admin-toggle-btn {
      background: none; border: none;
      font-size: 0.78rem; color: #9ca3af;
      cursor: pointer; font-family: 'Inter', sans-serif;
      display: flex; align-items: center; gap: 0.4rem;
      padding: 0; transition: color 0.15s;
      width: 100%; justify-content: center;
      text-decoration: underline; text-underline-offset: 2px;
    }
    .admin-toggle-btn:hover { color: var(--ub-maroon); }

    /* Admin form */
    .admin-form-section {
      display: none;
      margin-top: 1.25rem;
      padding-top: 1.25rem;
      border-top: 1px solid #f3f4f6;
    }
    .admin-form-section.open { display: block; }
    .admin-label {
      font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em;
      text-transform: uppercase; color: #6b7280;
      display: block; margin-bottom: 0.4rem;
    }
    .admin-input-wrap {
      position: relative; margin-bottom: 0.875rem;
    }
    .admin-input-icon {
      position: absolute; left: 0.875rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem;
      pointer-events: none;
    }
    .admin-input {
      width: 100%;
      padding: 0.7rem 0.875rem 0.7rem 2.25rem;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 0.875rem; color: #1a1209;
      outline: none; transition: border-color 0.15s, box-shadow 0.15s;
      background: #fafafa;
    }
    .admin-input:focus {
      border-color: var(--ub-maroon);
      box-shadow: 0 0 0 3px rgba(123,15,16,0.08);
      background: #fff;
    }
    .admin-pass-toggle {
      position: absolute; right: 0.875rem; top: 50%;
      transform: translateY(-50%); cursor: pointer;
      color: #9ca3af; font-size: 0.82rem;
      transition: color 0.15s;
    }
    .admin-pass-toggle:hover { color: var(--ub-maroon); }
    .btn-admin-submit {
      width: 100%;
      padding: 0.75rem;
      background: #374151; color: #fff;
      border: none; border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 0.875rem; font-weight: 700;
      cursor: pointer; transition: background 0.15s;
    }
    .btn-admin-submit:hover { background: #1f2937; }

    /* Alert */
    .alert-error {
      background: #fef2f2; color: #991b1b;
      border: 1px solid #fecaca; border-radius: 10px;
      padding: 0.65rem 0.875rem; font-size: 0.8rem;
      display: flex; align-items: flex-start; gap: 0.5rem;
      margin-bottom: 1.25rem;
    }
    .alert-error i { flex-shrink: 0; margin-top: 2px; }

    /* Trust note */
    .trust-note {
      text-align: center; font-size: 0.7rem; color: #9ca3af;
      padding-top: 1.25rem; border-top: 1px solid #f3f4f6;
      margin-top: 1.5rem;
      display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    }

    /* ── FOOTER ── */
    .page-footer {
      position: relative; z-index: 2;
      text-align: center;
      padding: 0.875rem 1rem; font-size: 0.7rem; color: #9ca3af;
      border-top: 1px solid #f3f4f6;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      .login-brand-panel { display: none; }
      .login-form-panel { width: 100%; padding: 2rem 1.5rem; }
      .login-card-wrap { border-radius: 20px; }
    }
    @media (max-width: 420px) {
      .login-card-wrap { border-radius: 16px; }
      .login-form-panel { padding: 1.75rem 1.25rem; }
    }
  </style>
</head>
<body>
<div class="login-page">
  <!-- Background blobs -->
  <div class="bg-blob bg-blob-1"></div>
  <div class="bg-blob bg-blob-2"></div>

  <!-- NAVBAR -->
  <nav class="ub-nav">
    <a class="ub-brand" href="/">
      <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo"/>
      <div>
        <span class="ub-brand-name">UBarter</span>
        <span class="ub-brand-sub">University of Batangas</span>
      </div>
    </a>
    <div class="ub-nav-links">
      <a class="ub-nav-link" href="https://ubian.ub.edu.ph/portal_news/list" target="_blank" rel="noopener">
        <i class="fas fa-newspaper me-1"></i> News
      </a>
      <a class="ub-nav-link" href="https://ebrahman.ub.edu.ph/" target="_blank" rel="noopener">
        <i class="fas fa-graduation-cap me-1"></i> eBrahman
      </a>
    </div>
  </nav>

  <!-- BODY -->
  <div class="login-body">
    <div class="login-card-wrap">

      <!-- LEFT: Brand panel -->
      <div class="login-brand-panel">
        <div class="brand-logo-row">
          <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo"/>
          <div>
            <span class="brand-logo-name">UBarter</span>
            <span class="brand-logo-sub">University of Batangas</span>
          </div>
        </div>

        <div class="brand-headline">
          <h1>Trade Smart,<br><span>Barter Better.</span></h1>
          <p>A peer-to-peer exchange platform built exclusively for the UB community. Barter items, reduce waste, and connect with fellow students.</p>
          <div class="brand-pills">
            <span class="brand-pill"><i class="fas fa-exchange-alt"></i> Barter Items</span>
            <span class="brand-pill"><i class="fas fa-hand-holding-heart"></i> Donate</span>
            <span class="brand-pill"><i class="fas fa-leaf"></i> Eco-Friendly</span>
            <span class="brand-pill"><i class="fas fa-shield-alt"></i> Verified UB Only</span>
          </div>
        </div>

        <div class="brand-trust">
          <i class="fas fa-lock"></i>
          Secured &amp; UBmail-verified accounts only
        </div>
      </div>

      <!-- RIGHT: Form panel -->
      <div class="login-form-panel">
        <div class="form-eyebrow">
          <i class="fas fa-shield-alt"></i> UB Community Access
        </div>
        <h2 class="form-title">Welcome back</h2>
        <p class="form-sub">Sign in to access the campus barter platform.</p>
        <div class="gold-accent"></div>

        @if ($errors->any() && !request()->has('_admin'))
          @foreach ($errors->all() as $error)
            <div class="alert-error">
              <i class="fas fa-exclamation-circle"></i>
              {{ $error }}
            </div>
          @endforeach
        @endif

        <!-- Google SSO -->
        <a href="{{ route('auth.google') }}" class="btn-sso">
          <span class="sso-icon"><i class="fas fa-envelope"></i></span>
          Continue with UB Mail
        </a>

        <!-- Admin toggle -->
        <div class="or-divider">
          <span>CES Admin?</span>
        </div>
        <button type="button" class="admin-toggle-btn" onclick="toggleAdminLogin()">
          <i class="fas fa-shield-lock" style="color:var(--ub-maroon);"></i>
          Sign in with credentials
        </button>

        <!-- Admin form -->
        <div id="adminLoginForm" class="admin-form-section @if($errors->any()) open @endif">
          <p style="font-size:0.7rem;font-weight:700;color:#6b7280;text-align:center;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:1rem;">
            <i class="fas fa-shield-check" style="color:var(--ub-maroon);margin-right:4px;"></i>
            Community Extension Services
          </p>

          @if ($errors->any())
            @foreach ($errors->all() as $error)
              <div class="alert-error" style="font-size:0.78rem;">
                <i class="fas fa-exclamation-circle"></i> {{ $error }}
              </div>
            @endforeach
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
              <label class="admin-label">Email</label>
              <div class="admin-input-wrap">
                <i class="fas fa-envelope admin-input-icon"></i>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="ces.admin@ub.edu.ph"
                       class="admin-input" required autocomplete="email">
              </div>
            </div>
            <div>
              <label class="admin-label">Password</label>
              <div class="admin-input-wrap" style="position:relative;">
                <i class="fas fa-lock admin-input-icon"></i>
                <input type="password" name="password" id="adminPass"
                       placeholder="••••••••"
                       class="admin-input" style="padding-right:2.5rem;"
                       required autocomplete="current-password">
                <span class="admin-pass-toggle" onclick="toggleAdminPass()">
                  <i class="fas fa-eye" id="adminPassIcon"></i>
                </span>
              </div>
            </div>
            <button type="submit" class="btn-admin-submit">
              <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i> Sign In as Admin
            </button>
          </form>
        </div>

        <div class="trust-note">
          <i class="fas fa-shield-alt" style="color:var(--ub-maroon);"></i>
          Access restricted to verified UB community members
        </div>
      </div>

    </div>
  </div>

  <!-- FOOTER -->
  <footer class="page-footer">
    © {{ date('Y') }} UBarter · University of Batangas · All rights reserved
  </footer>
</div>

<script>
  function toggleAdminLogin() {
    var form = document.getElementById('adminLoginForm');
    form.classList.toggle('open');
  }
  function toggleAdminPass() {
    var input = document.getElementById('adminPass');
    var icon  = document.getElementById('adminPassIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'fas fa-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'fas fa-eye';
    }
  }
</script>
</body>
</html>
