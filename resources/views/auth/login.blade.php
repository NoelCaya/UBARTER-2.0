<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UBarter 2.0 — University of Batangas</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --ub-maroon: #7b0f10;
      --ub-maroon-dark: #5a0a0b;
      --ub-gold: #f5c518;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

    /* ── LOGIN PAGE ── */
    #login-page {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: #f5f3ef;
      background-image: url('{{ asset("images/university-bg.png") }}');
      background-position: center bottom;
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      position: relative;
      overflow: hidden;
    }

    /* Subtle dark overlay to improve contrast without hiding the art */
    #login-page::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(160deg,
        rgba(245,243,239,0.82) 0%,
        rgba(245,243,239,0.60) 40%,
        rgba(30,10,10,0.25) 100%);
      z-index: 0;
      pointer-events: none;
    }

    /* ── NAVBAR ── */
    .ub-topnav {
      position: relative;
      z-index: 10;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 2px solid var(--ub-maroon);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 0.55rem 1.4rem;
      min-height: 58px;
    }
    .ub-brand {
      display: flex;
      align-items: center;
      gap: 0.55rem;
      text-decoration: none;
      color: #1a1209;
    }
    .ub-brand img {
      width: 28px; height: 28px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--ub-maroon);
      flex-shrink: 0;
    }
    .ub-brand-text { line-height: 1.1; }
    .ub-brand-name {
      font-weight: 800;
      font-size: 0.95rem;
      color: var(--ub-maroon);
      display: block;
    }
    .ub-brand-sub {
      font-size: 0.68rem;
      color: #888;
      display: block;
    }
    .ub-nav-links {
      display: flex;
      align-items: center;
      gap: 0.15rem;
    }
    .ub-nav-link {
      padding: 0.38rem 0.75rem;
      font-size: 0.82rem;
      font-weight: 500;
      color: #2a2015;
      text-decoration: none;
      border-radius: 6px;
      white-space: nowrap;
      transition: background 0.15s, color 0.15s;
    }
    .ub-nav-link:hover { background: rgba(123,15,16,0.08); color: var(--ub-maroon); }
    .ub-login-btn {
      background: var(--ub-maroon);
      color: white !important;
      border: none;
      border-radius: 999px;
      padding: 0.42rem 1.2rem;
      font-size: 0.82rem;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
      margin-left: 0.4rem;
    }
    .ub-login-btn:hover { background: var(--ub-maroon-dark); }

    /* ── BODY ── */
    .login-body {
      flex: 1;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1rem;
    }

    /* ── FROSTED GLASS WELCOME PANEL ── */
    #loginWelcome {
      text-align: center;
      width: 100%;
      max-width: 540px;
      background: rgba(255, 255, 255, 0.72);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(255,255,255,0.85);
      border-radius: 24px;
      padding: 2.8rem 2.4rem 2.4rem;
      box-shadow:
        0 8px 32px rgba(123,15,16,0.10),
        0 2px 8px rgba(0,0,0,0.06);
    }
    .welcome-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--ub-maroon);
      color: white;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.3rem 0.9rem;
      border-radius: 999px;
      margin-bottom: 1.2rem;
    }
    .welcome-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 5.5vw, 2.8rem);
      font-weight: 900;
      color: #1a1209;
      line-height: 1.15;
      margin-bottom: 0.9rem;
    }
    .welcome-title span { color: var(--ub-maroon); }
    .welcome-desc {
      font-size: 0.93rem;
      color: #3a2e25;
      max-width: 420px;
      margin: 0 auto 1.8rem;
      line-height: 1.75;
    }
    .welcome-divider {
      width: 48px;
      height: 3px;
      background: var(--ub-gold);
      border-radius: 2px;
      margin: 0 auto 1.8rem;
    }
    .btn-welcome-primary {
      background: var(--ub-maroon);
      color: white;
      border: none;
      border-radius: 999px;
      padding: 0.75rem 2.2rem;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s, transform 0.15s, box-shadow 0.15s;
      box-shadow: 0 4px 14px rgba(123,15,16,0.25);
    }
    .btn-welcome-primary:hover {
      background: var(--ub-maroon-dark);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(123,15,16,0.30);
    }
    .welcome-trust {
      margin-top: 1.4rem;
      font-size: 0.72rem;
      color: #7a6e65;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
    }

    /* ── LOGIN CARD ── */
    #loginCard {
      display: none;
      width: 100%;
      max-width: 440px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 12px 48px rgba(0,0,0,0.14);
      padding: 2rem;
      position: relative;
    }
    #loginCard.show { display: block; }
    @media (max-width: 480px) {
      #loginCard { padding: 1.5rem 1.2rem; border-radius: 14px; }
      #loginWelcome { padding: 2rem 1.4rem; border-radius: 18px; }
    }
    .card-close-btn {
      position: absolute;
      top: 0.9rem; right: 0.9rem;
      width: 30px; height: 30px;
      background: #f4f1ec;
      border: none;
      border-radius: 7px;
      cursor: pointer;
      color: #6b5e52;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.15s;
    }
    .card-close-btn:hover { background: #e0d8cf; color: #1a1209; }
    .card-title {
      font-weight: 800;
      font-size: 1.2rem;
      color: #1a1209;
      margin-bottom: 0.2rem;
      text-align: center;
    }
    .card-sub {
      font-size: 0.76rem;
      color: #7a6e65;
      text-align: center;
      margin-bottom: 0.5rem;
    }
    .gold-bar {
      width: 36px; height: 3px;
      background: var(--ub-gold);
      border-radius: 2px;
      margin: 0 auto 1.4rem;
    }
    .btn-sso {
      width: 100%;
      background: transparent;
      color: var(--ub-maroon);
      border: 2px solid var(--ub-maroon);
      border-radius: 12px;
      padding: 0.85rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-bottom: 1.5rem;
    }
    .btn-sso:hover { background: var(--ub-maroon); color: white; }
    .verified-note {
      text-align: center;
      font-size: 0.7rem;
      color: #9a8e85;
      padding-top: 1rem;
      border-top: 1px solid #e0d8cf;
    }
    .alert-error {
      background: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
      border-radius: 8px;
      padding: 0.6rem 0.9rem;
      font-size: 0.82rem;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* ── FOOTER ── */
    .page-footer {
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 0.8rem 1rem;
      font-size: 0.7rem;
      color: #9a8e85;
      border-top: 1px solid rgba(0,0,0,0.07);
      background: rgba(245,243,239,0.85);
      backdrop-filter: blur(8px);
    }

    @media (max-width: 600px) {
      .ub-nav-link { display: none; }
    }
  </style>
</head>
<body>

<div id="login-page">

  <!-- NAVBAR -->
  <nav class="ub-topnav">
    <a class="ub-brand" href="/">
      <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo" style="max-width:28px;max-height:28px;"/>
      <div class="ub-brand-text">
        <span class="ub-brand-name">UBarter</span>
        <span class="ub-brand-sub">University of Batangas</span>
      </div>
    </a>
    <div class="ub-nav-links">
      <a class="ub-nav-link" href="https://ubian.ub.edu.ph/portal_news/list" target="_blank" rel="noopener">
        <i class="bi bi-newspaper me-1"></i>News
      </a>
      <a class="ub-nav-link" href="https://wakelet.com/wake/OH5RDsBHZBIosbovORo16" target="_blank" rel="noopener">
        <i class="bi bi-play-circle me-1"></i>LMS Onboarding Tutorial
      </a>
      <a class="ub-nav-link" href="https://ebrahman.ub.edu.ph/" target="_blank" rel="noopener">
        <i class="bi bi-mortarboard me-1"></i>eBrahman
      </a>
      <button class="ub-login-btn" onclick="openLoginCard()">
        <i class="bi bi-box-arrow-in-right me-1"></i>Log In
      </button>
    </div>
  </nav>

  <!-- BODY -->
  <div class="login-body">

    <!-- FROSTED GLASS WELCOME PANEL -->
    <div id="loginWelcome">
      <div class="welcome-eyebrow">
        <i class="bi bi-shield-check-fill"></i> UB Community Only
      </div>
      <div class="welcome-title">Welcome to <span>UBarter</span></div>
      <div class="welcome-divider"></div>
      <p class="welcome-desc">
        A peer-to-peer exchange platform exclusively for the University of Batangas community. Trade, exchange, and connect with fellow students.
      </p>
      <button class="btn-welcome-primary" onclick="openLoginCard()">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
      </button>
      <div class="welcome-trust">
        <i class="bi bi-lock-fill" style="color:var(--ub-maroon);"></i>
        Secured · UBmail verified accounts only
      </div>
    </div>

    <!-- LOGIN CARD -->
    <div id="loginCard" @if ($errors->any()) class="show" @endif>
      <button class="card-close-btn" onclick="closeLoginCard()">
        <i class="bi bi-x-lg"></i>
      </button>

      <div class="card-title">Sign in to UBarter</div>
      <div class="card-sub">University of Batangas · Peer-to-Peer Exchange</div>
      <div class="gold-bar"></div>

      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div class="alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $error }}
          </div>
        @endforeach
      @endif

      <p style="text-align:center; font-size:0.88rem; color:#5a4e45; margin-bottom:1.6rem; line-height:1.6;">
        Use your <strong>UB email</strong> to sign in and access the campus barter platform.
      </p>

      <a href="{{ route('auth.google') }}" class="btn-sso">
        <i class="bi bi-envelope-fill"></i> Continue with UB MAIL
      </a>

      <div class="verified-note">
        <i class="bi bi-shield-check" style="color:var(--ub-maroon);"></i>
        Access restricted to verified UB community members
      </div>

      <!-- Admin login toggle -->
      <div style="margin-top:1.2rem;text-align:center;">
        <button type="button" onclick="toggleAdminLogin()"
                style="background:none;border:none;font-size:0.72rem;color:#9a8e85;cursor:pointer;text-decoration:underline;font-family:'DM Sans',sans-serif;">
          <i class="bi bi-shield-lock" style="color:var(--ub-maroon);"></i> CES Admin Login
        </button>
      </div>

      <!-- Admin email/password form (hidden by default) -->
      <div id="adminLoginForm" style="display:none;margin-top:1rem;padding-top:1rem;border-top:1px solid #e0d8cf;">
        <p style="font-size:0.72rem;font-weight:700;color:#7a6e65;text-align:center;margin-bottom:0.8rem;text-transform:uppercase;letter-spacing:0.06em;">
          <i class="bi bi-shield-fill-check" style="color:var(--ub-maroon);"></i> Community Extension Services
        </p>

        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div class="alert-error" style="margin-bottom:0.6rem;">
              <i class="bi bi-exclamation-circle-fill"></i> {{ $error }}
            </div>
          @endforeach
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div style="margin-bottom:0.8rem;">
            <label style="display:block;font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#7a6e65;margin-bottom:0.3rem;">Email</label>
            <div class="field-group">
              <input type="email" name="email" value="{{ old('email') }}"
                     placeholder="ces.admin@ub.edu.ph"
                     style="flex:1;border:none;outline:none;padding:0.65rem 0.9rem;font-family:'DM Sans',sans-serif;font-size:0.88rem;background:white;color:#1a1209;"
                     required autocomplete="email">
            </div>
          </div>
          <div style="margin-bottom:0.8rem;">
            <label style="display:block;font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#7a6e65;margin-bottom:0.3rem;">Password</label>
            <div class="field-group">
              <input type="password" name="password" id="adminPass"
                     placeholder="••••••••"
                     style="flex:1;border:none;outline:none;padding:0.65rem 0.9rem;font-family:'DM Sans',sans-serif;font-size:0.88rem;background:white;color:#1a1209;"
                     required autocomplete="current-password">
              <span onclick="toggleAdminPass()" style="display:flex;align-items:center;padding:0 0.85rem;background:white;color:#7a6e65;cursor:pointer;">
                <i class="bi bi-eye" id="adminPassIcon"></i>
              </span>
            </div>
          </div>
          <button type="submit" class="btn-signin" style="margin-top:0.4rem;">
            <i class="bi bi-box-arrow-in-right" style="margin-right:6px;"></i> Sign In as Admin
          </button>
        </form>
      </div>
    </div>

  </div>

  <!-- PAGE FOOTER -->
  <div class="page-footer">
    Built by students, for students — University of Batangas CICT · 2026 &nbsp;·&nbsp; ubarter.ub.edu.ph
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
function openLoginCard() {
    document.getElementById('loginWelcome').style.display = 'none';
    document.getElementById('loginCard').classList.add('show');
}
function closeLoginCard() {
    document.getElementById('loginCard').classList.remove('show');
    document.getElementById('loginWelcome').style.display = '';
}
function toggleAdminLogin() {
    var form = document.getElementById('adminLoginForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
function toggleAdminPass() {
    var pass = document.getElementById('adminPass');
    var icon = document.getElementById('adminPassIcon');
    if (pass.type === 'password') {
        pass.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pass.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var loginCard = document.getElementById('loginCard');
    if (loginCard.classList.contains('show')) {
        openLoginCard();
    }
    // Auto-open admin form if there were validation errors
    @if($errors->any())
        openLoginCard();
        document.getElementById('adminLoginForm').style.display = 'block';
    @endif
});
</script>
</body>
</html>
