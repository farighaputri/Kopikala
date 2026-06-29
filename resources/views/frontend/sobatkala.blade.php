<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>#Sobatkala - Kopikala</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght=700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Comic Neue',cursive;
    background:#7a5640;
    overflow-x:hidden;
}

/* ================= HEADER ================= */
header{
    width:100%;
    position:fixed;
    top:0;
    left:0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    z-index:999;
    transition:.3s;
}

header.scrolled{
    background:rgba(60,31,14,.92);
    backdrop-filter:blur(10px);
}

.logo img{
    width:280px;
}

nav{
    display:flex;
    align-items:center;
    gap:30px;
}

nav a{
    color:white;
    text-decoration:none;
    font-size:18px;
}

nav a:hover{
    color:#f1c27d;
}

.btn-kontak{
    background:#efe3d3;
    color:#3c1f0e;
    padding:10px 25px;
    border-radius:4px;
}

/* ================= PROFILE DROPDOWN WRAPPER ================= */
.profile-wrapper{
    position:relative;
    display: inline-block;
}

.profile-avatar{
    width:45px;
    height:45px;
    border-radius:50%;
    object-fit:cover;
    cursor:pointer;
    border:2px solid rgba(255,255,255,.7);
}

/* Kotak Dropdown Rapi Maksimal */
.profile-dropdown{
    position:absolute;
    right:0;
    top:60px;
    width:320px; /* Ditambah lebar box agar seimbang */
    background:white;
    border-radius:20px;
    padding:22px;
    display:none;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
    border: 1px solid #E6DED5;
    text-align: left;
}

.user-info{
    display:flex;
    align-items: center;
    gap:14px;
    margin-bottom:16px;
    width: 100%;
}

.user-info img{
    width:54px;
    height:54px;
    border-radius:50%;
    object-fit:cover;
    flex-shrink: 0;
    border: 1px solid #D8CABD;
}

.user-text-details {
    flex: 1;
    min-width: 0; /* Mencegah flexbox meleset keluar */
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
    word-break: break-word; /* Teks nama turun otomatis jika kepanjangan */
    white-space: normal;
}

.user-info small {
    font-family: 'Plus Jakarta Sans', sans-serif; /* Font khusus email agar presisi */
    font-size: 13px;
    color: #6E5443;
    overflow: hidden;
    text-overflow: ellipsis; /* Email panjang otomatis berujung titik-titik (...) */
    white-space: nowrap;
}

.dropdown-link{
    display:flex;
    justify-content:space-between;
    align-items: center;
    width: 100%;
    padding: 12px 6px;
    text-decoration:none;
    color:#3c1f0e;
    font-size: 18px;
    background: transparent;
    border: none;
    border-top:1px solid #E6DED5;
    font-family: 'Comic Neue', cursive;
    cursor: pointer;
    transition: color 0.2s ease;
}

.dropdown-link:hover{
    color:#f1c27d;
}

.dropdown-link.logout{
    color:#ff4d4d;
}

.dropdown-link.logout:hover {
    color: #cc0000;
}

/* ================= CONTENT ================= */
.sobatkala-section{
    width:100%;
    margin-top:90px;
}

.sobatkala-image{
    width:100%;
    display:block;
}

/* ================= FOOTER ================= */
footer{
    background:#3b1604;
    color:#fff8f0;
    padding:70px 45px 25px;
    position: relative;
    overflow:hidden;
    margin-top: 90px;
}

/* CONTAINER */
.footer-container{
    max-width:1200px;
    margin:0 auto;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:50px;
    position:relative;
    z-index:5;
}

/* ================= LEFT ================= */
.footer-left{
    flex:1;
}

.footer-left img{
    width:190px;
    height:auto;
    margin-top: -60px;
}

.footer-left p{
    margin-top:6px;
    font-size:15px;
    color:#f8e6cc;
    white-space:nowrap;
}

/* ================= CENTER ================= */
.footer-center{
    flex:10;
    text-align:center;
    margin-top: -20px;
}

.footer-center h3{
    margin-bottom:16px;
    font-size:1.4rem;
    margin-top: -10px;
}

.footer-center ul{
    list-style:none;
    padding:0;
    margin:0;
}

