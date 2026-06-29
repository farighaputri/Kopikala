@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

<style>
    /* Tambahan CSS internal untuk komponen tombol pagination agar rapi */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 10px 20px;
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
        transition: 0.2s;
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
    <h2>Transaction - Cabang Semeru</h2>
    <span class="date">Date: <strong>{{ now()->format('d/m/Y') }}</strong></span>
</div>

{{-- SUMMARY --}}
<div class="summary-box">
    <div class="summary-grid">

        <div class="summary-item">
            <h3>{{ $transactions->count() }}</h3>
            <p>Total Orders</p>
        </div>

        <div class="summary-item">
            <h3>Rp {{ number_format($transactions->sum('total')) }}</h3>
            <p>Total Sales</p>
        </div>

    </div>
</div>

{{-- FILTER --}}
<div class="filter-card">
    <div class="filter-grid">

        <div class="filter-group">
            <label>Search Order ID</label>
            <input type="text" id="searchInput" placeholder="Enter Order ID...">
        </div>

        <div class="filter-group">
            <label>Transaction Status</label>
            <select id="statusFilter">
                <option value="">All Status</option>
                <option value="Waiting Confirmation">Waiting Confirmation</option>
                <option value="Order Confirmed">Order Confirmed</option>
                <option value="Order Ready">Order Ready</option>
                <option value="Order Finished">Order Finished</option>
            </select>
        </div>

    </div>
</div>

<div class="table-wrapper" style="display:flex; flex-direction:column; overflow-x:auto;">
    <table class="transaction-table" style="width:100%; border-collapse:collapse; text-align:center;">
        <thead>
            <tr>
                <th style="padding:15px; text-align:center;">No</th>
                <th style="padding:15px; text-align:center;">Order ID</th>
                <th style="padding:15px; text-align:center;">Customer</th>
                <th style="padding:15px; text-align:center;">Quantity</th>
                <th style="padding:15px; text-align:center;">Status</th>
                <th style="padding:15px; text-align:center;">Total</th>
                <th style="padding:15px; text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody id="transactionBody">
            @foreach($transactions as $index => $trx)
            <tr data-id="{{ $trx->id }}">
                <td style="padding:15px; text-align:center;">{{ $index + 1 }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->order_id }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->customer_name }}</td>
                <td style="padding:15px; text-align:center;">{{ $trx->quantity }}</td>
                <td class="status" style="padding:15px; text-align:center;">{{ $trx->status }}</td>
                <td style="padding:15px; text-align:center;">Rp {{ number_format($trx->total) }}</td>
                <td style="padding:15px; text-align:center;">
                    <div style="display:flex; justify-content:center; align-items:center;">
                        <a href="{{ route('transactions.detail', $trx->order_id) }}" class="btn-detail">
                            <img src="{{ asset('images/icons/detail.png') }}" alt="Detail" class="icon-btn" title="Detail" style="width:20px;">
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- NAVIGASI PAGINATION YANG SAMA PERSIS --}}
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
const tableBody = document.getElementById('transactionBody');
const rows = Array.from(tableBody.querySelectorAll('tr'));

// Variabel Kontrol Pagination per 12 Item
const itemsPerPage = 12;
let currentPage = 1;
let filteredRows = [...rows];

function filterAndPaginateTable() {
    const search = searchInput.value.toLowerCase();
    const status = statusFilter.value;

    // 1. Jalankan Filter Data Berdasarkan Index Kolom yang Benar (cells[1] & cells[4])
    filteredRows = rows.filter(row => {
        const orderId = row.cells[1].innerText.toLowerCase();
        const rowStatus = row.cells[4].innerText; // Di halaman cabang ini, kolom status berada pada indeks 4

        const matchesSearch = orderId.includes(search);
        const matchesStatus = status === '' || rowStatus === status;

        return matchesSearch && matchesStatus;
    });

    // Reset halaman ke lembar pertama apabila melebihi total lembar baru setelah difilter
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage) || 1;
    if (currentPage > totalPages) {
        currentPage = 1;
    }

    // 2. Jalankan Logika Slice Pagination Data per 12 Item
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;

    // Sembunyikan semua data terlebih dahulu
    rows.forEach(row => row.style.display = 'none');

    // Tampilkan data yang sesuai rentang halaman aktif
    const activeRows = filteredRows.slice(startIndex, endIndex);
    activeRows.forEach(row => row.style.display = '');

    // 3. Atur Status & Kunci Tombol Navigasi
    document.getElementById('btnPrev').disabled = currentPage === 1;
    document.getElementById('btnNext').disabled = currentPage === totalPages || filteredRows.length === 0;

    const displayStart = filteredRows.length === 0 ? 0 : startIndex + 1;
    const displayEnd = Math.min(endIndex, filteredRows.length);
    document.getElementById('pageInfo').innerText = `Showing ${displayStart} to ${displayEnd} of ${filteredRows.length} entries`;
}

// Event Listener Pembantu Pagination Klik
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

// Event Listener Input/Select Filter
searchInput.addEventListener('input', () => { currentPage = 1; filterAndPaginateTable(); });
statusFilter.addEventListener('change', () => { currentPage = 1; filterAndPaginateTable(); });

// Inisialisasi awal sewaktu render pertama kali
filterAndPaginateTable();
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