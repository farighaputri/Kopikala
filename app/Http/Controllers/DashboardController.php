<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI BULAN INI
        |--------------------------------------------------------------------------
        */
$selectedMonth = request('month', now()->month);
$selectedYear = request('year', now()->year);

$allTransactions = Transaction::with('branch')
    ->whereMonth('created_at', $selectedMonth)
    ->whereYear('created_at', $selectedYear)
    ->latest()
    ->get();

        /*
        |--------------------------------------------------------------------------
        | NAMA STAFF LOGIN
        |--------------------------------------------------------------------------
        */

        $staffNameDisplay =
            session('staff.name')
            ?? auth()->user()->name
            ?? 'Admin';

        /*
        |--------------------------------------------------------------------------
        | TOTAL SALES
        |--------------------------------------------------------------------------
        */

        $totalSalesCalculated = $allTransactions->sum('total');

        /*
        |--------------------------------------------------------------------------
        | WEEKLY DATA
        |--------------------------------------------------------------------------
        */

        $weeklyTransactions = $allTransactions->filter(function ($trx) {
            return Carbon::parse($trx->created_at)
                ->greaterThanOrEqualTo(Carbon::now()->subDays(7));
        });

        $weeklyOrderCountCalculated = $weeklyTransactions->count();

        $weeklySalesAmountCalculated = $weeklyTransactions->sum('total');

        /*
        |--------------------------------------------------------------------------
        | BRANCH SALES
        |--------------------------------------------------------------------------
        */
$pendapatanDjuanda = 0;
$pendapatanSemeru = 0;

