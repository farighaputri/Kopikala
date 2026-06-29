<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopikala - Order</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
  
  {{-- CDN SweetAlert2 untuk Popup Ber-icon --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* === FIXING UI/UX MATCH MOCKUP PERFECTLY === */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Patrick Hand', cursive;
        background: #f3ede3 url("{{ asset('media/BG JAM.png') }}") repeat;
        background-size: 1400px auto;
        color: #3a1f10;
        min-height: 100vh;
    }
    
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(243, 237, 227, .92);
        z-index: -1;
    }

    /* Kustomisasi Font SweetAlert agar mengikuti font tema Kopikala */
    .swal2-popup {
        font-family: 'Comic Neue', cursive !important;
        border-radius: 16px !important;
    }

    /* HEADER TOPBAR */
    .topbar {
        width: 100%;
        background-color: transparent;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 50px;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10;
    }

    .logo img {
      width: 140px;
      height: auto;
    }

    .nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    .nav a {
      text-decoration: none;
      color: #3c1f0e;
      font-weight: 700;
      font-size: 1.05rem;
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
      border: 2px solid #3c1f0e;
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

    .login-btn {
      background: #3c1f0e;
      color: #ffffff !important;
      padding: 6px 20px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 700;
      border: none;
      cursor: pointer;
    }

    /* CART CONTAINER */
    .cart-wrapper {
        max-width: 1200px;
        margin: 120px auto 60px;
        padding: 0 20px;
    }

    /* HEADER KERANJANG & PICKUP BOX */
    .cart-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .cart-heading {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .cart-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #3c1f0e;
        margin-bottom: 5px;
    }

    .cart-subtitle {
        font-size: 1.1rem;
        color: #6d4a31;
    }

    /* STYLE CHIP WAKTU UPDATE DINAMIS & TRANSPARAN */
    .last-update-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #666;
        margin-top: 5px;
        align-self: flex-start;
    }

    /* PICKUP BOX COKELAT SESUAI MOCKUP */
    .pickup-box {
        background-color: #6d4a31;
        color: #fff8f0;
        padding: 15px 25px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 20px;
        max-width: 500px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .pickup-left {
        flex: 1;
    }

    .pickup-left small {
        font-size: 0.85rem;
        opacity: 0.9;
        display: block;
        margin-bottom: 4px;
    }

    .pickup-location {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .pickup-location i {
        color: #ffffff;
    }

    .branch-address {
        font-size: 0.85rem;
        opacity: 0.85;
        line-height: 1.3;
    }

    .branch-select {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 6px 12px;
        border-radius: 6px;
        font-family: 'Comic Neue', cursive;
        font-weight: 700;
        cursor: pointer;
        outline: none;
    }

    .branch-select option {
        color: #3c1f0e;
    }

    /* LAYOUT GRID UTAMA */
    .cart-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 40px;
        align-items: start;
    }

    /* DETAIL PESANAN KIRI */
    .cart-box h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #3c1f0e;
    }

    .cart-item {
        background: #ffffff;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
    }

    .cart-item img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }

    .item-info {
        flex: 1;
    }

    .item-info h4 {
        font-size: 1.3rem;
        color: #3c1f0e;
        margin-bottom: 4px;
    }

    .item-info p {
        font-size: 0.95rem;
        color: #707070;
        margin-bottom: 8px;
    }

    .item-price {
        font-size: 1.15rem;
        font-weight: 700;
        color: #3c1f0e;
    }

    /* QTY BOX COUNTER */
    .qty-box {
        display: flex;
        align-items: center;
        background: #f4ecdf;
        border: 1px solid #3c1f0e;
        border-radius: 6px;
        overflow: hidden;
    }

    .qty-box button {
        background: transparent;
        border: none;
        color: #3c1f0e;
        font-size: 1.2rem;
        font-weight: 700;
        width: 32px;
        height: 32px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .qty-box button:hover {
        background: rgba(60, 31, 14, 0.1);
    }

    .qty-box span {
        font-size: 1.1rem;
        font-weight: 700;
        min-width: 24px;
        text-align: center;
        color: #3c1f0e;
    }

    /* RINCIAN PEMBAYARAN KANAN */
    .summary-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
    }

    .summary-box h3 {
        font-size: 1.5rem;
        margin-bottom: 25px;
        color: #3c1f0e;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.15rem;
        margin-bottom: 15px;
        color: #3c1f0e;
    }

    .summary-divider {
        height: 1px;
        background-color: #3c1f0e;
        margin: 20px 0;
    }

    .summary-row.total {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 30px;
    }

    /* TOMBOL COKREK PANJANG SINKRON MOCKUP */
    .checkout-btn {
        display: block;
        background-color: #3c1f0e;
        color: #ffffff !important;
        text-align: center;
        text-decoration: none;
        padding: 12px;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(60, 31, 14, 0.2);
        transition: background-color 0.2s;
    }

    .checkout-btn.disabled-btn {
        background-color: #a0a0a0;
        cursor: not-allowed;
        box-shadow: none;
    }

    .checkout-btn:hover:not(.disabled-btn) {
        background-color: #2b1509;
    }

    .empty-cart {
        text-align: center;
        padding: 40px;
        font-size: 1.2rem;
        color: #6d4a31;
    }

    /* ================= FOOTER ================= */
    footer {
        margin-top: 90px;
        background: #3b1604;
        color: white;
        padding: 30px 60px 25px;
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
        position: relative;
        z-index: 5;
    }

    .footer-left {
        flex: 1;
    }

    .footer-left img {
        width: 190px;
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
        margin-top: -5px;
    }

    .footer-center h3 {
        margin-bottom: 16px;
        font-size: 1.4rem;
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
        text-decoration: none;
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
        .cart-layout { grid-template-columns: 1fr; gap: 30px; }
        .cart-top { flex-direction: column; align-items: stretch; }
        .pickup-box { max-width: 100%; }
        .footer-container { flex-direction: column; gap: 30px; align-items: center; text-align: center; }
        .footer-right { align-items: center; text-align: center; }
        .social-icons { justify-content: center; }
    }
  </style>
