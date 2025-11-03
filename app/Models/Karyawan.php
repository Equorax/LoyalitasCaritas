<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan'; // Nama tabel sesuai migrasi
    protected $primaryKey = 'ID_Karyawan'; // Primary key sesuai migrasi
    public $incrementing = true; // Asumsikan AUTO_INCREMENT BIGINT
    // protected $keyType = 'int'; // Default untuk BIGINT, bisa diabaikan

    protected $fillable = [
        'user_id',
        'Nama_Karyawan',
        'Username',
        'Email_Karyawan',
        'Nomor_Hp',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --- Tambahkan Relasi Berikut ---
    // Relasi: Karyawan -> Transaksi (One to Many)
    // Foreign key di tabel transaksi adalah 'karyawan_id' yang merujuk ke 'ID_Karyawan'
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'karyawan_id', 'ID_Karyawan');
    }
    // ---
}