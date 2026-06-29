<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kopikala - Order</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">

<script>
const AUTH_USER = @json(auth()->user());
</script>

<style>
/* ================= OVERRIDE PROFILE DROPDOWN STYLES ================= */
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
  border: 2px solid rgba(255,255,255,0.7);
  transition: .3s;
}

.profile-avatar:hover {
  transform: scale(1.08);
  border-color: #f1c27d;
}

/* Kotak Dropdown Rapi Maksimal */
.profile-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  width: 320px; 
  background: #FAFAFA;
  border-radius: 20px;
  padding: 22px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  display: none;
  z-index: 1000;
  margin-top: 15px;
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
  font-size: 20px;
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

/* ================= FOOTER CUPS STYLES ================= */
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
  background:transparent;
}

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

.footer-cups img{
  position:relative;
  z-index:3;
  width:auto;
  height:110px;
  object-fit:contain;
  display:block;
  flex-shrink:0;
}
</style>
</head>

<body>

<div id="toast" class="toast">
    Pesanan berhasil ditambahkan ke keranjang!
</div>

<header id="navbar" class="topbar">
  <div class="logo">
    <img src="{{ asset('media/Secondary logo.png') }}" alt="Kopikala">
  </div>

  <div class="nav">
    <a href="{{ route('menu') }}">menu</a>
    <a href="{{ route('frontend.about') }}">tentang</a>
    <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
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
            <span>Logout</span> <i class="fas fa-sign-out-alt"></i>
          </button>
        </form>
      </div>
    </div>
    @else
      <a href="{{ route('login') }}" class="login-btn">Login</a>
    @endauth
  </div>
</header>

<section class="hero">
    <h2>#sobatkala, mau minum apa hari ini?</h2>
    <p>Pilih minuman kopi atau non kopi dan kustomisasi sesukamu sebelum datang mengambilnya di lokasi kami!</p>

    <div class="pickup-container" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; width: 100%; margin-top: 25px; box-sizing: border-box;">
        <div class="pickup-box" style="flex: 1; margin: 0; text-align: left; box-sizing: border-box;">
            <div>
                <small>Pesananmu dapat diambil di</small>
                <div class="pickup-location" style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                    <i class="fa-solid fa-location-dot" style="color: #fff; font-size: 16px;"></i>
                    <span>{{ $branch->branch_name ?? 'Kopikala Coffee Shop' }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('orders.my') }}" style="text-decoration: none;">
            <button class="pickup-btn" style="margin: 0; white-space: nowrap; height: 100%; min-height: 56px; display: inline-flex; align-items: center; justify-content: center; box-sizing: border-box; padding: 0 35px;">
                Pesanan Saya
            </button>
        </a>
    </div>
</section>

<section class="grid">
    @foreach($products as $item)
    <div class="card">
        <img src="{{ asset('storage/' . $item->image) }}" class="menu-img" alt="{{ $item->name }}">
        <h4>{{ $item->name }}</h4>
        <small>{{ $item->description ?? 'Kopi Susu' }}</small>
        <div class="price">
            <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
            <button onclick='openModal(@json($item->load("customizations.options")))' >+</button>
        </div>
    </div>
    @endforeach
</section>

<div class="cart" onclick="window.location.href='{{ route('cart') }}'">
    <img src="{{ asset('media/keranjang.png') }}" alt="Cart" class="cart-icon">
    <span id="cart-count">
        {{ collect(session('cart', []))->sum('qty') }}
    </span>
</div>

<div id="customModal" class="modal-overlay">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">×</button>
        <img id="modalImage" class="modal-image" alt="Modal Image">

        <div class="modal-body">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Kopi Susu</div>
                <div class="modal-desc" id="modalDesc">Kopi & Susu</div>
            </div>

            <div id="customizationContainer"></div>

            <div class="modal-footer">
                <div class="footer-top">
                    <div class="modal-price" id="modalPrice">Rp 10.000</div>
                    <div class="qty-wrapper">
                        <button class="qty-btn" onclick="changeQty(-1)">-</button>
                        <span id="modalQty">1</span>
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                </div>
                <button class="add-cart-btn" onclick="addCustomizedToCart()">
                    Tambahkan ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

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

<script>
let cartCount = {{ collect(session('cart', []))->sum('qty') }};
let selectedProduct = null;
let modalQty = 1;

function openModal(product) {
    selectedProduct = product;
    modalQty = 1;

    document.getElementById('modalTitle').innerText = product.name;
    document.getElementById('modalDesc').innerText = product.description ?? 'Kopi & Susu';
    document.getElementById('modalPrice').innerText = 'Rp ' + Number(product.price).toLocaleString('id-ID');
    document.getElementById('modalQty').innerText = modalQty;
    document.getElementById('modalImage').src = '/storage/' + product.image;

    const container = document.getElementById('customizationContainer');
    container.innerHTML = '';

    if (product.customizations) {
        product.customizations.forEach((custom, index) => {
            let html = `<div class="custom-group"><h5>${custom.name}</h5><div class="option-list">`;
            custom.options.forEach((option, i) => {
                const id = `c_${index}_${i}`;
                html += `
                    <div class="option-item">
                        <input type="radio" name="custom_${index}" 
                        value="${option.name}" 
                        data-price="${option.additional_price || 0}" 
                        id="${id}" 
                        ${i === 0 ? 'checked' : ''}>
                        <label for="${id}">${option.name}</label>
                    </div>
                `;
            });
            html += `</div></div>`;
            container.innerHTML += html;
        });
    }
    document.getElementById('customModal').classList.add('active');
}

function closeModal(){
    document.getElementById('customModal').classList.remove('active');
}

function changeQty(v){
    modalQty = Math.max(1, modalQty + v);
    document.getElementById('modalQty').innerText = modalQty;
}

function addCustomizedToCart(){
    let selectedOptions = [];
    let extra = 0;

    selectedProduct.customizations.forEach((c,i)=>{
        const checked = document.querySelector(`input[name="custom_${i}"]:checked`);
        if(checked){
            extra += Number(checked.dataset.price);
            selectedOptions.push({
                customization: c.name,
                option: checked.value
            });
        }
    });

    const price = Number(selectedProduct.price) + extra;

    fetch("{{ route('cart.add') }}",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },
        body:JSON.stringify({
            product_id: selectedProduct.id,
            name: selectedProduct.name,
            price: price,
            qty: modalQty,
            image: selectedProduct.image,
            options: selectedOptions
        })
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.success){
            cartCount += Number(modalQty);
            document.getElementById('cart-count').innerText = cartCount;
            closeModal();
            showToast("Berhasil ditambahkan ke keranjang!");
        }
    });
}

function showToast(msg){
    let t=document.getElementById('toast');
    t.innerText=msg;
    t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'),3000);
}

// TOGGLE HANDLER MODAL PROFILE
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