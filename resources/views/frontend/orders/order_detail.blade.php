<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Pesanan - Kopikala</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --cream:#F3EDE2;
    --brown:#4A210B;
    --brown2:#6B3A16;
    --brown3:#8A6A57;
    --white:#fff;
}

body{
    background:var(--cream) url("{{ asset('media/BG JAM.png') }}") repeat;
    background-size:1200px auto;
    font-family:'Patrick Hand', cursive;
    color:var(--brown);
}

/* OVERLAY */
body::before{
    content:"";
    position:fixed;
    inset:0;
    background:rgba(243,237,226,.90);
    z-index:-1;
}

/* ================= HEADER ================= */
.topbar{
    max-width:1400px;
    margin:auto;
    padding:28px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo img{
    height:60px;
}

.nav{
    display:flex;
    align-items:center;
    gap:55px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:18px;
    font-weight:600;
}

.nav a{
    text-decoration:none;
    color:var(--brown);
}

.profile-icon{
    font-size:34px;
}

/* ================= MAIN ================= */
.order-wrapper{
    max-width:1400px;
    margin:auto;
    padding:0 40px 80px;
}

.page-title{
    font-size:64px;
    margin-bottom:30px;
}

.order-card{
    background:#F8F8F8;
    border-radius:30px;
    padding:32px 36px;
    box-shadow:none;
    border:1px solid #E6DED5;
}

/* HEADER */
.order-id{
    font-size:28px;
    margin-bottom:14px;
    font-weight:400;
}

.order-time{
    display:flex;
    gap:60px;
    font-size:16px;
    margin-bottom:20px;
    color:#5C4638;
}

hr{
    border:none;
    border-top:1px solid #B08A73;
    margin:26px 0;
}

/* ================= STATUS ================= */
.status-wrapper{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    margin-bottom:45px;
}

.step{
    display:flex;
    align-items:center;
    gap:8px;
    white-space:nowrap;
}

.circle{
    width:24px;
    height:24px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:11px;
    background:#C9B7AA;
}

.step.active .circle{
    background:#6B3A16;
}

.step span{
    font-size:15px;
    color:#6B3A16;
}

.line{
    flex:1;
    height:2px;
    background:#CDB7A7;
    margin:0 8px;
}

/* ================= ITEM ================= */
.order-item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:40px;
}

.item-left{
    display:flex;
    align-items:flex-start;
    gap:16px;
}

.item-left img{
    width:92px;
    height:72px;
    object-fit:cover;
    border-radius:12px;
}

.item-info h3{
    font-size:22px;
    margin-bottom:8px;
    line-height:1.2;
    font-weight:400;
}

.item-info p{
    font-size:14px;
    color:#5F4537;
    line-height:1.5;
}

/* HAPUS BOX DETAIL */
.menu-detail-box{
    display:none;
}

.item-right{
    text-align:right;
}

.item-right .price{
    font-size:20px;
    margin-bottom:8px;
    font-weight:400;
}

.item-right .qty{
    font-size:14px;
}

/* ================= SECTION ================= */
.section-title{
    font-size:28px;
    margin-bottom:24px;
    font-weight:400;
}

/* ================= DETAIL ================= */
.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:120px;
}

.detail-item{
    margin-bottom:28px;
}

.detail-item .label{
    display:block;
    font-size:15px;
    margin-bottom:8px;
    color:#5B4638;
}

.detail-item .value{
    font-size:18px;
}

/* ================= PAYMENT ================= */
.payment-box{
    max-width:520px;
}

.payment-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
    font-size:18px;
}

.payment-total{
    display:flex;
    justify-content:space-between;
    margin-top:35px;
    font-size:30px;
}

* ================= FOOTER ================= */

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

