<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'item_name',
        'category_id',
        'branch_id',
        'qty_purchased',
        'unit_price',
        'total_price',
        'in_stock',
        'status',
        'image'
    ];

    // Relasi kategori
    public function categoryRelation() {
        return $this->belongsTo(Category::class, 'category_id');
    }

   public function product()
{
    return $this->belongsTo(Product::class);
}

public function branch()
{
    return $this->belongsTo(Branch::class);
}

}
