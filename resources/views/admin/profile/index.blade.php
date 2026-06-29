@extends('layouts.app')

@section('content')

<style>
.profile-page {
    padding: 30px;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.profile-header h1 {
    font-size: 48px;
    font-weight: 700;
    color: #3d1f00;
    margin: 0;
}

.profile-header span {
    font-size: 28px;
    color: #4a2a08;
}

.profile-card {
    background: #fff;
    border-radius: 18px;
    padding: 40px 80px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}

.avatar-section {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
    width: 130px;
    height: 130px;
}

.profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #eee;
}

.edit-icon {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #4a1f00;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    border: 2px solid #fff;
    transition: transform 0.2s ease;
}

.edit-icon:hover {
    transform: scale(1.1);
}

.profile-form {
    max-width: 960px;
    margin: auto;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group input {
    width: 100%;
    height: 42px;
    border: 1px solid #d9d9d9;
    border-radius: 10px;
    padding: 0 14px;
    font-size: 15px;
    background: #fff;
}

.form-group input:focus {
    outline: none;
    border-color: #5b2d00;
}

/* Modifikasi status style agar input readonly terlihat terkunci */
.form-group input:disabled,
.form-group input[readonly] {
    background: #f5f5f5;
    color: #666;
    cursor: not-allowed;
    border-color: #d9d9d9 !important;
}

.profile-divider {
    margin: 40px 0;
    border: none;
    border-top: 1px solid #ddd;
}

.profile-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.btn-cancel {
    background: #e60000;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 35px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
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

.btn-update {
    background: #4a1f00;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 35px;
    font-weight: 600;
    cursor: pointer;
}

.btn-update:hover {
    background: #341500;
}

@media(max-width:768px){
    .profile-card { padding: 25px; }
    .form-grid { grid-template-columns: 1fr; }
    .profile-actions { flex-direction: column; }
    .btn-cancel, .btn-edit-toggle, .btn-update { width: 100%; text-align: center; }
}
</style>

@php
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
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf

            {{-- AVATAR SECTION --}}
            <div class="avatar-section">
                <div class="avatar-wrapper">
                    <img src="{{ $avatarUrl }}?v={{ time() }}" class="profile-avatar" id="avatarPreview">
                    <input type="file" name="photo" id="avatarInput" accept="image/*" style="display: none;">
                    
                    <div class="edit-icon" onclick="document.getElementById('avatarInput').click()">
                        <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" style="width: 25px; height: 25px; max-width: 25px; max-height: 25px; margin: auto; display: block; object-fit: contain;">
                    </div>
                </div>
                <div style="margin-top: 10px; font-size: 13px; color: #666;">Klik ikon pensil untuk mengubah foto</div>
            </div>

            {{-- FORM INPUT SECTION --}}
            <div class="profile-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="nameInput" value="{{ $staff->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" id="emailInput" value="{{ $staff->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" value="{{ $staff->status }}" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" value="{{ $staff->role->name ?? '-' }}" readonly disabled>
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

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    
    formData.append('_method', 'PUT');

    fetch("{{ route('admin.profile.update') }}", {
        method: "POST", 
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
        alert("Profil Admin berhasil diperbarui!");
        window.location.reload(); 
    })
    .catch(err => {
        console.error(err);
        alert(err.message || "Terjadi kesalahan saat menyimpan data profile.");
    });
});
</script>

@endsection