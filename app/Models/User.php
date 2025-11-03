<?php

namespace App\Models;

// Tambahkan ini untuk menghindari error
use App\Models\Karyawan;
use App\Models\Pelanggan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    // Relasi ke tabel karyawan dan pelanggan
    // Kita harus memberi tahu Eloquent nama tabel yang benar
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id'); // Sesuaikan foreign key
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id'); // Sesuaikan foreign key
    }
}