/* ================= MOBILE ================= */
@media(max-width:768px){
    .nav{
        display:none;
    }
    .page-title{
        font-size:44px;
    }
    .order-id{
        font-size:30px;
    }
    .order-time{
        flex-direction:column;
        gap:15px;
        font-size:20px;
    }
    .status-wrapper{
        flex-direction:column;
        align-items:flex-start;
    }
    .line{
        width:2px;
        height:30px;
    }
    .order-item{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }
    .item-right{
        text-align:left;
    }
    .detail-grid{
        grid-template-columns:1fr;
        gap:20px;
    }
    .footer-container{
        flex-direction:column;
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
        <i class="fa-solid fa-circle-user profile-icon"></i>
    </div>
</header>

<div class="order-wrapper">

    <h1 class="page-title">Pesanan Saya</h1>

    <div class="order-card">
        
        <div class="order-id">
            Order id : {{ $transaction->order_id ?? 'Kopkal-0001' }}
        </div>

        <div class="order-time">
            {{-- LOGIKA PARSING WAKTU DARI DATA PEMESANAN USER --}}
            @php
                $waktuPesan = isset($transaction->created_at) ? \Carbon\Carbon::parse($transaction->created_at)->setTimezone('Asia/Jakarta') : \Carbon\Carbon::now('Asia/Jakarta');
                // Set waktu pengambilan otomatis menjadi +1 jam (60 menit) dari waktu pesan
                $waktuAmbil = $waktuPesan->copy()->addHour();
            @endphp

            <div>Waktu Pemesanan &nbsp; <span>{{ $waktuPesan->translatedFormat('j F Y H:i') }} WIB</span></div>
            <div>Waktu Pengambilan &nbsp; <span id="pickupTimeText">{{ $waktuAmbil->format('H:i') }}</span> <strong id="countdownText" style="color: #6B3A16; margin-left: 8px;">(--:-- menit)</strong></div>
        </div>

        <hr>

        <div class="status-wrapper">
    {{-- Step 1: Menunggu Konfirmasi --}}
    <div class="step {{ in_array($transaction->status, ['Waiting Confirmation', 'Order Confirmed', 'Order Ready', 'Order Finished']) ? 'active' : '' }}">
        <div class="circle">1</div>
        <span>Menunggu Konfirmasi</span>
    </div>
    <div class="line"></div>
    
    {{-- Step 2: Pesanan Dikonfirmasi --}}
    <div class="step {{ in_array($transaction->status, ['Order Confirmed', 'Order Ready', 'Order Finished']) ? 'active' : '' }}">
        <div class="circle">2</div>
        <span>Pesanan Dikonfirmasi</span>
    </div>
    <div class="line"></div>
    
    {{-- Step 3: Pesanan Siap --}}
    <div class="step {{ in_array($transaction->status, ['Order Ready', 'Order Finished']) ? 'active' : '' }}">
        <div class="circle">3</div>
        <span>Pesanan Siap</span>
    </div>
    <div class="line"></div>
    
    {{-- Step 4: Pesanan Selesai --}}
    <div class="step {{ $transaction->status == 'Order Finished' ? 'active' : '' }}">
        <div class="circle">4</div>
        <span>Pesanan Selesai</span>
    </div>
</div>

        @php
        $items = [];
        if(isset($transaction->details) && count($transaction->details)){
            foreach($transaction->details as $detail){
                $items[] = [
                    'name' => $detail->product->nama_produk ?? 'Produk',
                    'foto' => $detail->product->foto ?? 'kopi-susu.png',
                    'price' => $detail->price ?? 0,
                    'qty' => $detail->qty ?? 0,
                    'size' => $detail->size ?? 'Kopi Normal',
                    'sugar_level' => $detail->sugar_level ?? 'Normal',
                    'ice_level' => $detail->ice_level ?? 'Normal',
                ];
            }
        } elseif(isset($transaction->items)){
            if(is_array($transaction->items)){
                $items = $transaction->items;
            } else {
                $items = json_decode($transaction->items, true) ?? [];
            }
        }

        $subtotal = 0;
        foreach($items as $item){
            $subtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
        }
        $discount = $transaction->discount ?? 0;
        $total = $subtotal - $discount;
        @endphp

        @forelse($items as $item)
        <div class="order-item">
            <div class="item-left">
                <img src="{{ asset('images/' . ($item['foto'] ?? 'kopi-susu.png')) }}" alt="{{ $item['name'] ?? 'Produk' }}">
                <div class="item-info">
                    <h3>{{ $item['name'] ?? '-' }}</h3>
                   <p>
@php
    $customText = [];

    if(isset($item['options'])){
        foreach($item['options'] as $option){
            $customText[] = $option['customization'] . ' : ' . $option['option'];
        }
    }
@endphp

{{ count($customText) ? implode(', ', $customText) : 'Tanpa Customisasi' }}
</p>
                </div>
            </div>

            <div class="item-right">
                <div class="price">
                    Rp {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 0), 0, ',', '.') }}
                </div>
                <div class="qty">
                    {{ $item['qty'] ?? 0 }} item
                </div>
            </div>
        </div>
        @empty
        <div style="padding:50px 0;font-size:28px;">
            Tidak ada item pesanan
        </div>
        @endforelse

        <hr>

        <div class="section-title">Detail Pemesanan</div>

        <div class="detail-grid">
            <div>
                <div class="detail-item">
                    <span class="label">Nama Pemesan</span>
                    <div class="value">{{ $transaction->customer_name ?? 'Jonathan' }}</div>
                </div>
                <div class="detail-item">
                    <span class="label">No. HP</span>
                    <div class="value">{{ $transaction->phone ?? '085678233267' }}</div>
                </div>
            </div>
            <div>
                <div>
    <div class="detail-item">
        <span class="label">Email</span>
        <div class="value">
            {{ $transaction->email ?? 'Jonathan@gmail.com' }}
        </div>
    </div>

    <div class="detail-item">
        <span class="label">Cabang Pengambilan</span>

        <div class="value">
            <i class="fa-solid fa-store"></i>

            {{ $transaction->branch->branch_name ?? 'Cabang tidak ditemukan' }}
        </div>
    </div>
