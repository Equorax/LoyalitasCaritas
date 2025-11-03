<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamanTransaksi extends Model
{
    use HasFactory;

    // Tetapkan nama tabel karena berbeda dari konvensi jamak Eloquent
    protected $table = 'rekaman_transaksi'; // <-- Pastikan ini ada

    // Kolom yang bisa diisi secara massal
    // Tambahkan 'input_status' ke sini
    protected $fillable = [
        'pelanggan_id',
        'id_transaksi_input',
        'transaksi_id', // Bisa null jika tidak cocok
        'diskon_diberikan',
        'input_status', // <-- Tambahkan ini
    ];

    // Casting tipe data kolom
    // Tambahkan casting untuk 'input_status'
    protected $casts = [
        'diskon_diberikan' => 'boolean',
        'input_status' => 'string', // <-- Tambahkan ini
    ];

    // ... (relasi tetap sama seperti sebelumnya) ...
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'ID_Pelanggan');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'ID_Transaksi');
    }
}