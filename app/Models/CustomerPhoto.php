<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class CustomerPhoto extends Model
{
    protected $fillable = ['transaction_id','photo_path'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
