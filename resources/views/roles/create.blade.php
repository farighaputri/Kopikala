@extends('layouts.app')

@section('content')

<div class="page-header">
<div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Role --}}
    <a href="{{ route('roles.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Role 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Add New Role
            </span>
        </h2>
    </a>
</div>
</div>

<div class="card" style="padding:32px; max-width:1000px">

<form method="POST" action="{{ route('roles.store') }}">
@csrf

{{-- ROLE NAME --}}
<div style="margin-bottom:28px">
    <label class="form-label">
        Role Name <span style="color:red">*</span>
    </label>
    <input
        type="text"
        name="name"
        class="form-input"
        placeholder="Enter Role Name"
        value="{{ old('name') }}"
        required
    >
    @error('name')
        <small class="error-text">{{ $message }}</small>
    @enderror
</div>

{{-- STATUS --}}
<div style="margin-bottom:32px">
    <label class="form-label">Status</label>

    <input type="hidden" name="status" value="0">

    <label class="switch">
        <input type="checkbox" name="status" value="1" checked>
        <span class="slider"></span>
    </label>

    <span style="margin-left:10px;font-size:14px;color:#555">Active</span>
</div>

<hr class="divider">

{{-- ACCESS --}}
<div>
    <label class="form-label">Access <span style="color:red">*</span></label>

    <div class="access-grid">

        {{-- GLOBAL --}}
        <div>
            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="WHOLE ACCESS">
                <div>
                    <strong>WHOLE ACCESS</strong>
                    <div class="muted">Whole Access of Admin Dashboard</div>
                </div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="WHOLE MAIN ACCESS">
                <div>
                    <strong>WHOLE MAIN ACCESS</strong>
                    <div class="muted">
                        Main Dashboard, Staff, Transaction, Stock, Branch, Role, Product
                    </div>
                </div>
            </label>
        </div>

        {{-- MAIN ACCESS --}}
        <div>
            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Main Dashboard">
                <div><strong>Main Dashboard</strong><div class="muted">Access to main dashboard</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Products">
                <div><strong>Products</strong><div class="muted">Access to products</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Kopikala Branch">
                <div><strong>Kopikala Branch</strong><div class="muted">Access to Kopikala Branch</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Main Transaction">
                <div><strong>Main Transaction</strong><div class="muted">Access to Main Transaction</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Staff">
                <div><strong>Staff</strong><div class="muted">Access to Whole Staff</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Stock">
                <div><strong>Stock</strong><div class="muted">Access to Whole Stock</div></div>
            </label>

            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="Role">
                <div><strong>Role</strong><div class="muted">Access to Role</div></div>
            </label>

        </div>

        {{-- SEMERU --}}
        <div>
            <strong class="muted">Semeru Branch Access</strong>

            @foreach(['Semeru Transaction','Semeru Staff','Semeru Stock'] as $a)
            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="{{ $a }}">
                <div><strong>{{ $a }}</strong></div>
            </label>
            @endforeach
        </div>

        {{-- DJUANDA --}}
        <div>
            <strong class="muted">Djuanda Branch Access</strong>

            @foreach(['Djuanda Transaction','Djuanda Staff','Djuanda Stock'] as $a)
            <label class="access-item">
                <input type="checkbox" class="access-checkbox" name="access[]" value="{{ $a }}">
                <div><strong>{{ $a }}</strong></div>
            </label>
            @endforeach
        </div>
    </div>

    <hr class="divider">

    {{-- NO ACCESS --}}
    <label class="access-item" style="border:1px solid #fecaca">
        <input type="checkbox" id="noAccess" name="access[]" value="NO ACCESS">
        <div>
            <strong style="color:#b91c1c">NO ACCESS</strong>
            <div class="muted">No Access to Anything</div>
        </div>
    </label>
</div>

<div class="action-footer">
    <a href="{{ route('roles.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="add-btn">Add New Role</button>
</div>

</form>
</div>

{{-- NO ACCESS LOGIC --}}
<script>
const noAccess = document.getElementById('noAccess');
const allAccess = document.querySelectorAll('.access-checkbox');

noAccess.addEventListener('change', function () {
    if (this.checked) {
        allAccess.forEach(cb => {
            cb.checked = false;
            cb.disabled = true;
        });
    } else {
        allAccess.forEach(cb => cb.disabled = false);
    }
});
</script>

@endsection
