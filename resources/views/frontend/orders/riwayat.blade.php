<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesanan Saya - Kopikala</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
/* =========================================
   KOPIKALA - PESANAN SAYA (PIXEL PERFECT)
========================================= */

/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --cream: #f3ede2;
    --brown: #4a210b;
    --brown-light: #7a5234;
    --text: #3b1f0d;
    --muted: #6e5443;
    --white: #ffffff;
    --card-bg: #f3ede2;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
    --radius: 22px;
    --container: 1400px;
}

body {
    font-family: 'Patrick Hand', cursive;
    background: var(--cream) url("{{ asset('media/BG JAM.png') }}") repeat;
    background-size: 1200px auto;
    color: var(--text);
    min-height: 100vh;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(243, 237, 226, 0.92);
    z-index: -1;
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    display: block;
    max-width: 100%;
}

/* =========================================
   HEADER
========================================= */
.topbar {
    max-width: var(--container);
    margin: 0 auto;
    padding: 28px 45px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 56px;
    width: auto;
}

.nav {
    display: flex;
    align-items: center;
    gap: 52px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
}

.nav a {
    transition: 0.2s ease;
}

.nav a:hover {
    color: var(--brown-light);
}

.nav form {
    margin: 0;
}

.login-btn {
    background: none;
    border: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    cursor: pointer;
}

/* =========================================
   MAIN
========================================= */
.main {
    max-width: var(--container);
    margin: 0 auto;
    padding: 20px 45px 80px;
}

/* TITLE + PICKUP BOX */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 40px;
    margin-bottom: 42px;
}

.page-title {
    font-size: 62px;
    font-weight: 400;
    line-height: 1;
    color: var(--brown);
    margin-top: 42px;
}

/* PICKUP BOX */
.pickup-box {
    width: 430px;
    background: var(--brown-light);
    color: #fff;
    border-radius: 18px;
    padding: 16px 20px;
    margin-top: 10px;
}

.pickup-box .label {
    font-size: 17px;
    margin-bottom: 8px;
}

.pickup-box .branch {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 22px;
    line-height: 1.2;
    margin-bottom: 6px;
}

.pickup-box .address {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px;
    line-height: 1.4;
    opacity: 0.95;
}

/* =========================================
   TABS (POSISI RIWAYAT AKTIF SESUAI GAMBAR)
========================================= */
.tabs {
    display: flex;
    gap: 34px;
    margin-bottom: 18px;
}

.tab {
    position: relative;
    font-size: 30px;
    color: var(--brown);
    line-height: 1;
    padding-bottom: 10px;
    cursor: pointer;
}

.tab.active::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 90px; /* Lebar garis pas di bawah tulisan Riwayat */
    height: 3px;
    background: var(--brown);
    border-radius: 999px;
}

/* =========================================
   CONTENT BOX
========================================= */
.content-box {
    background: #ffffff;
    border-radius: 20px;
    min-height: 720px;
    padding: 22px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.order-actions{
    display:flex;
    gap:12px;
    justify-content:flex-end;
    flex-wrap:wrap;
}

.receipt-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#fff;
    color:#4A210B;
    border:2px solid #4A210B;
    padding:12px 22px;
    border-radius:10px;
    font-size:20px;
    line-height:1;
}

.receipt-btn:hover{
    background:#4A210B;
    color:#fff;
}

/* =========================================
   ORDER CARD
========================================= */
.order-card {
    background: var(--card-bg);
    border-radius: 18px;
     overflow: visible;
    box-shadow: var(--shadow);
    margin-bottom: 25px;
}

.order-card-header {
    background: var(--brown);
    color: white;
    padding: 10px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 22px;
}

.order-card-body {
    padding: 20px 18px 20px;
    display: flex;
    justify-content: space-between;
    gap: 30px;
}

.order-left {
    flex: 1;
}

.order-id {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 20px;
}

.customer-name {
    font-size: 38px;
    line-height: 1;
    margin-bottom: 6px;
    color: var(--brown);
}

.customer-contact {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 28px;
}

/* BUTTON */
.contact-btn {
    display: inline-block;
    padding: 10px 20px;
    border: 2px solid #7a5234;
    border-radius: 10px;
    background: white;
    color: var(--brown);
    font-size: 18px;
    line-height: 1;
    transition: 0.2s;
}

.contact-btn:hover {
    background: #7a5234;
    color: white;
}

/* RIGHT */
.order-right {
    min-width: 340px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: right;
    gap: 16px;
}
.order-actions{
   display:flex;
   flex-direction:column;
}

.order-date {
    font-size: 18px;
    color: var(--brown);
    margin-bottom: 12px;
}

.order-total {
    font-size: 40px;
    line-height: 1;
    color: var(--brown);
    margin-bottom: 4px;
}

.order-item-count {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 22px;
}

.detail-btn {
    display: inline-block;
    background: var(--brown);
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 20px;
    line-height: 1;
    transition: 0.2s;
}

.detail-btn:hover {
    background: #5c2d12;
}

/* =========================================
   EMPTY STATE
========================================= */
.empty-order {
    text-align: center;
    padding: 140px 20px;
    color: #a08671;
}

.empty-order i {
    display: block;
    font-size: 64px;
    margin-bottom: 15px;
}

.empty-order p {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px;
    font-weight: 600;
}

/* =========================================
   FOOTER
========================================= */
footer {
    margin-top: 80px;
    background: #3b1604;
    color: white;
    padding-top: 60px;
}

