<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:30', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nomor_hp' => ['sometimes', 'string', 'max:12'], // Contoh: hanya jika karyawan
        ]);

        // --- Logika Penentuan Role ---
        // Misalnya: jika email berisi domain tertentu (ganti dengan yang kamu inginkan)
        $email = strtolower($request->email); // Konversi ke huruf kecil untuk pencocokan
        $karyawanEmailMarker = 'kcaritas'; // Ganti dengan domain atau kata kunci karyawan kamu

        $role = 'pelanggan'; // Default role
        if (str_contains($email, $karyawanEmailMarker)) {
            $role = 'karyawan';
        }

        // --- Akhir Logika Penentuan Role ---

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Gunakan role yang ditentukan otomatis
        ]);

        if ($role === 'karyawan') {
            // Pastikan field yang diperlukan di tabel karyawan diisi
            Karyawan::create([
                'user_id' => $user->id,
                'Nama_Karyawan' => $request->name,
                'Username' => explode('@', $request->email)[0], // username dari email
                // HAPUS 'Kata_Sandi' => $request->password, // Jangan simpan password plain text!
                'Email_Karyawan' => $request->email,
                'Nomor_Hp' => $request->nomor_hp ?? '000000000000', // Gunakan input nomor_hp atau default
            ]);
        } else { // $role === 'pelanggan'
            Pelanggan::create([
                'user_id' => $user->id,
                'Nama_Pelanggan' => $request->name,
                // HAPUS 'Kata_Sandi' => $request->password, // Jangan simpan password plain text!
                'Email_Pelanggan' => $request->email,
                'Frekuensi_Pembelian' => 0,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}