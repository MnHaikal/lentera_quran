<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\TahlilItem;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class ComprehensiveRouteTest extends TestCase
{
    public function test_all_authenticated_and_admin_routes_return_ok(): void
    {
        $superAdmin = User::where('role', Role::SUPER_ADMIN)->first() ?? User::factory()->create(['role' => Role::SUPER_ADMIN]);

        $routes = [
            '/tersimpan',
            '/pengaturan',
            '/profil',
            '/admin',
            '/admin/surah',
            '/admin/tahlil',
            '/admin/kategori-doa',
            '/admin/doa',
            '/admin/pengguna',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($superAdmin)->get($route);
            $this->assertSame(200, $response->getStatusCode(), "Route {$route} failed with status {$response->getStatusCode()}");
        }
    }

    public function test_user_can_save_settings(): void
    {
        $user = User::factory()->create(['role' => Role::USER]);

        $response = $this->actingAs($user)->put('/pengaturan', [
            'ukuran_font_arab' => 32,
            'tampilkan_latin' => true,
            'tampilkan_terjemahan' => true,
            'tema' => 'gelap',
        ]);

        $response->assertRedirect('/pengaturan');
        $this->assertDatabaseHas('user_settings', [
            'user_id' => $user->id,
            'ukuran_font_arab' => 32,
            'tema' => 'gelap',
        ]);
    }

    public function test_user_can_save_last_read(): void
    {
        $user = User::factory()->create(['role' => Role::USER]);

        $response = $this->actingAs($user)->postJson('/al-quran/1/terakhir-dibaca', [
            'ayah_id' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseHas('last_reads', [
            'user_id' => $user->id,
            'surah_id' => 1,
            'ayah_id' => 1,
        ]);
    }

    public function test_admin_can_crud_tahlil(): void
    {
        $admin = User::where('role', Role::ADMIN)->first() ?? User::factory()->create(['role' => Role::ADMIN]);

        $responseStore = $this->actingAs($admin)->post('/admin/tahlil', [
            'urutan' => 99,
            'judul' => 'Tahlil Test Unit',
            'teks_arab' => 'لا إله إلا الله',
            'teks_latin' => 'Laa ilaha illallah',
            'terjemahan' => 'Tiada Tuhan selain Allah',
            'jumlah_baca' => 33,
            'is_published' => true,
        ]);
        $responseStore->assertRedirect('/admin/tahlil');

        $tahlil = TahlilItem::where('urutan', 99)->first();
        $this->assertNotNull($tahlil);

        $responseUpdate = $this->actingAs($admin)->put("/admin/tahlil/{$tahlil->id}", [
            'urutan' => 99,
            'judul' => 'Tahlil Test Unit Revisi',
            'teks_arab' => 'لا إله إلا الله',
            'teks_latin' => 'Laa ilaha illallah',
            'terjemahan' => 'Tiada Tuhan selain Allah Yang Maha Esa',
            'jumlah_baca' => 100,
            'is_published' => true,
        ]);
        $responseUpdate->assertRedirect('/admin/tahlil');

        $responseDelete = $this->actingAs($admin)->delete("/admin/tahlil/{$tahlil->id}");
        $responseDelete->assertRedirect('/admin/tahlil');
        $this->assertDatabaseMissing('tahlil_items', ['id' => $tahlil->id]);
    }

    public function test_superadmin_can_crud_user(): void
    {
        $superAdmin = User::where('role', Role::SUPER_ADMIN)->first() ?? User::factory()->create(['role' => Role::SUPER_ADMIN]);
        $uniqueEmail = 'user_test_' . Str::random(8) . '@example.com';

        $responseStore = $this->actingAs($superAdmin)
            ->from('/admin/pengguna')
            ->post('/admin/pengguna', [
                'name' => 'Pengguna Uji Coba',
                'email' => $uniqueEmail,
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => Role::USER->value,
            ]);
        $responseStore->assertRedirect('/admin/pengguna');

        $createdUser = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($createdUser);

        $responseUpdate = $this->actingAs($superAdmin)
            ->from('/admin/pengguna')
            ->put("/admin/pengguna/{$createdUser->id}", [
                'name' => 'Pengguna Uji Coba Revisi',
                'email' => $uniqueEmail,
                'role' => Role::ADMIN->value,
            ]);
        $responseUpdate->assertRedirect('/admin/pengguna');

        $responseDelete = $this->actingAs($superAdmin)
            ->from('/admin/pengguna')
            ->delete("/admin/pengguna/{$createdUser->id}");
        $responseDelete->assertRedirect('/admin/pengguna');
        $this->assertDatabaseMissing('users', ['id' => $createdUser->id]);
    }
}
