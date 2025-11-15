<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Konfigurasi Primary Key karena bukan 'id'
    protected $primaryKey = 'ID_Transaksi';
    public $incrementing = false; // Karena bukan integer auto-increment
    protected $keyType = 'string'; // Karena tipe primary key adalah string

     protected $table = 'transaksi';

    protected $fillable = [
        'ID_Transaksi',
        'ID_Karyawan', // Pastikan ini merujuk ke ID_Karyawan di tabel karyawan
        'tanggal',
        'TotalHarga', // Tambahkan kolom baru
        'MetodePembayaran',
        'redeem_status',
    ];

    // Relasi: Transaksi -> Karyawan (Many to One)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'ID_Karyawan', 'karyawan_id'); // foreign key, local key
    }

    // Relasi: Transaksi -> Pelanggan (Many to One)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_Pelanggan', 'ID_Pelanggan'); // foreign key, local key
    }

    // Relasi: Transaksi -> DetailTransaksi (One to Many)
    // public function detailTransaksi()
    // {
    //     return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'ID_Transaksi');// foreign key, local key
    // }

    // Relasi: Transaksi -> RekamanTransaksi (One to One)
    public function rekamanTransaksi()
    {
        return $this->hasOne(RekamanTransaksi::class, 'ID_Transaksi', 'ID_Transaksi'); // foreign key, local key
    }
}