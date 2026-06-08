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
    width: 100%; /* Dibikin 100% mengikuti elemen tab aktif */
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
      <a href="#sobatkala">#sobatkala</a>
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
        </div>
    </div>

    <div class="tabs">
        <div class="tab active" data-target="berlangsung">Sedang berlangsung</div>
        <div class="tab" data-target="riwayat">Riwayat</div>
    </div>


    <div class="content-box">

        {{-- Array penampung status awal untuk keperluan sinkronisasi real-time --}}
        @php $stateTracker = []; @endphp

        @forelse($transactions as $trx)
        
        {{-- Simpan status transaksi ke dalam tracker array --}}
        @php 
            $stateTracker[$trx->order_id] = $trx->status; 
        @endphp

        <div class="order-card 
        {{ $trx->status == 'Order Finished' ? 'card-riwayat' : 'card-berlangsung' }}"
    
        data-branch="{{ $trx->branch_id }}"
        data-order-id="{{ $trx->order_id }}"
        data-current-status="{{ $trx->status }}">

            <div class="order-card-header">
                {{-- AMBIL TRANSLATED INDONESIA STATUS SECARA DINAMIS --}}
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
                    <div class="order-id">
                        Order id : {{ $trx->order_id }}
                    </div>

                    <div class="customer-name">
                        {{ $trx->customer_name }}
                    </div><br>

                    <div class="customer-contact">
    {{ $trx->email }} &nbsp; - &nbsp; {{ $trx->phone }}
</div>

<div style="
    margin-top:-12px;
    margin-bottom:28px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:14px;
    color:#7a5234;
">
    <i class="fa-solid fa-store"></i>

    {{ $trx->branch->branch_name ?? 'Cabang tidak ditemukan' }}
</div>

                    <a href="https://wa.me/6281410882927"
                    target="_blank"
                    class="contact-btn">
                    Hubungi Toko
                    </a>
                </div>

                <div class="order-right">
                    <div>
                        <div class="order-date">
                            {{-- SESUAIKAN KORIDOR WAKTU INDONESIA BARAT (WIB) SECARA AKURAT --}}
                            {{ \Carbon\Carbon::parse($trx->created_at)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                            &nbsp;
                            {{ \Carbon\Carbon::parse($trx->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
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

                    <div>
                        <a href="{{ route('orders.order_detail', $trx->id) }}"
                           class="detail-btn">
                            Detail Pesanan
                        </a>
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


{{-- SCRIPT INTERAKSI TAB TOGGLE + REAL-TIME CHECKER DB --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // =========================================
    // FILTER TAB
    // =========================================
    function filterContent(targetTab)
    {
        $('.dynamic-empty').hide();

        $('.order-card').hide();

        let visibleCards = 0;

        $('.order-card').each(function () {

            let isRiwayat =
                $(this).hasClass('card-riwayat');

            // ================= BERLANGSUNG =================
            if (targetTab === 'berlangsung')
            {
                if (!isRiwayat)
                {
                    $(this).show();
                    visibleCards++;
                }
            }

            // ================= RIWAYAT =================
            else
            {
                if (isRiwayat)
                {
                    $(this).show();
                    visibleCards++;
                }
            }

        });

        // =========================================
        // EMPTY STATE
        // =========================================
        if (visibleCards === 0)
        {
            if (targetTab === 'berlangsung')
            {
                $('#empty-state-text')
                    .text('Belum ada pesanan yang sedang berlangsung.');
            }
            else
            {
                $('#empty-state-text')
                    .text('Belum ada riwayat pesanan.');
            }

            $('#filter-empty-state').show();
        }
        else
        {
            $('#filter-empty-state').hide();
        }
    }

    // =========================================
    // TAB CLICK
    // =========================================
    $('.tab').click(function () {

        $('.tab').removeClass('active');

        $(this).addClass('active');

        let currentTarget =
            $(this).data('target');

        filterContent(currentTarget);

    });

    // =========================================
    // DEFAULT LOAD
    // =========================================
    filterContent('berlangsung');

    // =========================================
    // REALTIME STATUS CHECKER
    // =========================================
    const initialStates = @json($stateTracker);

    function verifyOrderStatusRealtime()
    {
        Object.keys(initialStates).forEach(function (orderId) {

            $.ajax({

                url:
                    "{{ url('/transactions') }}/"
                    + orderId +
                    "/check-status",

                type: "GET",

                dataType: "JSON",

                success: function (response)
                {
                    if (
                        response.status
                        &&
                        response.status !== initialStates[orderId]
                    )
                    {
                        window.location.reload();
                    }
                },

                error: function ()
                {
                    console.warn(
                        "Gagal menyinkronkan data ID: "
                        + orderId
                    );
                }

            });

        });
    }

    // =========================================
    // AUTO REFRESH STATUS
    // =========================================
    if (Object.keys(initialStates).length > 0)
    {
        setInterval(
            verifyOrderStatusRealtime,
            4000
        );
    }

});
</script>

  <footer>
    <div class="footer-container">
      <div class="footer-left">
        <img src="media/logo.png" alt="Logo Kopikala">
        <p>Harga Terjangkau, Kualitas Terjaga!</p>
      </div>

      <div class="footer-center">
        <h3>Info Kopikala</h3> 
        <ul>
        <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">pemesanan</a>
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
    </div><br>

    <div class="footer-cups">
      <img src="media/Kopi Ga Miring01.png" alt="cup">
      <img src="media/Kopi Ga Miring02.png" alt="cup">
      <img src="media/Kopi Ga Miring03.png" alt="cup">
      <img src="media/Kopi Ga Miring04.png" alt="cup">
      <img src="media/Kopi Ga Miring01.png" alt="cup">
      <img src="media/Kopi Ga Miring02.png" alt="cup">
      <img src="media/Kopi Ga Miring03.png" alt="cup">
      <img src="media/Kopi Ga Miring04.png" alt="cup">
      <img src="media/Kopi Ga Miring01.png" alt="cup">
      <img src="media/Kopi Ga Miring02.png" alt="cup">
      <img src="media/Kopi Ga Miring03.png" alt="cup">
    </div>
  </footer>
</body>
</html>