$qtyDjuanda = 0;
$qtySemeru = 0;

        $barDjuanda = array_fill(0, 12, 0);
        $barSemeru = array_fill(0, 12, 0);

        /*
        |--------------------------------------------------------------------------
        | LINE CHART
        |--------------------------------------------------------------------------
        */

        $dailySalesArray = array_fill(1, 31, 0);

        foreach ($allTransactions as $trx) {

            $tanggal = Carbon::parse($trx->created_at);

            $bulanIndex = $tanggal->month - 1;
            $hariIndex = $tanggal->day;

            /*
            |--------------------------------------------------------------------------
            | DAILY SALES
            |--------------------------------------------------------------------------
            */

            $dailySalesArray[$hariIndex] += $trx->total;

            /*
            |--------------------------------------------------------------------------
            | BRANCH NAME
            |--------------------------------------------------------------------------
            */

            $branchName = Str::lower(
                $trx->branch->branch_name ?? ''
            );

            /*
            |--------------------------------------------------------------------------
            | QTY
            |--------------------------------------------------------------------------
            */

            $qty = 0;

            $items = is_array($trx->items)
                ? $trx->items
                : json_decode($trx->items, true);

            if (is_array($items)) {
                foreach ($items as $item) {
                    $qty += $item['qty'] ?? 1;
                }
            } else {

                // fallback ambil quantity table
                $qty = $trx->quantity ?? 1;
            }

            /*
            |--------------------------------------------------------------------------
            | DJUANDA
            |--------------------------------------------------------------------------
            */

            if (
                Str::contains($branchName, 'djuanda')
            ) {

                $pendapatanDjuanda += $trx->total;

                $qtyDjuanda += $qty;

                $barDjuanda[$bulanIndex] += $trx->total;
            }

            /*
            |--------------------------------------------------------------------------
            | SEMERU
            |--------------------------------------------------------------------------
            */

            if (
                Str::contains($branchName, 'semeru')
            ) {

                $pendapatanSemeru += $trx->total;

                $qtySemeru += $qty;

                $barSemeru[$bulanIndex] += $trx->total;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI CHART
        |--------------------------------------------------------------------------
        */

        $maxDailySales = max($dailySalesArray);

        if ($maxDailySales <= 0) {
            $maxDailySales = 1;
        }

        $normalizedLineData = [];

        for ($i = 1; $i <= 31; $i++) {

            $normalizedLineData[] =
                round(
                    ($dailySalesArray[$i] / $maxDailySales) * 65
                ) + 20;
        }

        /*
        |--------------------------------------------------------------------------
        | LABEL
        |--------------------------------------------------------------------------
        */

        $lineLabels = [];

        for ($i = 1; $i <= 31; $i++) {

            if ($i == 1) {
                $lineLabels[] = 'Week 1';
            } elseif ($i == 8) {
                $lineLabels[] = 'Week 2';
            } elseif ($i == 15) {
                $lineLabels[] = 'Week 3';
            } elseif ($i == 22) {
                $lineLabels[] = 'Week 4';
            } else {
                $lineLabels[] = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TARGET
        |--------------------------------------------------------------------------
        */

        $targetNominal = 25000000;

        $persenDjuanda = $targetNominal > 0
            ? round(($pendapatanDjuanda / $targetNominal) * 100)
            : 0;

        $persenSemeru = $targetNominal > 0
            ? round(($pendapatanSemeru / $targetNominal) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | LOW STOCK
        |--------------------------------------------------------------------------
        */

        $lowStocks = Stock::with('branch')
            ->where('in_stock', '<=', 5)
            ->orderBy('in_stock')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ACTIVE USERS
        |--------------------------------------------------------------------------
        */

        $activeUsers = Staff::with('branch')
            ->where('status', 'active')
            ->latest()
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

       return view('dashboard', compact(
    'allTransactions',
    'totalSalesCalculated',
    'weeklyOrderCountCalculated',
    'weeklySalesAmountCalculated',
    'pendapatanDjuanda',
    'pendapatanSemeru',
    'qtyDjuanda',
    'qtySemeru',
    'barDjuanda',
    'barSemeru',
    'normalizedLineData',
    'lineLabels',
    'targetNominal',
    'persenDjuanda',
    'persenSemeru',
    'lowStocks',
    'activeUsers',
    'staffNameDisplay',
    'selectedMonth',
    'selectedYear'
));
    }
public function semeruDashboard()
{
    $staffNameDisplay = session('staff.name')
        ?? auth()->user()->name
        ?? 'Admin';

    $selectedMonth = request('month', now()->month);
    $selectedYear  = request('year', now()->year);

    $targetNominal = 25000000;

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI SEMERU
    |--------------------------------------------------------------------------
    */

    $safeTransactions = Transaction::with(['branch'])
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->latest()
        ->get()
        ->filter(function ($trx) {
            return Str::contains(
                strtolower($trx->branch->branch_name ?? ''),
                'semeru'
            );
        });

    /*
    |--------------------------------------------------------------------------
    | TOTAL SALES
    |--------------------------------------------------------------------------
    */

    $totalSalesCalculated = $safeTransactions->sum('total');

    /*
    |--------------------------------------------------------------------------
    | WEEKLY DATA
    |--------------------------------------------------------------------------
    */

    $weeklyTransactions = $safeTransactions->filter(function ($trx) {
        return Carbon::parse($trx->created_at)
            ->greaterThanOrEqualTo(now()->subDays(7));
    });

    $weeklyOrderCountCalculated = $weeklyTransactions->count();

    $weeklySalesAmountCalculated = $weeklyTransactions->sum('total');

    /*
    |--------------------------------------------------------------------------
    | MONTHLY TARGET
    |--------------------------------------------------------------------------
    */

    $persenSemeru = $targetNominal > 0
        ? round(($totalSalesCalculated / $targetNominal) * 100)
        : 0;

    $persenSemeru = min($persenSemeru, 100);

    /*
|--------------------------------------------------------------------------
| CHART DATA
|--------------------------------------------------------------------------
*/

$daysInMonth = Carbon::create(
    $selectedYear,
    $selectedMonth,
    1
)->daysInMonth;

$dailySalesArray = [];

for ($i = 1; $i <= $daysInMonth; $i++) {
    $dailySalesArray[$i] = 0;
}

foreach ($safeTransactions as $trx) {

    $day = Carbon::parse($trx->created_at)->day;

    $dailySalesArray[$day] += $trx->total;
}

$maxDailySales = max($dailySalesArray);

if ($maxDailySales <= 0) {
    $maxDailySales = 1;
}

$normalizedLineData = [];

foreach ($dailySalesArray as $sales) {

    $normalizedLineData[] =
        round(($sales / $maxDailySales) * 100);
}

/* LABEL HARI */
$lineLabels = array_keys($dailySalesArray);

    /*
    |--------------------------------------------------------------------------
    | LOW STOCK
    |--------------------------------------------------------------------------
    */

    $lowStocks = Stock::with([
    'branch',
    'categoryRelation'
])
        ->where('in_stock', '<=', 5)
        ->get()
        ->filter(function ($stock) {

            return Str::contains(
                strtolower($stock->branch->branch_name ?? ''),
                'semeru'
            );
        })
        ->take(5);

    /*
    |--------------------------------------------------------------------------
    | ACTIVE USER
    |--------------------------------------------------------------------------
    */

    $activeUsers = Staff::with([
            'branch',
            'role'
        ])
        ->where('status', 'active')
        ->get()
        ->filter(function ($staff) {

            return Str::contains(
                strtolower($staff->branch->branch_name ?? ''),
                'semeru'
            );
        })
        ->take(3);

    /*
    |--------------------------------------------------------------------------
    | EXTRA SUMMARY (MOCKUP)
    |--------------------------------------------------------------------------
    */

    $totalOrderSemeru = $safeTransactions->count();

    $latestTransactions = $safeTransactions
        ->sortByDesc('created_at')
        ->take(5);

    return view('semeru.dashboard', compact(
        'staffNameDisplay',

        'safeTransactions',
        'latestTransactions',

        'totalSalesCalculated',

        'weeklyOrderCountCalculated',
        'weeklySalesAmountCalculated',

        'normalizedLineData',
        'lineLabels',

        'targetNominal',
        'persenSemeru',

        'lowStocks',
        'activeUsers',

        'totalOrderSemeru',

        'selectedMonth',
        'selectedYear'
    ));
}
public function djuandaDashboard()
{
    $staffNameDisplay = session('staff.name')
        ?? auth()->user()->name
        ?? 'Admin';

    $selectedMonth = request('month', now()->month);
    $selectedYear  = request('year', now()->year);

    $targetNominal = 25000000;

    /*
    |---------------------------------------------
    | TRANSAKSI DJUANDA
    |---------------------------------------------
    */

    $safeTransactions = Transaction::with(['branch'])
        ->whereMonth('created_at', $selectedMonth)
        ->whereYear('created_at', $selectedYear)
        ->latest()
        ->get()
        ->filter(function ($trx) {
            return Str::contains(
                strtolower($trx->branch->branch_name ?? ''),
                'djuanda'
            );
        });

    /*
    |---------------------------------------------
    | TOTAL SALES
    |---------------------------------------------
    */

    $totalSalesCalculated = $safeTransactions->sum('total');

    /*
    |---------------------------------------------
    | WEEKLY DATA
    |---------------------------------------------
    */

    $weeklyTransactions = $safeTransactions->filter(function ($trx) {
        return Carbon::parse($trx->created_at)
            ->greaterThanOrEqualTo(now()->subDays(7));
    });

    $weeklyOrderCountCalculated = $weeklyTransactions->count();
    $weeklySalesAmountCalculated = $weeklyTransactions->sum('total');

    /*
    |---------------------------------------------
    | TARGET %
    |---------------------------------------------
    */

    $persenDjuanda = $targetNominal > 0
        ? round(($totalSalesCalculated / $targetNominal) * 100)
        : 0;

    $persenDjuanda = min($persenDjuanda, 100);

    /*
    |---------------------------------------------
    | CHART DATA
    |---------------------------------------------
    */

    $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;

    $dailySalesArray = [];

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $dailySalesArray[$i] = 0;
    }

    foreach ($safeTransactions as $trx) {
        $day = Carbon::parse($trx->created_at)->day;
        $dailySalesArray[$day] += $trx->total;
    }

    $maxDailySales = max($dailySalesArray);
    if ($maxDailySales <= 0) $maxDailySales = 1;

    $normalizedLineData = [];

    foreach ($dailySalesArray as $sales) {
        $normalizedLineData[] =
            round(($sales / $maxDailySales) * 100);
    }

    $lineLabels = array_keys($dailySalesArray);

    /*
    |---------------------------------------------
    | LOW STOCK
    |---------------------------------------------
    */

    $lowStocks = Stock::with(['branch','categoryRelation'])
        ->where('in_stock', '<=', 5)
        ->get()
        ->filter(function ($stock) {
            return Str::contains(
                strtolower($stock->branch->branch_name ?? ''),
                'djuanda'
            );
        })
        ->take(5);

    /*
    |---------------------------------------------
    | ACTIVE USERS
    |---------------------------------------------
    */

    $activeUsers = Staff::with(['branch','role'])
        ->where('status', 'active')
        ->get()
        ->filter(function ($staff) {
            return Str::contains(
                strtolower($staff->branch->branch_name ?? ''),
                'djuanda'
            );
        })
        ->take(3);

    /*
    |---------------------------------------------
    | TOTAL ORDER
    |---------------------------------------------
    */

    $totalOrderDjuanda = $safeTransactions->count();

    return view('djuanda.dashboard', compact(
        'staffNameDisplay',
        'safeTransactions',
        'totalSalesCalculated',
        'weeklyOrderCountCalculated',
        'weeklySalesAmountCalculated',
        'normalizedLineData',
        'lineLabels',
        'targetNominal',
        'persenDjuanda',
        'lowStocks',
        'activeUsers',
        'totalOrderDjuanda',
        'selectedMonth',
        'selectedYear'
    ));
}
}