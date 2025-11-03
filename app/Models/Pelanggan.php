<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Tetapkan nama tabel
    protected $table = 'pelanggan';

    // Tetapkan primary key jika bukan 'id'
    protected $primaryKey = 'ID_Pelanggan'; // Sesuaikan jika kamu menggunakannya
    public $incrementing = true; // Asumsikan AUTO_INCREMENT BIGINT
    // protected $keyType = 'int'; // Default untuk BIGINT, bisa diabaikan
    
    // Kolom yang bisa diisi
    protected $fillable = [
        'user_id',
        'Nama_Pelanggan',
        'Email_Pelanggan',
        'Frekuensi_Pembelian',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --- Tambahkan Relasi Berikut ---
    // Relasi: Pelanggan -> Transaksi (One to Many)
    // Foreign key di tabel transaksi adalah 'pelanggan_id' yang merujuk ke 'ID_Pelanggan'
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id', 'ID_Pelanggan');
    }

    // Relasi: Pelanggan -> RekamanTransaksi (One to Many)
    // Foreign key di tabel rekaman_transaksi adalah 'pelanggan_id' yang merujuk ke 'ID_Pelanggan'
    public function rekamanTransaksi()
    {
        return $this->hasMany(RekamanTransaksi::class, 'pelanggan_id', 'ID_Pelanggan');
    }
    
}