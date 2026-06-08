<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>#Sobatkala - Kopikala</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">

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

/* ================= PROFILE ================= */

.profile-wrapper{
    position:relative;
}

.profile-avatar{
    width:45px;
    height:45px;
    border-radius:50%;
    object-fit:cover;
    cursor:pointer;
    border:2px solid rgba(255,255,255,.7);
}

.profile-dropdown{
    position:absolute;
    right:0;
    top:60px;

    width:250px;
    background:white;

    border-radius:15px;
    padding:15px;

    display:none;

    box-shadow:0 10px 30px rgba(0,0,0,.2);
}

.user-info{
    display:flex;
    gap:10px;
    margin-bottom:15px;
}

.user-info img{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}

.dropdown-link{
    display:flex;
    justify-content:space-between;
    text-decoration:none;
    color:#3c1f0e;
    padding:10px 0;
}

.dropdown-link.logout{
    color:red;
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
    background-color:#3c1f0e;
    color:#fff8f0;

    padding:70px 60px 0;

    position:relative;
    overflow:hidden;
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
    width:180px;
    height:auto;
}

.footer-left p{
    margin-top:10px;

    font-size:1.05rem;
    color:#f8e6cc;

    max-width:280px;
    line-height:1.6;
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

footer {
    margin-top: 90px;
    background: #3b1604;
    color: white;
    padding-top: 80px;
    padding-bottom: 25px;
}

.footer-container {
    max-width: var(--container);
    margin: 0 auto;

    padding: 0 45px;

    display: flex;
    justify-content: space-between;

    align-items: flex-start; 
}

.footer-left img {
    width: 190px; /* kecilin logo */
    margin-top: -60px;

}

.footer-left p {
    margin-top: 6px;
    font-size: 15px;
    white-space:nowrap; /* biar ga turun */
}

.footer-title {
    font-size: 18px; /* kecilin title */
    margin-bottom: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px;
}

/* ================= FOOTER RIGHT ================= */

.footer-right{
    flex:1;

    display:flex;
    flex-direction:column;

    align-items:flex-end; /* pojok kanan */
    text-align:right;
}

/* Judul */
.footer-right h3{
    margin:0 0 14px;

    font-size:1.2rem;
    color:#fff8f0;

    white-space:nowrap; /* biar ga turun */
    margin-top: -30px;
}

/* ================= SOCIAL ICONS ================= */

.social-icons{
    display:flex;
    justify-content:flex-end;
    align-items:center;

    gap:14px;
}

/* Link */
.social-icons a{
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Icon */
.social-icons img{
    width:34px;
    height:34px;

    object-fit:contain;

    transition:0.3s ease;
}

/* Hover */
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

    /* background utama footer */
    background:transparent;
}

/* COKLAT MUDA DI TENGAH */
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

/* CUP */
.footer-cups img{
    position:relative;
    z-index:3;

    width:auto;
    height:110px;

    object-fit:contain;
    display:block;

    flex-shrink:0;
}

/* POSISI CUP BEBAS */
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


</style>
</head>
<body>

<header id="navbar">

    <div class="logo">
        <img src="{{ asset('media/logo.png') }}">
    </div>

    <nav>

        <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">pemesanan</a>

        @auth

            <div class="profile-wrapper">

                <img
                    src="{{ auth()->user()->avatar
                        ? asset('storage/'.auth()->user()->avatar)
                        : asset('media/default-avatar.png') }}"
                    id="profileToggle"
                    class="profile-avatar">

                <div class="profile-dropdown" id="profileMenu">

                    <div class="user-info">

                        <img
                            src="{{ auth()->user()->avatar
                                ? asset('storage/'.auth()->user()->avatar)
                                : asset('media/default-avatar.png') }}">

                        <div>
                            <h4>{{ auth()->user()->name }}</h4>
                            <small>{{ auth()->user()->email }}</small>
                        </div>

                    </div>

                    <a href="{{ route('profile.show') }}"
                       class="dropdown-link">
                        My Profile
                        <i class="fas fa-chevron-right"></i>
                    </a>

                    <form action="{{ route('logout.user') }}"
                          method="POST">
                        @csrf

                        <button type="submit"
                                class="dropdown-link logout"
                                style="border:none;background:none;width:100%;cursor:pointer;">
                            Logout
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>

                </div>

            </div>

        @else

            <a href="{{ route('login') }}"
               class="btn-kontak">
                Login
            </a>

        @endauth

    </nav>

</header>

<section class="sobatkala-section">

    <img
        src="{{ asset('media/sobatkala.png') }}"
        class="sobatkala-image"
        alt="#Sobatkala">

</section>

<footer>

    <div class="footer-container">

        <div class="footer-left">

            <img src="{{ asset('media/logo.png') }}">

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

                <a href="https://www.instagram.com/kopikalaaa/" target="_blank">
        <img src="media/Instagram.png" alt="Instagram">
        </a>
         <a href="https://linkedin.com/company/kopikala"
   target="_blank">
    <img src="media/Linkedin.png" alt="LinkedIn">
</a>
          <a href="https://wa.me/6281410882927"
   target="_blank"
   rel="noopener noreferrer">
    <img src="media/Whatsapp.png" alt="WhatsApp">
</a>

            </div>

        </div>

    </div>

    <div class="footer-cups">

        <img src="{{ asset('media/Kopi Ga Miring01.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring02.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring03.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring04.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring01.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring02.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring03.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring04.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring02.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring03.png') }}">
        <img src="{{ asset('media/Kopi Ga Miring04.png') }}">

    </div>

</footer>

<script>

const navbar=document.getElementById('navbar');

window.addEventListener('scroll',()=>{

    if(window.scrollY>50){
        navbar.classList.add('scrolled');
    }else{
        navbar.classList.remove('scrolled');
    }

});

const profileToggle=document.getElementById('profileToggle');
const profileMenu=document.getElementById('profileMenu');

if(profileToggle){

    profileToggle.addEventListener('click',(e)=>{

        e.stopPropagation();

        profileMenu.style.display=
            profileMenu.style.display==='block'
            ?'none'
            :'block';

    });

    window.addEventListener('click',()=>{

        profileMenu.style.display='none';

    });

}

</script>

</body>
</html>