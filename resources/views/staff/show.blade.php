@extends('layouts.app')

@section('content')

<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('staff.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Staff
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Detail Staff
            </span>
        </h2>
    </a>
</div>
</div>

<div class="form-card">
    <table class="table-custom">
        <tr>
            <th>ID Staff</th>
            <td>{{ $staff->staff_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $staff->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $staff->email }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $staff->role->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Branch</th>
            <td>{{ $staff->branch->branch_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td><span class="badge {{ $staff->status=='active'?'success':'danger' }}">{{ ucfirst($staff->status) }}</span></td>
        </tr>
    </table>

    <div style="margin-top:20px;">
        <a href="{{ route('staff.index') }}" class="btn-cancel">Back</a>
        <a href="{{ route('staff.edit',$staff->id) }}" class="btn-submit">Edit</a>
    </div>
</div>

@endsection
