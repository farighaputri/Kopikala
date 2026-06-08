<!DOCTYPE html>
<html lang="id">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopikala - Login / Daftar</title>
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

    .social-login button {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 14px;
      border-radius: 10px;
      border: 1px solid #ccc;
      cursor: pointer;
      background-color: white;
      transition: 0.3s;
      font-family: inherit;
    }

    .social-login button:hover {
      background-color: #eee;
    }
    .social-btn{
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
}


.google-btn:hover,
.apple-btn:hover{
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
      <div class="form-section {{ session('show') == 'register' ? 'hidden' : '' }}" id="login-form">
        <h1>Selamat Datang Kembali!</h1>
        <p>Masuk untuk mengakses akun Anda</p>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

       <form method="POST" action="{{ route('login.submit') }}">
  @csrf

  <div class="form-group">
    <input type="email" name="email" placeholder="Masukkan alamat email" value="{{ old('email') }}" required>
  </div>

  <div class="form-group">
    <input type="password" name="password" placeholder="Masukkan Password" required>
  </div>

 
  <div class="form-group">
    <select name="login_as" required style="width:100%; padding:10px; border-radius:10px;">
      <option value="user">Login sebagai User</option>
      <option value="admin">Login sebagai Admin</option>
    </select>
  </div>

 <button type="submit" class="btn">Login</button>

<div class="divider">atau</div>

<div class="social-login">
    <a href="/auth/google/user">
        <button type="button" class="social-btn google-btn">
            <i class="fa-brands fa-google"></i>
            Google
        </button>
    </a>

    <button type="button" class="social-btn apple-btn">
        <i class="fa-brands fa-apple"></i>
        Apple
    </button>
</div>
  <p class="switch-text">Belum punya akun? <a onclick="showRegister()">Daftar</a></p>
</form>
      </div>

      {{-- REGISTER FORM --}}
      <div class="form-section {{ $errors->has('password') || $errors->has('email') || $errors->has('name') ? '' : 'hidden' }}" id="register-form">
        <h1>Daftar Sekarang</h1>
        <p>Buat akun baru untuk bergabung bersama kami</p>

        <form method="POST" action="{{ route('register.submit') }}">
          @csrf
          <div class="form-group">
            <input type="text" name="name" placeholder="Masukkan nama" value="{{ old('name') }}" required>
            @error('name')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Masukkan alamat email" value="{{ old('email') }}" required>
            @error('email')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <input type="password" name="password" placeholder="Masukkan password" required>
            @error('password')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>

          <div class="checkbox-inline">
            <input type="checkbox" required><span>Saya setuju dengan kebijakan privasi</span>
          </div><br>

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

    function showRegister() {
      loginForm.classList.add('hidden');
      registerForm.classList.remove('hidden');
    }

    function showLogin() {
      registerForm.classList.add('hidden');
      loginForm.classList.remove('hidden');
    }
  </script>

</body>
</html>
