@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

<div class="transaction-header">
    <div>
        <h2>Transaction</h2>
        <span class="date">Transaction by <strong id="trx-date">{{ now()->format('d/m/Y') }}</strong></span>
    </div>

    <div>
        <button id="btnExcel" class="btn-download">
    Download Transaction Report (.xlsx)
</button>

<button id="btnPdf" class="btn-download">
    Download Transaction Report (PDF)
</button>

    </div>
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

<div class="table-wrapper"
     style="
        display:flex;
        justify-content:center;
        overflow-x:auto;
     ">

    <table class="transaction-table"
           style="
                width:100%;
                border-collapse:collapse;
                text-align:center;
           ">

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

                <td style="padding:15px; text-align:center;">
                    {{ $index + 1 }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $trx->order_id }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $trx->created_at->format('d/m/Y H:i') }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $trx->customer_name }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $trx->quantity }}
                </td>

                <td class="status"
                    style="padding:15px; text-align:center;">

                    {{ $trx->status }}

                </td>

                <td style="padding:15px; text-align:center;">

                    {{ $trx->branch 
                        ? $trx->branch->branch_name . ' - ' . $trx->branch->location 
                        : ($trx->location ?? '-') }}

                </td>

                <td style="padding:15px; text-align:center;">
                    Rp {{ number_format($trx->total) }}
                </td>

                <td style="padding:15px; text-align:center;">

                    <div class="action-icons"
                         style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            gap:15px;
                         ">

                        {{-- DETAIL --}}
                        <a href="{{ route('transactions.detail', $trx->order_id) }}"
                           class="btn-detail">

                            <img src="{{ asset('images/icons/detail.png') }}"
                                 alt="Detail"
                                 class="icon-btn"
                                 title="Detail"
                                 style="width:20px;">

                        </a>

                        {{-- DELETE FORM --}}
                        <form id="deleteTransactionForm{{ $trx->id }}"
                              method="POST"
                              action="{{ route('transactions.destroy', $trx->id) }}"
                              style="display:none;">

                            @csrf
                            @method('DELETE')

                        </form>

                        {{-- DELETE BUTTON --}}
                        <button type="button"
                                class="btn-delete"
                                onclick="showDeletePopup('deleteTransactionForm{{ $trx->id }}')"
                                style="
                                    background:none;
                                    border:none;
                                    cursor:pointer;
                                    padding:0;
                                ">

                            <img src="{{ asset('images/icons/delete.png') }}"
                                 alt="Delete"
                                 class="icon-btn"
                                 title="Delete"
                                 style="width:20px;">

                        </button>

                    </div>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const locationFilter = document.getElementById('locationFilter');
    const tableBody = document.getElementById('transactionBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const location = locationFilter.value;

        rows.forEach(row => {
            const orderId = row.cells[1].innerText.toLowerCase();
            const rowStatus = row.cells[5].innerText;
            const rowLocation = row.cells[6].innerText;

            const matchesSearch = orderId.includes(search);
            const matchesStatus = status === '' || rowStatus === status;
            const matchesLocation = location === '' || rowLocation.includes(location);

            row.style.display = (matchesSearch && matchesStatus && matchesLocation) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    locationFilter.addEventListener('change', filterTable);

    // ====== CHANGE STATUS ======
    function changeStatus(id, currentStatus) {
        const nextStatus = prompt('Update Order Status', currentStatus);
        if(nextStatus && nextStatus !== currentStatus){
            fetch(`/transactions/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: nextStatus })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status){
                    alert('Status updated');
                    document.querySelector(`tr[data-id="${id}"] .status`).innerText = nextStatus;
                } else {
                    alert('Failed to update status');
                }
            });
        }
    }

    // ====== DELETE TRANSACTION ======
    function deleteTransaction(id){
        if(confirm('Are you sure want to delete this transaction?')){
            fetch(`/transactions/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status){
                    alert('Transaction deleted');
                    document.querySelector(`tr[data-id="${id}"]`).remove();
                } else {
                    alert('Failed to delete transaction');
                }
            });
        }
    }
    
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // FIX: pastikan button tidak submit form
    const btnExcel = document.getElementById('btnExcel');
    const btnPdf   = document.getElementById('btnPdf');

    if (btnExcel) {
        btnExcel.type = 'button';
        btnExcel.addEventListener('click', function () {
            window.location.href = "{{ route('transactions.export.excel') }}";
        });
    }

    if (btnPdf) {
        btnPdf.type = 'button';
        btnPdf.addEventListener('click', function () {
            window.location.href = "{{ route('transactions.export.pdf') }}";
        });
    }

});
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
