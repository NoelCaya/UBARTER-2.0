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
      background-image: url('{{ asset("images/ubarter-bg.png") }}');
      background-position: center bottom;
      background-size: contain;
      background-repeat: no-repeat;
      background-attachment: fixed;
      position: relative;
      overflow: hidden;
    }
    #login-page::before {
      content: '';
      position: absolute;
      inset: 0; 
      background: linear-gradient(180deg,
        rgba(245,243,239,0.97) 0%,
        rgba(245,243,239,0.88) 15%,
        rgba(245,243,239,0.50) 42%,
        rgba(245,243,239,0.10) 100%);
      z-index: 0;
      pointer-events: none;
    }

    /* Navbar */
    .ub-topnav {
      position: relative;
      z-index: 10;
      background: rgba(245,243,239,0.97);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(0,0,0,0.07);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 0.6rem 1.2rem;
      min-height: 62px;
    }
    .ub-brand {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      text-decoration: none;
      color: #1a1209;
    }
    .ub-brand img {
      width: 36px; height: 36px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
    }
    .ub-brand-name {
      font-weight: 800;
      font-size: 1rem;
      white-space: nowrap;
    }
    .ub-nav-links {
      display: flex;
      align-items: center;
      gap: 0.1rem;
      flex-wrap: nowrap;
    }
    .ub-nav-link {
      padding: 0.4rem 0.7rem;
      font-size: 0.85rem;
      font-weight: 500;
      color: #2a2015;
      text-decoration: none;
      border-radius: 6px;
      white-space: nowrap;
    }
    .ub-nav-link:hover { background: rgba(0,0,0,0.06); }
    .ub-login-btn {
      background: var(--ub-maroon);
      color: white !important;
      border: none;
      border-radius: 999px;
      padding: 0.45rem 1.2rem;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
    }
    .ub-login-btn:hover { background: var(--ub-maroon-dark); }

    /* Body area */
    .login-body {
      flex: 1;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    /* Welcome */
    #loginWelcome { text-align: center; width: 100%; max-width: 520px; }
    .welcome-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.9rem, 6vw, 3rem);
      font-weight: 900;
      color: #1a1209;
      line-height: 1.15;
      margin-bottom: 0.8rem;
    }
    .welcome-title span { color: var(--ub-maroon); }
    .welcome-desc {
      font-size: 0.97rem;
      color: #000000;
      max-width: 440px;
      margin: 0 auto 1.8rem;
      line-height: 1.7;
    }
    .welcome-btns {
      display: flex;
      gap: 0.7rem;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn-welcome-primary {
      background: var(--ub-maroon);
      color: white;
      border: none;
      border-radius: 999px;
      padding: 0.7rem 2rem;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: background 0.2s;
    }
    .btn-welcome-primary:hover { background: var(--ub-maroon-dark); }
    .btn-welcome-outline {
      background: transparent;
      color: var(--ub-maroon);
      border: 1.5px solid rgba(123,15,16,0.4);
      border-radius: 999px;
      padding: 0.7rem 2rem;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      transition: all 0.2s;
      text-decoration: none;
    }
    .btn-welcome-outline:hover { background: var(--ub-maroon); color: white; }

    /* Login Card */
    #loginCard {
      display: none;
      width: 100%;
      max-width: 440px;
      background: white;
      border-radius: 18px;
      box-shadow: 0 8px 48px rgba(0,0,0,0.12);
      padding: 2rem 2rem;
      position: relative;
    }
    #loginCard.show {
      display: block;
    }
    @media (max-width: 480px) {
      #loginCard { padding: 1.5rem 1.2rem; border-radius: 14px; }
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
    }
    .card-close-btn:hover { background: #e0d8cf; color: #1a1209; }
    .card-title {
      font-weight: 800;
      font-size: 1.25rem;
      color: #1a1209;
      margin-bottom: 0.25rem;
      text-align: center;
    }
    .card-sub {
      font-size: 0.78rem;
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
    .field-label {
      display: block;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #7a6e65;
      margin-bottom: 0.35rem;
    }
    .field-group {
      display: flex;
      border: 1.5px solid #e0d8cf;
      border-radius: 10px;
      overflow: hidden;
      transition: border-color 0.2s;
    }
    .field-group:focus-within { border-color: var(--ub-maroon); }
    .field-group input {
      flex: 1;
      border: none;
      outline: none;
      padding: 0.72rem 0.9rem;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.92rem;
      background: white;
      color: #1a1209;
    }
    .field-group span {
      display: flex;
      align-items: center;
      padding: 0 0.85rem;
      background: white;
      color: #7a6e65;
      cursor: pointer;
      font-size: 0.95rem;
    }
    .row-check {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 0.6rem 0 1rem;
      font-size: 0.8rem;
    }
    .row-check label { color: #7a6e65; cursor: pointer; }
    .row-check a { color: var(--ub-maroon); font-weight: 600; text-decoration: none; }
    .btn-signin {
      width: 100%;
      background: var(--ub-maroon);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 0.82rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      margin-bottom: 0.5rem;
      transition: background 0.2s;
    }
    .btn-signin:hover { background: var(--ub-maroon-dark); }
    .or-divider {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      font-size: 0.8rem;
      color: #7a6e65;
      margin: 0.6rem 0;
    }
    .or-divider::before, .or-divider::after {
      content: ''; flex: 1;
      height: 1px;
      background: #e0d8cf;
    }
    .btn-sso {
      width: 100%;
      background: transparent;
      color: var(--ub-maroon);
      border: 1.5px solid var(--ub-maroon);
      border-radius: 10px;
      padding: 0.75rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .btn-sso:hover { background: var(--ub-maroon); color: white; }
    .card-footer-note {
      text-align: center;
      font-size: 0.8rem;
      color: #7a6e65;
      margin-top: 1rem;
    }
    .card-footer-note a { color: var(--ub-maroon); font-weight: 600; text-decoration: none; cursor: pointer; }
    .verified-note {
      text-align: center;
      font-size: 0.7rem;
      color: #9a8e85;
      margin-top: 1rem;
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
    .alert-success {
      background: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
      border-radius: 8px;
      padding: 0.6rem 0.9rem;
      font-size: 0.82rem;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .input-error {
      color: #991b1b;
      margin-top: 0.25rem;
      font-size: 0.8rem;
      display: block;
    }

    /* Page footer strip */
    .page-footer {
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 0.85rem 1rem;
      font-size: 0.72rem;
      color: #9a8e85;
      border-top: 1px solid rgba(0,0,0,0.07);
      background: rgba(245,243,239,0.7);
    }

    /* Mobile nav collapse */
    @media (max-width: 600px) {
      .ub-nav-link { display: none; }
    }
    @media (max-width: 400px) {
      .ub-brand-name { font-size: 0.88rem; }
    }
  </style>
</head>
<body>

<div id="login-page">
  
  <!-- NAVBAR -->
  <nav class="ub-topnav">
    <a class="ub-brand" href="/">
      <img src="{{ asset('images/ub-logo.svg') }}" alt="UB Logo"/>
      <span class="ub-brand-name">University of Batangas</span>
    </a>
    <div class="ub-nav-links">
      <a class="ub-nav-link" href="#">News</a>
      <a class="ub-nav-link" href="#">LMS Onboarding Tutorial</a>
      <a class="ub-nav-link" href="#">eBrahman</a>
      <button class="ub-login-btn" onclick="openLoginCard()">Log In</button>
    </div>
  </nav>

  <!-- BODY -->
  <div class="login-body">

    <!-- WELCOME SECTION -->
    <div id="loginWelcome">
      <div class="welcome-title">Welcome to <span>UBarter</span></div>
      <p class="welcome-desc">
        A peer-to-peer exchange platform exclusively for the University of Batangas community. Trade, exchange, and connect with fellow students.
      </p>
      <div class="welcome-btns">
        <button class="btn-welcome-primary" onclick="openLoginCard()">Sign In</button>
      </div>
    </div>

    <!-- LOGIN CARD -->
    <div id="loginCard" @if ($errors->any()) class="show" @endif>
      <button class="card-close-btn" onclick="closeLoginCard()">
        <i class="bi bi-x-lg"></i>
      </button>

      <div class="card-title">Sign in to UBarter</div>
      <div class="card-sub">University of Batangas · Peer-to-Peer Exchange Platform</div>
      <div class="gold-bar"></div>

      <!-- Display Validation Errors -->
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div class="alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $error }}
          </div>
        @endforeach
      @endif

      <div style="margin-bottom: 2rem; text-align: center;">
        <p class="text-gray-600" style="font-size: 0.9rem; line-height: 1.6;">
          Sign in to your UBarter account using your UB email to get started with the peer-to-peer exchange platform.
        </p>
      </div>

      <a href="{{ route('auth.google') }}" class="btn-sso" style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 1rem; padding: 0.9rem;">
        <i class="bi bi-key-fill"></i> Continue with UB MAIL
      </a>

      <div class="verified-note">
        <i class="bi bi-shield-check" style="color:var(--ub-maroon);"></i>
        Access restricted to verified UB community members
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
    const welcome = document.getElementById('loginWelcome');
    if (welcome) welcome.style.display = 'none';
    document.getElementById('loginCard').classList.add('show');
}

function closeLoginCard() {
    document.getElementById('loginCard').classList.remove('show');
    const welcome = document.getElementById('loginWelcome');
    if (welcome) welcome.style.display = 'block';
}

function togglePass() {
  const pass = document.getElementById('loginPass');
  const icon = document.getElementById('passIcon');
  if (pass.type === 'password') {
    pass.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    pass.type = 'password';
    icon.className = 'bi bi-eye';
  }
}

// Auto-open card if there are validation errors
document.addEventListener('DOMContentLoaded', function() {
  const loginCard = document.getElementById('loginCard');
  if (loginCard.classList.contains('show')) {
    openLoginCard();
  }
});
</script>
</body>
</html>
