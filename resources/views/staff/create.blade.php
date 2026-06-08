@extends('layouts.app')

@section('content')

<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('staff.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Staff 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Add New Staff
            </span>
        </h2>
    </a>
</div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data">
        @csrf
        
        {{-- UPLOAD PHOTO SECTION --}}
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="margin-bottom: 10px;">
                <label for="photo" style="cursor:pointer; font-size: 50px;">
                    <img id="photo-preview" src="{{ asset('images/icons/camera-placeholder.png') }}" 
                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px dashed #ccc;">
                </label>
            </div>
            
            <input type="file" name="photo" id="photo" style="display:none;" accept="image/*" onchange="previewImage(event)">
            <label for="photo" style="cursor:pointer; font-weight:600; color:#4b2207;">Upload Photo</label>
        </div>

        {{-- FORM GRID --}}
        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Name <span>*</span></label>
                <input type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Status <span>*</span></label>
                <select name="status" required>
                    <option value="">Choose Status</option>
                    <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label>Phone Number <span>*</span></label>
                <input type="text" name="phone" placeholder="Enter Phone Number" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label>Email <span>*</span></label>
                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Role <span>*</span></label>
                <select name="role_id">
                    <option value="">Choose Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id')==$role->id?'selected':'' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Location <span>*</span></label>
                <select name="branch_id" required>
                    <option value="">Choose Location</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id')==$branch->id?'selected':'' }}>{{ $branch->branch_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Password <span>*</span></label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label>Confirmation Password <span>*</span></label>
                <input type="password" name="password_confirmation" placeholder="Re Enter Password" required>
            </div>
        </div>

        <div class="form-action" style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
            <a href="{{ route('staff.index') }}" class="btn-cancel" style="background:#dc3545; color:white; padding:10px 25px; border-radius:5px; text-decoration:none;">Cancel</a>
            <button type="submit" class="btn-submit" style="background:#2d2a2a; color:white; padding:10px 25px; border-radius:5px; border:none; cursor:pointer;">Add New Staff</button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('photo-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection