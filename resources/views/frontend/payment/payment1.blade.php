<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kopikala - Pembayaran</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap"
rel="stylesheet">

<!-- ✅ PAYMENT CSS -->
<link rel="stylesheet" href="{{ asset('css/payment1.css') }}">

</head>

<body>

<!-- HEADER -->
<header class="topbar">

    <img
        src="{{ asset('media/Secondary Logo.png') }}"
        class="logo"
        alt="Kopikala Logo"
    >

    <nav class="nav-menu">
      <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">pemesanan</a>
    </nav>

    <i class="fas fa-user-circle profile-icon"></i>

</header>

<!-- CONTENT -->
<section class="payment-wrapper">

    <h1 class="payment-title">Pembayaran</h1>

    <!-- STEP -->
    <div class="checkout-steps">

        <div class="step active">
            <div class="step-circle">1</div>
            <span>Review Pesanan</span>
        </div>

        <div class="step-line active"></div>

        <div class="step">
            <div class="step-circle">2</div>
            <span>Data Diri</span>
        </div>

        <div class="step-line"></div>

        <div class="step">
            <div class="step-circle">3</div>
            <span>Pembayaran</span>
        </div>

    </div>

    <!-- PICKUP -->
    <div class="pickup-box">

        <div class="pickup-location">

            <i class="fas fa-map-marker-alt"></i>

            <div>
                <strong>Pesanan akan diambil di</strong>

                <span>
                    {{ optional($branches->where('id', session('selected_branch'))->first())->branch_name ?? 'Pilih Cabang' }}
                </span>

                <div class="branch-address">
                    {{ optional($branches->where('id', session('selected_branch'))->first())->location ?? 'Alamat belum terpilih...' }}
                </div>
            </div>

        </div>

    </div>

    <!-- MAIN -->
    <div class="main-card">

        <div class="payment-layout">

            <!-- LEFT -->
            <div>

                <h2 class="section-title">Review Pesanan</h2>

                <div class="estimation">
                    ⏰ Estimasi Pengambilan dalam 19 menit
                </div>

                <div class="cart-list">

                    @php $subtotal = 0; @endphp

                    @forelse($cart as $key => $item)

                        @php $subtotal += $item['price'] * $item['qty']; @endphp

                        <div class="cart-item">

                            <div class="item-left">

                                <img src="{{ asset('storage/' . $item['image']) }}">

                                <div class="item-info">

                                    <h4>{{ $item['name'] }}</h4>

                                    <p>
                                        @if(isset($item['options']))
                                            @foreach($item['options'] as $option)
                                                {{ $option['option'] }}@if(!$loop->last),@endif
                                            @endforeach
                                        @endif
                                    </p>

                                    <div class="item-price">
                                        Rp {{ number_format($item['price'],0,',','.') }}
                                    </div>

                                </div>

                            </div>

                            <div class="qty-box">

                                <button onclick="updateQty('{{ $key }}', -1)">-</button>

                                <span id="qty-{{ $key }}">{{ $item['qty'] }}</span>

                                <button onclick="updateQty('{{ $key }}', 1)">+</button>

                            </div>

                        </div>

                    @empty

                        <div style="text-align:center;padding:40px;font-size:24px;color:#7a6655;">
                            Keranjang masih kosong ☕
                        </div>

                    @endforelse

                </div>

            </div>

            <!-- RIGHT -->
            <div>

                <h3 class="summary-title">Rincian Pembayaran</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                </div>

                <div class="summary-row">
                    <span>Potongan Harga</span>
                    <span>Rp 0</span>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
                </div>

                <a href="{{ route('payment.data') }}">
                    <button class="checkout-btn">Selanjutnya</button>
                </a>

            </div>

        </div>

    </div>

</section>

<script>
function updateQty(cartId, change)
{
    let qtyElement = document.getElementById('qty-' + cartId);
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;

    if(newQty < 1) return;

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

<!-- FOOTER (masih static, nanti bisa kita layout-kan juga) -->
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
      <img src="media/Kopi Ga Miring01.png">
      <img src="media/Kopi Ga Miring02.png">
      <img src="media/Kopi Ga Miring03.png">
      <img src="media/Kopi Ga Miring04.png">
      <img src="media/Kopi Ga Miring01.png">
      <img src="media/Kopi Ga Miring02.png">
      <img src="media/Kopi Ga Miring03.png">
      <img src="media/Kopi Ga Miring04.png">
      <img src="media/Kopi Ga Miring02.png">
      <img src="media/Kopi Ga Miring03.png">
      <img src="media/Kopi Ga Miring04.png">
    </div>
</footer>

</body>
</html>