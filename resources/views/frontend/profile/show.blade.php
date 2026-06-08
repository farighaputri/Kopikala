<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopikala - Profil Saya</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

    <header class="topbar">
        <img src="{{ asset('media/Secondary Logo.png') }}" class="logo">
        <nav class="nav-menu">
            <a href="{{ route('menu') }}">menu</a>
        <a href="{{ route('frontend.about') }}">tentang</a>
        <a href="{{ route('frontend.sobatkala') }}">#sobatkala</a>
        <a href="{{ route('frontend.order') }}">pemesanan</a>
        </nav>
        <i class="fas fa-user-circle profile-icon"></i>
    </header>

    <div class="profile-main-container">
        <div class="title-profil">Profil Saya</div>

        <div class="profile-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="header-section">
        <div class="avatar-wrapper">

            {{-- Preview Avatar --}}
            <img 
    src="{{ auth()->user()->avatar 
        ? asset('storage/' . auth()->user()->avatar) 
        : asset('media/default-avatar.png') }}"
    class="avatar"
    id="avatarPreview"
    alt="Avatar">

            {{-- Input Upload Hidden --}}
            <input type="file" 
                   name="avatar" 
                   id="avatarInput" 
                   accept="image/*" 
                   hidden>

            {{-- Tombol Edit --}}
            <div class="edit-icon" onclick="document.getElementById('avatarInput').click()">
                <i class="fa-solid fa-pencil"></i>
            </div>

        </div>

        <div class="user-info">
        <h2 id="profileName">{{ auth()->user()->name }}</h2>
        <p id="profileEmail">{{ auth()->user()->email }}</p>
    </div>
    </div>
                <div class="form-group">
    <label>Nama</label>
    {{-- Jika user Google, paksa readonly atau buat logic khusus --}}
    <input type="text" name="name" id="nameInput" value="{{ auth()->user()->name }}" 
           {{ auth()->user()->google_id ? 'readonly' : 'disabled' }}>
</div>

<div class="form-group">
    <label>Alamat Email</label>
    <input type="email" name="email" id="emailInput" value="{{ auth()->user()->email }}" 
           {{ auth()->user()->google_id ? 'readonly' : 'disabled' }}>
</div>

<div class="btn-group">

    {{-- USER GOOGLE --}}
    @if(auth()->user()->google_id)

        <a href="/menu" class="btn btn-batal">
            Batal
        </a>

        <button type="submit" class="btn btn-simpan">
            Simpan
        </button>

    {{-- USER MANUAL --}}
    @else

        <button type="button"
                class="btn btn-edit"
                id="btnEdit"
                onclick="enableEdit()">
            Edit Profil
        </button>

        <button type="button"
                class="btn btn-batal"
                id="btnBatal"
                onclick="disableEdit()"
                style="display:none;">
            Batal
        </button>

        <button type="submit"
                class="btn btn-simpan"
                onclick="resetAfterSave()">
            Simpan
        </button>

    @endif

</div>
            </form>
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
                    <a href="#"><img src="{{ asset('media/Instagram.png') }}" alt="Instagram"></a>
                    <a href="#"><img src="{{ asset('media/Linkedin.png') }}" alt="LinkedIn"></a>
                    <a href="#"><img src="{{ asset('media/Whatsapp.png') }}" alt="WhatsApp"></a>
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
<script>

function enableEdit() {
    document.getElementById('nameInput').disabled = false;
    document.getElementById('emailInput').disabled = false;

    document.getElementById('btnEdit').style.display = 'none';
    document.getElementById('btnBatal').style.display = 'inline-flex';
}

function disableEdit() {
    document.getElementById('nameInput').disabled = true;
    document.getElementById('emailInput').disabled = true;

    document.getElementById('btnEdit').style.display = 'inline-flex';
    document.getElementById('btnBatal').style.display = 'none';
}

// ================= LIVE AJAX =================
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('profile.update') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // 🔥 UPDATE LIVE DI HALAMAN (NO RELOAD)
        document.getElementById('profileName').innerText = data.name;
        document.getElementById('profileEmail').innerText = data.email;

        if (data.avatar) {
            document.getElementById('avatarPreview').src = data.avatar;
        }

        // reset edit mode
        disableEdit();

    })
    .catch(err => {
        console.error(err);
        alert("Gagal update profile");
    });
});

// ================= AVATAR PREVIEW =================
document.getElementById('avatarInput').addEventListener('change', function(e) {

    let file = e.target.files[0];

    if (file) {
        let reader = new FileReader();

        reader.onload = function(ev) {
            document.getElementById('avatarPreview').src = ev.target.result;
        };

        reader.readAsDataURL(file);
    }

});

</script>
</body>
</html>