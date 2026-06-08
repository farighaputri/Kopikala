<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kopikala - Order</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<style>
    /* === FIXING UI/UX MATCH MOCKUP PERFECTLY === */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Comic Neue', cursive;
        background-color: #f4ecdf;
        color: #3c1f0e;
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

    .checkout-btn:hover {
        background-color: #2b1509;
    }

    .empty-cart {
        text-align: center;
        padding: 40px;
        font-size: 1.2rem;
        color: #6d4a31;
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
    padding-top: 30px;
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
    @media (max-width: 900px) {
        .cart-layout { grid-template-columns: 1fr; gap: 30px; }
        .cart-top { flex-direction: column; align-items: stretch; }
        .pickup-box { max-width: 100%; }
        .footer-container { flex-direction: column; gap: 30px; }
    }
</style>
</head>

<body>

<header class="topbar">
    <div class="logo">
        <img src="{{ asset('media/Secondary logo.png') }}">
    </div>
    <div class="nav">
        <a href="{{ route('menu') }}">Menu</a>
        <a href="#">Tentang</a>
        <a href="#">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">Pemesanan</a>

        @auth
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="login-btn">Logout</button>
        </form>
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
        </div>

      <div class="pickup-box">

    <div class="pickup-left">

        <small>
            Pesananmu dapat diambil di
        </small>

        <div class="pickup-location">

            <i class="fas fa-map-marker-alt"></i>

            <span>
                {{ optional($branches->where('id', session('selected_branch'))->first())->branch_name ?? 'Pilih Cabang' }}
            </span>

        </div>

        @php
            $currentBranch = $branches->where('id', session('selected_branch'))->first();
            // Otomatis deteksi kolom mana yang berisi alamat asli di DB lu (branch_address, address, atau location)
            $branchAddressDisplay = $currentBranch->branch_address ?? ($currentBranch->address ?? ($currentBranch->location ?? 'Alamat belum terpilih...'));
        @endphp

        <div class="branch-address">
            {{ $branchAddressDisplay }}
        </div>

    </div>

    <form action="{{ route('cart.branch') }}" method="POST">

        @csrf

        <select
            name="branch_id"
            class="branch-select"
            onchange="this.form.submit()"
        >

            <option value="">
                Ganti Cabang
            </option>

            @foreach($branches as $branch)

            <option
                value="{{ $branch->id }}"
                {{ session('selected_branch') == $branch->id ? 'selected' : '' }}
            >
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
                <img src="{{ asset('storage/' . $item['image']) }}">
                <div class="item-info">
                    <h4>{{ $item['name'] }}</h4>
                    <p>
    @if(isset($item['options']))
        @foreach($item['options'] as $option)

            {{ $option['customization'] }}
            :
            {{ $option['option'] }}

            @if(!$loop->last)
                ,
            @endif

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
            <a href="{{ route('payment.payment1') }}" class="checkout-btn">Lanjut Ke Pembayaran</a>
        </div> 
    </div>
</section>

<script>
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
          <li><a href="#menu">Menu</a></li>
          <li><a href="#sobatkala">#sobatkala</a></li>
          <li><a href="#tentang">Tentang Kopikala</a></li>
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