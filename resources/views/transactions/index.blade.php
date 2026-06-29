@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

<style>
    /* === KONSISTENSI UI & INTEGRASI TEMA KOPIKALA === */
    .export-filter-box {
        display: flex;
        align-items: flex-end;
        gap: 15px;
        background: #ffffff;
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .export-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .export-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #3c1f0e;
    }
    .export-input {
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-family: inherit;
        outline: none;
        color: #3c1f0e;
        background-color: #fcfcfc;
    }
    .btn-download-action {
        background-color: #3c1f0e;
        color: #ffffff;
        border: 1px solid #3c1f0e;
        padding: 9px 18px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        font-weight: 700;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-download-action:hover {
        background-color: #5a3112;
        border-color: #5a3112;
    }

    /* PAGINATION ALIGNMENT */
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
        color: #3c1f0e;
        border: 1px solid #3c1f0e;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
        font-weight: 700;
        transition: all 0.2s ease;
    }
    .btn-page:hover:not(:disabled) {
        background-color: #3c1f0e;
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

<div class="transaction-header">
    <div>
        <h2>Transaction</h2>
        <span class="date">Transaction by <strong id="trx-date">{{ now()->format('d/m/Y') }}</strong></span>
    </div>
</div>

{{-- FORM KOMPONEN PILIHAN TANGGAL BULAN TAHUN UNTUK EXPORT --}}
<div class="export-filter-box">
    <div class="export-group">
        <label for="start_date">Dari Tanggal</label>
        <input type="date" id="start_date" class="export-input" required value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
    </div>

    <div class="export-group">
        <label for="end_date">Sampai Tanggal</label>
        <input type="date" id="end_date" class="export-input" required value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}">
    </div>

    <button type="button" id="btnExcel" class="btn-download-action">
        <i class="fa-regular fa-file-excel"></i> Export Excel
    </button>
    
    <button type="button" id="btnPdf" class="btn-download-action">
        <i class="fa-regular fa-file-pdf"></i> Export PDF
    </button>
</div>

<div class="summary-box">
    <div class="summary-grid">
        <div class="summary-item">
            <h3 id="total-order">{{ $transactions->count() }}</h3>
            <p>Total number of Order</p>
            <span class="growth">↑ Active</span>
        </div>

        <div class="summary-item">
            <h3 id="total-sales">Rp {{ number_format($transactions->sum('total')) }}</h3>
            <p>Total Sales</p>
            <span class="growth">↑ Active</span>
        </div>

        <input id="searchInput" class="search-input" placeholder="Search Order ID and..." />

        <select id="statusFilter" class="filter-select">
            <option value="">Filter Status</option>
            <option value="Waiting Confirmation">Waiting Confirmation</option>
            <option value="Order Confirmed">Order Confirmed</option>
            <option value="Order Ready">Order Ready</option>
            <option value="Order Finished">Order Finished</option>
        </select>

        <select id="locationFilter" class="filter-select">
            <option value="">Filter Location</option>
            <option value="Semeru">Semeru</option>
            <option value="Djuanda">Djuanda</option>
        </select>
    </div>
</div>

