<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_guests_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_panel_and_gets_403(): void
    {
        $user = User::where('role', Role::USER)->first() ?? User::factory()->create(['role' => Role::USER]);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', Role::ADMIN)->first() ?? User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_cannot_manage_users_and_gets_403(): void
    {
        $admin = User::where('role', Role::ADMIN)->first() ?? User::factory()->create(['role' => Role::ADMIN]);

        $response = $this->actingAs($admin)->get('/admin/pengguna');
        $response->assertStatus(403);
    }

    public function test_super_admin_can_manage_users(): void
    {
        $superAdmin = User::where('role', Role::SUPER_ADMIN)->first() ?? User::factory()->create(['role' => Role::SUPER_ADMIN]);

        $response = $this->actingAs($superAdmin)->get('/admin/pengguna');
        $response->assertStatus(200);
    }
}

