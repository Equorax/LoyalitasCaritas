<?php

namespace App\Http\Controllers;

use App\Models\RekamanTransaksi;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Import Rule untuk prohibitedIf

class InputNomorTransaksiController extends Controller
{
     public function create() // <-- Pastikan method ini ada dan publik
    {
        return view('input-nomor-transaksi');
    }

    public function store(Request $request)
    {
        $pelanggan = Auth::user()->pelanggan;
        $input_transaksi = $request->input('id_transaksi_input');

        // Cek apakah ID ini SUDAH PERNAH dimasukkan oleh pelanggan ini sebelumnya DAN statusnya SEKARANG adalah VALID
        $rekamanSebelumnyaValid = $pelanggan->rekamanTransaksi()
            ->where('id_transaksi_input', $input_transaksi)
            ->where('input_status', 'VALID') // Hanya cek jika sekarang statusnya VALID
            ->exists();

        // Definisikan aturan validasi
        $rules = [
            'id_transaksi_input' => [
                'required',
                'string',
                'min:17',
                'max:17',
                // Tambahkan aturan untuk mencegah input ulang yang SUDAH VALID sebelumnya
                Rule::prohibitedIf(
                    fn() => $rekamanSebelumnyaValid // Jika hasil cek di atas true
                    // Pesan error sekarang akan ditentukan di messages di bawah
                ),
            ],
        ];

        // Definisikan pesan error kustom
        $messages = [
            'id_transaksi_input.prohibited' => 'Nomor transaksi sudah digunakan dan tercatat.', // Pesan khusus untuk aturan prohibited
        ];

        // Jalankan validasi
        $validated = $request->validate($rules, $messages);

        // Jika validasi lolos, lanjutkan dengan logika sebelumnya untuk Skenario 1 & 2
        $rekamanSebelumnya = $pelanggan->rekamanTransaksi()
            ->where('id_transaksi_input', $input_transaksi)
            ->first();

        $transaksi = Transaksi::where('ID_Transaksi', $input_transaksi)->first();

        $inputStatus = 'INVALID'; // Default status
        $diskonDiberikan = false;
        $pesan = 'Nomor transaksi berhasil disimpan.';

        if ($transaksi) {
            $inputStatus = 'VALID';

            $bolehRedeem = ($transaksi->redeem_status === 'unredeemed' && (!$rekamanSebelumnya || $rekamanSebelumnya->input_status !== 'VALID'));

            if ($bolehRedeem) {
                $transaksi->update(['redeem_status' => 'redeemed']);
                $pelanggan->increment('Frekuensi_Pembelian');
            }

            $jumlahTransaksiValidSebelumnya = $pelanggan->rekamanTransaksi()
                ->where('input_status', 'VALID')
                ->count();

            $jumlahTotalTransaksiValid = $jumlahTransaksiValidSebelumnya + 1;

            if ($jumlahTotalTransaksiValid % 5 == 0) {
                $diskonDiberikan = true;
            }

            $pesan = $diskonDiberikan ? 'Nomor transaksi valid dan Anda mendapatkan diskon pada transaksi ke-5 Anda!' : 'Nomor transaksi valid.';
        } else {
             $pesan = 'Nomor transaksi tidak ditemukan di sistem.';
        }

        if ($rekamanSebelumnya) {
            if ($rekamanSebelumnya->input_status !== 'VALID' && $inputStatus === 'VALID') {
                $rekamanSebelumnya->update(['input_status' => $inputStatus]);
            }
        } else {
            RekamanTransaksi::create([
                'pelanggan_id' => $pelanggan->ID_Pelanggan,
                'id_transaksi_input' => $input_transaksi,
                'input_status' => $inputStatus,
            ]);
        }

        return redirect()->route('dashboard.pelanggan')->with('success', $pesan);
    }
}