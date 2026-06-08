@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/semerudashboard.css') }}">

<div class="dashboard-admin-wrapper">

    <h1 class="welcome-title">
        Welcome, {{ $staffNameDisplay }} (Djuanda Branch)
    </h1>

    <div class="welcome-subtitle">
        Check Out today's Djuanda statistic and report!
    </div>

    {{-- TOP WIDGETS --}}
    <div class="top-widgets-grid">

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Total Djuanda Sales</div>

                <div class="widget-value">
                    Rp {{ number_format($totalSalesCalculated,0,',','.') }}
                </div>

                <small style="color:#27AE60;">
                    ↑ 19% up last month
                </small>
            </div>

            <div class="widget-icon" style="background:#FFF4E5;color:#7A5234;">
                <i class="fas fa-gift"></i>
            </div>
        </div>

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Djuanda Weekly Orders</div>

                <div class="widget-value">
                    {{ number_format($weeklyOrderCountCalculated,0,',','.') }}
                </div>

                <small style="color:#E74C3C;">
                    ↓ 2.3% down last week
                </small>
            </div>

            <div class="widget-icon" style="background:#FFF7EB;color:#FF9F43;">
                <i class="fas fa-box"></i>
            </div>
        </div>

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Djuanda Weekly Sales</div>

                <div class="widget-value">
                    Rp {{ number_format($weeklySalesAmountCalculated,0,',','.') }}
                </div>

                <small style="color:#27AE60;">
                    ↑ 21% up last week
                </small>
            </div>

            <div class="widget-icon" style="background:#E8F7FF;color:#56CCF2;">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

    </div>

    {{-- MAIN GRID --}}
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">

        {{-- LEFT SIDE --}}
        <div>

            {{-- SALES DETAILS --}}
            <div class="dashboard-card">

                <div class="card-header-flex">

                    <h3>Sales Details</h3>

                    <div style="display:flex;gap:10px;">

                        <select id="monthSelect" class="dashboard-select">
                            @foreach([
                                '01'=>'January','02'=>'February','03'=>'March','04'=>'April',
                                '05'=>'May','06'=>'June','07'=>'July','08'=>'August',
                                '09'=>'September','10'=>'October','11'=>'November','12'=>'December'
                            ] as $num => $month)

                                <option value="{{ $num }}"
                                    {{ (int)$selectedMonth == (int)$num ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>

                            @endforeach
                        </select>

                        <select id="yearSelect" class="dashboard-select">
                            @for($year = now()->year; $year >= 2023; $year--)
                                <option value="{{ $year }}"
                                    {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>

                    </div>
                </div>

                <div style="height:300px;">
                    <canvas id="salesDetailsChart"></canvas>
                </div>

            </div>

            {{-- LATEST TRANSACTION --}}
            <div class="dashboard-card" style="margin-top:20px;">

                <div class="card-header-flex">
                    <h3>Latest Djuanda Transactions</h3>

                    <a href="{{ route('djuanda.transaction') }}"
                       style="color:#7A5234;text-decoration:underline;">
                        View All
                    </a>
                </div>

                <table class="admin-data-table">

                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($safeTransactions->take(5) as $trx)

                        <tr>
                            <td style="font-weight:700;">{{ $trx->order_id }}</td>
                            <td>{{ $trx->quantity ?? 1 }}</td>
                            <td>
                                <span class="status-badge status-confirmed">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td style="font-weight:800;">
                                Rp {{ number_format($trx->total,0,',','.') }}
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                No transaction data
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div>

            {{-- TARGET --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>
                        <i class="fas fa-info-circle" style="color:#3B82F6;margin-right:8px;"></i>
                        Monthly Target Information
                    </h3>
                </div>

                <div class="target-wrapper">

                    <div class="target-circle">
                        <canvas id="targetDonut"></canvas>
                    </div>

                    <div class="target-box">
                        <div class="target-label">Monthly Target</div>
                        <div class="target-value">Rp 25.000.000</div>
                    </div>

                </div>

                <div class="target-summary">

                    <div class="summary-item">
                        <i class="fas fa-store"></i>
                        <div>
                            <small>Order</small>
                            <strong>{{ number_format($totalOrderDjuanda) }} Orders</strong>
                        </div>
                    </div>

                    <div class="summary-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <div>
                            <small>Total Sales</small>
                            <strong>
                                Rp {{ number_format($totalSalesCalculated,0,',','.') }}
                            </strong>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ACTIVE USER --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>Active User</h3>
                    <a href="{{ route('djuanda.staff') }}" class="view-all-link">View All</a>
                </div>

                <table class="admin-data-table">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>ROLE</th>
                            <th>TIME</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($activeUsers->take(3) as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><span class="category-badge">{{ $user->role->name ?? 'Staff' }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- LOW STOCK --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>Low Stock Item</h3>
                    <a href="{{ route('branch.stock','djuanda') }}" class="view-all-link">View All</a>
                </div>

                <table class="admin-data-table">

                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>In Stock</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($lowStocks->take(5) as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td><span class="category-badge">{{ $item->categoryRelation->name ?? '-' }}</span></td>
                            <td>{{ $item->in_stock }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const salesCtx = document.getElementById('salesDetailsChart');

const salesGradient = salesCtx
    .getContext('2d')
    .createLinearGradient(0,0,0,300);

salesGradient.addColorStop(0,'rgba(122,82,52,0.35)');
salesGradient.addColorStop(1,'rgba(255,255,255,0)');

new Chart(salesCtx,{
    type:'line',
    data:{
        labels:{!! json_encode($lineLabels) !!},
        datasets:[{
            data:{!! json_encode($normalizedLineData) !!},
            borderColor:'#7A5234',
            backgroundColor:salesGradient,
            fill:true,
            tension:0.4,
            borderWidth:3,
            pointRadius:0
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false
    }
});

new Chart(document.getElementById('targetDonut'), {
    type:'doughnut',
    data:{
        datasets:[{
            data:[
                {{ min($persenDjuanda,100) }},
                {{ 100 - min($persenDjuanda,100) }}
            ],
            backgroundColor:['#F59E0B','#E5E7EB']
        }]
    },
    options:{
        cutout:'78%',
        plugins:{legend:{display:false}}
    }
});

document.getElementById('monthSelect').addEventListener('change', reloadDashboard);
document.getElementById('yearSelect').addEventListener('change', reloadDashboard);

function reloadDashboard(){
    let url = new URL(window.location.href);
    url.searchParams.set('month', document.getElementById('monthSelect').value);
    url.searchParams.set('year', document.getElementById('yearSelect').value);
    window.location.href = url.toString();
}
</script>

@endsection