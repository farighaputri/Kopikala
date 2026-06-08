@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div style="margin-bottom: 25px;">
    <a href="{{ url()->previous() }}" style="text-decoration: none; color: inherit;">
        <h2 style="font-size: 24px; font-weight: 700; color: #333; margin: 0;">
            Kopikala Branch 
            <span style="color: #999; font-weight: 400; font-size: 18px; margin-left: 5px;">
                › Branch Detail
            </span>
        </h2>
    </a>
</div>

    <div class="form-card">

        {{-- Branch Info --}}
        <div class="form-group">
            <label>Branch Name</label>
            <input type="text" value="{{ $branch->branch_name }}" readonly>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" value="{{ $branch->location }}" readonly>
        </div>

        <div class="form-group">
            <label>Status</label>
            <input type="text" value="{{ ucfirst($branch->status ?? 'active') }}" readonly>
        </div>

        <div class="form-actions">
            <a href="{{ route('branch.index') }}" class="btn-cancel">Back</a>
        </div>

    </div>

</div>

@endsection
