@extends('layouts.app')

@section('content')

<div class="page-header">
    <h2 class="page-title">Semeru Stock</h2>
</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="stock-summary">
    <div class="summary-card">
        <div class="summary-value">{{ $totalItems ?? 0 }}</div>
        <div class="summary-title">Semeru Items</div>
        <div class="summary-sub">
            @if(($totalItems ?? 0) > ($prevTotalItems ?? 0))
                ↑ {{ ($totalItems ?? 0) - ($prevTotalItems ?? 0) }} more than last year
            @else
                — 
            @endif
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-value">Rp {{ number_format($totalCost ?? 0,0,',','.') }}</div>
        <div class="summary-title">Semeru Total Item Cost</div>
        <div class="summary-sub">
            @if(($totalCost ?? 0) < ($prevTotalCost ?? 0))
                ↓ 3% less than last month
            @else
                —
            @endif
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-value">{{ $lowStockCount ?? 0 }}</div>
        <div class="summary-title">Semeru Items Low in Stock</div>
        <div class="summary-sub">
            @if(($lowStockCount ?? 0) > ($prevLowStockCount ?? 0))
                ↑ 10% more than yesterday
            @else
                —
            @endif
        </div>
    </div>
</div>

{{-- ================= FILTER ================= --}}
<div class="stock-filter-wrapper">
    <form method="GET" class="stock-filter">
        <input type="text" name="search" placeholder="Search Stock ID and Item Name" value="{{ request('search') }}" class="stock-input">

        <select name="category" class="stock-input">
            <option value="">Filter Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="status" class="stock-input">
            <option value="">Filter Status</option>
            <option value="IN STOCK" @selected(request('status')=='IN STOCK')>IN STOCK</option>
            <option value="LOW STOCK" @selected(request('status')=='LOW STOCK')>LOW STOCK</option>
            <option value="OUT OF STOCK" @selected(request('status')=='OUT OF STOCK')>OUT OF STOCK</option>
        </select>

        <button type="submit" class="stock-btn">Filter</button>

        <div class="last-update">
            Last Updated: <span id="lastUpdatedTime">-</span>
        </div>
    </form>
</div>

{{-- ================= STOCK TABLE ================= --}}
<div class="stock-table-wrapper">
    <table class="stock-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Stock ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Qty Purchased</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>In Stock</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $i => $stock)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $stock->stock_id }}</td>
                    <td>{{ $stock->item_name }}</td>
                    <td>{{ $stock->categoryRelation->name ?? '-' }}</td>
                    <td>{{ $stock->qty_purchased }}</td>
                    <td>Rp {{ number_format($stock->unit_price,0,',','.') }}</td>
                    <td>Rp {{ number_format($stock->total_price,0,',','.') }}</td>
                    <td>{{ $stock->in_stock }}</td>
                    <td>
                        <span class="badge {{ $stock->status=='IN STOCK' ? 'badge-green' : ($stock->status=='LOW STOCK' ? 'badge-yellow' : 'badge-red') }}">
                            {{ $stock->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="no-data">No stock data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ================= LAST UPDATE SCRIPT ================= --}}
<script>
let lastTimestamp = null;
async function fetchLastUpdated() {
    const el = document.getElementById('lastUpdatedTime');
    if(!el) return;
    try {
        const res = await fetch("{{ route('stock.last-updated') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if(!res.ok) return;
        const data = await res.json();
        if(!data.timestamp) {
            el.innerText = '-';
            return;
        }
        if(lastTimestamp === data.timestamp) return;
        lastTimestamp = data.timestamp;
        const date = new Date(data.timestamp * 1000);
        const formatted = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            day:'2-digit', month:'2-digit', year:'numeric',
            hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false
        }).format(date).replace(',', '');
        el.innerText = formatted;
    } catch(err) {
        console.error('Last updated error:', err);
        el.innerText = '-';
    }
}
fetchLastUpdated();
setInterval(fetchLastUpdated, 5000);
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
    const currentUrl = window.location.href;

    sidebarLinks.forEach(link => {
        if(link.href === currentUrl){
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>
@endsection
