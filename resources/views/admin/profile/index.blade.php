@extends('layouts.app')

@section('content')

<style>
.profile-page{
    padding:30px;
}

.profile-header{
    display:flex;
    align-items:center;
    gap:20px;
    margin-bottom:25px;
}

.profile-header h1{
    font-size:48px;
    font-weight:700;
    color:#3d1f00;
    margin:0;
}

.profile-header span{
    font-size:28px;
    color:#4a2a08;
}

.profile-card{
    background:#fff;
    border-radius:18px;
    padding:40px 80px;
    box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.avatar-section{
    text-align:center;
    margin-bottom:40px;
    position: relative;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
    width: 130px;
    height: 130px;
}

.profile-avatar{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #eee;
}

/* Tombol Pensil Kustom agar tampilan estetik */
.edit-icon {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #4a1f00;
    color: #fff;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: transform 0.2s ease;
}

.edit-icon:hover {
    transform: scale(5.5);
}

.profile-form{
    max-width:960px;
    margin:auto;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px 25px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:500;
    color:#333;
}

.form-group input{
    width:100%;
    height:42px;
    border:1px solid #d9d9d9;
    border-radius:10px;
    padding:0 14px;
    font-size:15px;
    background:#fff;
}

.form-group input:focus{
    outline:none;
    border-color:#5b2d00;
}

.form-group input:disabled,
.form-group input[readonly] {
    background: #f5f5f5;
    color: #666;
    cursor: not-allowed;
}

.profile-divider{
    margin:40px 0;
    border:none;
    border-top:1px solid #ddd;
}

.profile-actions{
    display:flex;
    justify-content:flex-end;
    gap:15px;
}

.btn-cancel{
    background:#e60000;
    color:#fff;
    border:none;
    border-radius:8px;
    padding:10px 35px;
    text-decoration:none;
    font-weight:600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-edit-toggle {
    background: #7A5234;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 35px;
    font-weight: 600;
    cursor: pointer;
}

.btn-update{
    background:#4a1f00;
    color:#fff;
    border:none;
    border-radius:8px;
    padding:10px 35px;
    font-weight:600;
    cursor:pointer;
}

.btn-update:hover{
    background:#341500;
}

@media(max-width:768px){
    .profile-card{
        padding:25px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .profile-actions{
        flex-direction:column;
    }

    .btn-cancel,
    .btn-edit-toggle,
    .btn-update{
        width:100%;
        text-align: center;
    }
}
</style>

@php
    // Ambil data resmi dari Laravel Auth Guard Staff
    $staff = Auth::guard('staff')->user();

    $avatarUrl = $staff->photo
        ? asset($staff->photo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($staff->name) . '&background=7A5234&color=fff';
@endphp

<div class="profile-page">

    <div style="margin-bottom: 25px;">
        
        <a href="{{ route('admin.profile') }}" style="text-decoration: none; color: inherit; display: inline-block;">
            <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
                Profile
                <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                    › Edit Profile
                </span>
            </h2>
        </a>
    </div>

    <div class="profile-card">

       
        <form action="{{ route('admin.profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              id="profileForm">

            @csrf
            @method('PUT')

           {{-- AVATAR SECTION --}}
<div class="avatar-section">
    <div class="avatar-wrapper">
        {{-- Preview Foto Utama Admin --}}
        <img src="{{ $avatarUrl }}?v={{ time() }}" class="profile-avatar" id="avatarPreview">
        
        {{-- Input file tersembunyi untuk upload --}}
        <input type="file" name="photo" id="avatarInput" accept="image/*" style="display: none;">
        
        {{-- Tombol Edit Bulat Kecil Cokelat --}}
        <div class="edit-icon" onclick="document.getElementById('avatarInput').click()" 
             style="background: #4a1f00; border: 2px solid #fff; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; padding: 0;">
            
           
            <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" 
                 style="width: 25px; height: 25px; max-width: 25px; max-height: 25px; margin: auto; display: block; object-fit: contain;">
                 
        </div>
    </div>
    <div style="margin-top: 10px; font-size: 13px; color: #666;">Klik ikon pensil untuk mengubah foto</div>
</div>
            {{-- FORM INPUT SECTION --}}
            <div class="profile-form">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="nameInput" value="{{ $staff->name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="emailInput" value="{{ $staff->email }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" value="{{ $staff->status }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" value="{{ $staff->role->name ?? '-' }}" readonly>
                    </div>

                </div>

                <hr class="profile-divider">

                <div class="profile-actions">

                    <button type="button" class="btn-edit-toggle" id="btnEdit" onclick="enableEdit()">
                        Edit Data
                    </button>

                    <button type="button" class="btn-cancel" id="btnBatal" onclick="disableEdit()" style="display:none;">
                        Batal
                    </button>

                    <button type="submit" class="btn-update">
                        Update Profile
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- ================= JAVASCRIPT LIVE ENGINE ================= --}}
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

// Handler AJAX Proses Update Tanpa Mental/Reload Paksa
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    
    // Buka proteksi disabled sesaat agar datanya tidak bernilai null/kosong di server
    nameInput.disabled = false;
    emailInput.disabled = false;

    let formData = new FormData(this);

    // Kunci kembali statusnya setelah disalin objek FormData
    nameInput.disabled = true;
    emailInput.disabled = true;

    fetch("{{ route('admin.profile.update') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal memperbarui data.');
        return res.json();
    })
    .then(data => {
        alert("Profil Admin berhasil diperbarui!");
        window.location.reload(); // Di-reload sekali saja agar foto Topbar sinkron
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan saat menyimpan data profile.");
    });
});

// Handler Live Preview Gambar Saat Dipilih Dari Dokumen Lokal
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

@endsection