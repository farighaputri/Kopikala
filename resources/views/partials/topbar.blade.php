<div class="topbar">
    <input type="text" placeholder="Search" class="search-input">

@php
    $staff = auth('staff')->user();
@endphp

@if($staff)
    <a href="{{ route('admin.profile') }}"
       class="user-info"
       style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">

        {{-- FOTO (FIXED PATH) --}}
        @if($staff->photo)
            {{-- 🔥 FIX UTAMA: Hapus 'storage/' karena controller menyimpan langsung ke 'uploads/staff' --}}
            <img src="{{ asset($staff->photo) }}?v={{ time() }}"
                 style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
        @else
            <div style="width:40px;height:40px;border-radius:50%;background:#7A5234;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                {{ strtoupper(substr($staff->name ?? 'A',0,1)) }}
            </div>
        @endif

        <div style="text-align:left;line-height:1.2;">
            <div style="font-weight:600;font-size:14px;">
                {{ $staff->name ?? '-' }}
            </div>

            <div style="font-size:12px;color:#888;">
                {{ $staff->role->name ?? '-' }}
            </div>
        </div>

    </a>
@endif

</div>