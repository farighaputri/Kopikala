@extends('layouts.app')

@section('content')

<div class="page-wrapper">
<div class="page-header">
</div>
<div style="margin-bottom: 25px;">
    <a href="{{ url()->previous() }}" style="text-decoration: none; color: inherit;">
        <h2 style="font-size: 24px; font-weight: 700; color: #333; margin: 0;">
            Kopikala Branch 
            <span style="color: #999; font-weight: 400; font-size: 18px; margin-left: 5px;">
                › Add New Kopikala Branch
            </span>
        </h2>
    </a>
</div>
    <div class="form-card">
        <form action="{{ route('branch.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Branch Name <span>*</span></label>
                <input type="text" name="branch_name" placeholder="Enter Branch Name">
            </div>

            <div class="form-group">
                <label>Location <span>*</span></label>
                <input type="text" name="location" placeholder="Enter Location">
            </div>

            <div class="form-actions">
                <a href="{{ route('branch.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Add New Branch</button>
            </div>
        </form>
    </div>

</div>

@endsection
