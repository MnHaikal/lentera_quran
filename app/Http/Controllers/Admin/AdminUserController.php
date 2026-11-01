<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Enums\Theme;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $role = $request->query('role');

        $query = User::latest();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if (!empty($role) && in_array($role, Role::values(), true)) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::cases();

        return view('admin.pengguna.index', compact('users', 'roles', 'q', 'role'));
    }

    public function create(): View
    {
        $roles = Role::cases();

        return view('admin.pengguna.create', compact('roles'));
    }

    public function store(AdminUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        DB::transaction(function () use ($data) {
            $user = User::create($data);

            UserSetting::create([
                'user_id' => $user->id,
                'ukuran_font_arab' => 28,
                'tampilkan_latin' => true,
                'tampilkan_terjemahan' => true,
                'tema' => Theme::SISTEM,
            ]);
        });

        return redirect()->route('admin.pengguna.index')
            ->with('status', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $roles = Role::cases();

        return view('admin.pengguna.edit', compact('user', 'roles'));
    }

    public function update(AdminUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('status', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user, Request $request): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('status', 'Pengguna berhasil dihapus.');
    }
}
