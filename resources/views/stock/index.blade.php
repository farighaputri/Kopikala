@extends('layouts.app')

@section('content')

<style>
    /* === NAVIGASI CONTROLLER PAGINATION DESIGN SYSTEM === */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 12px 20px;
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .pagination-buttons {
        display: flex;
        gap: 10px;
    }
    .btn-page {
        background-color: #f4ecdf;
        color: #4b2207;
        border: 1px solid #4b2207;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .btn-page:hover:not(:disabled) {
        background-color: #4b2207;
        color: #ffffff;
    }
    .btn-page:disabled {
        background-color: #e2e8f0;
        color: #a0aec0;
        border-color: #cbd5e1;
        cursor: not-allowed;
    }
    .page-info {
        font-size: 0.95rem;
        color: #4a5568;
        font-weight: 600;
    }
</style>

<div class="stock-header" style="margin-bottom: 20px;">
    <h2 style="font-size: 28px; font-weight: 700; color: #2d1405;">Stock</h2>
</div>

{{-- ================= SUMMARY CARDS (Grid 4 Kolom) ================= --}}
<div class="stock-summary" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    
    {{-- Categories Card --}}
    <div class="summary-card" onclick="window.location='{{ route('categories.index') }}'" 
         style="cursor: pointer; background: #fff; border: 1px solid #e5e5e5; padding: 20px; border-radius: 16px;">
        <div class="summary-title" style="font-size: 14px; color: #666; margin-bottom: 8px;">Categories</div>
        <div class="summary-value" style="font-size: 24px; font-weight: 700; color: #2d1405;">{{ $totalCategories ?? 0 }}</div>
        <div class="summary-sub" style="font-size: 12px; color: #4b2207; margin-top: 8px; font-weight: 600;">See Categories →</div>
    </div>

    {{-- Items Card --}}
    <div class="summary-card" style="background: #fff; border: 1px solid #e5e5e5; padding: 20px; border-radius: 16px;">
        <div class="summary-title" style="font-size: 14px; color: #666; margin-bottom: 8px;">Items</div>
        <div class="summary-value" style="font-size: 24px; font-weight: 700; color: #2d1405;">{{ $totalItems ?? 0 }}</div>
        <div class="summary-sub" style="font-size: 12px; color: #666; margin-top: 8px;">
            @if(($totalItems ?? 0) > ($prevTotalItems ?? 0)) ↑ {{ ($totalItems ?? 0) - ($prevTotalItems ?? 0) }} added @else — No change @endif
        </div>
    </div>

    {{-- Total Cost Card --}}
    <div class="summary-card" style="background: #fff; border: 1px solid #e5e5e5; padding: 20px; border-radius: 16px;">
        <div class="summary-title" style="font-size: 14px; color: #666; margin-bottom: 8px;">Total Item Cost</div>
        <div class="summary-value" style="font-size: 24px; font-weight: 700; color: #2d1405;">Rp {{ number_format($totalCost ?? 0,0,',','.') }}</div>
        <div class="summary-sub" style="font-size: 12px; color: #666; margin-top: 8px;">{{ ($totalCost ?? 0) > ($prevTotalCost ?? 0) ? '↑ Increased' : 'Stable' }}</div>
    </div>

    {{-- Low Stock Card --}}
    <div class="summary-card" onclick="window.location='{{ route('stock.index', ['status'=>'LOW STOCK']) }}'"
         style="cursor: pointer; background: #fff; border: 1px solid #e5e5e5; padding: 20px; border-radius: 16px;">
        <div class="summary-title" style="font-size: 14px; color: #666; margin-bottom: 8px;">Items Low in Stock</div>
        <div class="summary-value" style="font-size: 24px; font-weight: 700; color: #2d1405;">{{ $lowStockCount ?? 0 }}</div>
        <div class="summary-sub" style="font-size: 12px; color: #d9534f; margin-top: 8px; font-weight: 600;">See Items →</div>
    </div>
</div>

{{-- ================= FILTER & ACTIONS ================= --}}
<form method="GET" action="{{ route('stock.index') }}" class="stock-filter" style="display:grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 15px; align-items:flex-end; margin-bottom: 20px;">
    
    <div class="form-group"><label style="font-size: 12px; font-weight:600;">Search Stock ID and Item Name</label>
        <input type="text" name="search" value="{{ request('search') }}" class="stock-input" placeholder="Search..." style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;">
    </div>

    <div class="form-group"><label style="font-size: 12px; font-weight:600;">Filter Category</label>
        <select name="category" class="stock-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat) <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option> @endforeach
        </select>
    </div>

    <div class="form-group"><label style="font-size: 12px; font-weight:600;">Filter Status</label>
        <select name="status" class="stock-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px;">
            <option value="">All Status</option>
            <option value="IN STOCK" @selected(request('status')=='IN STOCK')>IN STOCK</option>
            <option value="LOW STOCK" @selected(request('status')=='LOW STOCK')>LOW STOCK</option>
            <option value="OUT OF STOCK" @selected(request('status')=='OUT OF STOCK')>OUT OF STOCK</option>
        </select>
    </div>

    <div class="form-group"><label style="font-size: 12px; font-weight:600;">Filter Location</label>
        <select name="branch_id" class="stock-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px;">
            <option value="">All Locations</option>
            @foreach($branches as $branch) <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>{{ $branch->branch_name }}</option> @endforeach
        </select>
    </div>

    <button type="submit" class="stock-btn" style="height: 42px; padding: 0 20px; background: #4b2207; color: white; border-radius: 8px; border: none; cursor: pointer; align-self: flex-end;">Filter</button>
</form>

