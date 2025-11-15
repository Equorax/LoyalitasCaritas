<?php

namespace App\Http\Controllers;

use App\Imports\TransaksiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class UploadTransaksiController extends Controller
{
    /**
     * Tampilkan form upload.
     */
    public function showForm()
    {
        return view('upload-transaksi-form'); // Pastikan view ini dibuat
    }

    /**
     * Proses upload file CSV.
     */
    public function processUpload(Request $request)
    {
        // Validasi file: hanya menerima CSV
        $request->validate([
            'file' => 'required|mimes:csv,txt' // 'txt' terkadang digunakan untuk CSV plain text
        ]);

        try {
            // Lakukan import menggunakan TransaksiImport yang akan kita buat/update
            Excel::import(new TransaksiImport, $request->file('file'));

            return Redirect::back()->with('success', 'File CSV berhasil diupload dan diproses!');
        } catch (\Exception $e) {
            Log::error('Error Upload Transaksi: ' . $e->getMessage()); // Log error untuk debugging
            return Redirect::back()->withErrors('Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }
}