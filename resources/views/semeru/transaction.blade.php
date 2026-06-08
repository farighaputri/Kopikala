@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">

<div class="transaction-header">
    <h2>Transaction - Cabang Semeru</h2>
    <span class="date">Date: <strong>{{ now()->format('d/m/Y') }}</strong></span>
</div>

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
        <input id="searchInput" placeholder="Search Order ID..." class="search-input" />
        <select id="statusFilter" class="filter-select">
            <option value="">Filter Status</option>
            <option value="Waiting Confirmation">Waiting Confirmation</option>
            <option value="Order Confirmed">Order Confirmed</option>
            <option value="Order Ready">Order Ready</option>
            <option value="Order Finished">Order Finished</option>
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

                <td style="padding:15px; text-align:center;">
                    {{ $index + 1 }}
                </td>

                <td style="padding:15px; text-align:center;">
                    {{ $trx->order_id }}
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
                    Rp {{ number_format($trx->total) }}
                </td>

                <td style="padding:15px; text-align:center;">

                    <div style="
                        display:flex;
                        justify-content:center;
                        align-items:center;
                    ">

                        <a href="{{ route('transactions.detail', $trx->order_id) }}"
                           class="btn-detail">

                            <img src="{{ asset('images/icons/detail.png') }}"
                                 alt="Detail"
                                 class="icon-btn"
                                 title="Detail"
                                 style="width:20px;">

                        </a>

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
const rows = Array.from(document.querySelectorAll('#transactionBody tr'));

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const status = statusFilter.value;

    rows.forEach(row => {
        const orderId = row.cells[1].innerText.toLowerCase();
        const rowStatus = row.cells[4].innerText;

        row.style.display = (orderId.includes(search) && (status === '' || rowStatus === status)) ? '' : 'none';
    });
}

searchInput.addEventListener('input', filterTable);
statusFilter.addEventListener('change', filterTable);
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
