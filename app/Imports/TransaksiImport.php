<?php

namespace App\Imports;

use App\Models\Transaksi;
use App\Models\Karyawan; // Import model Karyawan
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithChunkReading; // Tetap import ini untuk mengatur chunk size
use Maatwebsite\Excel\Concerns\WithBatchInserts; // Tetap import ini
// Hapus baris berikut karena WithBatchInserts adalah class, bukan trait
// use Maatwebsite\Excel\Concerns\WithBatchInserts, Maatwebsite\Excel\Concerns\WithChunkReading;

// Extends dari WithBatchInserts untuk mendapatkan fungsionalitas batch insert
class TransaksiImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    // Karena kita extends WithBatchInserts, kita bisa override method batchSize()
    public function batchSize(): int
    {
        return 1000; // Sesuaikan dengan kebutuhan Anda
    }

    // Karena kita implements WithChunkReading, kita harus menyediakan method chunkSize()
    public function chunkSize(): int
    {
        return 1000; // Sesuaikan dengan kebutuhan Anda
    }

    public function model(array $row)
    {
        // 1. Ambil id_user dari CSV
        $id_user_csv = $row['id_user']; // Nama header CSV: id_user

        // 2. Ekstrak angka dari id_user (mengabaikan awalan seperti K00, M00)
        // Kita asumsikan formatnya adalah [3 karakter awal][angka]
        // Misalnya: K001, K0010, M002, dll.
        // Pola: 1 huruf kapital diikuti 2 angka
        $angka_user = preg_replace('/^[A-Z]{1}[0-9]{2}/', '', $id_user_csv);

        if (!is_numeric($angka_user)) {
            \Log::warning("Format id_user CSV tidak valid: {$id_user_csv}. Tidak dapat mengekstrak angka.");
            return null; // Lewati baris ini jika format tidak valid
        }

        // 3. Cari ID_Karyawan berdasarkan user_id (angka_user harus sesuai dengan user_id di tabel karyawan)
        // Kolom 'user_id' di tabel 'karyawan' merujuk ke kolom 'id' di tabel 'users'.
        // Proses registrasi membuat entri di 'users', lalu membuat entri di 'karyawan' dengan 'user_id' yang sama.
        $karyawan = Karyawan::where('user_id', $angka_user)->first();

        if (!$karyawan) {
            // Jika tidak ditemukan karyawan untuk user_id ini, log pesan dan lewati baris
            \Log::warning("Karyawan tidak ditemukan untuk user_id (dari CSV: {$id_user_csv}, diekstrak: {$angka_user}). Transaksi tidak akan diimpor.", ['csv_user_id' => $id_user_csv, 'extracted_user_id' => $angka_user]);
            return null; // Lewati baris ini
        }

        // 4. Dapatkan ID_Karyawan yang benar dari model yang ditemukan
        // Kolom 'ID_Karyawan' adalah primary key di tabel 'karyawan'.
        $karyawan_id_yang_digunakan = $karyawan->ID_Karyawan;

        // 5. Buat instance model Transaksi dengan data yang diproses
        // Kolom 'tanggal' di CSV dalam format m/d/Y, ubah ke Y-m-d untuk kolom date
        $tanggal_php = \DateTime::createFromFormat('m/d/Y', $row['tanggal']);
        $tanggal_db = $tanggal_php ? $tanggal_php->format('Y-m-d') : null;

        return new Transaksi([
            'ID_Transaksi'      => $row['id_transaksi'], // Nama header CSV: id_transaksi
            'karyawan_id'       => $karyawan_id_yang_digunakan, // Gunakan ID_Karyawan dari tabel karyawan
            'tanggal'           => $tanggal_db, // Gunakan tanggal yang sudah diformat
            'TotalHarga'        => $row['totalharga'],  // Nama header CSV: totalharga
            'MetodePembayaran'  => $row['metode_pembayaran'], // Nama header CSV: metode_pembayaran
            'redeem_status'     => 'unredeemed', // Nilai default
            // Kolom created_at dan updated_at akan diisi otomatis oleh Laravel jika timestamps() aktif
        ]);
    }

    // // Karena sekarang kita implements WithChunkReading, method ini HARUS ada
    // public function chunkSize(): int
    // {
    //     return 1000; // Sesuaikan dengan kebutuhan Anda
    // }
    // // Karena sekarang kita extends WithBatchInserts, method ini bisa di-override
    // public function batchSize(): int
    // {
    //     return 1000; // Sesuaikan dengan kebutuhan Anda
    // }
}