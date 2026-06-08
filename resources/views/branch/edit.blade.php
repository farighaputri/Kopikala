@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div style="margin-bottom: 25px;">
    <a href="{{ url()->previous() }}" style="text-decoration: none; color: inherit;">
        <h2 style="font-size: 24px; font-weight: 700; color: #333; margin: 0;">
            Kopikala Branch 
            <span style="color: #999; font-weight: 400; font-size: 18px; margin-left: 5px;">
                › Edit Branch
            </span>
        </h2>
    </a>
</div>

    <div class="form-card">
        <form action="{{ route('branch.update', $branch->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Branch Name <span>*</span></label>
                <input type="text" name="branch_name" placeholder="Enter Branch Name" value="{{ old('branch_name', $branch->branch_name) }}">
            </div>

            <div class="form-group">
                <label>Location <span>*</span></label>
                <input type="text" name="location" placeholder="Enter Location" value="{{ old('location', $branch->location) }}">
            </div>

            <div class="form-actions">
                <a href="{{ route('branch.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Update Branch</button>
            </div>
        </form>
    </div>

</div>

@endsection
