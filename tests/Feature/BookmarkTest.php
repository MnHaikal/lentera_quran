<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Bookmark;
use App\Models\User;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    public function test_guests_cannot_toggle_bookmark(): void
    {
        $response = $this->post('/al-quran/1/simpan');
        $response->assertRedirect('/login');
    }

    public function test_user_can_toggle_surah_bookmark(): void
    {
        $user = User::where('role', Role::USER)->first() ?? User::factory()->create(['role' => Role::USER]);

        $response = $this->actingAs($user)->postJson('/al-quran/1/simpan');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'created',
            'bookmarked' => true,
        ]);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'bookmarkable_type' => 'surah',
            'bookmarkable_id' => 1,
        ]);

        $responseOff = $this->actingAs($user)->postJson('/al-quran/1/simpan');
        $responseOff->assertStatus(200);
        $responseOff->assertJson([
            'status' => 'deleted',
            'bookmarked' => false,
        ]);

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'bookmarkable_type' => 'surah',
            'bookmarkable_id' => 1,
        ]);
    }

    public function test_user_bookmarks_are_isolated(): void
    {
        $userA = User::factory()->create(['role' => Role::USER]);
        $userB = User::factory()->create(['role' => Role::USER]);

        Bookmark::create([
            'user_id' => $userA->id,
            'bookmarkable_type' => 'surah',
            'bookmarkable_id' => 1,
        ]);

        $response = $this->actingAs($userB)->get('/tersimpan');
        $response->assertStatus(200);
        $response->assertDontSee('Disimpan ' . $userA->name);
    }

    public function test_user_can_update_bookmark_note(): void
    {
        $user = User::factory()->create(['role' => Role::USER]);
        $bookmark = Bookmark::create([
            'user_id' => $user->id,
            'bookmarkable_type' => 'surah',
            'bookmarkable_id' => 1,
            'catatan' => 'Catatan awal',
        ]);

        $response = $this->actingAs($user)->patchJson("/tersimpan/{$bookmark->id}/catatan", [
            'catatan' => 'Catatan revisi untuk murojaah',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'catatan' => 'Catatan revisi untuk murojaah',
        ]);

        $this->assertDatabaseHas('bookmarks', [
            'id' => $bookmark->id,
            'catatan' => 'Catatan revisi untuk murojaah',
        ]);
    }

    public function test_other_user_cannot_update_bookmark_note(): void
    {
        $userA = User::factory()->create(['role' => Role::USER]);
        $userB = User::factory()->create(['role' => Role::USER]);

        $bookmark = Bookmark::create([
            'user_id' => $userA->id,
            'bookmarkable_type' => 'surah',
            'bookmarkable_id' => 1,
            'catatan' => 'Catatan User A',
        ]);

        $response = $this->actingAs($userB)->patchJson("/tersimpan/{$bookmark->id}/catatan", [
            'catatan' => 'Mencoba ubah catatan orang lain',
        ]);

        $response->assertStatus(403);
    }
}
