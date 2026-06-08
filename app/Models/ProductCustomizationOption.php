<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOption extends Model
{
    protected $fillable = [
        'product_customization_id',
        'name',
        'additional_price'
    ];

    public function customization()
    {
        return $this->belongsTo(ProductCustomization::class, 'product_customization_id');
    }
}