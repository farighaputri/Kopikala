@extends('layouts.app')

@section('content')

<div style="display: flex; justify-content: center; align-items: flex-start; min-height: 80vh; padding: 20px;">
    <div style="width: 100%; max-width: 1000px;"> 
        
        <div class="page-header" style="text-align: center; margin-bottom: 30px;">
            <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Staff --}}
    <a href="{{ route('staff.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Staff
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Edit Staff
            </span>
        </h2>
    </a>
</div>
        </div>

        <div class="form-card" style="background: white; padding: 40px; border-radius: 20px; border: 1px solid #e5e5e5; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

            <form method="POST" action="{{ route('staff.update', $staff->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- PHOTO --}}
                <div style="text-align: center; margin-bottom: 35px;">
                    <label for="photo-input" style="cursor:pointer;">
                        <img id="photo-preview"
                             src="{{ $staff->photo ? asset('storage/'.$staff->photo) : asset('images/icons/camera-placeholder.png') }}"
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:2px dashed #ccc;">
                    </label>

                    <input type="file"
                           name="photo"
                           id="photo-input"
                           style="display:none"
                           accept="image/*"
                           onchange="previewImage(event)">

                    <div style="margin-top:10px; font-weight:600; color:#4b2207;">
                        Change Photo
                    </div>
                </div>

                {{-- GRID --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:30px;">

                    <div>
                        <label>Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $staff->name) }}"
                               required
                               style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $staff->email) }}"
                               required
                               style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                    </div>

                    <div>
                        <label>Password (opsional)</label>
                        <input type="password" name="password"
                               placeholder="Kosongkan jika tidak diganti"
                               style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                    </div>

                    {{-- ROLE (SESUAI MODEL: belongsTo Role) --}}
                    <div>
                        <label>Role</label>
                        <select name="role_id"
                                style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id', $staff->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BRANCH (SESUAI MODEL: belongsTo Branch) --}}
                    <div>
                        <label>Branch</label>
                        <select name="branch_id"
                                required
                                style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                            <option value="">-- Select Branch --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ old('branch_id', $staff->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label>Status</label>
                        <select name="status"
                                required
                                style="width:100%;padding:12px;border:1px solid #ddd;border-radius:10px;">
                            <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $staff->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                </div>

                {{-- ACTION --}}
                <div style="margin-top:40px;display:flex;justify-content:flex-end;gap:20px;">
                    <a href="{{ route('staff.index') }}"
                       style="padding:12px 25px;background:#eee;border-radius:10px;text-decoration:none;color:#333;">
                        Cancel
                    </a>

                    <button type="submit"
                            style="padding:12px 25px;background:#4b2207;color:white;border:none;border-radius:10px;">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('photo-preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection