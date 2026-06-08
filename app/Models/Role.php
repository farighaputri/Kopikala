<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'access', 'status'];

 
    protected $casts = [
        'access' => 'array', 
        'status' => 'boolean'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
    
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}