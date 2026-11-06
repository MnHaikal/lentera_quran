<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\EmailChangeOtpMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman informasi profil pengguna.
     */
    public function edit(Request $request): View
    {
        $viewName = view()->exists('akun.profil') ? 'akun.profil' : 'profile.edit';

        return view($viewName, [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui informasi nama profil pengguna.
     */
    public function updateName(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
        ]);

        $user = $request->user();
        $user->name = trim($validated['name']);
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Nama lengkap berhasil diperbarui.',
                'name' => $user->name,
            ]);
        }

        return Redirect::route('profile.edit')->with('success', 'Nama lengkap berhasil diperbarui.');
    }

    /**
     * Kirim tautan konfirmasi atur ulang kata sandi ke email pengguna.
     */
    public function sendPasswordResetLink(Request $request): RedirectResponse
    {
        $user = $request->user();

        try {
            $status = Password::sendResetLink(['email' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim tautan atur ulang kata sandi dari profil: ' . $e->getMessage());

            return Redirect::route('profile.edit')->withErrors([
                'password_reset' => 'Terjadi kendala saat mengirim email. Pastikan koneksi internet aktif atau coba beberapa saat lagi.',
            ]);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return Redirect::route('profile.edit')->with('success', 'Tautan untuk mengatur ulang kata sandi berhasil dikirim ke alamat email Anda (' . $user->email . '). Silakan periksa kotak masuk atau spam email Anda dan klik tautan tersebut.');
        }

        return Redirect::route('profile.edit')->withErrors([
            'password_reset' => __($status),
        ]);
    }

    /**
     * Kirim kode OTP 6 digit ke alamat email baru untuk validasi.
     */
    public function sendEmailOtp(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'new_email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:150',
                Rule::notIn([$user->email]),
                Rule::unique(User::class, 'email')->ignore($user->id),
            ],
        ], [
            'new_email.required' => 'Alamat email baru wajib diisi.',
            'new_email.email' => 'Format alamat email tidak valid (contoh: nama@email.com).',
            'new_email.not_in' => 'Alamat email baru harus berbeda dari email Anda saat ini.',
            'new_email.unique' => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
        ]);

        $newEmail = strtolower(trim($validated['new_email']));
        $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        $payload = [
            'new_email' => $newEmail,
            'otp' => $otp,
            'expires_at' => $expiresAt->timestamp,
        ];

        Cache::put("profile_email_otp_{$user->id}", $payload, $expiresAt);
        $request->session()->put('pending_email_change', $payload);

        try {
            Mail::to($newEmail)->send(new EmailChangeOtpMail($user->name, $newEmail, $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim kode OTP perubahan email: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim email verifikasi ke alamat tersebut. Pastikan alamat email aktif dan valid.',
                ], 422);
            }

            return back()->withInput()->withErrors([
                'new_email' => 'Gagal mengirim email verifikasi ke alamat tersebut. Pastikan alamat email aktif dan valid.',
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Kode OTP 6 digit telah dikirim ke {$newEmail}.",
                'new_email' => $newEmail,
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('success', "Kode OTP 6 digit telah dikirim ke {$newEmail}. Silakan masukkan kode OTP untuk memverifikasi.")
            ->with('pending_email_step', true);
    }

    /**
     * Verifikasi kode OTP dan simpan alamat email baru.
     */
    public function verifyEmailOtp(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $rawOtp = (string) $request->input('otp', '');
        $cleanedOtp = preg_replace('/[^0-9]/', '', $rawOtp);
        $request->merge(['otp' => $cleanedOtp]);

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP 6 digit wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $cacheKey = "profile_email_otp_{$user->id}";
        $pending = Cache::get($cacheKey) ?? $request->session()->get('pending_email_change');

        if (! $pending) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi verifikasi OTP telah kedaluwarsa atau belum diminta. Silakan kirim ulang kode OTP.',
                ], 422);
            }

            return Redirect::route('profile.edit')->withErrors([
                'otp' => 'Sesi verifikasi OTP telah kedaluwarsa atau belum diminta. Silakan kirim ulang kode OTP.',
            ]);
        }

        if (now()->timestamp > (int) $pending['expires_at']) {
            Cache::forget($cacheKey);
            $request->session()->forget('pending_email_change');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP telah kedaluwarsa. Silakan kirim ulang kode OTP baru.',
                ], 422);
            }

            return Redirect::route('profile.edit')->withErrors([
                'otp' => 'Kode OTP telah kedaluwarsa. Silakan kirim ulang kode OTP baru.',
            ]);
        }

        if (trim($pending['otp']) !== $cleanedOtp) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali pesan email Anda.',
                ], 422);
            }

            return back()->withInput()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali pesan email Anda.',
            ]);
        }

        $newEmail = $pending['new_email'];

        // Cek kembali apakah email baru sudah diambil orang lain saat menunggu OTP
        if (User::where('email', $newEmail)->where('id', '!=', $user->id)->exists()) {
            Cache::forget($cacheKey);
            $request->session()->forget('pending_email_change');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
                ], 422);
            }

            return Redirect::route('profile.edit')->withErrors([
                'otp' => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
            ]);
        }

        $user->email = $newEmail;
        $user->email_verified_at = now();
        $user->save();

        Cache::forget($cacheKey);
        $request->session()->forget('pending_email_change');

        if ($request->expectsJson()) {
            $request->session()->flash('success', "Alamat email akun Anda berhasil diperbarui menjadi {$user->email}.");

            return response()->json([
                'success' => true,
                'message' => "Alamat email akun Anda berhasil diperbarui menjadi {$user->email}.",
                'email' => $user->email,
            ]);
        }

        return Redirect::route('profile.edit')->with('success', "Alamat email akun Anda berhasil diperbarui menjadi {$user->email}.");
    }

    /**
     * Mempertahankan kompatibilitas update bawaan.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $redirectRoute = $request->routeIs('profil.*') ? 'profil.edit' : 'profile.edit';

        return Redirect::route($redirectRoute)
            ->with('status', 'profile-updated')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Hapus akun pengguna secara permanen setelah konfirmasi kata sandi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
