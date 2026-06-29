<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopikala</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Comic Neue', cursive;
      background-color: #f4ecdf;
      color: #3c1f0e;
      scroll-behavior: smooth;
    }

    /* === HEADER === */
    header {
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      z-index: 10;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    header.scrolled {
      background: rgba(60, 31, 14, 0.9);
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .logo img {
      width: 300px;
      height: auto;
      filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.4));
      transition: transform 0.3s ease;
    }

    header.scrolled .logo img {
      transform: scale(0.95);
    }

    nav {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    nav a {
      text-decoration: none;
      color: white;
      font-weight: 600;
      font-size: 1.10rem;
      transition: 0.3s;
    }

    nav a:hover {
      color: #f1c27d;
    }

    .btn-kontak {
      background: #f1c27d;
      color: #3c1f0e !important;
      padding: 8px 20px;
      border-radius: 20px;
      font-weight: bold;
    }

    .btn-kontak:hover {
      background: white;
    }

    /* ================= PROFILE DROPDOWN WRAPPER ================= */
    .profile-wrapper {
      position: relative;
      display: inline-block;
    }

    .profile-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      border: 2px solid rgba(255,255,255,0.7);
      transition: .3s;
    }

    .profile-avatar:hover {
      transform: scale(1.08);
      border-color: #f1c27d;
    }

    /* Kotak Dropdown Utama (Rapi Maksimal) */
    .profile-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      width: 320px; /* Lebar ditambah agar teks tidak sesak */
      background: #FAFAFA;
      border-radius: 20px;
      padding: 22px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      display: none;
      z-index: 1000;
      margin-top: 15px;
      border: 1px solid #E6DED5;
      text-align: left;
    }

    /* Detail User Box */
    .user-info {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 16px;
      width: 100%;
    }

    .user-info img {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 1px solid #D8CABD;
    }

    .user-text-details {
      flex: 1;
      min-width: 0; /* Mencegah flexbox mendorong elemen keluar */
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .user-info h4 {
      font-family: 'Comic Neue', cursive;
      font-size: 18px;
      margin: 0;
      color: #3c1f0e;
      line-height: 1.2;
      word-break: break-word; /* Teks turun otomatis */
      white-space: normal;
    }

    .user-info span {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13px;
      color: #6E5443;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* Link & Button Navigasi */
    .dropdown-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 12px 6px;
      color: #3c1f0e;
      text-decoration: none;
      font-size: 18px;
      border: none;
      background: transparent;
      border-top: 1px solid #E6DED5;
      font-family: 'Comic Neue', cursive;
      cursor: pointer;
      transition: color 0.2s ease;
    }

    .dropdown-link:hover {
      color: #f1c27d;
    }

    .dropdown-link.logout {
      color: #ff4d4d;
    }

    .dropdown-link.logout:hover {
      color: #cc0000;
    }

    /* === HERO === */
    .hero {
      background: url("{{ asset('media/moment.png') }}") center/cover no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      color: white;
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(52, 25, 0, 0.83);
      z-index: 1;
    }

    .hero h1 {
      font-size: 4.0rem;
      z-index: 2;
      position: relative;
      line-height: 1.4;
      font-weight: 800;
    }

    /* === KENALAN === */
    section.kenalan {
      position: relative;
      min-height: 100vh;
      width: 100%;
      padding: 120px 20px;
      text-align: center;
      overflow: hidden;
      background-image:
        linear-gradient(rgba(244, 236, 223, 0.92), rgba(249, 233, 206, 0.92)),
        url("{{ asset('media/BG JAM.png') }}");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
    }

    section.kenalan::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(255, 248, 240, 0.25);
      z-index: 1;
    }

    .kenalan .content {
      max-width: 900px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    .kenalan h2 {
      font-size: 4.8rem;
      margin-bottom: 30px;
      font-weight: bold;
      color: #3a1d0a;
    }

    .kenalan p {
      font-size: 1.9rem;
      line-height: 1.8;
      margin-bottom: 25px;
      color: #4b2b16;
    }

    .kopi-dekorasi {
      position: absolute;
      width: 200px;
      opacity: 0.95;
      z-index: 0;
      transition: transform 0.3s ease;
    }

    .kopi-left-top { top: 30px; left: 30px; transform: rotate(8deg); }
    .kopi-left-bottom { bottom: 30px; left: 30px; transform: rotate(5deg); }
    .kopi-right-top { top: 30px; right: 30px; transform: rotate(-8deg); }
    .kopi-right-bottom { bottom: 30px; right: 30px; transform: rotate(-5deg); }

    /* === MENU === */
    section.menu {
      display: flex;
      width: 100%;
      height: 100vh;
    }

    .menu .left {
      flex: 1;
      background: url("{{ asset('media/menu.jpg') }}") center/cover no-repeat;
      position: relative;
      transition: background-image 0.4s ease-in-out;
    }

    .menu-detail-overlay {
      position: absolute;
      bottom: 30px;
      left: 30px;
      background: rgba(43, 21, 8, 0.85);
      color: #f4ecdf;
      padding: 10px 24px;
      border-radius: 4px;
      font-size: 1.3rem;
      font-weight: 600;
      display: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .menu .right {
      flex: 1;
      background-color: #3c1f0e;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 100px;
      color: white;
    }

    .menu .right h1 {
      font-size: 2.8rem;
      margin-bottom: 40px;
      font-weight: 700;
    }

    .menu-item {
      font-size: 1.8rem;
      padding: 12px 20px;
      margin-bottom: 20px;
      position: relative;
      cursor: pointer;
      color: #ffffff;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .menu-item::after {
      content: "";
      position: absolute;
      left: 20px;
      bottom: 0;
      width: calc(100% - 40px);
      height: 2px;
      background-color: rgba(255, 255, 255, 0.4);
      transition: background-color 0.3s ease;
    }

    .menu-item:hover {
      color: #f1c27d;
    }

    .menu-item.active {
      background-color: #e6dac6;
      color: #3c1f0e !important;
      font-weight: 800;
      padding-left: 30px;
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .menu-item.active::after {
      background-color: transparent;
    }

    .footer {
      margin-top: 50px;
      font-size: 1.2rem;
      color: #e6dac6;
    }

    /* === SOBATKALA === */
    section.sobatkala {
      position: relative;
      width: 100%;
      min-height: 100vh;
      background: url("{{ asset('media/BG JAM.png') }}") center/cover no-repeat;
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 100px 40px;
      overflow: hidden;
    }

    section.sobatkala::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(244, 236, 223, 0.92);
      z-index: 1;
    }

    .sobatkala .content {
      position: relative;
      z-index: 2;
      max-width: 1150px;
    }

    .sobatkala h2 {
      font-size: 2.8rem;
      color: #3a1d0a;
      margin-bottom: 15px;
    }

    .sobatkala h2 span {
      color: #5d2c15;
    }

    .sobatkala p {
      font-size: 1.3rem;
      color: #4b2b16;
      margin-bottom: 60px;
    }

    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .polaroid {
      background: white;
      padding: 12px;
      width: 200px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 6px;
    }

    .polaroid img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-radius: 4px;
    }

    .polaroid:hover {
      transform: scale(1.06) rotate(0deg) !important;
      box-shadow: 0 12px 24px rgba(0,0,0,0.3);
      z-index: 5;
    }

    .rotate-left { transform: rotate(-3deg); }
    .rotate-right { transform: rotate(3deg); }

    /* === FOOTER === */
    footer {
      margin-top: 90px;
      background: #3b1604;
      color: white;
      padding: 80px 60px 25px;
      position: relative;
      overflow: hidden;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: flex-start; 
      gap: 50px;
    }

    .footer-left img {
      width: 190px;
      margin-top: -60px;
    }

    .footer-left p {
      margin-top: 6px;
      font-size: 15px;
      color: #f8e6cc;
      white-space: nowrap; 
    }

    .footer-center {
      flex: 10;
      text-align: center;
      margin-top: -20px;
    }

    .footer-center h3 {
      margin-bottom: 16px;
      font-size: 1.4rem;
      margin-top: -10px;
    }

    .footer-center ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-center li {
      margin-bottom: 10px;
    }

    .footer-center a {
      color: #fff8f0;
      font-size: 1.05rem;
      transition: .3s;
    }

    .footer-center a:hover {
      color: #f1c27d;
    }

    .footer-right {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: flex-end; 
      text-align: right;
    }

    .footer-right h3 {
      margin: 0 0 14px;
      font-size: 1.2rem;
      color: #fff8f0;
      white-space: nowrap; 
      margin-top: -30px;
    }

    .social-icons {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 14px;
    }

    .social-icons a {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .social-icons img {
      width: 34px;
      height: 34px;
      object-fit: contain;
      transition: 0.3s ease;
    }

    .social-icons img:hover {
      transform: scale(1.12);
    }

    .footer-cups {
      width: 100vw;
      height: 120px;
      position: relative;
      display: flex;
      justify-content: space-evenly;
      align-items: flex-end;
      padding: 0 10px;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
      overflow: visible;
      background: transparent;
    }

    .footer-cups::before {
      content: '';
      position: absolute;
      left: 0;
      top: 100%;
      transform: translateY(-50%);
      width: 100%;
      height: 90px;
      background: #8b6345;
      z-index: 1;
    }

    .footer-cups img {
      position: relative;
      z-index: 3;
      width: auto;
      height: 110px;
      object-fit: contain;
      display: block;
      flex-shrink: 0;
    }

    .footer-cups img:nth-child(1){ transform:translateY(-10px); }
    .footer-cups img:nth-child(2){ transform:translateY(8px); }
    .footer-cups img:nth-child(3){ transform:translateY(-6px); }
    .footer-cups img:nth-child(4){ transform:translateY(5px); }
    .footer-cups img:nth-child(5){ transform:translateY(-10px); }
    .footer-cups img:nth-child(6){ transform:translateY(8px); }
    .footer-cups img:nth-child(7){ transform:translateY(-6px); }
    .footer-cups img:nth-child(8){ transform:translateY(5px); }
    .footer-cups img:nth-child(9){ transform:translateY(-10px); }
    .footer-cups img:nth-child(10){ transform:translateY(8px); }
    .footer-cups img:nth-child(11){ transform:translateY(-6px); }

    @media (max-width: 900px) {
      header { flex-direction: column; padding: 15px; gap: 15px; }
      .logo img { width: 130px; }
      .hero h1 { font-size: 2.5rem; }
      section.menu { flex-direction: column; height: auto; }
      .menu .left, .menu .right { flex: unset; height: 60vh; }
      .menu .right { padding: 40px 30px; text-align: center; }
      .menu-item { font-size: 1.5rem; }
      .menu-item::after { left: 10%; width: 80%; }
      .polaroid { width: 160px; }
      .polaroid img { height: 200px; }
      .footer-container { flex-direction: column; text-align: center; align-items: center; gap: 30px; }
      .footer-left img { margin-top: 0; }
      .footer-right h3 { margin-top: 0; }
      .footer-left, .footer-center, .footer-right { text-align: center; }
      .social-icons { justify-content: center; }
      .footer-cups img { width: 70px; }
    }
  </style>
</head>

<body>
  <header id="navbar">
    <div class="logo">
      <img src="{{ asset('media/logo.png') }}" alt="Logo Kopikala">
    </div>
    <nav>
      <a href="{{ route('menu') }}">menu</a>
      <a href="{{ route('frontend.about') }}">tentang</a>
      <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
      <a href="{{ route('frontend.order') }}">pemesanan</a>

      @auth
      <div class="profile-wrapper">
        <img 
          src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('media/default-avatar.png') }}"
          alt="Profile"
          id="profileToggle"
          class="profile-avatar"
        >
        
        <div class="profile-dropdown" id="profileMenu">
          <div class="user-info">
            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('media/default-avatar.png') }}" alt="Profile"> 
            <div class="user-text-details">
              <h4>{{ auth()->user()->name }}</h4>
              <span>{{ auth()->user()->email }}</span>
            </div>
          </div>
          
          <a href="{{ route('profile.show') }}" class="dropdown-link">
            <span>My Profile</span> <i class="fas fa-chevron-right"></i>
          </a>

          <form action="{{ route('logout.user') }}" method="POST" style="display:block; margin:0;">
            @csrf
            <button type="submit" class="dropdown-link logout">
                <span>Log Out</span> <i class="fas fa-sign-out-alt"></i>
            </button>
          </form>
        </div>
      </div>
      @else
        <a href="{{ route('login') }}" class="btn-kontak">Login</a>
      @endauth
    </nav>
  </header>

  <section class="hero" id="home">
    <h1>Harga Terjangkau,<br>Kualitas Terjaga!</h1>
  </section>

  <section class="kenalan" id="tentang">
    <img src="{{ asset('media/kopi1.png') }}" class="kopi-dekorasi kopi-left-top" alt="kopi">
    <img src="{{ asset('media/kopi2.png') }}" class="kopi-dekorasi kopi-left-bottom" alt="kopi">
    <img src="{{ asset('media/kopi3.png') }}" class="kopi-dekorasi kopi-right-top" alt="kopi">
    <img src="{{ asset('media/kopi4.png') }}" class="kopi-dekorasi kopi-right-bottom" alt="kopi">

    <div class="content">
      <h2>Kenalin, Kami Kopikala!</h2>
      <p>Nama "Kopikala" berasal dari dua kata sederhana, "kopi" dan "kala," yang berarti "kopi pada saat itu" – sebuah momen yang menyatukan kami sebagai tim dalam proyek kewirausahaan, dengan satu kesamaan: kecintaan pada kopi.</p>
      <p>Di Kopikala, kami percaya bahwa kopi bukan sekadar minuman. Kopi adalah sumber energi dan inspirasi yang menghidupkan setiap momen. Dengan komitmen kuat, kami menghadirkan kopi berkualitas tinggi yang terjangkau bagi siapa saja yang membutuhkan semangat ekstra.</p>
    </div>
  </section>

  <section class="menu" id="menu">
    <div class="left" id="menuImage">
      <div class="menu-detail-overlay" id="menuOverlay">Kopi Susu - Kopi, Susu, Gula</div>
    </div>
    
    <div class="right">
      <h1>Menu Kopikala</h1>
      <div class="menu-item" data-img="{{ asset('media/kopikala.png') }}" data-text="Kopikala - Kopi, Susu, Gula Aren">Kopikala</div>
      <div class="menu-item" data-img="{{ asset('media/kopi susu.png') }}" data-text="Kopi Susu - Kopi, Susu, Gula">Kopi Susu</div>
      <div class="menu-item" data-img="{{ asset('media/susu aren.png') }}" data-text="Susu Aren - Susu, Gula Aren">Susu Aren</div>
      <div class="menu-item" data-img="{{ asset('media/susu pisang.jpg') }}" data-text="Susu Pisang - Susu, Ekstrak Pisang">Susu Pisang</div>
      
      <div class="footer">
        Pemesanan melalui gofood dan Instagram <b>@kopikalaaaa</b>
      </div>
    </div>
  </section>

  <section class="sobatkala" id="sobatkala">
    <div class="content">
      <h2>Momen bersama <span>#sobatkala</span></h2>
      <p>Kamu sudah jadi bagian dari <b>#sobatkala</b> belum?</p>

      <div class="gallery">
        <div class="polaroid rotate-left"><img src="{{ asset('media/sobat1.jpg') }}" alt="Sobatkala 1"></div>
        <div class="polaroid rotate-right"><img src="{{ asset('media/sobat2.jpg') }}" alt="Sobatkala 2"></div>
        <div class="polaroid rotate-left"><img src="{{ asset('media/sobat3.jpg') }}" alt="Sobatkala 3"></div>
        <div class="polaroid rotate-right"><img src="{{ asset('media/sobat4.jpg') }}" alt="Sobatkala 4"></div>
        <div class="polaroid rotate-left"><img src="{{ asset('media/sobat5.jpg') }}" alt="Sobatkala 5"></div>
        <div class="polaroid rotate-right"><img src="{{ asset('media/sobat6.jpg') }}" alt="Sobatkala 6"></div>
        <div class="polaroid rotate-left"><img src="{{ asset('media/sobat7.jpg') }}" alt="Sobatkala 7"></div>
        <div class="polaroid rotate-right"><img src="{{ asset('media/sobat8.jpg') }}" alt="Sobatkala 8"></div>
        <div class="polaroid rotate-left"><img src="{{ asset('media/sobat9.jpg') }}" alt="Sobatkala 9"></div>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer-container">
      <div class="footer-left">
        <img src="{{ asset('media/logo.png') }}" alt="Logo Kopikala">
        <p>Harga Terjangkau, Kualitas Terjaga!</p>
      </div>

      <div class="footer-center">
        <h3>Info Kopikala</h3> 
        <ul>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#sobatkala">#sobatkala</a></li>
          <li><a href="#tentang">Tentang Kopikala</a></li><br>
        </ul>
      </div>

      <div class="footer-right">
        <h3>Ayo jadi #sobatkala!</h3>
        <div class="social-icons">
          <a href="https://www.instagram.com/kopikalaaa/" target="_blank">
            <img src="{{ asset('media/Instagram.png') }}" alt="Instagram">
          </a>
          <a href="https://linkedin.com/company/kopikala" target="_blank">
            <img src="{{ asset('media/Linkedin.png') }}" alt="LinkedIn">
          </a>
          <a href="https://wa.me/6281410882927" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('media/Whatsapp.png') }}" alt="WhatsApp">
          </a>
        </div>
      </div>
    </div>

    <div class="footer-cups">
      <img src="{{ asset('media/Kopi Ga Miring01.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring02.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring03.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring04.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring01.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring02.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring03.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring04.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring01.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring02.png') }}" alt="cup">
      <img src="{{ asset('media/Kopi Ga Miring03.png') }}" alt="cup">
    </div>
  </footer>

<script>
    // 1. SCROLL NAVBAR
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 2. INTERAKSI MENU
    const menuImage = document.getElementById('menuImage');
    const menuOverlay = document.getElementById('menuOverlay');
    const defaultImage = "{{ asset('media/menu.jpg') }}";
    const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const targetImg = item.getAttribute('data-img');
            const targetText = item.getAttribute('data-text');

            if (item.classList.contains('active')) {
                item.classList.remove('active');
                menuImage.style.backgroundImage = `url('${defaultImage}')`;
                menuOverlay.style.display = 'none';
            } else {
                menuItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                menuImage.style.backgroundImage = `url('${targetImg}')`;
                menuOverlay.innerText = targetText;
                menuOverlay.style.display = 'block';
            }
        });
    });

    // 3. TOGGLE PROFILE MENU
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.style.display =
                profileMenu.style.display === 'block' ? 'none' : 'block';
        });
    }

    // 4. CLOSE PROFILE MENU WHEN CLICK OUTSIDE
    window.addEventListener('click', (e) => {
        if (profileMenu && profileMenu.style.display === 'block') {
            if (!profileMenu.contains(e.target) && e.target !== profileToggle) {
                profileMenu.style.display = 'none';
            }
        }
    });
</script>
</body>
</html>