<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_name',
        'location',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'branch_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'branch_id');
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'branch_id');
    }
}
