<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;

class FetchTransactions extends Command
{
    protected $signature = 'transactions:fetch';
    protected $description = 'Fetch transactions from API and save to database';

    public function handle()
    {
        $response = Http::get('https://kopikala.com/api/transactions'); // ganti endpoint asli
        if ($response->ok()) {
            $transactions = $response->json();

            foreach ($transactions as $tx) {
                Transaction::updateOrCreate(
                    ['id' => $tx['id']], // jika ID sudah ada, update
                    [
                        'customer_name' => $tx['customer_name'],
                        'total' => $tx['total'],
                        'status' => $tx['status']
                    ]
                );
            }

            $this->info('Transactions synced successfully!');
        } else {
            $this->error('Failed to fetch transactions from API');
        }
    }
}