</div>
            </div>
        </div>

        <hr>

        <div class="section-title">Rincian Pembayaran</div>

<div class="payment-box">
    <div class="payment-row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>

    <div class="payment-row">
        <span>Potongan Harga</span>
        <span>Rp {{ number_format($discount, 0, ',', '.') }}</span>
    </div>

    <div class="payment-total">
        <span>Total</span>
        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
    </div>
</div>

@if($transaction->status == 'Order Finished')
<div style="
    width:100%;
    margin-top:40px;
    display:flex;
    justify-content:flex-end;
">

    <a href="{{ route('orders.receipt', $transaction->id) }}"
       target="_blank"
       style="
        width:320px;
        height:64px;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:12px;

        background:#4A210B;
        color:white;

        border-radius:14px;
        text-decoration:none;

        font-size:24px;

        transition:.2s;
       "

       onmouseover="this.style.background='#6B3A16'"
       onmouseout="this.style.background='#4A210B'">

        <i class="fa-solid fa-receipt"></i>
        Cetak Struk

    </a>

</div>
@endif
        </div>

    </div> 
</div> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentStatus = "{{ $transaction->status }}";
        let rawPickupText = $("#pickupTimeText").text().trim();

        // 1. LOGIKA COUNTDOWN MENIT DAN DETIK BERJALAN
        function startCountdown() {
            if (!rawPickupText) return;

            let timeParts = rawPickupText.split(':');
            let targetTime = new Date();
            targetTime.setHours(parseInt(timeParts[0]), parseInt(timeParts[1]), 0, 0);

            function updateTimer() {
                let now = new Date();
                let diff = targetTime - now;

                if (currentStatus === 'Order Finished') {
                    $("#countdownText").text("(Pesanan Selesai)").css("color", "green");
                    return;
                }

                if (diff <= 0) {
                    $("#countdownText").text("(Melebihi Estimasi)").css("color", "red");
                } else {
                    let minutes = Math.floor(diff / 1000 / 60);
                    let seconds = Math.floor((diff / 1000) % 60);
                    
                    seconds = seconds < 10 ? '0' + seconds : seconds;
                    $("#countdownText").text(`(Sisa: ${minutes}:${seconds} menit)`).css("color", "#6B3A16");
                }
            }

            setInterval(updateTimer, 1000);
            updateTimer();
        }

        startCountdown();

        // 2. LOGIKA REAL-TIME CHECK STATUS DB SETIAP 4 DETIK
        setInterval(function() {
            $.ajax({
                url: "{{ route('transactions.checkStatus', $transaction->order_id) }}",
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    if (response.status !== currentStatus) {
                        window.location.reload();
                    }
                }
            });
        }, 4000); 
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
          <li><a href="#menu">Menu</a></li>
          <li><a href="#sobatkala">#sobatkala</a></li>
          <li><a href="#tentang">Tentang Kopikala</a></li><br>
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
</html>