<div class="table-wrapper" style="display:flex; flex-direction:column; overflow-x:auto;">
    <table class="transaction-table" style="width:100%; border-collapse:collapse; text-align:center;">
        <thead>
            <tr>
                <th style="padding:15px; text-align:center;">No</th>
                <th style="padding:15px; text-align:center;">Order ID</th>
                <th style="padding:15px; text-align:center;">Time</th>
                <th style="padding:15px; text-align:center;">Customer Name</th>
                <th style="padding:15px; text-align:center;">Quantity</th>
                <th style="padding:15px; text-align:center;">Status</th>
                <th style="padding:15px; text-align:center;">Location</th>
                <th style="padding:15px; text-align:center;">Total</th>
                <th style="padding:15px; text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody id="transactionBody">
            @foreach($transactions as $index => $trx)
            <tr data-id="{{ $trx->id }}">
                <td style="padding:15px; text-align:center;">{{ $index + 1 }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->order_id }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->customer_name }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->quantity }}</td>
                <td class="status" style="padding:15px; text-align:center;">{{ $trx->status }}</td>
                <td style="padding:15px; text-align:center;">
                    {{ $trx->branch ? $trx->branch->branch_name . ' - ' . $trx->branch->location : ($trx->location ?? '-') }}
                </td>
                <td style="padding:15px; text-align:center;">Rp {{ number_format($trx->total) }}</td>
                <td style="padding:15px; text-align:center;">
                    <div class="action-icons" style="display:flex; justify-content:center; align-items:center; gap:15px;">
                        <a href="{{ route('transactions.detail', $trx->order_id) }}" class="btn-detail">
                            <img src="{{ asset('images/icons/detail.png') }}" alt="Detail" class="icon-btn" title="Detail" style="width:20px;">
                        </a>
                        <form id="deleteTransactionForm{{ $trx->id }}" method="POST" action="{{ route('transactions.destroy', $trx->id) }}" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" class="btn-delete" onclick="showDeletePopup('deleteTransactionForm{{ $trx->id }}')" style="background:none; border:none; cursor:pointer; padding:0;">
                            <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="icon-btn" title="Delete" style="width:20px;">
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-container">
        <div class="page-info" id="pageInfo">Showing 0 to 0 of 0 entries</div>
        <div class="pagination-buttons">
            <button class="btn-page" id="btnPrev">Previous</button>
            <button class="btn-page" id="btnNext">Next</button>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const locationFilter = document.getElementById('locationFilter');
    const tableBody = document.getElementById('transactionBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    
    const itemsPerPage = 12;
    let currentPage = 1;
    let filteredRows = [...rows];

    function filterAndPaginateTable() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const location = locationFilter.value;

        filteredRows = rows.filter(row => {
            const orderId = row.cells[1].innerText.toLowerCase();
            const rowStatus = row.cells[5].innerText;
            const rowLocation = row.cells[6].innerText;

            const matchesSearch = orderId.includes(search);
            const matchesStatus = status === '' || rowStatus === status;
            const matchesLocation = location === '' || rowLocation.includes(location);

            return matchesSearch && matchesStatus && matchesLocation;
        });

        const totalPages = Math.ceil(filteredRows.length / itemsPerPage) || 1;
        if (currentPage > totalPages) {
            currentPage = 1;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        rows.forEach(row => row.style.display = 'none');

        const activeRows = filteredRows.slice(startIndex, endIndex);
        activeRows.forEach(row => row.style.display = '');

        document.getElementById('btnPrev').disabled = currentPage === 1;
        document.getElementById('btnNext').disabled = currentPage === totalPages || filteredRows.length === 0;

        const displayStart = filteredRows.length === 0 ? 0 : startIndex + 1;
        const displayEnd = Math.min(endIndex, filteredRows.length);
        document.getElementById('pageInfo').innerText = `Showing ${displayStart} to ${displayEnd} of ${filteredRows.length} entries`;
    }

    document.getElementById('btnPrev').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            filterAndPaginateTable();
        }
    });

    document.getElementById('btnNext').addEventListener('click', () => {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            filterAndPaginateTable();
        }
    });

    searchInput.addEventListener('input', () => { currentPage = 1; filterAndPaginateTable(); });
    statusFilter.addEventListener('change', () => { currentPage = 1; filterAndPaginateTable(); });
    locationFilter.addEventListener('change', () => { currentPage = 1; filterAndPaginateTable(); });

    filterAndPaginateTable();

    // ====== FILTER TANGGAL EXPORT HANDLER ======
    document.addEventListener('DOMContentLoaded', function () {
        const btnExcel = document.getElementById('btnExcel');
        const btnPdf   = document.getElementById('btnPdf');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        if (btnExcel) {
            btnExcel.addEventListener('click', function () {
                const start = startDateInput.value;
                const end = endDateInput.value;
                if(!start || !end) { alert('Pilih rentang tanggal terlebih dahulu!'); return; }
                window.location.href = `{{ route('transactions.export.excel') }}?start_date=${start}&end_date=${end}`;
            });
        }

        if (btnPdf) {
            btnPdf.addEventListener('click', function () {
                const start = startDateInput.value;
                const end = endDateInput.value;
                if(!start || !end) { alert('Pilih rentang tanggal terlebih dahulu!'); return; }
                window.location.href = `{{ route('transactions.export.pdf') }}?start_date=${start}&end_date=${end}`;
            });
        }
    });
</script>
@endsection