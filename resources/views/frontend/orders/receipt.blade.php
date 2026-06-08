<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Kopikala</title>

<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f3ede2;
    font-family:'Patrick Hand', cursive;
    padding:40px;
}

.receipt{
    max-width:700px;
    margin:auto;
    background:white;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.receipt-header{
    background:#4A210B;
    color:white;
    padding:28px;
    text-align:center;
}

.receipt-header img{
    width:160px;
    margin:auto;
    margin-bottom:14px;
}

.receipt-header h1{
    font-size:42px;
    font-weight:400;
}

.receipt-body{
    padding:35px;
}

.row{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
    gap:20px;
}

.label{
    font-family:'Plus Jakarta Sans', sans-serif;
    color:#7a5234;
    font-size:14px;
    margin-bottom:4px;
}

.value{
    font-size:24px;
    color:#4A210B;
}

hr{
    border:none;
    border-top:1px dashed #c9b5a3;
    margin:28px 0;
}

.item{
    display:flex;
    justify-content:space-between;
    margin-bottom:16px;
}

.item-name{
    font-size:24px;
}

.item-price{
    font-size:22px;
}

.total{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:30px;
}

.total span{
    font-size:28px;
}

.total strong{
    font-size:42px;
    color:#4A210B;
}

.download-actions{
    display:flex;
    justify-content:center;
    gap:16px;
    margin-top:35px;
}

.btn{
    border:none;
    padding:14px 24px;
    border-radius:14px;
    cursor:pointer;
    font-size:18px;
    font-family:'Patrick Hand', cursive;
}

.btn-print{
    background:#4A210B;
    color:white;
}

.btn-back{
    background:#e9ddd0;
    color:#4A210B;
    text-decoration:none;
}

@media print{
    .download-actions{
        display:none;
    }

    body{
        padding:0;
        background:white;
    }

    .receipt{
        box-shadow:none;
    }
}
</style>
</head>

<body>

<div class="receipt">

    <div class="receipt-header">

        <img src="{{ asset('media/logo.png') }}">

        <h1>Struk Pembayaran</h1>

    </div>

    <div class="receipt-body">

        <div class="row">
            <div>
                <div class="label">Order ID</div>
                <div class="value">
                    {{ $transaction->order_id }}
                </div>
            </div>

            <div style="text-align:right;">
                <div class="label">Pickup Code</div>
                <div class="value">
                    {{ $transaction->pickup_code ?? '---' }}
                </div>
            </div>
        </div>

        <div class="row">
            <div>
                <div class="label">Nama Pemesan</div>
                <div class="value">
                    {{ $transaction->customer_name }}
                </div>
            </div>

            <div style="text-align:right;">
                <div class="label">Cabang</div>
                <div class="value">
                    {{ $transaction->branch->branch_name ?? '-' }}
                </div>
            </div>
        </div>

        <hr>

        @php
            $items = is_array($transaction->items)
                ? $transaction->items
                : json_decode($transaction->items, true);
        @endphp

        @foreach($items as $item)

        <div class="item">

            <div class="item-name">
                {{ $item['name'] ?? 'Menu' }}
                x{{ $item['qty'] ?? 1 }}
            </div>

            <div class="item-price">
                Rp {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1),0,',','.') }}
            </div>

        </div>

        @endforeach

        <hr>

        <div class="total">

            <span>Total Pembayaran</span>

            <strong>
                Rp {{ number_format($transaction->total,0,',','.') }}
            </strong>

        </div>

        <div class="download-actions">

            <button onclick="window.print()" class="btn btn-print">
                Print / Save PDF
            </button>

            <a href="{{ route('orders.my') }}"
               class="btn btn-back">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>