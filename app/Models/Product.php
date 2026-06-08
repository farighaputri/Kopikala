<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCustomization;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'status',
        'image',
        'description',
    ];

    /**
     * Relasi ke tabel product_customizations
     * Satu produk memiliki banyak customization.
     */
    public function customizations()
    {
        return $this->hasMany(ProductCustomization::class);
    }
    public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}
}