<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'staff_id',
        'name',
        'email',
        'password',
        'branch_id',
        'role_id',
        'status',
        'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Pengecekan Hak Akses Berdasarkan Tabel Database (RBAC Full)
     */
    public function hasPermission($name)
{
    // 1. Jika staff tidak punya role, otomatis tolak
    if (!$this->role) {
        return false;
    }

    // 2. KUNCI BYPASS: Master Admin otomatis selalu lolos
    if ($this->role->name === 'Master Admin' || $this->role_id == 1) {
        return true;
    }

    // 3. FIX UTAMA: Gunakan query builder 'where' untuk memeriksa keberadaan permission di tabel pivot database
    return $this->role->permissions()->where('name', $name)->exists();
}
}