@extends('layouts.app')

@section('content')

<div class="stock-header">
    <h2>Stock Cabang {{ $branch->branch_name }}</h2>
</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="stock-summary" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
    
    {{-- Card 1: Djuanda Items --}}
    <div class="summary-card" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <div class="summary-title" style="color: #666; font-size: 14px;">Djuanda Items</div>
        <div class="summary-value" style="font-size: 24px; font-weight: bold; margin: 5px 0;">{{ $totalItems ?? 0 }}</div>
        <div class="summary-sub" style="font-size: 12px; color: green;">
            ↑ {{ ($totalItems ?? 0) - ($prevTotalItems ?? 0) }} more than last year
        </div>
    </div>

    {{-- Card 2: Total Item Cost --}}
    <div class="summary-card" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <div class="summary-title" style="color: #666; font-size: 14px;">Djuanda Total Item Cost</div>
        <div class="summary-value" style="font-size: 24px; font-weight: bold; margin: 5px 0;">Rp {{ number_format($totalCost ?? 0,0,',','.') }}</div>
        <div class="summary-sub" style="font-size: 12px; color: red;">
            ↓ {{ ($totalCost ?? 0) < ($prevTotalCost ?? 0) ? '3% less' : 'Compared' }} than last month
        </div>
    </div>

    {{-- Card 3: Low Stock --}}
    <div class="summary-card" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <div class="summary-title" style="color: #666; font-size: 14px;">Djuanda Items Low in Stock</div>
        <div class="summary-value" style="font-size: 24px; font-weight: bold; margin: 5px 0;">{{ $lowStockCount ?? 0 }}</div>
        <div class="summary-sub" style="font-size: 12px; color: green;">
            ↑ 10% more than yesterday
        </div>
    </div>
</div>
{{-- ================= FILTER ================= --}}
<div class="stock-filter-wrapper" style="margin-top:15px;">
    <form method="GET" class="stock-filter">
        <input type="text" name="search" placeholder="Search Stock ID or Item Name" value="{{ request('search') }}" class="stock-input">

        <select name="category" class="stock-input">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="status" class="stock-input">
            <option value="">All Status</option>
            <option value="IN STOCK" @selected(request('status')=='IN STOCK')>IN STOCK</option>
            <option value="LOW STOCK" @selected(request('status')=='LOW STOCK')>LOW STOCK</option>
            <option value="OUT OF STOCK" @selected(request('status')=='OUT OF STOCK')>OUT OF STOCK</option>
        </select>

        <button type="submit" class="stock-btn">Filter</button>
    </form>

    {{-- Last updated --}}
    <div class="last-update" style="margin-top:5px; font-size:12px; color:#666;">
        Last updated: <span id="lastUpdatedTime">-</span>
    </div>
</div>

{{-- ================= TABLE STOCK ================= --}}
<div class="stock-table-wrapper" style="margin-top:10px;">
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
                        <span class="badge 
                            {{ $stock->status=='IN STOCK' ? 'badge-green' : ($stock->status=='LOW STOCK' ? 'badge-yellow' : 'badge-red') }}">
                            {{ $stock->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; color:#999;">No stock data found</td>
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
