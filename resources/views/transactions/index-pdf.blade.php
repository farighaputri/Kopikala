<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kopikala - Transaction Report</title>
    <style>
        /* === SETTING DRIVER CETAK DENGAN MARGIN PRESISI === */
        @page {
            size: A4 portrait;
            margin: 20mm 15mm 20mm 15mm;
        }

        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333333;
            line-height: 1.4;
        }
        .header-container {
            border-bottom: 2px solid #3c1f0e;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .company-title {
            font-size: 20px;
            font-weight: bold;
            color: #3c1f0e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
        }
        .report-title {
            font-size: 14px;
            font-weight: bold;
            color: #555555;
            margin: 0 0 15px 0;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .meta-table td {
            border: none !important;
            padding: 2px 0;
            font-size: 11px;
        }
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        table.data-table th, table.data-table td { 
            border: 1px solid #cccccc; 
            padding: 8px 6px; 
        }
        table.data-table th { 
            background-color: #f4ecdf; 
            color: #3c1f0e;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .total-row td {
            border-top: 2px solid #3c1f0e !important;
            border-bottom: 2px solid #3c1f0e !important;
            color: #3c1f0e;
        }
    </style>
</head>
<body>

<div class="header-container">
    <table class="meta-table">
        <tr>
            <td class="text-left" style="vertical-align: top;">
                <h1 class="company-title">Kopikala Coffee</h1>
                <h2 class="report-title">Laporan Transaksi Penjualan</h2>
            </td>
            <td class="text-right" style="vertical-align: top; color: #666666;">
                {{-- MEMBACA FILTER TANGGAL DARI URL INDEX SEARA OTOMATIS --}}
                @if(request()->filled('start_date') && request()->filled('end_date'))
                    <strong>Periode:</strong> {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}<br>
                @else
                    <strong>Periode:</strong> Semua Riwayat Transaksi<br>
                @endif
                <strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}
            </td>
        </tr>
    </table>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;" class="text-center">No</th>
            <th style="width: 15%;" class="text-center">Order ID</th>
            <th style="width: 15%;" class="text-center">Tanggal</th>
            <th style="width: 20%;" class="text-left">Customer</th>
            <th style="width: 8%;" class="text-center">Qty</th>
            <th style="width: 12%;" class="text-center">Status</th>
            <th style="width: 13%;" class="text-center">Branch</th>
            <th style="width: 12%;" class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $grandTotalQty = 0;
            $grandTotalSales = 0;
        @endphp
        
        @forelse($transactions as $i => $trx)
            @php 
                $grandTotalQty += $trx->quantity;
                $grandTotalSales += $trx->total;
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td class="text-center"><strong>{{ $trx->order_id }}</strong></td>
                <td class="text-center">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-left">{{ $trx->customer_name }}</td>
                <td class="text-center">{{ $trx->quantity }}</td>
                <td class="text-center">{{ $trx->status }}</td>
                <td class="text-center">{{ optional($trx->branch)->branch_name ?? ($trx->location ?? '-') }}</td>
                <td class="text-right">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px; color: #999999;">
                    Tidak ada data transaksi pada periode ini.
                </td>
            </tr>
        @endforelse
        
        @if($transactions->count() > 0)
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-center">{{ $grandTotalQty }}</td>
                <td colspan="2"></td>
                <td class="text-right">Rp {{ number_format($grandTotalSales, 0, ',', '.') }}</td>
            </tr>
        @endif
    </tbody>
</table>

</body>
</html>