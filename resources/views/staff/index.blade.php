@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/staff.css') }}">

<style>
    /* === NAVIGASI CONTROLLER PAGINATION DESIGN SYSTEM === */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 12px 20px;
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .pagination-buttons {
        display: flex;
        gap: 10px;
    }
    .btn-page {
        background-color: #f4ecdf;
        color: #3c1f0e;
        border: 1px solid #3c1f0e;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .btn-page:hover:not(:disabled) {
        background-color: #3c1f0e;
        color: #ffffff;
    }
    .btn-page:disabled {
        background-color: #e2e8f0;
        color: #a0aec0;
        border-color: #cbd5e1;
        cursor: not-allowed;
    }
    .page-info {
        font-size: 0.95rem;
        color: #4a5568;
        font-weight: 600;
    }
</style>

<div class="page-header">
    <h2 class="page-title">Staff</h2>

    <a href="{{ route('staff.create') }}" class="add-btn">
        + Add New Staff
    </a>
</div>

{{-- STATISTIC --}}
<div class="stat-grid" style="display:flex; gap:16px; margin-bottom:20px;">
    <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
        <h3>{{ $staffs->count() }}</h3>
        <p>Total number of staff</p>
    </div>

    <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
        <h3>{{ $staffs->where('status','active')->count() }}</h3>
        <p>Total active staff</p>
    </div>

    <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
        <h3>{{ $staffs->where('status','inactive')->count() }}</h3>
        <p>Total inactive staff</p>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-card">
    <form method="GET" class="filter-grid">
        <div>
            <label>Search Staff</label>
            <input type="text" name="search" placeholder="Enter name" value="{{ request('search') }}">
        </div>

        <div>
            <label>Filter Role</label>
            <select name="role_id">
                <option value="">Filter Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Filter Branch</label>
            <select name="branch_id">
                <option value="">Filter Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Filter Status</label>
            <select name="status">
                <option value="">Filter Status</option>
                <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <button type="submit" class="add-btn">
                Filter
            </button>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="table-card" style="overflow-x:auto; display:flex; flex-direction:column;">

    <table class="table-custom" style="width:100%; border-collapse:collapse; text-align:center;">
        <thead>
            <tr>
                <th style="padding:15px; text-align:center;">No</th>
                <th style="padding:15px; text-align:center;">ID</th>
                <th style="padding:15px; text-align:center;">Name</th>
                <th style="padding:15px; text-align:center;">Email</th>
                <th style="padding:15px; text-align:center;">Role</th>
                <th style="padding:15px; text-align:center;">Branch</th>
                <th style="padding:15px; text-align:center;">Status</th>
                <th style="padding:15px; text-align:center;">Action</th>
            </tr>
        </thead>

        <tbody id="staffTableBody">
            @forelse($staffs as $i => $staff)
                @php
                    $roleName = strtolower($staff->role->name ?? '');
                    $roleClass = 'role-badge-default';

                    if($roleName == 'master admin'){ $roleClass = 'role-badge-master'; }
                    elseif($roleName == 'finance manager'){ $roleClass = 'role-badge-finance-manager'; }
                    elseif($roleName == 'head store djuanda'){ $roleClass = 'role-badge-head-store-djuanda'; }
                    elseif($roleName == 'head store semeru'){ $roleClass = 'role-badge-head-store-semeru'; }
                    elseif($roleName == 'hrd'){ $roleClass = 'role-badge-hrd'; }
                    elseif($roleName == 'kasir'){ $roleClass = 'role-badge-kasir'; }
                    elseif($roleName == 'operational manager'){ $roleClass = 'role-badge-operational-manager'; }
                    elseif($roleName == 'operational staff'){ $roleClass = 'role-badge-operational-staff'; }
                    elseif($roleName == 'secretary'){ $roleClass = 'role-badge-secretary'; }
                    elseif($roleName == 'cleaning staff'){ $roleClass = 'role-badge-cleaning-staff'; }
                @endphp

                <tr>
                    <td style="padding:15px; text-align:center;">{{ $i+1 }}</td>
                    <td style="padding:15px; text-align:center;">{{ $staff->staff_id }}</td>
                    <td style="padding:15px; text-align:center;">{{ $staff->name }}</td>
                    <td style="padding:15px; text-align:center;">{{ $staff->email }}</td>
                    <td style="padding:15px; text-align:center;">
                        <span class="badge role-badge {{ $roleClass }}">
                            {{ $staff->role->name ?? '-' }}
                        </span>
                    </td>
                    <td style="padding:15px; text-align:center;">{{ $staff->branch->branch_name ?? '-' }}</td>
                    <td style="padding:15px; text-align:center;">
                        <span class="badge {{ $staff->status=='active' ? 'badge-active':'badge-disable' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </td>
                    <td style="padding:15px; text-align:center;">
                        <div class="action-icons" style="display:flex; justify-content:center; align-items:center; gap:15px;">
                            <a href="{{ route('staff.show', $staff->id) }}">
                                <img src="{{ asset('images/icons/detail.png') }}" alt="Show" class="icon-btn" title="Detail" style="width:20px;">
                            </a>
                            <a href="{{ route('staff.edit', $staff->id) }}">
                                <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" class="icon-btn" title="Edit" style="width:20px;">
                            </a>
                            <form id="deleteForm{{ $staff->id }}" method="POST" action="{{ route('staff.destroy', $staff->id) }}" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="showDeletePopup('deleteForm{{ $staff->id }}')" style="background:none; border:none; cursor:pointer; padding:0;">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="icon-btn" title="Delete" style="width:20px;">
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="no-data-row">
                    <td colspan="8" style="text-align:center; padding:20px; color:#999;">
                        No staff found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- NAVIGASI CONTROLLER PAGINATION --}}
    <div class="pagination-container">
        <div class="page-info" id="pageInfo">Showing 0 to 0 of 0 entries</div>
        <div class="pagination-buttons">
            <button type="button" class="btn-page" id="btnPrev">Previous</button>
            <button type="button" class="btn-page" id="btnNext">Next</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('staffTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-data-row)'));
    
    // Jika tidak ada data sama sekali, sembunyikan container pagination
    if (rows.length === 0) {
        document.querySelector('.pagination-container').style.display = 'none';
        return;
    }

    const itemsPerPage = 12;
    let currentPage = 1;

    function paginateTable() {
        const totalPages = Math.ceil(rows.length / itemsPerPage) || 1;
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Sembunyikan semua data baris terlebih dahulu
        rows.forEach(row => row.style.display = 'none');

        // Tampilkan hanya baris yang masuk rentang 12 data halaman aktif
        const activeRows = rows.slice(startIndex, endIndex);
        activeRows.forEach(row => row.style.display = '');

        // Update interaksi status tombol navigasi
        document.getElementById('btnPrev').disabled = currentPage === 1;
        document.getElementById('btnNext').disabled = currentPage === totalPages;

        const displayStart = startIndex + 1;
        const displayEnd = Math.min(endIndex, rows.length);
        document.getElementById('pageInfo').innerText = `Showing ${displayStart} to ${displayEnd} of ${rows.length} entries`;
    }

    // Event Klik tombol navigasi
    document.getElementById('btnPrev').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    document.getElementById('btnNext').addEventListener('click', () => {
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateTable();
        }
    });

    // Inisialisasi awal pagination
    paginateTable();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
    const currentUrl = window.location.href;

    sidebarLinks.forEach(link => {
        if(link.href === currentUrl){
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>
@endsection