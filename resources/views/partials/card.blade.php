<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">{{ $number }}</h5>
            <small class="text-muted">{{ $label }}</small>
        </div>
        <div class="icon">
            {{ $icon ?? '👤' }}
        </div>
    </div>
</div>
