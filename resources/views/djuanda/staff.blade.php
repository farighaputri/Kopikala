@extends('layouts.app')

@section('content')

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 class="page-title">Staff Cabang Djuanda</h2>
</div>

{{-- STATISTIC --}}
<div class="stat-grid" style="display:flex; gap:16px; margin-bottom:20px;">
    <div class="stat-card">
        <h3>{{ $staffs->count() }}</h3>
        <p>Total Staff</p>
    </div>

    <div class="stat-card">
        <h3>{{ $staffs->where('status','active')->count() }}</h3>
        <p>Active Staff</p>
    </div>

    <div class="stat-card">
        <h3>{{ $staffs->where('status','inactive')->count() }}</h3>
        <p>Inactive Staff</p>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-card" style="margin-bottom:16px;">
    <form method="GET" class="filter-grid">
        <div>
            <label>Search Staff</label>
            <input type="text" name="search" placeholder="Enter name" value="{{ request('search') }}">
        </div>

        <div>
            <label>Filter Role</label>
            <select name="role_id">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id')==$role->id ? 'selected':'' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" style="padding:6px 12px; background:#3490dc; color:#fff; border:none; border-radius:4px;">Filter</button>
        </div>
    </form>
</div>

{{-- TABLE STAFF --}}
<div class="table-card"
     style="
        display:flex;
        justify-content:center;
        overflow-x:auto;
     ">

    <table class="table-custom"
           style="
                width:100%;
                border-collapse:collapse;
                text-align:center;
           ">

        <thead>

            <tr>

                <th style="padding:15px; text-align:center;">No</th>

                <th style="padding:15px; text-align:center;">ID Staff</th>

                <th style="padding:15px; text-align:center;">Name</th>

                <th style="padding:15px; text-align:center;">Email</th>

                <th style="padding:15px; text-align:center;">Position</th>

                <th style="padding:15px; text-align:center;">Role</th>

                <th style="padding:15px; text-align:center;">Status</th>

            </tr>

        </thead>

        <tbody>

        @forelse($staffs as $i => $staff)

            <tr>

                <td style="padding:15px; text-align:center;">
                    {{ $i+1 }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $staff->staff_id }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $staff->name }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $staff->email }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $staff->role->name ?? '-' }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $staff->role->name ?? '-' }}
                </td>

                <td style="padding:15px; text-align:center;">

                    <span class="badge {{ $staff->status=='active' ? 'success':'danger' }}">
                        {{ ucfirst($staff->status) }}
                    </span>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7"
                    style="
                        text-align:center;
                        color:#999;
                        padding:20px;
                    ">

                    No staff found.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>
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
