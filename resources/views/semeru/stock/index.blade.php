@extends('layouts.app')

@section('content')

{{-- HEADER & ADD BUTTON --}}
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="page-title" style="margin: 0; font-weight: 700; color: #333;">Semeru Stock</h2>
    
    {{-- Memanggil rute yang sudah mengarah ke fungsi semeruCreate --}}
    <a href="{{ route('semeru.stock.create') }}" class="add-btn" style="text-decoration: none; padding: 10px 15px; background: #4A3525; color: #fff; border-radius: 5px; font-weight: bold; transition: background 0.2s;">
        + Add New Stock
    </a>
</div>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="stock-summary" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px;">
    <div class="summary-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
        <div class="summary-value" style="font-size: 28px; font-weight: 700; color: #4A3525;">{{ $totalItems ?? 0 }}</div>
        <div class="summary-title" style="font-size: 14px; color: #666; margin: 5px 0;">Semeru Items</div>
        <div class="summary-sub" style="font-size: 12px; color: #999;">
            @if(($totalItems ?? 0) > ($prevTotalItems ?? 0))
                ↑ {{ ($totalItems ?? 0) - ($prevTotalItems ?? 0) }} more than last year
            @else
                — 
            @endif
        </div>
    </div>

    <div class="summary-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
        <div class="summary-value" style="font-size: 28px; font-weight: 700; color: #4A3525;">Rp {{ number_format($totalCost ?? 0,0,',','.') }}</div>
        <div class="summary-title" style="font-size: 14px; color: #666; margin: 5px 0;">Semeru Total Item Cost</div>
        <div class="summary-sub" style="font-size: 12px; color: #999;">
            @if(($totalCost ?? 0) < ($prevTotalCost ?? 0))
                ↓ 3% less than last month
            @else
                —
            @endif
        </div>
    </div>

    <div class="summary-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
        <div class="summary-value" style="font-size: 28px; font-weight: 700; color: #dc3545;">{{ $lowStockCount ?? 0 }}</div>
        <div class="summary-title" style="font-size: 14px; color: #666; margin: 5px 0;">Semeru Items Low in Stock</div>
        <div class="summary-sub" style="font-size: 12px; color: #999;">
            @if(($lowStockCount ?? 0) > ($prevLowStockCount ?? 0))
                ↑ 10% more than yesterday
            @else
                —
            @endif
        </div>
    </div>
</div>

{{-- ================= FILTER BAR ================= --}}
<div class="stock-filter-wrapper" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="{{ route('semeru.stock') }}" class="stock-filter" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) auto; gap: 15px; align-items: flex-end;">
        
        <div style="display: flex; flex-direction: column; gap: 5px;">
            <input type="text" name="search" placeholder="Search Stock ID and Item Name" value="{{ request('search') }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; box-sizing: border-box;">
        </div>

        <div style="display: flex; flex-direction: column; gap: 5px;">
            <select name="category" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; background: #fff;">
                <option value="">Filter Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; flex-direction: column; gap: 5px;">
            <select name="status" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; background: #fff;">
                <option value="">Filter Status</option>
                <option value="IN STOCK" @selected(request('status')=='IN STOCK')>IN STOCK</option>
                <option value="LOW STOCK" @selected(request('status')=='LOW STOCK')>LOW STOCK</option>
                <option value="OUT OF STOCK" @selected(request('status')=='OUT OF STOCK')>OUT OF STOCK</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="padding: 10px 20px; background: #4A3525; color: #fff; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Filter</button>
            <a href="{{ route('semeru.stock') }}" style="padding: 10px 20px; background: #8C7A6B; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; box-sizing: border-box;">Reset</a>
        </div>

        <div class="last-update" style="font-size: 13px; color: #666; justify-self: end; grid-column: 1 / -1; margin-top: 5px;">
            Last Updated: <span id="lastUpdatedTime" style="font-weight: bold; color: #333;">-</span>
        </div>
    </form>
</div>

{{-- ================= STOCK TABLE ================= --}}
<div class="stock-table-wrapper" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow-x: auto;">
    <table class="stock-table" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px;">No</th>
                <th style="padding: 15px;">Stock ID</th>
                <th style="padding: 15px;">Item Name</th>
                <th style="padding: 15px;">Category</th>
                <th style="padding: 15px;">Qty Purchased</th>
                <th style="padding: 15px;">Unit Price</th>
                <th style="padding: 15px;">Total Price</th>
                <th style="padding: 15px;">In Stock</th>
                <th style="padding: 15px;">Status</th>
                <th style="padding: 15px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $i => $stock)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 15px;">{{ $i+1 }}</td>
                    <td style="padding: 15px; font-weight: bold; color: #555;">{{ $stock->stock_id }}</td>
                    <td style="padding: 15px; font-weight: 500;">{{ $stock->item_name }}</td>
                    <td style="padding: 15px;">{{ $stock->categoryRelation->name ?? '-' }}</td>
                    <td style="padding: 15px;">{{ $stock->qty_purchased }}</td>
                    <td style="padding: 15px;">Rp {{ number_format($stock->unit_price,0,',','.') }}</td>
                    <td style="padding: 15px;">Rp {{ number_format($stock->total_price,0,',','.') }}</td>
                    <td style="padding: 15px; font-weight: bold;">{{ $stock->in_stock }}</td>
                    <td style="padding: 15px;">
                        <span class="badge {{ $stock->status=='IN STOCK' ? 'badge-green' : ($stock->status=='LOW STOCK' ? 'badge-yellow' : 'badge-red') }}">
                            {{ $stock->status }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 12px;">
                            
                            {{-- Detail --}}
                            <a href="{{ route('semeru.stock.show', $stock->id) }}" title="Detail">
                                <img src="{{ asset('images/icons/detail.png') }}" alt="Detail" style="width: 18px; height: 18px;">
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('semeru.stock.edit', $stock->id) }}" title="Edit">
                                <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" style="width: 18px; height: 18px;">
                            </a>

                            {{-- Delete --}}
                            <form id="deleteStockForm{{ $stock->id }}" method="POST" action="{{ route('semeru.stock.destroy', $stock->id) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="showDeletePopup('deleteStockForm{{ $stock->id }}')" style="background: none; border: none; cursor: pointer; padding: 0;" title="Delete">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" style="width: 18px; height: 18px;">
                            </button>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="padding: 30px; color: #999; font-style: italic;">No stock data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ================= SCRIPTS ================= --}}
<script>
    function showDeletePopup(formId) {
        if (confirm('Are you sure you want to delete this stock item?')) {
            const form = document.getElementById(formId);
            if (form) form.submit();
        }
    }
</script>

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
@endsection