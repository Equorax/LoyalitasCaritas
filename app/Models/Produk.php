<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Jika Anda ingin nama tabel tetap 'produk' (tunggal), tambahkan baris ini:
    // protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'kategori', 
    ];

    // Relasi: Produk -> DetailTransaksi (One to Many)
    // (Relasi Produk ke Transaksi adalah Many-to-Many via DetailTransaksi)
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id', 'id');
    }
}