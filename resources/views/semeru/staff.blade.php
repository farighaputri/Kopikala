@extends('layouts.app')

@section('content')

<div class="main-content" style="padding:20px;">

    {{-- Page Header --}}
    <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 class="page-title">Staff Cabang {{ $branchName }}</h2>

        {{-- Tombol Add Staff hanya jika tidak readonly --}}
        @if(!($readonly ?? false))
            <a href="{{ route('staff.create') }}" class="add-btn" 
               style="padding:6px 10px; background:#3490dc; color:#fff; border-radius:4px; text-decoration:none;">
               + Add New Staff
            </a>
        @endif
    </div>

    {{-- Statistik --}}
    <div class="stat-grid" style="display:flex; gap:16px; margin-bottom:20px;">
        <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
            <h3>{{ $staffs->count() }}</h3>
            <p>Total Staff</p>
        </div>
        <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
            <h3>{{ $staffs->where('status','active')->count() }}</h3>
            <p>Active Staff</p>
        </div>
        <div class="stat-card" style="flex:1; padding:12px; border:1px solid #ddd; border-radius:6px; text-align:center;">
            <h3>{{ $staffs->where('status','inactive')->count() }}</h3>
            <p>Inactive Staff</p>
        </div>
    </div>

    {{-- Filter --}}
    @if(!($readonly ?? false))
    <div class="filter-card" style="margin-bottom:16px;">
        <form method="GET" class="filter-grid" style="display:flex; gap:12px; flex-wrap:wrap; align-items:end;">
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
                <button type="submit" style="padding:6px 12px; background:#3490dc; color:#fff; border:none; border-radius:4px;">Filter</button>
            </div>
        </form>
    </div>
    @endif

    {{-- Tabel Staff --}}
    <div class="table-card"
     style="
        overflow-x:auto;
        display:flex;
        justify-content:center;
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

                <th style="padding:15px; text-align:center;">ID</th>

                <th style="padding:15px; text-align:center;">Name</th>

                <th style="padding:15px; text-align:center;">Email</th>

                <th style="padding:15px; text-align:center;">Role</th>

                <th style="padding:15px; text-align:center;">Branch</th>

                <th style="padding:15px; text-align:center;">Status</th>

                @if(!($readonly ?? false))
                    <th style="padding:15px; text-align:center;">Action</th>
                @endif

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
                        {{ $staff->branch->branch_name ?? '-' }}
                    </td>

                    <td style="padding:15px; text-align:center;">

                        <span class="badge {{ $staff->status=='active' ? 'success':'danger' }}">
                            {{ ucfirst($staff->status) }}
                        </span>

                    </td>

                    @if(!($readonly ?? false))

                    <td style="padding:15px; text-align:center;">

                        <div style="
                            display:flex;
                            gap:12px;
                            justify-content:center;
                            align-items:center;
                        ">

                            {{-- DELETE --}}
                            <form method="POST"
                                  action="{{ route('staff.destroy', $staff->id) }}"
                                  onsubmit="return confirm('Are you sure?');"
                                  style="margin:0;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        style="
                                            background:none;
                                            border:none;
                                            cursor:pointer;
                                            padding:0;
                                        ">

                                    <img src="{{ asset('images/icons/delete.png') }}"
                                         alt="Delete"
                                         title="Delete"
                                         style="width:20px;">

                                </button>

                            </form>

                            {{-- EDIT --}}
                            <a href="{{ route('staff.edit', $staff->id) }}">

                                <img src="{{ asset('images/icons/edit.png') }}"
                                     alt="Edit"
                                     title="Edit"
                                     style="width:20px;">

                            </a>

                            {{-- DETAIL --}}
                            <a href="{{ route('staff.show', $staff->id) }}">

                                <img src="{{ asset('images/icons/detail.png') }}"
                                     alt="Detail"
                                     title="Detail"
                                     style="width:20px;">

                            </a>

                        </div>

                    </td>

                    @endif

                </tr>

            @empty

                <tr>

                    <td colspan="{{ ($readonly ?? false) ? 7 : 8 }}"
                        style="
                            text-align:center;
                            padding:20px;
                            color:#999;
                        ">

                        No staff found.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
</div> {{-- End Main content --}}
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
