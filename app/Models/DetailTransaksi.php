<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id', // Merujuk ke ID_Transaksi
        'produk_id',
        'jumlah',
        'subtotal',
    ];

    // Relasi: DetailTransaksi -> Transaksi (Many to One)
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'ID_Transaksi');
    }

    // Relasi: DetailTransaksi -> Produk (Many to One)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}