@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="page-header">
    <div style="margin-bottom: 25px;">
    {{-- Navigasi Kembali ke halaman Role --}}
    <a href="{{ route('roles.index') }}" style="text-decoration: none; color: inherit; display: inline-block;">
        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">
            Role 
            <span style="color: #999; font-weight: 400; font-size: 20px; margin-left: 5px;">
                › Role Detail
            </span>
        </h2>
    </a>
</div>
    <a href="{{ route('roles.index') }}" class="add-btn">← Back</a>
</div>

<div class="card" style="padding:32px; max-width:1000px">

    {{-- ROLE NAME --}}
    <div style="margin-bottom:28px">
        <label class="form-label">Role Name</label>
        <div style="padding:12px 16px; background:#f9fafb; border-radius:8px; border:1px solid #ddd; color:#111;">
            {{ $role->name }}
        </div>
    </div>

    {{-- STATUS --}}
    <div style="margin-bottom:32px">
        <label class="form-label">Status</label>
        <div style="padding:12px 16px; display:inline-block; border-radius:12px; color:#fff; font-weight:500; background-color: {{ $role->status ? '#16a34a' : '#dc2626' }};">
            {{ $role->status ? 'Active' : 'Inactive' }}
        </div>
    </div>

    <hr class="divider">

    {{-- ACCESS --}}
    <div>
        <label class="form-label">Access</label>

        <div class="access-grid" style="display:flex; flex-wrap:wrap; gap:12px; margin-top:8px;">
            @php
                $accesses = is_array($role->access) ? $role->access : json_decode($role->access, true);
                $accesses = $accesses ?? [];
            @endphp

            @if(in_array('NO ACCESS', $accesses))
                <label class="access-item" style="border:1px solid #fecaca; padding:12px; border-radius:8px; background:#fee2e2; width:220px;">
                    <div>
                        <strong style="color:#b91c1c">NO ACCESS</strong>
                        <div class="muted">No Access to Anything</div>
                    </div>
                </label>
            @else
                {{-- GLOBAL --}}
                @foreach(['WHOLE ACCESS','WHOLE MAIN ACCESS'] as $a)
                    @if(in_array($a, $accesses))
                    <label class="access-item" style="border:1px solid #ddd; padding:12px; border-radius:8px; width:220px;">
                        <div>
                            <strong>{{ $a }}</strong>
                            @if($a == 'WHOLE ACCESS')
                                <div class="muted">Whole Access of Admin Dashboard</div>
                            @else
                                <div class="muted">Main Dashboard, Staff, Transaction, Stock, Branch, Role, Product</div>
                            @endif
                        </div>
                    </label>
                    @endif
                @endforeach

                {{-- MAIN ACCESS --}}
                @foreach(['Main Dashboard','Products','Kopikala Branch','Main Transaction','Staff','Stock','Role','Stock Request'] as $a)
                    @if(in_array($a, $accesses))
                    <label class="access-item" style="border:1px solid #ddd; padding:12px; border-radius:8px; width:220px;">
                        <div>
                            <strong>{{ $a }}</strong>
                            <div class="muted">Access to {{ strtolower($a) }}</div>
                        </div>
                    </label>
                    @endif
                @endforeach

                {{-- SEMERU --}}
                @foreach(['Semeru Branch','Semeru Dashboard','Semeru Transaction','Semeru Staff','Semeru Stock'] as $a)
                    @if(in_array($a, $accesses))
                    <label class="access-item" style="border:1px solid #ddd; padding:12px; border-radius:8px; width:220px;">
                        <div><strong>{{ $a }}</strong></div>
                    </label>
                    @endif
                @endforeach

                {{-- DJUANDA --}}
                @foreach(['Djuanda Branch','Djuanda Dashboard','Djuanda Transaction','Djuanda Staff','Djuanda Stock'] as $a)
                    @if(in_array($a, $accesses))
                    <label class="access-item" style="border:1px solid #ddd; padding:12px; border-radius:8px; width:220px;">
                        <div><strong>{{ $a }}</strong></div>
                    </label>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

</div>

@endsection
