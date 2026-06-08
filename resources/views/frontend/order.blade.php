<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kopikala - Order</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">

<script>
const AUTH_USER = @json(auth()->user());
</script>
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
        src="{{ auth()->user()->avatar 
            ? asset('storage/' . auth()->user()->avatar) 
            : asset('media/default-avatar.png') }}"
        class="profile-avatar"
        id="profileToggle"
        alt="Profile"
      >

      <div class="profile-dropdown" id="profileMenu">

        <div class="user-info">
          <img 
            src="{{ auth()->user()->avatar 
                ? asset('storage/' . auth()->user()->avatar) 
                : asset('media/default-avatar.png') }}"
          >
          <div>
            <h4>{{ auth()->user()->name }}</h4>
            <span>{{ auth()->user()->email }}</span>
          </div>
        </div>

        <a href="{{ route('profile.show') }}" class="dropdown-link">
          My Profile
        </a>

        <form action="{{ route('logout.user') }}" method="POST">
          @csrf
          <button class="dropdown-link logout" style="background:none;border:none;cursor:pointer;">
            Logout
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

    <p>Pilih minuman kopi atau non kopi dan kustomisasi sesukamu</p>

    <div class="pickup-box">

        <div>
            <small>Pesananmu dapat diambil di</small>

            <div class="pickup-location">
                📍 {{ $branch->branch_name ?? 'Kopikala Coffee Shop' }}
            </div>
        </div>

        <a href="{{ route('orders.my') }}">
            <button class="pickup-btn">Pesanan Saya</button>
        </a>

    </div>
</section>

<section class="grid">

@foreach($products as $item)

<div class="card">

    <img src="{{ asset('storage/' . $item->image) }}" class="menu-img">

    <h4>{{ $item->name }}</h4>

    <small>{{ $item->description ?? 'Kopi Susu' }}</small>

    <div class="price">

        <span>
            Rp {{ number_format($item->price, 0, ',', '.') }}
        </span>

        <button onclick='openModal(@json($item->load("customizations.options")))' >
            +
        </button>

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

<!-- MODAL -->
<div id="customModal" class="modal-overlay">

    <div class="modal">

        <button class="modal-close" onclick="closeModal()">×</button>

        <img id="modalImage" class="modal-image">

       <div class="modal-body">

    <!-- HEADER -->
    <div class="modal-header">

        <div class="modal-title" id="modalTitle">
            Kopi Susu
        </div>

       <div class="modal-desc" id="modalDesc">
    Kopi & Susu
</div>

    </div>

    <!-- CUSTOM -->
    <div id="customizationContainer"></div>

    <!-- FOOTER -->
    <div class="modal-footer">

        <div class="footer-top">

            <div class="modal-price" id="modalPrice">
                Rp 10.000
            </div>

            <div class="qty-wrapper">

                <button class="qty-btn" onclick="changeQty(-1)">
                    -
                </button>

                <span id="modalQty">1</span>

                <button class="qty-btn" onclick="changeQty(1)">
                    +
                </button>

            </div>

        </div>

        <button class="add-cart-btn" onclick="addCustomizedToCart()">
            Tambahkan ke Keranjang
        </button>

    </div>

</div>
    </div>
</div>

<script>

let cartCount = {{ collect(session('cart', []))->sum('qty') }};
let selectedProduct = null;
let modalQty = 1;

/* ================= OPEN MODAL ================= */
function openModal(product) {
    selectedProduct = product;
    modalQty = 1;

    document.getElementById('modalTitle').innerText = product.name;
    document.getElementById('modalDesc').innerText =
    product.description ?? 'Kopi & Susu';
    document.getElementById('modalPrice').innerText = 'Rp ' + Number(product.price).toLocaleString('id-ID');
    document.getElementById('modalQty').innerText = modalQty;
    document.getElementById('modalImage').src = '/storage/' + product.image;

    const container = document.getElementById('customizationContainer');
    container.innerHTML = '';

    if (product.customizations) {
        product.customizations.forEach((custom, index) => {
            // Kita bungkus dalam .custom-group
            let html = `<div class="custom-group"><h5>${custom.name}</h5><div class="option-list">`;

            custom.options.forEach((option, i) => {
                const id = `c_${index}_${i}`;
                // KELAS PENTING: .option-item
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

/* ================= CLOSE ================= */
function closeModal(){
    document.getElementById('customModal').classList.remove('active');
}

/* ================= QTY ================= */
function changeQty(v){
    modalQty = Math.max(1, modalQty + v);
    document.getElementById('modalQty').innerText = modalQty;
}

/* ================= ADD CART ================= */
function addCustomizedToCart(){

    let selectedOptions = [];
    let extra = 0;

    selectedProduct.customizations.forEach((c,i)=>{

        const checked = document.querySelector(`input[name="custom_${i}"]:checked`);

        if(checked){
            extra += Number(checked.dataset.price);
            selectedOptions.push({
                customization:c.name,
                option:checked.value
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
            product_id:selectedProduct.id,
            name:selectedProduct.name,
            price:price,
            qty:modalQty,
            image:selectedProduct.image,
            options:selectedOptions
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

/* ================= CHECKOUT (FINAL FIX) ================= */
function checkoutOrder(){

    const cart = @json(session('cart', []));

    if(!AUTH_USER){
        alert("Login dulu!");
        return;
    }

    if(cart.length===0){
        alert("Keranjang kosong!");
        return;
    }

    fetch("{{ route('frontend.order') }}",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },
        body:JSON.stringify({
            customer_name:AUTH_USER.name,
            email:AUTH_USER.email,
            phone:"-",
            items:cart,
            total:cart.reduce((s,i)=>s+(i.price*i.qty),0),
            branch_id:1
        })
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.status){
            document.getElementById('cart-count').innerText = 0;
            window.location.href="/confirmation/"+d.order_id;
        }else{
            alert("Checkout gagal");
        }
    });
}

/* ================= TOAST ================= */
function showToast(msg){
    let t=document.getElementById('toast');
    t.innerText=msg;
    t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'),3000);
}
const profileToggle = document.getElementById('profileToggle');
const profileMenu = document.getElementById('profileMenu');

if (profileToggle && profileMenu) {
  profileToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    profileMenu.style.display =
      profileMenu.style.display === 'block' ? 'none' : 'block';
  });
}

window.addEventListener('click', (e) => {
  if (profileMenu && !profileMenu.contains(e.target)) {
    profileMenu.style.display = 'none';
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