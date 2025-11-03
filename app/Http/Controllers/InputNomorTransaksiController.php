<?php

namespace App\Http\Controllers;

use App\Models\RekamanTransaksi;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InputNomorTransaksiController extends Controller
{
     public function create() // <-- Pastikan method ini ada dan publik
    {
        return view('input-nomor-transaksi');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_transaksi_input' => [
                'required',
                'string',
                'min:17',
                'max:17',
                Rule::unique('rekaman_transaksi', 'id_transaksi_input')->where(function ($query) {
                    return $query->where('pelanggan_id', Auth::user()->pelanggan->ID_Pelanggan);
                }),
            ],
        ]);

        $pelanggan = Auth::user()->pelanggan;
        $input_transaksi = $validated['id_transaksi_input'];

        // Cari transaksi di tabel transaksi berdasarkan id_transaksi_input
        $transaksi = Transaksi::where('ID_Transaksi', $input_transaksi)->first();

        // Tentukan status input dan diskon
        $inputStatus = 'INVALID'; // Default status adalah 'INVALID'
        $diskonDiberikan = false;
        $transaksiId = null;

        if ($transaksi) {
            $inputStatus = 'VALID'; // Ubah status menjadi 'VALID' jika cocok
            $transaksiId = $transaksi->ID_Transaksi;

            // Hitung jumlah transaksi VALID sebelumnya YANG TELAH DISIMPAN DI DB dengan status 'VALID'
            $jumlahTransaksiValidSebelumnya = $pelanggan->rekamanTransaksi()
                ->where('input_status', 'VALID') // Gunakan kolom yang sekarang ada di DB
                ->count();

            $jumlahTotalTransaksiValid = $jumlahTransaksiValidSebelumnya + 1;

            if ($jumlahTotalTransaksiValid % 5 == 0) {
                $diskonDiberikan = true;
            }
        }

        // Simpan rekaman transaksi
        // SEKARANG kita bisa menyertakan 'input_status' karena kolomnya ada di DB dan kita atur nilainya
        RekamanTransaksi::create([
            'pelanggan_id' => $pelanggan->ID_Pelanggan,
            'id_transaksi_input' => $input_transaksi,
            'transaksi_id' => $transaksiId,
            'diskon_diberikan' => $diskonDiberikan,
            'input_status' => $inputStatus, // <-- Sekarang kita simpan status ke DB
        ]);

        $pesan = 'Nomor transaksi berhasil disimpan.';
        if ($inputStatus === 'INVALID') {
             $pesan = 'Nomor transaksi tidak ditemukan di sistem.';
        } elseif ($diskonDiberikan) {
             $pesan = 'Nomor transaksi valid dan Anda mendapatkan diskon pada transaksi ini!';
        }

        return redirect()->route('dashboard.pelanggan')->with('success', $pesan);
    }
}