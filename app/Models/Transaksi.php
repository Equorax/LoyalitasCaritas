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
        'karyawan_id', // Pastikan ini merujuk ke ID_Karyawan di tabel karyawan
        'pelanggan_id', // Pastikan ini merujuk ke ID_Pelanggan di tabel pelanggan
        'tanggal',
    ];

    // Relasi: Transaksi -> Karyawan (Many to One)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'ID_Karyawan');
    }

    // Relasi: Transaksi -> Pelanggan (Many to One)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'ID_Pelanggan');
    }

    // Relasi: Transaksi -> DetailTransaksi (One to Many)
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'ID_Transaksi');
    }

    // Relasi: Transaksi -> RekamanTransaksi (One to One)
    public function rekamanTransaksi()
    {
        return $this->hasOne(RekamanTransaksi::class, 'transaksi_id', 'ID_Transaksi');
    }
}