<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Kopikala Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/branch.css') }}">

<style>
/* ===== GLOBAL POPUP STYLE ===== */
.popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

.popup-box {
    background: #fff;
    width: 420px;
    max-width: 90%;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,.25);
    display: flex;
    align-items: center;
    padding: 14px 18px;
    animation: popupSlide .3s ease;
}

.popup-icon img {
    width: 70px;
    margin-right: 16px;
}

.popup-content {
    flex: 1;
}

.popup-content h3 {
    font-size: 18px;
    margin-bottom: 4px;
}

.popup-content p {
    font-size: 14px;
    margin: 0;
    color: #444;
}

.popup-box button {
    padding: 6px 14px;
    border: none;
    background: #3490dc;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
    margin-left: 8px;
}

.btn-danger {
    background: #e3342f;
}

@keyframes popupSlide {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
</head>

<body>

<div class="app-layout">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- MAIN AREA --}}
    <div class="main-area">

        {{-- TOPBAR --}}
        @include('partials.topbar')

        {{-- CONTENT --}}
        <div class="content-area">
            @yield('content')
        </div>

    </div>
</div>

{{-- ================= SUCCESS / ERROR POPUP ================= --}}
@if(session('success') || session('error'))
<div class="popup-overlay" id="globalPopup">
    <div class="popup-box">

        <div class="popup-icon">
            @if(session('success'))
                <img src="{{ asset('images/popup-success.png') }}">
            @else
                <img src="{{ asset('images/popup-error.png') }}">
            @endif
        </div>

        <div class="popup-content">
            <h3>{{ session('success') ? 'Success' : 'Error' }}</h3>
            <p>{{ session('success') ?? session('error') }}</p>
        </div>

        <button onclick="closePopup()">OK</button>
    </div>
</div>
@endif


{{-- ================= DELETE CONFIRM POPUP ================= --}}
<div class="popup-overlay" id="deletePopup" style="display:none;">
    <div class="popup-box">

        <div class="popup-icon">
            <img src="{{ asset('images/popup-error.png') }}">
        </div>

        <div class="popup-content">
            <h3>Delete Data</h3>
            <p>Data yang dihapus tidak dapat dikembalikan. Yakin ingin menghapus?</p>
        </div>

        <button onclick="cancelDelete()">Batal</button>
        <button class="btn-danger" onclick="confirmDeleteAction()">Hapus</button>

    </div>
</div>


<script>
let deleteTargetForm = null;

/* close success/error popup */
function closePopup() {
    document.getElementById('globalPopup')?.remove();
}

/* show delete popup */
function showDeletePopup(formId) {
    deleteTargetForm = document.getElementById(formId);
    document.getElementById('deletePopup').style.display = 'flex';
}

/* cancel delete */
function cancelDelete() {
    deleteTargetForm = null;
    document.getElementById('deletePopup').style.display = 'none';
}

/* confirm delete */
function confirmDeleteAction() {
    if(deleteTargetForm) {
        deleteTargetForm.submit();
    }
}
</script>

</body>
</html>