{{-- Header Kanan --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
    <div></div>
    <div style="text-align:right;">
        <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Last updated: <span id="lastUpdatedTime">-</span></div><br>
        <a href="{{ route('stock.create') }}" style="padding: 10px 20px; background: #4b2207; color: #fff; text-decoration:none; border-radius: 8px; font-weight: 600;">+ Add New Item</a><br>
    </div>
</div>
<br>

{{-- ================= TABLE ================= --}}
<div class="stock-table-wrapper" style="background: white; border: 1px solid #e5e5e5; border-radius: 16px; overflow: hidden; margin: 0 auto; width: 100%; display: flex; flex-direction: column;">
    <table class="stock-table" style="width: 100%; border-collapse: collapse; table-layout: auto;">
        <thead style="background: #fafafa;">
            <tr>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">No</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Stock ID</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Item Name</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Category</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Qty Purchased</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Unit Price</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Total Price</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">In Stock</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Status</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Location</th>
                <th style="padding: 15px; text-align: center; color: #4b2207; font-weight: 700;">Action</th>
            </tr>
        </thead>
        <tbody id="stockTableBody">
            @forelse($stocks as $i => $stock)
            <tr style="border-bottom: 1px solid #eee; text-align: center;">
                <td style="padding: 15px;">{{ $i+1 }}</td>
                <td style="padding: 15px;">{{ $stock->stock_id }}</td>
                <td style="padding: 15px;">{{ $stock->item_name }}</td>
                <td style="padding: 15px;">{{ $stock->categoryRelation->name ?? '-' }}</td>
                <td style="padding: 15px;">{{ $stock->qty_purchased }}</td>
                <td style="padding: 15px;">Rp {{ number_format($stock->unit_price,0,',','.') }}</td>
                <td style="padding: 15px;">Rp {{ number_format($stock->total_price,0,',','.') }}</td>
                <td style="padding: 15px;">{{ $stock->in_stock }}</td>
                <td style="padding: 15px;">
                    <span class="badge" style="padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; 
                        {{ $stock->status=='IN STOCK' ? 'background:#dcf7ef; color:#17a572;' : ($stock->status=='LOW STOCK' ? 'background:#fff3cd; color:#856404;' : 'background:#ffe5e5; color:#dc2626;') }}">
                        {{ $stock->status }}
                    </span>
                </td>
                <td style="padding: 15px;">{{ $stock->branch->branch_name ?? '-' }}</td>
                <td style="padding: 15px;">
                    <div class="action-icons" style="display:flex; justify-content:center; gap:10px;">
                        <a href="{{ route('stock.show', $stock->id) }}"><img src="{{ asset('images/icons/detail.png') }}" width="20"></a>
                        <a href="{{ route('stock.edit', $stock->id) }}"><img src="{{ asset('images/icons/edit.png') }}" width="20"></a>
                        <button type="button" onclick="showDeletePopup('deleteForm{{ $stock->id }}')" style="border:none; background:none; cursor:pointer;"><img src="{{ asset('images/icons/delete.png') }}" width="20"></button>
                    </div>
                    <form id="deleteForm{{ $stock->id }}" action="{{ route('stock.destroy', $stock->id) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
                </td>
            </tr>
            @empty
            <tr class="no-data-row">
                <td colspan="11" style="text-align:center; padding: 20px; color: #999; font-style: italic;">No stock data found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- NAVIGASI CONTROLLER PAGINATION --}}
    <div class="pagination-container">
        <div class="page-info" id="pageInfo">Showing 0 to 0 of 0 entries</div>
        <div class="pagination-buttons">
            <button type="button" class="btn-page" id="btnPrev">Previous</button>
            <button type="button" class="btn-page" id="btnNext">Next</button>
        </div>
    </div>
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
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('stockTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-data-row)'));
    
    // Sembunyikan container pagination jika data stok kosong
    if (rows.length === 0) {
        document.querySelector('.pagination-container').style.display = 'none';
        return;
    }

    const itemsPerPage = 12;
    let currentPage = 1;

    function paginateTable() {
        const totalPages = Math.ceil(rows.length / itemsPerPage) || 1;
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Sembunyikan seluruh data baris terlebih dahulu
        rows.forEach(row => row.style.display = 'none');

        // Tampilkan hanya baris yang masuk rentang 12 data halaman aktif
        const activeRows = rows.slice(startIndex, endIndex);
        activeRows.forEach(row => row.style.display = '');

        // Update status interaksi tombol navigasi
        document.getElementById('btnPrev').disabled = currentPage === 1;
        document.getElementById('btnNext').disabled = currentPage === totalPages;

        const displayStart = startIndex + 1;
        const displayEnd = Math.min(endIndex, rows.length);
        document.getElementById('pageInfo').innerText = `Showing ${displayStart} to ${displayEnd} of ${rows.length} entries`;
    }

    document.getElementById('btnPrev').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            paginateTable();
        }
    });

    document.getElementById('btnNext').addEventListener('click', () => {
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            paginateTable();
        }
    });

    paginateTable();
});
</script>

<script>
    let lastTimestamp = null;
    async function fetchLastUpdated() {
        const el = document.getElementById('lastUpdatedTime');
        if(!el) return;
        try {
            const res = await fetch("{{ route('stock.last-updated') }}");
            const data = await res.json();
            if(data.timestamp) {
                const date = new Date(data.timestamp * 1000);
                el.innerText = date.toLocaleDateString('id-ID') + ' ' + date.toLocaleTimeString('id-ID');
            }
        } catch(err) { el.innerText = '-'; }
    }
    fetchLastUpdated();
    setInterval(fetchLastUpdated, 5000);
</script>

@endsection