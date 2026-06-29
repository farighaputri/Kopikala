<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      background-color: transparent;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      z-index: 10;
    }

    header.scrolled {
      background-color: rgba(43, 20, 7, 0.95);
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(6px);
    }

    .logo img {
      width: 170px;
      height: auto;
      filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.4));
      transition: transform 0.3s ease;
    }

    nav {
      display: flex;
      gap: 30px;
      align-items: center;
    }

    nav a {
      text-decoration: none;
      color: #fff8f0;
      font-weight: 600;
      font-size: 1.05rem;
      transition: 0.3s;
    }

    nav a:hover {
      color: #f1c27d;
    }

    .btn-kontak {
      background: #f1c27d;
      color: #2e1b0e;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
    }

    .btn-kontak:hover {
      background: #e0b16e;
    }

    /* ================= DROPDOWN PROFIL WRAPPER ================= */
    .profile-wrapper {
      position: relative;
      display: inline-block;
    }

    .profile-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      border: 2px solid white;
      transition: .3s;
    }

    .profile-avatar:hover {
      transform: scale(1.08);
    }

    /* Kotak Dropdown Rapi Maksimal */
    .profile-dropdown {
      position: absolute;
      top: 130%;
      right: 0;
      width: 320px;
      background: white;
      border-radius: 20px;
      padding: 22px;
      display: none;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      z-index: 1000;
      border: 1px solid #E6DED5;
      text-align: left;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 16px;
      width: 100%;
    }

    .user-info img {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 1px solid #D8CABD;
    }

    .user-text-details {
      flex: 1;
      min-width: 0;
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
      word-break: break-word;
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

    /* === HERO === */
    .hero {
      position: relative;
      height: 100vh;
      background:
        linear-gradient(rgba(27, 13, 0, 0.83), rgba(71, 35, 1, 0.83)),
        url("{{ asset('media/BG JAM.png') }}") center/cover no-repeat;
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 130px 20px;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    }

    .hero p {
      max-width: 700px;
      margin: 0 auto;
      font-size: 1.2rem;
      line-height: 1.7;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
    }

    .hero button {
      margin-top: 25px;
      background-color: #f1c27d;
      color: #2e1b0e;
      border: none;
      padding: 10px 25px;
      font-weight: 700;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .hero button:hover {
      background-color: #e0b16e;
    }

    /* === GALLERY POLAROID === */
    .gallery {
      position: relative;
      width: 100%;
      height: 370px;
      margin-top: -180px;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      z-index: 2;
      overflow: visible;
    }

    .gallery-inner {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: flex-end;
    }

    .polaroid {
      background: #fff;
      padding: 12px 12px 35px;
      width: 300px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      border-radius: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      margin-left: -80px;
    }

    .polaroid:first-child { margin-left: 0; }
    .polaroid img { width: 100%; height: 220px; object-fit: cover; border-radius: 4px; }

    .polaroid:nth-child(1) { top: 30px; transform: rotate(-5deg); z-index: 1; }
    .polaroid:nth-child(2) { top: -10px; transform: rotate(3deg); z-index: 2; }
    .polaroid:nth-child(3) { top: 20px; transform: rotate(-2deg); z-index: 3; }
    .polaroid:nth-child(4) { top: -25px; transform: rotate(4deg); z-index: 4; }
    .polaroid:nth-child(5) { top: 15px; transform: rotate(-4deg); z-index: 5; }
    .polaroid:nth-child(6) { top: -5px; transform: rotate(3deg); z-index: 6; }

    .polaroid:hover { transform: scale(1.07) rotate(0deg); z-index: 10; }

    /* === ABOUT === */
    .about {
      background-color: #f4ecdf;
      padding: 80px 10% 50px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
      flex-wrap: wrap;
    }

    .about .text { flex: 1 1 400px; }
    .about .text h2 { font-size: 2rem; margin-bottom: 20px; color: #3a1d0a; }
    .about .text p { font-size: 1.2rem; line-height: 1.8; color: #4b2b16; }

    .about .illustration img {
      width: 380px;
      height: auto;
      transform: scale(1.05);
      transition: transform 0.3s ease;
    }
    .about .illustration img:hover { transform: scale(1.1); }

    /* === KOMITMEN === */
    .commitment {
      text-align: center;
      background-color: #f4ecdf;
      padding: 20px 0 40px;
      margin-top: -30px;
    }

    .commitment h3 { font-size: 1.5rem; margin-bottom: 20px; color: #3a1d0a; }
    .commitment .list {
      display: flex;
      justify-content: center;
      gap: 25px;
      flex-wrap: wrap;
    }
    .commitment .list div {
      background-color: #3c1f0e;
      color: white;
      padding: 10px 25px;
      border-radius: 6px;
      font-size: 1.1rem;
    }

    /* === TEAM === */
    .team {
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #3c1f0e;
    }

    .team img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* === PENJUALAN === */
    .penjualan-section {
      background-color: #f2e8d9;
      text-align: center;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .penjualan-section .judul-atas { font-size: 25px; margin-bottom: 8px; }
    .penjualan-section .highlight img { width: 100%; max-width: 970px; height: auto; object-fit: cover; display: block; }
    .penjualan-section .periode { font-size: 15px; margin-top: 10px; margin-bottom: 15px; }
    .penjualan-section .deskripsi { font-size: 18px; line-height: 1.6; max-width: 950px; }

    /* === KOLASE FOTO === */
    .kolase-wrapper {
      background-color: #3c1f0e;
      color: white;
      text-align: center;
      padding: 35px 0;
      margin-top: -10px;
      width: 100vw;
      position: relative;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
    }

    .kolase-wrapper .quote { font-size: 24px; text-align: center; margin-bottom: 40px; max-width: 900px; line-height: 1.5; margin-left: auto; margin-right: auto; }
    .kolase-wrapper img { display: block; width: 100vw; height: auto; margin: 0; }

    /* ================= FOOTER ================= */
    footer{
      background:#3b1604;
      color:#fff8f0;
      padding:70px 45px 25px;
      overflow:hidden;
    }

    .footer-container{
      max-width: 1200px;
      margin: 0 auto;
      display:flex;
      justify-content:space-between;
      align-items:flex-start;
      gap:50px;
    }

    .footer-left{
      flex:1;
      display:flex;
      flex-direction:column;
      align-items:flex-start;
      text-align:left;
    }

    .footer-left img{ width:190px; margin-bottom:10px; }
    .footer-left p{ font-size:15px; color: #f8e6cc; white-space: nowrap; }

    .footer-center{
      flex:1;
      display:flex;
      flex-direction:column;
      align-items:center;
      text-align:center;
    }

    .footer-center h3{ font-size:1.4rem; margin-bottom:16px; }
    .footer-center ul{ list-style:none; }
    .footer-center li{ margin-bottom:10px; }
    .footer-center a{ color:white; text-decoration:none; font-size:1.05rem; transition: .3s; }
    .footer-center a:hover{ color: #f1c27d; }

    .footer-right{
      flex:1;
      display:flex;
      flex-direction:column;
      align-items:flex-end;
      text-align:right;
    }

    .footer-right h3{ font-size:1.2rem; margin-bottom:14px; white-space: nowrap; }

    .social-icons{
      display:flex;
      justify-content:flex-end;
      gap:14px;
    }

    .social-icons a { display: flex; justify-content: center; align-items: center; }
    .social-icons img { width: 34px; height: 34px; object-fit: contain; transition: 0.3s ease; }
    .social-icons img:hover { transform: scale(1.12); }

    .footer-cups{
      width:100vw;
      height:120px;
      position:relative;
      display:flex;
      justify-content:space-evenly;
      align-items:flex-end;
      padding:0 10px;
      left:50%;
      right:50%;
      margin-left:-50vw;
      margin-right:-50vw;
      overflow:visible;
      background:transparent;
    }

    .footer-cups::before{
      content:'';
      position:absolute;
      left:0;
      top:100%;
      transform:translateY(-50%);
      width:100%;
      height:90px;
      background:#8b6345;
      z-index:1;
    }

    .footer-cups img{ position:relative; z-index:3; width:auto; height:110px; object-fit:contain; display:block; flex-shrink:0; }
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

    /* ================= RESPONSIVE ================= */
    @media (max-width: 900px) {
      header { flex-direction: column; padding: 15px; gap: 15px; }
      .logo img { width: 120px; }
      .hero h1 { font-size: 2.2rem; }
      .polaroid { width: 150px; }
      .polaroid img { height: 190px; }
      .about { flex-direction: column; text-align: center; }
      .about .illustration img { width: 300px; }
      .footer-container { flex-direction: column; text-align: center; align-items: center; gap: 30px; }
      .footer-left, .footer-center, .footer-right { align-items: center; text-align: center; }
      .social-icons { justify-content: center; }
      .footer-cups img { width: 70px; }
      .penjualan-section .highlight img { max-width: 300px; }
      .penjualan-section .deskripsi { font-size: 16px; max-width: 300px; }
      .kolase-wrapper .quote { font-size: 18px; }
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
          class="profile-avatar"
          id="profileToggle"
          alt="Profile"
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

  <section class="hero">
    <h1>Harga Terjangkau, Kualitas Terjaga!</h1>
    <p>Kami percaya bahwa menikmati kopi terbaik tidak harus mahal. Kopikala hadir sebagai teman cerita, memberikan energi dan inspirasi bagi siapa saja yang membutuhkan semangat di setiap momen mereka.</p>
    <button>geser untuk mengetahui lebih banyak ↓</button>
  </section>

  <section class="gallery" id="sobatkala">
    <div class="gallery-inner">
      <div class="polaroid"><img src="{{ asset('media/land1.jpg') }}" alt="Momen 1"></div>
      <div class="polaroid"><img src="{{ asset('media/land2.jpg') }}" alt="Momen 2"></div>
      <div class="polaroid"><img src="{{ asset('media/land3.jpg') }}" alt="Momen 3"></div>
      <div class="polaroid"><img src="{{ asset('media/land4.jpg') }}" alt="Momen 4"></div>
      <div class="polaroid"><img src="{{ asset('media/land5.jpg') }}" alt="Momen 5"></div>
      <div class="polaroid"><img src="{{ asset('media/land6.jpg') }}" alt="Momen 6"></div>
    </div>
  </section>

  <section class="about" id="about">
    <div class="text">
      <h2>Kami menyajikan kopi murah yang berkualitas!</h2>
      <p>Di Kopikala, kami percaya bahwa kopi bukan sekadar minuman. Kopi adalah sumber energi dan motivasi yang menyatukan setiap momen. Dengan komitmen kami, kami menyajikan kopi berkualitas tinggi yang terjangkau bagi siapa saja yang membutuhkan semangat ekstra.</p>
    </div>
    <div class="illustration">
      <img src="{{ asset('media/gelas.png') }}" alt="Ilustrasi Kopi">
    </div>
  </section>

  <section class="commitment">
    <h3>Kopikala berkomitmen untuk...</h3>
    <div class="list">
      <div>✔ Menyajikan Kopi Berkualitas</div>
      <div>✔ Harga Terjangkau</div>
      <div>✔ Menjaga Kualitas</div>
    </div>
  </section>

  <section class="team">
    <img src="{{ asset('media/tim.png') }}" alt="Tim Kopikala">
  </section>

  <section class="penjualan-section">
    <p class="judul-atas">dengan lebih dari</p>
    <div class="highlight">
      <img src="{{ asset('media/penjualan 300.png') }}" alt="300+ Penjualan Kopikala">
    </div>
    <p class="periode">Periode pre-order Oktober sampai dengan Desember 2024</p>
    <p class="deskripsi">
      Kopikala bertekad untuk terus menghadirkan kopi berkualitas bagi <b>#sobatkala</b>,
      memberikan pengalaman ngopi yang nikmat dengan harga yang tetap ramah di kantong.
      <br><br>
      Kami akan terus berinovasi dan memastikan setiap tegukan kopi dari Kopikala
      memberikan energi serta kebahagiaan bagi <b>#sobatkala</b>!
    </p>
  </section>

  <section class="kolase-wrapper">
    <p class="quote">
      "Kopikala bukan sekadar kopi, tapi bentuk semangat dan cerita dari setiap <b>#sobatkala</b> yang menikmati setiap tegukannya."
    </p>
    <img src="{{ asset('media/moment.png') }}" alt="Kolase Kopikala">
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
          <li><a href="#tentang">Tentang Kopikala</a></li>
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
            <img src="{{ asset('media/Whatsapp.png') }}" alt="Whatsapp">
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
    // Efek navbar berganti warna saat di-scroll
    window.addEventListener('scroll', function() {
      const header = document.getElementById('navbar');
      if (window.scrollY > 50) header.classList.add('scrolled');
      else header.classList.remove('scrolled');
    });

    // Toggle Menu Dropdown Profil
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle && profileMenu) {
      profileToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu.style.display =
          profileMenu.style.display === 'block' ? 'none' : 'block';
      });
    }

    // Menutup dropdown otomatis jika klik di luar elemen modal
    window.addEventListener('click', (e) => {
      if (profileMenu && !profileMenu.contains(e.target)) {
        profileMenu.style.display = 'none';
      }
    });
  </script>
</body>
</html>