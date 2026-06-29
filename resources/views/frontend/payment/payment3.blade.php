<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kopikala - Pembayaran Akhir</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/payment1.css') }}">

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            font-family: 'Patrick Hand', cursive;
            background: #f3ede3 url("{{ asset('media/BG JAM.png') }}") repeat;
            background-size: 1400px auto;
            color: #3a1f10;
        }

        body::before{
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(243, 237, 227, .92);
            z-index: -1;
        }

        a{
            text-decoration: none;
        }

        /* ================= HEADER ================= */
        .topbar {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .logo img {
            height: 60px;
            width: auto;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 55px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #4A210B;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 18px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .nav-menu a:hover {
            color: #6B3A16;
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
            border: 2px solid #4A210B;
            transition: .3s;
            margin-left: 35px;
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: none;
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
            width: 54px;
            height: 54px;
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
            font-family: 'Patrick Hand', cursive;
            font-size: 18px;
            margin: 0;
            color: #3c1f0e;
            line-height: 1.2;
            word-break: break-word; 
            white-space: normal;
            font-weight: normal;
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

        /* ================= WRAPPER ================= */
        .payment-wrapper{
            max-width: 1320px;
            margin: auto;
            padding: 10px 25px 60px;
        }

        /* ================= TITLE ================= */
        .payment-title{
            font-size: 52px;
            font-weight: normal;
            margin-bottom: 15px;
        }

        /* ================= STEP ================= */
        .checkout-steps{
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .step{
            display: flex;
            align-items: center;
            gap: 8px;
            color: #866f5f;
            font-size: 15px;
        }

        .step-circle{
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ccb8a5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .step.active{
            color: #3a1f10;
        }

        .step.active .step-circle{
            background: #4b2411;
        }

        .step-line{
            width: 36px;
            height: 2px;
            background: #ccb8a5;
        }

        .step-line.active{
            background: #4b2411;
        }

        /* ================= PICKUP ================= */
        .pickup-box{
            width: fit-content;
            margin-left: auto;
            background: #7a5337;
            color: white;
            border-radius: 16px;
            padding: 15px 20px;
            margin-bottom: 22px;
        }

        .pickup-location{
            display: flex;
            gap: 12px;
        }

        .pickup-box strong{
            display: block;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .pickup-box span{
            font-size: 21px;
        }

        .branch-address{
            margin-top: 5px;
            font-size: 13px;
        }

        /* ================= MAIN CARD ================= */
        .main-card{
            background: white;
            border-radius: 24px;
            border: 1px solid #e6d8ca;
            padding: 40px;
            max-width: 1100px;
            margin: auto;
        }

        .payment-layout{
            display: block;
        }

        .payment-content{
            max-width: 700px;
            margin: auto;
        }

        .section-title{
            font-size: 42px;
            margin-bottom: 25px;
            margin-left: -150px;
        }

        .summary-title{
            font-size: 36px;
            margin-bottom: 25px;
            font-weight: normal;
        }

        .qris-timer-box{
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #7a5337;
            color: white;
            padding: 12px 18px;
            border-radius: 16px;
            font-size: 18px;
            margin-bottom: 35px;
        }

        .payment-row-detail{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            width: 100%;
        }

        .payment-label{
            font-size: 18px;
            color: #6e5443;
        }

        .price-display{
            font-size: 25px;
            color: #3a1f10;
            font-weight: 600;
        }

        .instruction-box h4{
            font-size: 28px;
            margin-bottom: 10px;
        }

        .instruction-box ol{
            font-family: 'Patrick Hand', cursive;
            font-size: 18px;
            line-height: 1.8;
            color: #3a1f10;
        }

        .checkout-btn{
            width: 100%;
            height: 60px;
            border: none;
            border-radius: 10px;
            background: #4b2411;
            color: white;
            font-family: 'Patrick Hand', cursive;
            font-size: 28px;
            cursor: pointer;
            margin-top: 30px;
        }

        /* ================= RESPONSIVE FOOTER STYLES ================= */
        footer {
            margin-top: 90px;
            background: #3b1604;
            color: white;
            padding: 80px 45px 25px;
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
            margin-top: -30px;
        }

        .social-icons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 14px;
        }

        .social-icons a { display: flex; justify-content: center; align-items: center; }
        .social-icons img { width: 34px; height: 34px; object-fit: contain; transition: 0.3s ease; }
        .social-icons img:hover { transform: scale(1.12); }

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

        /* ================= RESPONSIVE ================= */
        @media(max-width:950px){
            .topbar { flex-direction: column; gap: 15px; padding: 20px; }
            .logo img { width: 130px; }
            .nav-menu { display: none; }
            .payment-layout{ grid-template-columns: 1fr; }
            .pickup-box{ margin-left: 0; width: 100%; }
            .footer-content{ flex-direction: column; text-align: center; }
            .footer-container { flex-direction: column; text-align: center; align-items: center; gap: 30px; }
            .footer-left img { margin-top: 0; }
            .footer-right h3 { margin-top: 0; }
            .footer-left, .footer-center, .footer-right { align-items: center; text-align: center; }
            .social-icons{ justify-content: center; }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="logo">
            <img src="{{ asset('media/Secondary Logo.png') }}" alt="Kopikala Logo">
        </div>

        <nav class="nav-menu">
            <a href="{{ route('menu') }}">menu</a>
            <a href="{{ route('frontend.about') }}">tentang</a>
            <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
            <a href="{{ route('frontend.order') }}">pemesanan</a>
        </nav>

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
    </header>

    <section class="payment-wrapper">
        <h1 class="payment-title">Pembayaran</h1>

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
            <div class="step-line active"></div>

            <div class="step active">
                <div class="step-circle">3</div>
                <span>Pembayaran</span>
            </div>
        </div>

        <div class="pickup-box">
            <div class="pickup-location">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Pesanan akan diambil di</strong>
                    <span>{{ optional($branches->where('id', session('selected_branch'))->first())->branch_name ?? 'Kopikala Coffee Shop Pandu Raya' }}</span>
                    <div class="branch-address">
                        {{ optional($branches->where('id', session('selected_branch'))->first())->location ?? 'No.141 A, Jl. Pandu Raya No.14A, RT.03/RW.16, Tegal Gundil, Kec...' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card">
            <div class="payment-layout">
                <div class="payment-content">

                    <h2 class="section-title">Pembayaran</h2>

                    <div class="qris-timer-box">
                        <i class="far fa-clock"></i>
                        <span id="qris-timer">
                            Selesaikan pembayaran dalam 14 menit : 59 detik
                        </span>
                    </div>

                    <h3 class="summary-title">Detail Pembayaran</h3>

                    @php
                        $subtotal = 0;
                        if(isset($cart) && is_array($cart)) {
                            foreach($cart as $item){
                                $subtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
                            }
                        }
                    @endphp

                    <div class="payment-row-detail">
                        <div class="payment-label">
                            Total Pembayaran
                        </div>
                        <div class="price-display">
                            Rp {{ number_format($subtotal > 0 ? $subtotal : 40000, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="instruction-box">
                        <h4>Tata Cara Pembayaran</h4>
                        <ol>
                            <li>Klik tombol pembayaran di bawah untuk memilih metode pembayaran yang anda inginkan seperti E-wallet, Virtual Account Bank, Gerai Retail, atau Kartu Kredit.</li>
                            <li>Ikuti intruksi pembayaran yang muncul sesuai dengan metode yang sudah anda pilih sebelumnya.</li>
                            <li>Setelah pembayaran berhasil, sistem akan mendeteksi dan memverifikasi transaksi Anda secara otomatis tanpa perlu mengunggah bukti transfer.</li>
                            <li>Status pesanan anda akan langsung berubah dan tim Kopikala akan segera memproses pesanan tersebut.</li>
                            <li>Anda dapat langsung mengambil pesanan di Lokasi Kopikala yang tertera setelah menerima notifikasi bahwa pesanan siap di ambil.</li>
                        </ol>
                    </div>

                    <button id="pay-button" class="checkout-btn">
                        Konfirmasi Pembayaran
                    </button>

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
            <img src="{{ asset('media/Kopi Ga Miring02.png') }}" alt="cup">
            <img src="{{ asset('media/Kopi Ga Miring03.png') }}" alt="cup">
            <img src="{{ asset('media/Kopi Ga Miring04.png') }}" alt="cup">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // 1. ENGINE RUNNING COUNTDOWN TIMER (15 MENIT)
        let timeInSeconds = 15 * 60;
        const timerElement = document.getElementById('qris-timer');

        function startTimer() {
            const interval = setInterval(function() {
                let minutes = Math.floor(timeInSeconds / 60);
                let seconds = timeInSeconds % 60;

                seconds = seconds < 10 ? '0' + seconds : seconds;
                timerElement.innerHTML = `Selesaikan pembayaran dalam ${minutes} menit : ${seconds} detik`;

                if (timeInSeconds <= 0) {
                    clearInterval(interval);
                    timerElement.innerHTML = "Waktu pembayaran telah habis!";
                    document.getElementById('pay-button').disabled = true;
                }
                timeInSeconds--;
            }, 1000);
        }
        startTimer();

        // 2. BACKEND HANDLER INTEGRASI MIDTRANS
        document.getElementById('pay-button').onclick = function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            window.snap.pay("{{ $snapToken }}", {
                onSuccess: function(result){
                    document.getElementById('pay-button').innerText = "Memproses...";
                    document.getElementById('pay-button').disabled = true;

                    fetch("{{ route('payment.success') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify(result)
                    })
                    .then(response => {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw new Error(data.message || 'Gagal menyimpan data ke database sistem.');
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        window.location.href = data.redirect || "{{ route('orders.my') }}";
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Pembayaran berhasil di Midtrans, tetapi gagal mencatat ke database:\n" + error.message);
                        document.getElementById('pay-button').innerText = "Konfirmasi Pembayaran";
                        document.getElementById('pay-button').disabled = false;
                    });
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda diselesaikan.");
                    window.location.href = "{{ route('orders.my') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal atau dibatalkan, silakan coba beberapa saat lagi.");
                }
            });
        };

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

</body>
</html>