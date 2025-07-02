<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir untuk mengedit profil pengguna.
     * Untuk apa: Memberikan pengguna antarmuka untuk melihat dan memperbarui informasi pribadi mereka.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Mengirimkan objek pengguna yang sedang login ke view
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna di database.
     * Untuk apa: Menyimpan perubahan data profil yang diinput pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated()); // Mengisi model pengguna dengan data yang sudah divalidasi

        // Mengatur ulang status verifikasi email jika email diubah
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save(); // Menyimpan perubahan profil pengguna ke database

        // Mengarahkan kembali ke halaman edit profil dengan pesan status
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     * Untuk apa: Memberikan opsi kepada pengguna untuk menghapus akun mereka secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Memvalidasi input kata sandi pengguna untuk konfirmasi penghapusan akun
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], // Kata sandi harus diisi dan cocok dengan kata sandi saat ini
        ]);

        $user = $request->user(); // Mendapatkan objek pengguna yang akan dihapus

        Auth::logout(); // Mengeluarkan pengguna dari sesi

        $user->delete(); // Menghapus record pengguna dari database

        $request->session()->invalidate(); // Mengakhiri sesi pengguna
        $request->session()->regenerateToken(); // Meregenerasi token CSRF sesi

        return Redirect::to('/'); // Mengarahkan pengguna ke halaman utama setelah akun dihapus
    }
}