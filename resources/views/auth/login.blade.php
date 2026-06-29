<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopikala - Login / Daftar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      width: 100%;
      font-family: 'Comic Neue', cursive;
      overflow: hidden;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #5a3112;
    }

    .container {
      display: flex;
      width: 100%;
      position: relative;
    }

    /* ALERT */
    .alert {
      width: 90%;
      margin: 0 auto 15px;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      text-align: center;
      animation: fadeIn 0.4s ease;
    }
    .alert-success { background: #d4edda; color: #155724; }
    .alert-error { background: #f8d7da; color: #721c24; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* === KIRI === */
    .left {
      width: 50%;
      background-color: #f2f2f2;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .form-section {
      width: 100%;
      max-width: 350px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      transition: opacity 0.4s ease, visibility 0.4s ease;
      opacity: 1;
      visibility: visible;
    }

    .form-section.hidden {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
    }

    h1 {
      font-size: 1.9rem;
      margin-bottom: 10px;
      color: #1f140a;
      text-align: center;
    }

    p {
      margin-bottom: 20px;
      color: #555;
      text-align: center;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 15px;
    }

    input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-family: inherit;
    }

    .error-text {
      font-size: 12px;
      color: #d8000c;
      margin-top: 3px;
    }

    .checkbox-inline {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #555;
    }

    .checkbox-inline input {
      width: auto;
      margin: 0;
      accent-color: #5a3112;
    }

    .btn {
      background-color: #3b1f0a;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 10px;
      cursor: pointer;
      font-family: inherit;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #5a3112;
    }

    .divider {
      margin: 20px 0;
      text-align: center;
      font-size: 14px;
      color: #999;
      position: relative;
    }

    .divider::before, .divider::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #ccc;
    }

    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .social-login {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .social-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background: #fff;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 10px;
      font-family: inherit;
    }

    .google-btn:hover,
    .apple-btn:hover {
      background: #f5f5f5;
    }

    .switch-text {
      color: #333;
      font-size: 14px;
      text-align: center;
    }

    .switch-text a {
      color: #1a73e8;
      text-decoration: none;
      cursor: pointer;
    }

    /* === KANAN === */
    .right {
      width: 50%;
      height: 100vh;
      background-color: #5a3112;
      position: relative;
      overflow: hidden;
    }

    .polaroid-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 110%;
      background-image: url('{{ asset('media/moment.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .overlay {
      position: absolute;
      inset: 0;
      background: rgba(58, 32, 10, 0.25);
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .left, .right {
        width: 100%;
        height: 50vh;
      }
      .form-section {
        position: relative;
        transform: none;
        left: auto;
        top: auto;
        margin: 0 auto;
        padding: 2rem 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="left">

      {{-- LOGIN FORM --}}
      {{-- Diperbaiki agar jika ada session error dari backend, form login tidak kabur atau tersembunyi --}}
      <div class="form-section {{ session('show') == 'register' && !session('error') ? 'hidden' : '' }}" id="login-form">
        <h1>Selamat Datang Kembali!</h1>
        <p>Masuk untuk mengakses akun Anda</p>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tempat cetak notifikasi akurat: "Akun belum terdaftar.", "Email atau password salah." dll --}}
        @if(session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" id="main-login-form">
          @csrf

          <div class="form-group">
            <input type="email" name="email" id="login_email" placeholder="Masukkan alamat email" value="{{ old('email') }}">
            <div class="error-text" id="error-login-email">
              @error('email') {{ $message }} @enderror
            </div>
          </div>

          <div class="form-group">
            <input type="password" name="password" id="login_password" placeholder="Masukkan Password">
            <div class="error-text" id="error-login-password">
              @error('password') {{ $message }} @enderror
            </div>
          </div>

          <div class="form-group">
            <select name="login_as" required style="width:100%; padding:10px; border-radius:10px; font-family: inherit;">
              <option value="user" {{ old('login_as') == 'user' ? 'selected' : '' }}>Login sebagai User</option>
              <option value="admin" {{ old('login_as') == 'admin' ? 'selected' : '' }}>Login sebagai Admin</option>
            </select>
          </div>

          <button type="submit" class="btn">Login</button>

          <div class="divider">atau</div>

          <div class="social-login">
            <a href="/auth/google/user" style="flex: 1; text-decoration: none;">
              <button type="button" class="social-btn google-btn">
                <i class="fa-brands fa-google"></i> Google
              </button>
            </a>
            <button type="button" class="social-btn apple-btn" style="flex: 1;">
              <i class="fa-brands fa-apple"></i> Apple
            </button>
          </div>
          <p class="switch-text">Belum punya akun? <a onclick="showRegister()">Daftar</a></p>
        </form>
      </div>

      {{-- REGISTER FORM --}}
      <div class="form-section {{ ($errors->has('password') || $errors->has('email') || $errors->has('name') || session('show') == 'register') && !session('error') ? '' : 'hidden' }}" id="register-form">
        <h1>Daftar Sekarang</h1>
        <p>Buat akun baru untuk bergabung bersama kami</p>

        <form method="POST" action="{{ route('register.submit') }}" id="main-register-form">
          @csrf
          <div class="form-group">
            <input type="text" name="name" id="register_name" placeholder="Masukkan nama" value="{{ old('name') }}">
            <div class="error-text" id="error-register-name">
              @error('name') {{ $message }} @enderror
            </div>
          </div>
          <div class="form-group">
            <input type="email" name="email" id="register_email" placeholder="Masukkan alamat email" value="{{ old('email') }}">
            <div class="error-text" id="error-register-email">
              @error('email') {{ $message }} @enderror
            </div>
          </div>
          <div class="form-group">
            <input type="password" name="password" id="register_password" placeholder="Masukkan password">
            <div class="error-text" id="error-register-password">
              @error('password') {{ $message }} @enderror
            </div>
          </div>

          <div class="checkbox-inline">
            <input type="checkbox" id="register_terms" required><span>Saya setuju dengan kebijakan privasi</span>
          </div>
          <div class="error-text" id="error-register-terms" style="margin-bottom: 10px;"></div>

          <button type="submit" class="btn">Daftar</button>

          <p class="switch-text">Sudah punya akun? <a onclick="showLogin()">Login</a></p>
        </form>
      </div>

    </div>

    <div class="right">
      <div class="polaroid-bg"></div>
      <div class="overlay"></div>
    </div>
  </div>

  <script>
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    
    const mainLoginForm = document.getElementById('main-login-form');
    const mainRegisterForm = document.getElementById('main-register-form');

    function showRegister() {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
      clearErrors();
    }

    function showLogin() {
      registerForm.classList.add('hidden');
      loginForm.classList.remove('hidden');
      clearErrors();
    }

    function clearErrors() {
      document.querySelectorAll('.error-text').forEach(el => el.innerText = '');
    }

    // === VALIDASI LIVE SISI CLIENT (FORM KOSONG) ===
    mainLoginForm.addEventListener('submit', function(e) {
      let valid = true;
      const email = document.getElementById('login_email').value.trim();
      const password = document.getElementById('login_password').value.trim();
      
      document.getElementById('error-login-email').innerText = '';
      document.getElementById('error-login-password').innerText = '';

      if (email === '') {
        document.getElementById('error-login-email').innerText = 'Email tidak boleh kosong.';
        valid = false;
      }
      if (password === '') {
        document.getElementById('error-login-password').innerText = 'Password tidak boleh kosong.';
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });

    mainRegisterForm.addEventListener('submit', function(e) {
      let valid = true;
      const name = document.getElementById('register_name').value.trim();
      const email = document.getElementById('register_email').value.trim();
      const password = document.getElementById('register_password').value.trim();
      
      document.getElementById('error-register-name').innerText = '';
      document.getElementById('error-register-email').innerText = '';
      document.getElementById('error-register-password').innerText = '';

      if (name === '') {
        document.getElementById('error-register-name').innerText = 'Nama tidak boleh kosong.';
        valid = false;
      }
      if (email === '') {
        document.getElementById('error-register-email').innerText = 'Email tidak boleh kosong.';
        valid = false;
      }
      if (password === '') {
        document.getElementById('error-register-password').innerText = 'Password tidak boleh kosong.';
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>