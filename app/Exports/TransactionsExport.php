<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaction::with('branch')->get()->map(function ($trx) {
            return [
                $trx->order_id,
                $trx->customer_name,
                $trx->quantity,
                $trx->status,
                optional($trx->branch)->branch_name,
                $trx->total,
                $trx->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Quantity',
            'Status',
            'Branch',
            'Total',
            'Date',
        ];
    }
}
