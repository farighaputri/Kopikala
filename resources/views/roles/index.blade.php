@extends('layouts.app')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 class="page-title">Role</h2>
    <a href="{{ route('roles.create') }}" class="add-btn">+ Add New Role</a>
</div>

{{-- ================= FILTER BAR ================= --}}
<div class="filter-wrapper" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
    <div class="filter-pill dropdown" onclick="toggleFilterMenu()">
        <span class="filter-icon">⚲</span>
        <span id="filterLabel">Filter</span>
        <span class="arrow">▾</span>
    </div>
    <a href="{{ route('roles.index') }}" class="filter-reset">⟳ Reset Filter</a>
</div>

{{-- ================= FILTER MENU ================= --}}
<div id="filterMenu" class="filter-menu" style="display:none;">
    <div onclick="selectFilter('access')">Access</div>
    <div onclick="selectFilter('status')">Status</div>
    <div onclick="selectFilter('name')">Role Name</div>
</div>

<form method="GET" action="{{ route('roles.index') }}">
    <div id="filterPanel" class="filter-panel">

        {{-- ACCESS --}}
        <div class="filter-box filter-field" data-filter="access">
            <label>Access</label>
            <select name="access" id="accessSelect" onchange="previewAccessColor(this.value)">
                <option value="">All Access</option>
                <option value="WHOLE ACCESS">WHOLE ACCESS</option>
                <option value="WHOLE MAIN ACCESS">WHOLE MAIN ACCESS</option>
                <option value="Main Dashboard">Main Dashboard</option>
                <option value="Products">Products</option>
                <option value="Kopikala Branch">Kopikala Branch</option>
                <option value="Main Transaction">Main Transaction</option>
                <option value="Staff">Staff</option>
                <option value="Stock">Stock</option>
                <option value="Role">Role</option>
                <option value="Stock Request">Stock Request</option>
                <option value="Semeru Branch">Semeru Branch</option>
                <option value="Semeru Dashboard">Semeru Dashboard</option>
                <option value="Semeru Transaction">Semeru Transaction</option>
                <option value="Semeru Staff">Semeru Staff</option>
                <option value="Semeru Stock">Semeru Stock</option>
                <option value="Djuanda Branch">Djuanda Branch</option>
                <option value="Djuanda Dashboard">Djuanda Dashboard</option>
                <option value="Djuanda Transaction">Djuanda Transaction</option>
                <option value="Djuanda Staff">Djuanda Staff</option>
                <option value="Djuanda Stock">Djuanda Stock</option>
                <option value="NO ACCESS">NO ACCESS</option>
            </select>

            {{-- PREVIEW WARNA --}}
            <div id="accessPreview" style="margin-top:8px;"></div>
        </div>

        {{-- STATUS --}}
        <div class="filter-box filter-field" data-filter="status">
            <label>Status</label>
            <select name="status">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        {{-- NAME --}}
        <div class="filter-box filter-field" data-filter="name">
            <label>Role Name</label>
            <input type="text" name="name" placeholder="Search role...">
        </div>

        <button type="submit" class="add-btn">Apply Filter</button>
    </div>
</form>

{{-- ================= TABLE ================= --}}
<div class="card">
    <table class="table" style="width:100%; border-collapse:collapse; text-align:center; vertical-align:middle;">
       <thead>
            <tr>
                <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">No</th>
                <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">Role Name</th>
                <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">Access</th>
                <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">Status</th>
                <th style="padding:10px; border-bottom:1px solid #ddd; text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($roles as $i => $role)
            <tr style="vertical-align:middle; text-align:center;">
                <td style="padding:8px; border-bottom:1px solid #eee;">{{ $i + 1 }}</td>
                <td style="padding:8px; border-bottom:1px solid #eee;">{{ $role->name }}</td>

                {{-- ACCESS BADGE (rata kiri) --}}
                <td style="padding:8px; border-bottom:1px solid #eee; text-align:left;">
                    @php
                        $accesses = is_array($role->access)
                            ? $role->access
                            : json_decode($role->access, true);
                        $accesses = $accesses ?? [];
                    @endphp
                    <div style="display:flex; justify-content:flex-start; gap:6px; flex-wrap:wrap; align-items:center;">
                        @foreach($accesses as $access)
                            @php
                                $class = strtolower(trim($access));
                                $class = str_replace([' ', '_'], '-', $class);
                            @endphp
                            <span class="badge-access {{ $class }}">
                                {{ $access }}
                            </span>
                        @endforeach
                    </div>
                </td>

                {{-- STATUS --}}
                <td style="padding:8px; border-bottom:1px solid #eee;">
                    <span class="badge {{ $role->status ? 'success' : 'danger' }}">
                        {{ $role->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                {{-- ACTION --}}
              <td class="action">
                <div class="action-icons">
                    <!-- Show / Detail Icon -->
                    <a href="{{ route('roles.show', $role->id) }}">
                        <img src="{{ asset('images/icons/detail.png') }}" alt="Show" class="icon-btn" title="Detail">
                    </a>

                    <!-- Edit Icon -->
                    <a href="{{ route('roles.edit', $role->id) }}">
                        <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" class="icon-btn" title="Edit">
                    </a>

                    <!-- Delete Icon -->
                    <!-- Delete Icon -->
                    <form id="deleteRoleForm{{ $role->id }}" method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="icon-btn-btn" onclick="showDeletePopup('deleteRoleForm{{ $role->id }}')">
                        <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="icon-btn" title="Delete">
                    </button>
                </div>
            </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="padding:10px; text-align:center;color:#999;">No roles found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function toggleFilterMenu() {
    const menu = document.getElementById('filterMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function selectFilter(type) {
    document.getElementById('filterLabel').innerText =
        type === 'access' ? 'Access' :
        type === 'status' ? 'Status' : 'Role Name';

    document.getElementById('filterPanel').classList.add('active');
    document.querySelectorAll('.filter-field').forEach(el => el.style.display = 'none');
    document.querySelector(`[data-filter="${type}"]`).style.display = 'block';
    document.getElementById('filterMenu').style.display = 'none';
}

function previewAccessColor(value) {
    if (!value) {
        document.getElementById('accessPreview').innerHTML = '';
        return;
    }

    let cls = value.toLowerCase().trim().replace(/[\s_]+/g, '-');
    document.getElementById('accessPreview').innerHTML =
        `<span class="badge-access ${cls}">${value}</span>`;
}
</script>

@endsection