.footer-container {
    max-width: var(--container);
    margin: 0 auto;
    padding: 0 45px;
    display: flex;
    justify-content: space-between;
    gap: 40px;
}

.footer-left img {
    width: 220px;
}

.footer-left p {
    margin-top: 8px;
    font-size: 15px;
}

.footer-title {
    font-size: 34px;
    margin-bottom: 18px;
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
}

.footer-links a {
    color: white;
}

.socials {
    display: flex;
    gap: 16px;
    margin-top: 10px;
}

.socials img {
    width: 40px;
}

/* CUP SECTION */
.footer-cups {
    margin-top: 45px;
    background: #7a5234;
    display: flex;
    justify-content: center;
    gap: 30px;
    padding: 12px 0;
    overflow: hidden;
}

.footer-cups img {
    height: 110px;
    width: auto;
}

/* =========================================
   RESPONSIVE
========================================= */
@media (max-width: 900px) {
    .topbar,
    .main,
    .footer-container {
        padding-left: 20px;
        padding-right: 20px;
    }

    .page-header {
        flex-direction: column;
    }

    .pickup-box {
        width: 60%;
    }

    .tabs {
        gap: 10px;
    }

    .tab {
        font-size: 28px;
    }

    .page-title {
        font-size: 52px;
        margin-top: 20px;
    }

    .order-card-body {
        flex-direction: column;
    }

    .order-right {
        min-width: auto;
        text-align: left;
        gap: 20px;
    }

    .footer-container {
        flex-direction: column;
    }

    .nav {
        display: none;
    }
}
</style>
</head>
<body>

<header class="topbar">
    <div class="logo">
        <img src="{{ asset('media/Secondary logo.png') }}" alt="Kopikala">
    </div>

    <div class="nav">
        <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">pemesanan</a>

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="login-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="login-btn">Login</a>
        @endauth
    </div>
</header>

<main class="main">

    <div class="page-header">
        <h1 class="page-title">Pesanan Saya</h1>

        <div class="pickup-box">
            <div class="label">Pesananmu dapat diambil di</div>
            <div class="branch">
                <i class="fa-solid fa-location-dot"></i>
                <span>Kopikala Coffee Shop Pandu Raya</span>
            </div>
            <div class="address">
                No.141 A, Jl. Pandu Raya No.14A, RT.03/RW.16, Tegal Gundil, Kec...
            </div>
        </div>
    </div>

    <div class="tabs">
        <div class="tab" onclick="window.location.href='{{ route('orders.my') }}'">Sedang berlangsung</div>
        <div class="tab active">Riwayat</div>
    </div>

    <div class="content-box">

        {{-- Filter Variabel Looping untuk Riwayat (Hanya Order Finished) --}}
        @php $adaRiwayat = false; @endphp

        @foreach($transactions as $trx)
            @if($trx->status == 'Order Finished')
                @php $adaRiwayat = true; @endphp
                
                <div class="order-card">
                    <div class="order-card-header">
                        <span>Pesanan Selesai</span>
                        <span>{{ $trx->pickup_code ?? 'K#01' }}</span>
                    </div>

                    <div class="order-card-body">
                        <div class="order-left">
                            <div class="order-id">
                                Order id : {{ $trx->order_id }}
                            </div>

                            <div class="customer-name">
                                {{ $trx->customer_name }}
                            </div><br>

                            <div class="customer-contact">
                                {{ $trx->email }} &nbsp; - &nbsp; {{ $trx->phone }}
                            </div>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $trx->phone) }}"
                               target="_blank"
                               class="contact-btn">
                                Hubungi Toko
                            </a>
                        </div>

                        <div class="order-right">
                            <div>
                                <div class="order-date">
                                    {{ \Carbon\Carbon::parse($trx->created_at)->setTimezone('Asia/Jakarta')->translatedFormat('j F Y | H:i') }}
                                </div>
                            </div>

                            <div>
                                <div class="order-total">
                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                </div>
                                <div class="order-item-count">
                                    {{ is_array($trx->items) ? count($trx->items) : (is_string($trx->items) ? count(json_decode($trx->items, true) ?? []) : 0) }} item
                                </div>
                            </div>

             <div class="order-actions">

    <a href="{{ route('orders.order_detail', $trx->id) }}"
       class="detail-btn">
        Detail Pesanan
    </a>

    <a href="{{ route('orders.receipt', $trx->id) }}"
       class="receipt-btn">
        <i class="fa-solid fa-download"></i>
        Download Struk
    </a>

</div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Jika data riwayat benar-benar kosong di database --}}
        @if(!$adaRiwayat)
            <div class="empty-order">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <p>Belum ada riwayat pesanan selesai.</p>
            </div>
        @endif

    </div>
</main>

<footer>
    <div class="footer-container">
        <div class="footer-left">
            <img src="{{ asset('media/logo-putih.png') }}" alt="Kopikala">
            <p>Harga Terjangkau, Kualitas Terjaga!</p>
        </div>

        <div>
            <div class="footer-title">Info Kopikala</div>
            <ul class="footer-links">
                <li><a href="#">Menu</a></li>
                <li><a href="#">#sobatkala</a></li>
                <li><a href="#">Tentang Kopikala</a></li>
            </ul>
        </div>

        <div>
            <div class="footer-title">Ayo jadi #sobatkala!</div>
            <div class="socials">
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
    </div>
</footer>

</body>
</html>