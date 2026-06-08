<div class="row g-3 mb-4">

    <div class="col-md-4">
        @include('partials.dashboard-card', [
            'title' => 'Total Sales',
            'value' => 'Rp ' . number_format($totalSales),
            'icon'  => '💰'
        ])
    </div>

    <div class="col-md-4">
        @include('partials.dashboard-card', [
            'title' => 'Weekly Total Order',
            'value' => $weeklyTotalOrder,
            'icon'  => '🛒'
        ])
    </div>

    <div class="col-md-4">
        @include('partials.dashboard-card', [
            'title' => 'Weekly Total Sales',
            'value' => 'Rp ' . number_format($weeklyTotalSales),
            'icon'  => '📈'
        ])
    </div>

</div>
