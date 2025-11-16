<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Jika perlu query builder
use Illuminate\Support\Facades\Log; // Opsional, untuk logging
use League\Csv\Writer; // Library untuk membuat CSV
use League\Csv\EscapeFormula; // Opsional, untuk menghindari formula injection
use Symfony\Component\HttpFoundation\StreamedResponse; // Untuk response file

class ExportPelangganController extends Controller
{
    public function export()
    {
        // Pastikan hanya karyawan yang bisa mengakses
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Akses ditolak. Hanya karyawan yang dapat mengakses fitur ini.');
        }

        $fileName = 'data_pelanggan_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // BOM untuk UTF-8 (opsional, baca dokumentasi jika diperlukan)
            // fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Ambil nama kolom dari model atau definisikan manual
            // Kita gunakan nama kolom dari $fillable dan tambahkan kolom penting lainnya
            $columns = [
                'ID_Pelanggan',
                'user_id',
                'Nama_Pelanggan',
                'Email_Pelanggan',
                'Frekuensi_Pembelian',
                'created_at',
                'updated_at'
            ];
            fputcsv($file, $columns); // Baris header

            // Ambil data pelanggan dan tulis ke CSV
            // Gunakan chunk untuk efisiensi jika data sangat banyak
            Pelanggan::with('user') // Load relasi user jika diperlukan
                ->chunk(1000, function ($pelanggans) use ($file) {
                    foreach ($pelanggans as $pelanggan) {
                        // Buat array baris sesuai urutan kolom
                        $row = [
                            $pelanggan->ID_Pelanggan,
                            $pelanggan->user_id,
                            $pelanggan->Nama_Pelanggan,
                            $pelanggan->Email_Pelanggan,
                            $pelanggan->Frekuensi_Pembelian,
                            // Ubah format menjadi Y-m-d saja
                            $pelanggan->created_at ? $pelanggan->created_at->format('Y-M-d') : null,
                            // Ubah format menjadi Y-m-d saja
                            $pelanggan->updated_at ? $pelanggan->updated_at->format('Y-M-d') : null,
                        ];
                        fputcsv($file, $row);
                    }
                });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}