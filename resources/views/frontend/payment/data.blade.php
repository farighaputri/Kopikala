<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kopikala - Data Diri</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap"
rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Patrick Hand', cursive;
    background:#f3ede3 url("{{ asset('media/BG JAM.png') }}") repeat;
    background-size:1400px auto;
    color:#3a1f10;
}

body::before{
    content:'';
    position:fixed;
    inset:0;
    background:rgba(243,237,227,.92);
    z-index:-1;
}

a{
    text-decoration:none;
}

/* ================= HEADER ================= */

.topbar{
    display:flex;
    align-items:center;
    padding:14px 40px;
    border-bottom:1px solid #d8cabd;
}

.logo{
    width:170px;
    margin-right:auto;
}

.nav-menu{
    display:flex;
    gap:35px;
    font-size:15px;
    align-items:center;
}

.nav-menu a{
    color:#2f180d;
}

.profile-icon{
    font-size:26px;
    color:#2f180d;
    margin-left:25px;
}

/* ================= WRAPPER ================= */

.payment-wrapper{
    max-width:1320px;
    margin:auto;
    padding:30px 25px 60px;
}

/* ================= TITLE ================= */

.payment-title{
    font-size:52px;
    font-weight:normal;
    margin-bottom:15px;
}

/* ================= STEP ================= */

.checkout-steps{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:24px;
    flex-wrap:wrap;
}

.step{
    display:flex;
    align-items:center;
    gap:8px;
    color:#866f5f;
    font-size:15px;
}

.step-circle{
    width:22px;
    height:22px;
    border-radius:50%;
    background:#ccb8a5;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
}

.step.active{
    color:#3a1f10;
}

.step.active .step-circle{
    background:#4b2411;
}

.step-line{
    width:36px;
    height:2px;
    background:#ccb8a5;
}

.step-line.active{
    background:#4b2411;
}

/* ================= PICKUP ================= */

.pickup-box{
    width:fit-content;
    margin-left:auto;
    background:#7a5337;
    color:white;
    border-radius:16px;
    padding:15px 20px;
    margin-bottom:22px;
}

.pickup-location{
    display:flex;
    gap:12px;
}

.pickup-box strong{
    display:block;
    font-size:14px;
    margin-bottom:3px;
}

.pickup-box span{
    font-size:21px;
}

.branch-address{
    margin-top:5px;
    font-size:13px;
}

/* ================= MAIN ================= */

.main-card{
    background:white;
    border-radius:22px;
    border:1px solid #e6d8ca;
    padding:28px;
}

.payment-layout{
    display:grid;
    grid-template-columns:1.1fr .9fr;
    gap:40px;
}

/* ================= FORM ================= */

.section-title{
    font-size:36px;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:22px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:16px;
}

.form-group span{
    color:#c53929;
}

.form-control{
    width:100%;
    height:42px;
    border:1px solid #d7ccc2;
    border-radius:5px;
    padding:0 14px;
    font-family:'Patrick Hand', cursive;
    font-size:16px;
    outline:none;
}

.form-control:focus{
    border-color:#4b2411;
}

/* ================= SUMMARY ================= */

.summary-title{
    font-size:32px;
    margin-bottom:28px;
    font-weight:normal;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
    font-size:22px;
}

.summary-divider{
    border-top:1px solid #d7c9bc;
    margin:24px 0;
}

.total{
    font-size:30px;
}

.checkout-btn{
    width:100%;
    height:52px;
    border:none;
    border-radius:8px;
    background:#4b2411;
    color:white;
    font-family:'Patrick Hand', cursive;
    font-size:20px;
    cursor:pointer;
    margin-top:26px;
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

/* ================= RESPONSIVE ================= */

@media(max-width:950px){

    .payment-layout{
        grid-template-columns:1fr;
    }

    .pickup-box{
        margin-left:0;
        width:100%;
    }

    .nav-menu{
        display:none;
    }

    .footer-content{
        flex-direction:column;
        text-align:center;
    }

    .social-icons{
        justify-content:center;
    }

}

</style>
</head>

<body>

<!-- HEADER -->
<header class="topbar">

    <img
        src="{{ asset('media/Secondary Logo.png') }}"
        class="logo"
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

    <h1 class="payment-title">
        Pembayaran
    </h1>

    <!-- STEP -->
    <div class="checkout-steps">

        <div class="step active">
            <div class="step-circle">1</div>
            <span>Review Pesanan</span>
        </div>

        <div class="step-line active"></div>

        <div class="step active">
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

                <strong>
                    Pesanan akan diambil di
                </strong>

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

                <h2 class="section-title">
                    Data Diri
                </h2>

                <form action="{{ route('payment.store.data') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label>
                            Nama <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Jonathan"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Alamat Email <span>*</span>
                        </label>

                       <input
    type="email"
    name="email"
    class="form-control"
    placeholder="farigha@gmail.com"
    value="{{ Auth::user()->email }}"
    required
    readonly
>

                    </div>

                    <div class="form-group">

                        <label>
                            No. HP <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            placeholder="+62 89576233347"
                            required
                        >

                    </div>

            </div>

            <!-- RIGHT -->
            <div>

                <h3 class="summary-title">
                    Rincian Pembayaran
                </h3>

                @php
                    $subtotal = 0;

                    foreach($cart as $item){
                        $subtotal += $item['price'] * $item['qty'];
                    }
                @endphp

                <div class="summary-row">

                    <span>Subtotal</span>

                    <span>
                        Rp {{ number_format($subtotal,0,',','.') }}
                    </span>

                </div>

                <div class="summary-row">
    <span>Total Item</span>
    <span>{{ collect($cart)->sum('qty') }} Item</span>
</div>

                <div class="summary-divider"></div>

                <div class="summary-row total">

                    <span>Total</span>

                    <span>
                        Rp {{ number_format($subtotal,0,',','.') }}
                    </span>

                </div>

                <button
                    type="submit"
                    class="checkout-btn"
                >
                    Selanjutnya
                </button>

                </form>

            </div>

        </div>

    </div>

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
          <li><a href="#tentang">Tentang Kopikala</a></li><br>
        </ul>
      </div>

      <div class="footer-right">
        <h3>Ayo jadi #sobatkala!</h3>
        <div class="social-icons">
          <<a href="https://www.instagram.com/kopikalaaa/" target="_blank">
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
</body>
</html>