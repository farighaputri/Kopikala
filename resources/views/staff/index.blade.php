@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/staff.css') }}">

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

                <th style="padding:15px; text-align:center;">Action</th>

            </tr>

        </thead>

      <tbody>

@forelse($staffs as $i => $staff)

   @php

    $roleName = strtolower($staff->role->name ?? '');

    $roleClass = 'role-badge-default';

    if($roleName == 'master admin'){
        $roleClass = 'role-badge-master';
    }

    elseif($roleName == 'finance manager'){
        $roleClass = 'role-badge-finance-manager';
    }

    elseif($roleName == 'head store djuanda'){
        $roleClass = 'role-badge-head-store-djuanda';
    }

    elseif($roleName == 'head store semeru'){
        $roleClass = 'role-badge-head-store-semeru';
    }

    elseif($roleName == 'hrd'){
        $roleClass = 'role-badge-hrd';
    }

    elseif($roleName == 'kasir'){
        $roleClass = 'role-badge-kasir';
    }

    elseif($roleName == 'operational manager'){
        $roleClass = 'role-badge-operational-manager';
    }

    elseif($roleName == 'operational staff'){
        $roleClass = 'role-badge-operational-staff';
    }

    elseif($roleName == 'secretary'){
        $roleClass = 'role-badge-secretary';
    }

    elseif($roleName == 'cleaning staff'){
        $roleClass = 'role-badge-cleaning-staff';
    }

@endphp

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

        {{-- EMAIL --}}
        <td style="padding:15px; text-align:center;">
            {{ $staff->email }}
        </td>

        {{-- ROLE --}}
        <td style="padding:15px; text-align:center;">

            <span class="badge role-badge {{ $roleClass }}">
                {{ $staff->role->name ?? '-' }}
            </span>

        </td>

        {{-- BRANCH --}}
        <td style="padding:15px; text-align:center;">
            {{ $staff->branch->branch_name ?? '-' }}
        </td>

        {{-- STATUS --}}
        <td style="padding:15px; text-align:center;">

            <span class="badge {{ $staff->status=='active' ? 'badge-active':'badge-disable' }}">
                {{ ucfirst($staff->status) }}
            </span>

        </td>

        {{-- ACTION --}}
        <td style="padding:15px; text-align:center;">

            <div class="action-icons"
                 style="
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    gap:15px;
                 ">

                {{-- SHOW --}}
                <a href="{{ route('staff.show', $staff->id) }}">

                    <img src="{{ asset('images/icons/detail.png') }}"
                         alt="Show"
                         class="icon-btn"
                         title="Detail"
                         style="width:20px;">

                </a>

                {{-- EDIT --}}
                <a href="{{ route('staff.edit', $staff->id) }}">

                    <img src="{{ asset('images/icons/edit.png') }}"
                         alt="Edit"
                         class="icon-btn"
                         title="Edit"
                         style="width:20px;">

                </a>

                {{-- DELETE FORM --}}
                <form id="deleteForm{{ $staff->id }}"
                      method="POST"
                      action="{{ route('staff.destroy', $staff->id) }}"
                      style="display:none;">

                    @csrf
                    @method('DELETE')

                </form>

                {{-- DELETE BUTTON --}}
                <button type="button"
                        class="icon-btn-btn"
                        onclick="showDeletePopup('deleteForm{{ $staff->id }}')"
                        style="
                            background:none;
                            border:none;
                            cursor:pointer;
                            padding:0;
                        ">

                    <img src="{{ asset('images/icons/delete.png') }}"
                         alt="Delete"
                         class="icon-btn"
                         title="Delete"
                         style="width:20px;">

                </button>

            </div>

        </td>

    </tr>

@empty

    <tr>
        <td colspan="8"
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

@endsection
