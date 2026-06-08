<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'pickup_code',
        'customer_name',
        'email',
        'phone',
        'quantity',
        'status',
        'location',
        'total',
        'items',
        'branch_id',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // ==============================
    // AUTO GENERATE PICKUP CODE
    // ==============================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trx) {
            if (!$trx->pickup_code) {

                $branchId = $trx->branch_id ?? 1;

                $trx->pickup_code =
                    'KOPIKALA-' .
                    $branchId . '-' .
                    now()->format('Hi');
            }
        });
    }

    // OPTIONAL (kalau mau dipakai manual)
    public static function generatePickupCode($branch_id)
    {
        do {
            $code = 'KOPIKALA-' . $branch_id . '-' . now()->format('Hi');
        } while (self::where('pickup_code', $code)->exists());

        return $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerPhotos()
    {
        return $this->hasMany(CustomerPhoto::class);
    }
    public function details()
{
    return $this->hasMany(TransactionDetail::class);
}
}