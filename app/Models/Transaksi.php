<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Transaksi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'transaksi';

    // Ganti 'ID_Karyawan' menjadi 'karyawan_id'
    protected $fillable = [
        'ID_Transaksi',
        'karyawan_id', // <-- Diubah dari 'ID_Karyawan'
        'tanggal',
        'TotalHarga',
        'MetodePembayaran',
        'redeem_status',
    ];


    // Relasi: Transaksi -> Karyawan (Many to One)
    public function karyawan()
    {
        // foreign key di tabel transaksi, local key di tabel karyawan
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'ID_Karyawan');
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