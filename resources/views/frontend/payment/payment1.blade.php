<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kopikala - Pembayaran</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/payment1.css') }}">

    <style>
        /* =========================================
           HEADER NAVBAR FIXED & SPACING IMPROVEMENT
        ========================================= */
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

        /* ================= MAIN CONTAINER SPACING ================= */
        .payment-wrapper {
            max-width: 1320px;
            margin: 0 auto;
            padding: 10px 25px 60px;
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

        @media (max-width: 900px) {
            .topbar { flex-direction: column; gap: 15px; padding: 20px; }
            .nav-menu { display: none; }
            .footer-container { flex-direction: column; text-align: center; align-items: center; gap: 30px; }
            .footer-left img { margin-top: 0; }
            .footer-right h3 { margin-top: 0; }
            .footer-left, .footer-center, .footer-right { align-items: center; text-align: center; }
            .social-icons { justify-content: center; }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
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

        <!-- MAIN CARD -->
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
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                    <div class="item-info">
                                        <h4>{{ $item['name'] }}</h4>
                                       <p>
                    @php
                        $customText = [];
                        if (isset($item['options']) && is_array($item['options'])) {
                            foreach ($item['options'] as $option) {
                                if (is_array($option)) {
                                    $key = $option['customization'] ?? $option['title'] ?? $option['name'] ?? null;
                                    $val = $option['option'] ?? $option['value'] ?? null;
                                    if ($key && $val) {
                                        $customText[] = $key . ' : ' . $val;
                                    }
                                } elseif (is_string($option)) {
                                    $customText[] = $option;
                                }
                            }
                        }
                    @endphp
                    {{ count($customText) ? implode(', ', $customText) : 'Tanpa Customisasi' }}
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

    <!-- FOOTER -->
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

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function updateQty(cartId, change) {
        let qtyElement = document.getElementById('qty-' + cartId);
        let currentQty = parseInt(qtyElement.innerText);
        let newQty = currentQty + change;

        if (newQty < 1) return;

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
            if (data.success) {
                location.reload();
            }
        });
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
    </script>

</body>
</html>