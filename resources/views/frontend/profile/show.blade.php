<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopikala - Profil Saya</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    
    {{-- CDN SweetAlert2 untuk Popup Ber-icon --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Kustomisasi Font SweetAlert agar mengikuti font tema Kopikala */
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 16px !important;
        }

        /* Gaya visual input saat dikunci menggunakan atribut readonly */
        .form-group input:disabled,
        .form-group input[readonly] {
            background: #f5f5f5;
            color: #666;
            cursor: not-allowed;
            border-color: #d9d9d9 !important;
        }
    </style>
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
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="header-section">
                    <div class="avatar-wrapper">
                        {{-- Preview Avatar --}}
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('media/default-avatar.png') }}"
                             class="avatar"
                             id="avatarPreview"
                             alt="Avatar">

                        {{-- Input Upload Hidden --}}
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" hidden>

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
                    {{-- 👑 GANTI JADI READONLY SEBAGAI DEFAULT UNTUK PENGGUNA NON-GOOGLE --}}
                    <input type="text" name="name" id="nameInput" value="{{ auth()->user()->name }}" 
                           {{ auth()->user()->google_id ? 'readonly' : 'readonly' }}>
                </div>

                <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email" id="emailInput" value="{{ auth()->user()->email }}" 
                           {{ auth()->user()->google_id ? 'readonly' : 'readonly' }}>
                </div>

                <div class="btn-group">
                    {{-- USER GOOGLE --}}
                    @if(auth()->user()->google_id)
                        <a href="/menu" class="btn btn-batal">Batal</a>
                        <button type="submit" class="btn btn-simpan">Simpan</button>

                    {{-- USER MANUAL --}}
                    @else
                        <button type="button" class="btn btn-edit" id="btnEdit" onclick="enableEdit()">
                            Edit Profil
                        </button>

                        <button type="button" class="btn btn-batal" id="btnBatal" onclick="disableEdit()" style="display:none;">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-simpan">
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
                    <a href="#"><img src="{{ asset('media/LinkedIn.png') }}" alt="LinkedIn"></a>
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
let originalAvatarSrc = document.getElementById('avatarPreview').src;
const nameInput = document.getElementById('nameInput');
const emailInput = document.getElementById('emailInput');
const btnEdit = document.getElementById('btnEdit');
const btnBatal = document.getElementById('btnBatal');

function enableEdit() {
    nameInput.removeAttribute('readonly');
    emailInput.removeAttribute('readonly');
    nameInput.focus();

    if(btnEdit) btnEdit.style.display = 'none';
    if(btnBatal) btnBatal.style.display = 'inline-flex';
}

function disableEdit() {
    if(!@json(auth()->user()->google_id)){
        nameInput.setAttribute('readonly', true);
        emailInput.setAttribute('readonly', true);

        if(btnEdit) btnEdit.style.display = 'inline-flex';
        if(btnBatal) btnBatal.style.display = 'none';
        
        nameInput.value = "{{ auth()->user()->name }}";
        emailInput.value = "{{ auth()->user()->email }}";
        document.getElementById('avatarPreview').src = originalAvatarSrc;
        document.getElementById('avatarInput').value = ""; 
    }
}

// ================= LIVE AJAX SUBMIT =================
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // VALIDASI KOSONG: Cek jika input nama atau email kosong
    if (nameInput.value.trim() === "" || emailInput.value.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Data Tidak Lengkap',
            text: 'Nama dan Alamat Email wajib terisi!',
            confirmButtonColor: '#3c1f0e'
        });
        return;
    }

    let formData = new FormData(this);
    
    // 👑 METHOD SPOOFING: Sisipkan parameter _method PUT agar dibaca dengan benar oleh route Laravel Anda
    formData.append('_method', 'PUT');

    fetch("{{ route('profile.update') }}", {
        method: "POST", // Tetap POST di browser agar file gambar terbaca biner
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(err => { throw new Error(err.message); });
        }
        return res.json();
    })
    .then(data => {
        // Terapkan perubahan data secara live di halaman tanpa reload paksa
        if(data.name) document.getElementById('profileName').innerText = data.name;
        if(data.email) document.getElementById('profileEmail').innerText = data.email;
        if(data.avatar) {
            document.getElementById('avatarPreview').src = data.avatar;
            originalAvatarSrc = data.avatar;
        }

        disableEdit();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Profil Anda telah berhasil diperbarui.',
            confirmButtonColor: '#3c1f0e'
        });
    })
    .catch(err => {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Gagal Memperbarui',
            text: err.message || 'Terjadi kendala sistem. Pastikan ukuran foto di bawah 2MB dengan format JPG/PNG.',
            confirmButtonColor: '#3c1f0e'
        });
    });
});

// ================= AVATAR PREVIEW SEMENTARA =================
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