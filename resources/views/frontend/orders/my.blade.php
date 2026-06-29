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

/* ================= DROPDOWN PROFIL WRAPPER ================= */
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
    border: 2px solid rgba(255, 255, 255, 0.7);
    transition: .3s;
}

.profile-avatar:hover {
    transform: scale(1.08);
    border-color: #f1c27d;
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

/* ================= DETAIL TEXT WRAPPER (FIXED) ================= */
.user-text-details {
    flex: 1;
    min-width: 0; /* PENTING: Memaksa kontainer flex untuk membatasi ruang teks */
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-info h4 {
    font-family: 'Patrick Hand', cursive;
    font-size: 18px;
    margin: 0;
    color: #3c1f0e;
    line-height: 1.2;
    font-weight: normal;
    /* Proteksi agar nama panjang turun ke bawah */
    word-break: break-word; 
    white-space: normal;
}

.user-info span, 
.user-info small {
    display: block; /* Mengubah elemen inline menjadi block context */
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    color: #6E5443;
    width: 100%; /* Memenuhi lebar maksimal kontainer parent */
    
    /* Kombinasi mematikan untuk memotong teks panjang secara anggun (...) */
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
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
    font-family: 'Patrick Hand', cursive;
    cursor: pointer;
    transition: color 0.2s ease;
}

.dropdown-link:hover {
    color: #f1c27d;
}

.dropdown-link.logout {
    color: #ff4d4d;
}

.login-btn {
    background: #f1c27d;
    color: #3c1f0e !important;
    padding: 8px 18px;
    border-radius: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
}

/* =========================================
   MAIN
========================================= */
.main {
    max-width: var(--container);
    margin: 0 auto;
    padding: 20px 45px 80px;
}

/* TITLE */
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

/* =========================================
   TABS
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
    width: 100%;
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

/* =========================================
   ORDER CARD
========================================= */
.order-card {
    background: var(--card-bg);
    border-radius: 18px;
    overflow: hidden;
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
    min-width: 260px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: right;
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

/* ================= FOOTER ================= */
footer {
    margin-top: 90px;
    background: #3b1604;
    color: white;
    padding: 80px 45px 25px;
    position: relative;
    overflow: hidden;
}

.footer-container {
    max-width: var(--container);
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
    .page-header { flex-direction: column; }
    .tabs { gap: 10px; }
    .tab { font-size: 28px; }
    .page-title { font-size: 52px; margin-top: 20px; }
    .order-card-body { flex-direction: column; }
    .order-right { min-width: auto; text-align: left; gap: 20px; }
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

<header class="topbar">
    <div class="logo">
        <img src="{{ asset('media/Secondary logo.png') }}" alt="Kopikala">
    </div>

    <div class="nav">
        <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="#sobatkala">#sobatkala</a>
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
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('media/default-avatar.png') }}" alt="Avatar">
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
            <a href="{{ route('login') }}" class="login-btn">Login</a>
        @endauth
    </div>
</header>

<main class="main">
    <div class="page-header">
        <h1 class="page-title">Pesanan Saya</h1>
    </div>

    <div class="tabs">
        <div class="tab active" data-target="berlangsung">Sedang berlangsung</div>
        <div class="tab" data-target="riwayat">Riwayat</div>
    </div>

    <div class="content-box">
        @php $stateTracker = []; @endphp

        @forelse($transactions as $trx)
        @php $stateTracker[$trx->order_id] = $trx->status; @endphp

        <div class="order-card {{ $trx->status == 'Order Finished' ? 'card-riwayat' : 'card-berlangsung' }}"
            data-branch="{{ $trx->branch_id }}"
            data-order-id="{{ $trx->order_id }}"
            data-current-status="{{ $trx->status }}">

            <div class="order-card-header">
                <span>
                    @if($trx->status == 'Waiting Confirmation') Menunggu Konfirmasi
                    @elseif($trx->status == 'Order Confirmed') Pesanan Dikonfirmasi
                    @elseif($trx->status == 'Order Ready') Pesanan Siap
                    @elseif($trx->status == 'Order Finished') Pesanan Selesai
                    @else {{ $trx->status }}
                    @endif
                </span>
                <span>{{ $trx->pickup_code ?? '---' }}</span>
            </div>

            <div class="order-card-body">
                <div class="order-left">
                    <div class="order-id">Order id : {{ $trx->order_id }}</div>
                    <div class="customer-name">{{ $trx->customer_name }}</div><br>
                    <div class="customer-contact">{{ $trx->email }} &nbsp; - &nbsp; {{ $trx->phone }}</div>

                    <div style="margin-top:-12px; margin-bottom:28px; font-family:'Plus Jakarta Sans', sans-serif; font-size:14px; color:#7a5234;">
                        <i class="fa-solid fa-store"></i> {{ $trx->branch->branch_name ?? 'Cabang tidak ditemukan' }}
                    </div>

                    <a href="https://wa.me/6281410882927" target="_blank" class="contact-btn">Hubungi Toko</a>
                </div>

                <div class="order-right">
                    <div>
                        <div class="order-date">
                            {{ \Carbon\Carbon::parse($trx->created_at)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y') }} &nbsp;
                            {{ \Carbon\Carbon::parse($trx->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
                        </div>
                    </div>
                    <div>
                        <div class="order-total">Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                        <div class="order-item-count">
                            {{ is_array($trx->items) ? count($trx->items) : (is_string($trx->items) ? count(json_decode($trx->items, true) ?? []) : 0) }} item
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('orders.order_detail', $trx->id) }}" class="detail-btn">Detail Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-order dynamic-empty">
            <i class="fa-solid fa-mug-hot"></i>
            <p>Belum ada pesanan.</p>
        </div>
        @endforelse

        <div class="empty-order" id="filter-empty-state" style="display: none;">
            <i class="fa-solid fa-mug-hot"></i>
            <p id="empty-state-text">Belum ada pesanan.</p>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function filterContent(targetTab) {
        $('.dynamic-empty').hide();
        $('.order-card').hide();
        let visibleCards = 0;

        $('.order-card').each(function () {
            let isRiwayat = $(this).hasClass('card-riwayat');
            if (targetTab === 'berlangsung') {
                if (!isRiwayat) { $(this).show(); visibleCards++; }
            } else {
                if (isRiwayat) { $(this).show(); visibleCards++; }
            }
        });

        if (visibleCards === 0) {
            if (targetTab === 'berlangsung') {
                $('#empty-state-text').text('Belum ada pesanan yang sedang berlangsung.');
            } else {
                $('#empty-state-text').text('Belum ada riwayat pesanan.');
            }
            $('#filter-empty-state').show();
        } else {
            $('#filter-empty-state').hide();
        }
    }

    $('.tab').click(function () {
        $('.tab').removeClass('active');
        $(this).addClass('active');
        let currentTarget = $(this).data('target');
        filterContent(currentTarget);
    });

    filterContent('berlangsung');

    const initialStates = @json($stateTracker);
    function verifyOrderStatusRealtime() {
        Object.keys(initialStates).forEach(function (orderId) {
            $.ajax({
                url: "{{ url('/transactions') }}/" + orderId + "/check-status",
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    if (response.status && response.status !== initialStates[orderId]) {
                        window.location.reload();
                    }
                },
                error: function () {
                    console.warn("Gagal menyinkronkan data ID: " + orderId);
                }
            });
        });
    }

    if (Object.keys(initialStates).length > 0) {
        setInterval(verifyOrderStatusRealtime, 4000);
    }

    // TOGGLE MENU DROPDOWN JAVASCRIPT
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', (e) => {
            if (profileMenu && !profileMenu.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
        });
    }
});
</script>

<footer>
    <div class="footer-container">
      <div class="footer-left">
        <img src="{{ asset('media/logo.png') }}" alt="Logo Kopikala">
        <p>Harga Terjangkau, Kualitas Terjaga!</p>
      </div>

      <div class="footer-center">
        <h3>Info Kopikala</h3> 
        <ul>
          <li><a href="{{ route('menu') }}">menu</a></li>
          <li><a href="{{ route('frontend.about') }}">tentang</a></li>
          <li><a href="{{ route('frontend.sobatkala') }}">#sobatkala</a></li>
          <li><a href="{{ route('frontend.order') }}">pemesanan</a></li>
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
</body>
</html>