.footer-center li{
    margin-bottom:10px;
}

.footer-center a{
    color:#fff8f0;
    font-size:1.05rem;
    transition:.3s;
}

.footer-center a:hover{
    color:#f1c27d;
}

/* ================= FOOTER RIGHT ================= */
.footer-right{
    flex:1;
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    text-align:right;
}

.footer-right h3{
    margin:0 0 14px;
    font-size:1.2rem;
    color:#fff8f0;
    white-space:nowrap;
    margin-top: -30px;
}

/* ================= SOCIAL ICONS ================= */
.social-icons{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:14px;
}

.social-icons a{
    display:flex;
    justify-content:center;
    align-items:center;
}

.social-icons img{
    width:34px;
    height:34px;
    object-fit:contain;
    transition:0.3s ease;
}

.social-icons img:hover{
    transform:scale(1.12);
}

/* ================= FOOTER CUPS ================= */
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

.footer-cups img{
    position:relative;
    z-index:3;
    width:auto;
    height:110px;
    object-fit:contain;
    display:block;
    flex-shrink:0;
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

/* ================= MOBILE RESPONSIVE ================= */
@media (max-width: 900px) {
    header { flex-direction: column; padding: 15px; gap: 15px; }
    .logo img { width: 120px; }
    .footer-container { flex-direction: column; text-align: center; align-items: center; gap: 30px; }
    .footer-left img { margin-top: 0; }
    .footer-right h3 { margin-top: 0; }
    .footer-left, .footer-center, .footer-right { align-items: center; text-align: center; }
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
                    src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('media/default-avatar.png') }}"
                    id="profileToggle"
                    class="profile-avatar"
                    alt="Profile Avatar"
                >

                <div class="profile-dropdown" id="profileMenu">
                    <div class="user-info">
                        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('media/default-avatar.png') }}" alt="User Photo">
                        <div class="user-text-details">
                            <h4>{{ auth()->user()->name }}</h4>
                            <small>{{ auth()->user()->email }}</small>
                        </div>
                    </div>

                    <a href="{{ route('profile.show') }}" class="dropdown-link">
                        <span>My Profile</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>

                    <form action="{{ route('logout.user') }}" method="POST" style="display:block; margin:0;">
                        @csrf
                        <button type="submit" class="dropdown-link logout">
                            <span>Logout</span>
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-kontak">Login</a>
        @endauth
    </nav>
</header>

<section class="sobatkala-section">
    <img src="{{ asset('media/sobatkala.png') }}" class="sobatkala-image" alt="#Sobatkala">
</section>

<footer>
    <div class="footer-container">
        <div class="footer-left">
            <img src="{{ asset('media/logo.png') }}" alt="Logo Footer">
            <p>Harga Terjangkau, Kualitas Terjaga!</p>
        </div>

        <div class="footer-center">
            <h3>Info Kopikala</h3>
            <ul>
                <li><a href="{{ route('menu') }}">Menu</a></li>
                <li><a href="{{ route('frontend.sobatkala') }}">#Sobatkala</a></li>
                <li><a href="{{ route('frontend.about') }}">Tentang Kopikala</a></li>
            </ul>
        </div>

        <div class="footer-right">
            <h3>Ayo jadi #sobatkala!</h3>
            <div class="social-icons">
                <!-- Sync Absolute Image Path Bawaan Laravel -->
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
        <img src="{{ asset('media/Kopi Ga Miring02.png') }}" alt="cup">
        <img src="{{ asset('media/Kopi Ga Miring03.png') }}" alt="cup">
        <img src="{{ asset('media/Kopi Ga Miring04.png') }}" alt="cup">
    </div>
</footer>

<script>
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

const profileToggle = document.getElementById('profileToggle');
const profileMenu = document.getElementById('profileMenu');

if (profileToggle && profileMenu) {
    profileToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Perbaikan agar menutup pop-up hanya saat klik di luar area modal sepenuhnya
    window.addEventListener('click', (e) => {
        if (profileMenu && !profileMenu.contains(e.target)) {
            profileMenu.style.display = 'none';
        }
    });
}
</script>

</body>
</html>