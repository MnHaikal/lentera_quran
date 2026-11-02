<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', Role::SuperAdmin)->exists()) {
            return;
        }

        $email = env('SUPERADMIN_EMAIL');
        $password = env('SUPERADMIN_PASSWORD');

        if (! $email || ! $password) {
            return;
        }

        $name = (string) env('SUPERADMIN_NAME', 'Super Admin');

        $user = User::firstOrNew(['email' => $email]);
        $user->forceFill([
            'name' => $name,
            'password' => Hash::make($password),
            'role' => Role::SuperAdmin,
            'email_verified_at' => now(),
        ])->save();

        $user->userSetting()->firstOrCreate([], [
            'ukuran_font_arab' => 28,
            'tampilkan_latin' => true,
            'tampilkan_terjemahan' => true,
            'tema' => 'sistem',
        ]);
    }
}
