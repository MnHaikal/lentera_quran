<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna & peran.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filter Pencarian (nama atau email)
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Peran (super_admin, admin, user)
        if ($peran = $request->input('peran')) {
            if (in_array($peran, ['super_admin', 'admin', 'user'], true)) {
                $query->where('role', $peran);
            }
        }

        // Filter Status Email (terverifikasi / belum)
        if ($statusEmail = $request->input('status_email')) {
            if ($statusEmail === 'terverifikasi') {
                $query->whereNotNull('email_verified_at');
            } elseif ($statusEmail === 'belum') {
                $query->whereNull('email_verified_at');
            }
        }

        // Urutkan ID asc atau terdaftar
        $users = $query->orderBy('id', 'asc')->paginate(5)->withQueryString();

        $totalUsers = User::count();
        $surahCount = Surah::count() ?: 114;
        $tahlilCount = TahlilItem::count() ?: 24;
        $doaCount = Doa::count() ?: 185;
        $doaCategoryCount = DoaCategory::count() ?: 12;

        return view('admin.users.index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'doaCategoryCount' => $doaCategoryCount,
            'userCount' => $totalUsers,
        ]);
    }

    /**
     * Tambah pengguna baru oleh Super Admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_verified' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'role.required' => 'Peran pengguna wajib dipilih.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $email = Str::lower(trim($validated['email']));

        DB::transaction(function () use ($validated, $email, $request) {
            $user = User::forceCreate([
                'name' => trim($validated['name']),
                'email' => $email,
                'password' => Hash::make($validated['password']),
                'role' => Role::from($validated['role']),
                'email_verified_at' => $request->boolean('is_verified') ? now() : null,
            ]);

            $user->userSetting()->create([
                'ukuran_font_arab' => 28,
                'tampilkan_latin' => true,
                'tampilkan_terjemahan' => true,
                'tema' => 'sistem',
            ]);
        });

        return redirect()
            ->back()
            ->with('success', "Pengguna '{$validated['name']}' ({$email}) berhasil ditambahkan.");
    }

    /**
     * Perbarui peran atau status pengguna.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'is_verified' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah terdaftar pada pengguna lain.',
            'role.required' => 'Peran pengguna wajib dipilih.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        // Proteksi: Super Admin tidak boleh menurunkan perannya sendiri jika dia satu-satunya Super Admin
        if ($user->id === Auth::id() && $user->role->isSuperAdmin() && $validated['role'] !== 'super_admin') {
            $superAdminCount = User::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return redirect()
                    ->back()
                    ->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri karena Anda adalah satu-satunya Super Admin.');
            }
        }

        $email = Str::lower(trim($validated['email']));

        $user->name = trim($validated['name']);
        $user->email = $email;
        $user->role = Role::from($validated['role']);

        if ($request->boolean('is_verified')) {
            $user->email_verified_at = $user->email_verified_at ?? now();
        } else {
            $user->email_verified_at = null;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->back()
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus pengguna dari platform.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Proteksi 1: Tidak dapat menghapus akun sendiri
        if ($user->id === Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Proteksi 2: Tidak dapat menghapus sesama Super Admin
        if ($user->role->isSuperAdmin()) {
            return redirect()
                ->back()
                ->with('error', 'Akun dengan peran Super Admin tidak dapat dihapus demi keamanan sistem.');
        }

        $userName = $user->name;
        $user->userSetting()->delete();
        $user->bookmarks()->delete();
        $user->lastRead()->delete();
        $user->delete();

        return redirect()
            ->back()
            ->with('success', "Pengguna '{$userName}' berhasil dihapus.");
    }
}

