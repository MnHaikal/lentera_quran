<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\OtpVerificationMail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Pastikan email belum terdaftar
        if (User::where('email', $validated['email'])->exists()) {
            return back()->withInput()->withErrors([
                'email' => 'Alamat email ini sudah terdaftar. Silakan masuk ke akun Anda.',
            ]);
        }

        // Generate kode OTP 6 digit
        $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus data OTP tertunda sebelumnya untuk email ini jika ada
        EmailOtp::where('email', $validated['email'])->delete();

        // Simpan data pendaftaran sementara dengan kedaluwarsa 10 menit
        EmailOtp::create([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Simpan email di session untuk halaman OTP
        $request->session()->put('pending_otp_email', $validated['email']);

        // Kirim email OTP
        try {
            Mail::to($validated['email'])->send(new OtpVerificationMail($validated['name'], $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email OTP saat pendaftaran: ' . $e->getMessage());
        }

        Log::info("Kode OTP verifikasi dibuat untuk {$validated['email']}: {$otp}");

        return redirect()->route('register.otp.notice');
    }
}