</head>

<body>

<header class="topbar">
    <div class="logo">
        <img src="{{ asset('media/Secondary logo.png') }}" alt="Kopikala">
    </div>
    <div class="nav">
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('frontend.about') }}">Tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">Pemesanan</a>

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

<section class="cart-wrapper">

    <div class="cart-top">
        <div class="cart-heading">
            <h1 class="cart-title">Keranjang mu</h1>
            <p class="cart-subtitle">Cek ulang pesanan sebelum melanjutkan pembayaran</p>
            
            {{-- CHIP PENUNJUK WAKTU KONSISTEN DENGAN HALAMAN STOK --}}
            <div class="last-update-chip">
                <span>Last updated: <span id="lastUpdatedTime">-</span></span>
            </div>
        </div>

        <div class="pickup-box">
            <div class="pickup-left">
                <small>Pesananmu dapat diambil di</small>
                <div class="pickup-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>
                        {{ optional($branches->where('id', session('selected_branch'))->first())->branch_name ?? 'Pilih Cabang' }}
                    </span>
                </div>

                @php
                    $currentBranch = $branches->where('id', session('selected_branch'))->first();
                    $branchAddressDisplay = $currentBranch->branch_address ?? ($currentBranch->address ?? ($currentBranch->location ?? 'Alamat belum terpilih...'));
                @endphp

                <div class="branch-address">
                    {{ $branchAddressDisplay }}
                </div>
            </div>

            <form action="{{ route('cart.branch') }}" method="POST">
                @csrf
                <select name="branch_id" class="branch-select" onchange="this.form.submit()">
                    <option value="">Ganti Cabang</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ session('selected_branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="cart-layout">
        <div class="cart-box">
            <h3>Detail Pesanan</h3>
            @php $subtotal = 0; @endphp

            @forelse($cart as $key => $item)
            @php $subtotal += $item['price'] * $item['qty']; @endphp
            <div class="cart-item">
                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                <div class="item-info">
                    <h4>{{ $item['name'] }}</h4>
                    <p>
                        @if(isset($item['options']))
                            @foreach($item['options'] as $option)
                                {{ $option['customization'] }} : {{ $option['option'] }}
                                @if(!$loop->last) , @endif
                            @endforeach
                        @endif
                    </p>
                    <div class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                </div>

                <div class="qty-box">
                    <button onclick="updateQty('{{ $key }}', -1)">-</button>
                    <span id="qty-{{ $key }}">{{ $item['qty'] }}</span>
                    <button onclick="updateQty('{{ $key }}', 1)">+</button>
                </div>
            </div>
            @empty
            <div class="empty-cart">Keranjang masih kosong</div>
            @endforelse
        </div>

        <div class="summary-box">
            <h3>Rincian Pembayaran</h3>
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Total Item</span>
                <span>{{ collect($cart)->sum('qty') }} Item</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            
            {{-- TOMBOL CHECKOUT DENGAN ID PROTEKSI JS --}}
            <a href="{{ route('payment.payment1') }}" class="checkout-btn" id="checkout-button">Lanjut Ke Pembayaran</a>
        </div> 
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Sinkronisasi status session & data backend Laravel ke JavaScript
const hasSelectedBranch = "{{ session()->has('selected_branch') ? 'true' : 'false' }}";
const cartIsEmpty = "{{ empty($cart) ? 'true' : 'false' }}";

// Konfigurasi template Toast kecil SweetAlert2 (Muncul di pojok kanan atas)
const MiniToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Otomatis jalankan Mini Toast jika terdeteksi kiriman sukses pilih cabang dari Controller
@if(session('success'))
    MiniToast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    });
@endif

// Validasi interaktif bermodal icon (SweetAlert2) saat tombol pembayaran ditekan
document.getElementById('checkout-button').addEventListener('click', function(e) {
    if (cartIsEmpty === 'true') {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Keranjang Kosong',
            text: 'Silakan pilih menu kopi terlebih dahulu sebelum checkout.',
            confirmButtonColor: '#3c1f0e'
        });
        return;
    }

    if (hasSelectedBranch === 'false') {
        e.preventDefault(); 
        Swal.fire({
            icon: 'error',
            title: 'Cabang Belum Terpilih',
            text: 'pesanan tidak bisa dilanjut jika belum memilih cabang.',
            confirmButtonColor: '#3c1f0e'
        });
    }
});

function updateQty(cartId, change) {
    let qtyElement = document.getElementById('qty-' + cartId);
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;

    fetch("{{ route('cart.qty') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            cart_id: cartId,
            qty: newQty
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            location.reload();
        }
    });
}

// Polling data waktu update otomatis
async function fetchLastUpdated() {
    const el = document.getElementById('lastUpdatedTime');
    if(!el) return;
    try {
        const res = await fetch("{{ route('stock.last-updated') }}");
        const data = await res.json();
        if(data.timestamp) {
            const date = new Date(data.timestamp * 1000);
            el.innerText = date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
        }
    } catch(err) { el.innerText = '-'; }
}
fetchLastUpdated();
setInterval(fetchLastUpdated, 5000);

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