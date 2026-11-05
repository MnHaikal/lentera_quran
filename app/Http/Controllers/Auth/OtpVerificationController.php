<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('pending_otp_email');

        if (! $email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi verifikasi tidak ditemukan. Silakan isi form pendaftaran.']);
        }

        $pending = EmailOtp::where('email', $email)->first();

        if (! $pending) {
            $request->session()->forget('pending_otp_email');

            return redirect()->route('register')
                ->withErrors(['email' => 'Data pendaftaran telah kedaluwarsa. Silakan daftar kembali.']);
        }

        $remainingSeconds = max(0, (int) now()->diffInSeconds($pending->expires_at, false));

        return view('auth.verify-otp', [
            'email' => $email,
            'name' => $pending->name,
            'expiresAt' => $pending->expires_at,
            'remainingSeconds' => $remainingSeconds,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $email = $request->session()->get('pending_otp_email');

        if (! $email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi verifikasi telah kedaluwarsa. Silakan daftar kembali.']);
        }

        // Bersihkan input OTP dari spasi atau karakter non-angka
        $rawOtp = (string) $request->input('otp', '');
        $cleanedOtp = preg_replace('/[^0-9]/', '', $rawOtp);
        $request->merge(['otp' => $cleanedOtp]);

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP 6 digit wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $pending = EmailOtp::where('email', $email)->first();

        if (! $pending) {
            $request->session()->forget('pending_otp_email');

            return redirect()->route('register')
                ->withErrors(['email' => 'Data pendaftaran tidak ditemukan atau telah kedaluwarsa.']);
        }

        if ($pending->isExpired()) {
            return back()->withErrors([
                'otp' => 'Kode OTP telah kedaluwarsa. Silakan klik "Kirim Ulang" di bawah ini.',
            ]);
        }

        if (trim($pending->otp) !== $cleanedOtp) {
            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali pesan email Anda.',
            ]);
        }

        // Cek lagi apakah email sudah pernah terdaftar saat menunggu OTP
        if (User::where('email', $email)->exists()) {
            $pending->delete();
            $request->session()->forget('pending_otp_email');

            return redirect()->route('login')->with('status', 'Alamat email ini sudah terdaftar. Silakan masuk.');
        }

        // Buat akun pengguna dan preferensi tilawah
        $user = DB::transaction(function () use ($pending): User {
            $user = User::create([
                'name' => $pending->name,
                'email' => $pending->email,
                'password' => $pending->password,
                'email_verified_at' => now(),
            ]);

            $user->userSetting()->create([
                'ukuran_font_arab' => 28,
                'tampilkan_latin' => true,
                'tampilkan_terjemahan' => true,
                'tema' => 'sistem',
            ]);

            return $user;
        });

        // Hapus data OTP yang sudah terverifikasi
        $pending->delete();
        $request->session()->forget('pending_otp_email');

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('beranda')
            ->with('success', 'Alhamdulillah! Akun Anda berhasil diverifikasi dan terdaftar di Lentera Quran.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $email = $request->session()->get('pending_otp_email');

        if (! $email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi pendaftaran tidak ditemukan. Silakan daftar kembali.']);
        }

        $pending = EmailOtp::where('email', $email)->first();

        if (! $pending) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Data pendaftaran tidak ditemukan. Silakan daftar kembali.']);
        }

        // Throttle pengiriman ulang (minimal jeda 45 detik)
        $secondsSinceLastUpdate = (int) $pending->updated_at->diffInSeconds(now());
        if ($secondsSinceLastUpdate < 45) {
            $wait = 45 - $secondsSinceLastUpdate;

            return back()->withErrors([
                'otp' => "Mohon tunggu {$wait} detik sebelum meminta kode OTP baru.",
            ]);
        }

        // Buat kode OTP 6 digit baru
        $newOtp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $pending->update([
            'otp' => $newOtp,
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($email)->send(new OtpVerificationMail($pending->name, $newOtp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email OTP ulang: ' . $e->getMessage());
        }

        Log::info("Kode OTP baru dikirim ke {$email}: {$newOtp}");

        return back()->with('status', 'Kode OTP baru telah berhasil dikirim ke alamat email Anda.');
    }
}
