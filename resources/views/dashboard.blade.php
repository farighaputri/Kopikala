@extends('layouts.app')

@section('content')
<style>
    /* CSS untuk fungsi View All */
    .table-wrapper {
        max-height: 300px; /* Tinggi untuk 5 baris */
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .table-wrapper.expanded {
        max-height: 2000px; /* Cukup untuk semua data */
    }
    .view-all-btn {
        background: none;
        border: none;
        color: #7A5234;
        font-weight: 700;
        cursor: pointer;
        padding: 0;
        text-decoration: underline;
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    // =========================================
    // FILTER BULAN & TAHUN
    // =========================================

    $selectedMonth = request('month', now()->format('m'));
    $selectedYear  = request('year', now()->format('Y'));

    // =========================================
    // FILTER TRANSAKSI SESUAI BULAN + TAHUN
    // =========================================

    $safeTransactions = $allTransactions->filter(function($trx) use ($selectedMonth, $selectedYear){

        $date = Carbon::parse($trx->created_at);

        return $date->format('m') == $selectedMonth
            && $date->format('Y') == $selectedYear;
    });

    // =========================================
    // STAFF
    // =========================================

    $staffNameDisplay = session('staff.name')
        ?? auth()->user()->name
        ?? 'Admin';

    // =========================================
    // TOTAL SALES
    // =========================================

    $totalSalesCalculated = $safeTransactions->sum('total');

    // =========================================
    // WEEKLY
    // =========================================

    $transaksiMingguIni = $safeTransactions->filter(function($trx){

        return Carbon::parse($trx->created_at)
            ->greaterThanOrEqualTo(Carbon::now()->subDays(7));
    });

    $weeklyOrderCountCalculated = $transaksiMingguIni->count();

    $weeklySalesAmountCalculated = $transaksiMingguIni->sum('total');

    // =========================================
    // MONTHLY SALES
    // =========================================

    $totalSalesBulanIni = $safeTransactions->sum('total');

    // =========================================
    // INIT
    // =========================================

    $qtyDjuanda = 0;
    $qtySemeru  = 0;

    $pendapatanDjuanda = 0;
    $pendapatanSemeru  = 0;

    $barDjuanda = array_fill(0, 12, 0);
    $barSemeru  = array_fill(0, 12, 0);

    $dailySalesArray = [];

    // JUMLAH HARI DALAM BULAN
    $daysInMonth = Carbon::createFromDate(
        $selectedYear,
        $selectedMonth,
        1
    )->daysInMonth;

    for($i=1; $i <= $daysInMonth; $i++){
        $dailySalesArray[$i] = 0;
    }

    // =========================================
    // LOOP TRANSAKSI
    // =========================================

    foreach($safeTransactions as $trx){

        $tanggal = Carbon::parse($trx->created_at);

        $hariIndex = $tanggal->day;

        // LINE CHART
        if(isset($dailySalesArray[$hariIndex])){
            $dailySalesArray[$hariIndex] += $trx->total;
        }

        // BRANCH
        $branchName = Str::lower($trx->branch->branch_name ?? '');

        // QTY
        $qty = 0;

        if(is_array($trx->items)){

            foreach($trx->items as $item){
                $qty += $item['qty'] ?? 1;
            }

        } else {

            $decoded = json_decode($trx->items, true);

            if(is_array($decoded)){

                foreach($decoded as $item){
                    $qty += $item['qty'] ?? 1;
                }
            }
        }

        // DJUANDA
        if(Str::contains($branchName,'djuanda')){

            $qtyDjuanda += $qty;

            $pendapatanDjuanda += $trx->total;

            $barDjuanda[$selectedMonth - 1] += $trx->total;
        }

        // SEMERU
        if(Str::contains($branchName,'semeru')){

            $qtySemeru += $qty;

            $pendapatanSemeru += $trx->total;

            $barSemeru[$selectedMonth - 1] += $trx->total;
        }
    }

    // =========================================
    // NORMALIZE LINE DATA
    // =========================================

    $maxDailySales = max($dailySalesArray);

    if($maxDailySales <= 0){
        $maxDailySales = 1;
    }

    $normalizedLineData = [];

    foreach($dailySalesArray as $value){

        $normalizedLineData[] =
            round(($value / $maxDailySales) * 80);
    }

    // =========================================
    // LABEL HARI
    // =========================================

    $lineLabels = [];

    for($i=1; $i <= $daysInMonth; $i++){
        $lineLabels[] = $i;
    }

    // =========================================
    // TARGET
    // =========================================

    $targetNominal = 25000000;

    $persenDjuanda = $targetNominal > 0
        ? round(($pendapatanDjuanda / $targetNominal) * 100)
        : 0;

    $persenSemeru = $targetNominal > 0
        ? round(($pendapatanSemeru / $targetNominal) * 100)
        : 0;
@endphp
<div class="dashboard-admin-wrapper">

    <h1 class="welcome-title">
        Welcome, {{ $staffNameDisplay }}
    </h1>

    <div class="welcome-subtitle">
        Check Out today's statistic and report!
    </div>

    {{-- TOP WIDGET --}}
    <div class="top-widgets-grid">

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Total Sales</div>

                <div class="widget-value">
                    Rp {{ number_format($totalSalesCalculated,0,',','.') }}
                </div>

                <div class="trend-text trend-up">
                    <i class="fas fa-arrow-up"></i>
                    19%
                    <span>up than last month</span>
                </div>
            </div>

            <div class="widget-icon" style="background: none; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/icons/Total Purchase Icon Container.png') }}" alt="Weekly Sales Icon" style="width: 48px; height: 48px; object-fit: contain;">
            </div>
        </div>

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Weekly Total Order</div>

                <div class="widget-value">
                    {{ number_format($weeklyOrderCountCalculated,0,',','.') }}
                </div>

                <div class="trend-text trend-up">
                    <i class="fas fa-arrow-up"></i>
                    1.3%
                    <span>up than last week</span>
                </div>
            </div>

            <div class="widget-icon" style="background: none; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/icons/icon.png') }}" alt="Weekly Sales Icon" style="width: 48px; height: 48px; object-fit: contain;">
            </div>
        </div>

        <div class="widget-stat-card">
            <div>
                <div class="widget-title">Weekly Total Sales</div>

                <div class="widget-value">
                    Rp {{ number_format($weeklySalesAmountCalculated,0,',','.') }}
                </div>

                <div class="trend-text trend-up">
                    <i class="fas fa-arrow-up"></i>
                    38%
                    <span>up than last week</span>
                </div>
            </div>

            <div class="widget-icon" style="background: none; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/icons/Icon-1.png') }}" alt="Weekly Sales Icon" style="width: 48px; height: 48px; object-fit: contain;">
            </div>
        </div>

    </div>

    <div class="main-dashboard-layout">

        {{-- LEFT --}}
        <div>

            {{-- SALES DETAILS --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>Sales Details</h3>
<div style="display:flex; gap:10px;">

    {{-- BULAN --}}
    <select
        id="monthSelect"
        class="dashboard-select"
    >

        @foreach([
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December'
        ] as $num => $month)

            <option
                value="{{ $num }}"
                {{ $selectedMonth == $num ? 'selected' : '' }}
            >
                {{ $month }}
            </option>

        @endforeach

    </select>

    {{-- TAHUN --}}
    <select
        id="yearSelect"
        class="dashboard-select"
    >

        @for($year = now()->year; $year >= 2023; $year--)

            <option
                value="{{ $year }}"
                {{ $selectedYear == $year ? 'selected' : '' }}
            >
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

            {{-- BRANCH SALES --}}
            <div class="dashboard-card">

                <div class="card-header-flex">

                    <h3>Branches Sales</h3>

                    <div class="filter-btn-group">
                        <button>1D</button>
                        <button>1W</button>
                        <button>1M</button>
                        <button>3M</button>
                        <button>6M</button>
                        <button class="active">1Y</button>
                    </div>

                </div>

                <div style="height:260px;">
                    <canvas id="branchSalesChart"></canvas>
                </div>

            </div>

            {{-- MONTHLY TARGET --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>Monthly Target Information</h3>
                </div>

                <div style="text-align:center;font-size:13px;color:#64748B;margin-bottom:8px;">
                    Monthly Target
                </div>

                <div style="text-align:center;font-size:28px;font-weight:800;margin-bottom:24px;">
                    Rp {{ number_format($targetNominal,0,',','.') }}
                </div>

                <div class="target-box-row">

                    <div class="target-box-item">
                        <div class="target-label">Total Sales</div>

                        <div class="target-value" style="color:#00B69B;">
                            Rp {{ number_format($totalSalesBulanIni,0,',','.') }}
                        </div>
                    </div>

                    <div class="target-box-item">
                        <div class="target-label">Djuanda</div>

                        <div class="target-value" style="color:#1E3A8A;">
                            {{ number_format($qtyDjuanda,0,',','.') }}
                        </div>
                    </div>

                    <div class="target-box-item">
                        <div class="target-label">Semeru</div>

                        <div class="target-value" style="color:#F59E0B;">
                            {{ number_format($qtySemeru,0,',','.') }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- DONUT --}}
            <div class="dashboard-card">

                <div class="card-header-flex">

                    <h3>Monthly Target Overview</h3>

                    <select style="padding:8px 12px;border-radius:8px;border:1px solid #E2E8F0;">
                        <option>March</option>
                    </select>

                </div>

                <div class="overview-flex">

                    <div style="width:180px;height:180px;">
                        <canvas id="targetOverviewDonut"></canvas>
                    </div>

                    <div class="overview-details">

                        <div class="overview-item">
                            <h4>
                                Rp {{ number_format($pendapatanDjuanda,0,',','.') }}
                            </h4>

                            <p style="color:#1E3A8A;">Djuanda</p>

                            <span class="percent-badge">
                                {{ $persenDjuanda }}% from target
                            </span>
                        </div>

                        <div class="overview-item">
                            <h4>
                                Rp {{ number_format($pendapatanSemeru,0,',','.') }}
                            </h4>

                            <p style="color:#F59E0B;">Semeru</p>

                            <span class="percent-badge">
                                {{ $persenSemeru }}% from target
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div>

            {{-- LOW STOCK --}}
            <div class="dashboard-card">

                <div class="card-header-flex">
                    <h3>Low Stock Item</h3>

                    <button type="button" class="view-all-btn" onclick="toggleTable('table-low-stock', this)">View All</button>
                </div>

                <div id="table-low-stock" class="table-wrapper">
                    <table class="admin-data-table">

                        <thead>
                            <tr>
                                <th>ITEM</th>
                                <th>CATEGORY</th>
                                <th>STOCK</th>
                                <th>LOCATION</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($lowStocks as $item)

                            @php
                                $locName = Str::lower($item->branch->branch_name ?? '');
                            @endphp

                            <tr>

                                <td style="font-weight:700;">
                                    {{ $item->item_name }}
                                </td>

                                <td>
                                    <span class="category-badge">
                                        {{ $item->category ?? 'Packaging' }}
                                    </span>
                                </td>

                                <td style="font-weight:800;">
                                    {{ $item->in_stock }}
                                </td>

                                <td>

                                    <span class="branch-badge
                                        @if(Str::contains($locName,'semeru'))
                                            branch-semeru
                                        @elseif(Str::contains($locName,'office'))
                                            branch-office
                                        @else
                                            branch-djuanda
                                        @endif
                                    ">
                                        {{ $item->branch->branch_name ?? 'Branch' }}
                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td>Plastic Straw</td>
                                <td><span class="category-badge">Packaging</span></td>
                                <td>2</td>
                                <td><span class="branch-badge branch-semeru">Semeru</span></td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

            {{-- ACTIVE USER --}}
            <div class="dashboard-card">

                <div class="card-header-flex">

                    <h3>Active User</h3>

                    <button type="button" class="view-all-btn" onclick="toggleTable('table-active-user', this)">View All</button>
                </div>

                <div id="table-active-user" class="table-wrapper">
                    <table class="admin-data-table">

                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>ROLE</th>
                                <th>LOCATION</th>
                                <th>TIME</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($activeUsers as $user)

                            <tr>

                                <td style="font-weight:700;">
                                    {{ $user->name }}
                                </td>

                                <td>

                                    <span class="category-badge">
                                        {{ $user->role->name ?? 'Staff' }}
                                    </span>

                                </td>

                                <td>

                                    <span class="branch-badge branch-office">
                                        {{ $user->branch->branch_name ?? 'Head Office' }}
                                    </span>

                                </td>

                                <td>
                                    {{ isset($user->created_at)
                                        ? \Carbon\Carbon::parse($user->created_at)->format('H:i')
                                        : '08:11'
                                    }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td>Rizal</td>
                                <td><span class="category-badge">Admin</span></td>
                                <td><span class="branch-badge branch-office">Head Office</span></td>
                                <td>08:11</td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

            {{-- TRANSACTION --}}
            <div class="dashboard-card">

                <div class="card-header-flex">

                    <h3>Latest Transaction</h3>

                    <button type="button" class="view-all-btn" onclick="toggleTable('table-latest-trx', this)">View All</button>
                </div>

                <div id="table-latest-trx" class="table-wrapper">
                    <table class="admin-data-table">

                        <thead>
                            <tr>
                                <th>ORDER ID</th>
                                <th>QTY</th>
                                <th>STATUS</th>
                                <th>LOCATION</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($safeTransactions as $trx)

                            <tr>

                                <td style="font-weight:700;">
                                    {{ $trx->order_id }}
                                </td>

                                <td>
                                    {{ $trx->quantity ?? 1 }}
                                </td>

                                <td>

                                    <span class="status-badge
                                        @if($trx->status == 'Waiting Confirmation')
                                            status-waiting
                                        @elseif($trx->status == 'Order Confirmed')
                                            status-confirmed
                                        @elseif($trx->status == 'Order Ready')
                                            status-ready
                                        @elseif($trx->status == 'Order Finished')
                                            status-finished
                                        @endif
                                    ">
                                        {{ $trx->status }}
                                    </span>

                                </td>

                                <td>

                                    <span class="branch-badge branch-djuanda">
                                        {{ $trx->branch->branch_name ?? 'Branch' }}
                                    </span>

                                </td>

                                <td style="font-weight:800;">
                                    Rp {{ number_format($trx->total,0,',','.') }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td>KOP-001</td>
                                <td>4</td>
                                <td><span class="status-badge status-confirmed">Confirmed</span></td>
                                <td><span class="branch-badge branch-semeru">Semeru</span></td>
                                <td>Rp 40.000</td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    /* ================= TOGGLE VIEW ALL ================= */
    function toggleTable(id, btn) {
        const table = document.getElementById(id);
        table.classList.toggle('expanded');
        btn.textContent = table.classList.contains('expanded') ? 'Show Less' : 'View All';
    }

    /* ================= SALES DETAIL CHART ================= */

    const salesCtx = document.getElementById('salesDetailsChart');

    const salesGradient = salesCtx.getContext('2d').createLinearGradient(0,0,0,300);

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
                pointRadius:0,
                pointHoverRadius:6,
                pointBackgroundColor:'#7A5234'
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{ legend:{ display:false } },
            scales:{
                x:{ grid:{ display:false }, ticks:{ color:'#94A3B8', font:{ weight:'700' } } },
                y:{ min:0, max:100, grid:{ color:'#F1F5F9' }, ticks:{ stepSize:20, callback:function(v){ return v + '%'; }, color:'#94A3B8', font:{ weight:'700' } } }
            }
        }
    });

    /* ================= BAR CHART ================= */

    new Chart(document.getElementById('branchSalesChart'), {
        type:'bar',
        data:{
            labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets:[
                {
                    label:'Djuanda',
                    data:{!! json_encode(array_map(fn($v) => ($v / 1000000), $barDjuanda)) !!},
                    backgroundColor:'#1E3A8A',
                    borderRadius:6,
                    barThickness:18
                },
                {
                    label:'Semeru',
                    data:{!! json_encode(array_map(fn($v) => ($v / 1000000), $barSemeru)) !!},
                    backgroundColor:'#F59E0B',
                    borderRadius:6,
                    barThickness:18
                }
            ]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            scales:{
                x:{ stacked:false, grid:{ display:false } }, // stacked: false agar tidak tertutup
                y:{ beginAtZero:true, stacked:false, ticks:{ callback:function(v){ return v + 'M'; } } }
            }
        }
    });

    /* ================= DONUT ================= */

    new Chart(document.getElementById('targetOverviewDonut'), {
        type:'doughnut',
        data:{
            labels:['Djuanda','Semeru'],
            datasets:[{
                data:[{{ $persenDjuanda > 0 ? $persenDjuanda : 1 }}, {{ $persenSemeru > 0 ? $persenSemeru : 1 }}],
                backgroundColor:['#1E3A8A','#F59E0B'],
                borderWidth:0
            }]
        },
        options:{ responsive:true, maintainAspectRatio:false, cutout:'72%', plugins:{ legend:{ display:false } } }
    });

    /* ================= FILTER BULAN & TAHUN ================= */
    const monthSelect = document.getElementById('monthSelect');
    const yearSelect  = document.getElementById('yearSelect');
    function updateFilter(){
        window.location.href = `?month=${monthSelect.value}&year=${yearSelect.value}`;
    }
    monthSelect.addEventListener('change', updateFilter);
    yearSelect.addEventListener('change', updateFilter);

</script>
@endsection