<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\Theme;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $name = (string) config('app.superadmin_name', env('SUPERADMIN_NAME', 'Super Admin'));
        $email = (string) config('app.superadmin_email', env('SUPERADMIN_EMAIL', 'superadmin@lenteraquran.com'));
        $password = (string) config('app.superadmin_password', env('SUPERADMIN_PASSWORD', 'password123'));

        $user = User::firstOrNew(['email' => $email]);
        $user->forceFill([
            'name' => $name,
            'password' => Hash::make($password),
            'role' => Role::SUPER_ADMIN,
            'email_verified_at' => now(),
        ])->save();

        UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'ukuran_font_arab' => 28,
                'tampilkan_latin' => true,
                'tampilkan_terjemahan' => true,
                'tema' => Theme::SISTEM,
            ]
        );
    }
}
