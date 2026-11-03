<?php

namespace Tests\Feature;

use App\Models\Ayah;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublicPagesAndNavigationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_all_four_public_routes_return_200_with_correct_titles_and_layout_elements(): void
    {
        $routes = [
            ['name' => 'beranda', 'uri' => '/', 'title' => 'Beranda', 'heading' => 'Terangi Hari dengan Cahaya'],
            ['name' => 'quran.index', 'uri' => '/al-quran', 'title' => "Al-Qur'an", 'heading' => 'Daftar Surah'],
            ['name' => 'tahlil.index', 'uri' => '/tahlil', 'title' => 'Bacaan Tahlil', 'heading' => 'Tahlil'],
            ['name' => 'doa.index', 'uri' => '/doa', 'title' => 'Kumpulan Doa', 'heading' => 'Doa'],
        ];

        foreach ($routes as $page) {
            $this->assertSame($page['uri'], route($page['name'], absolute: false));

            $response = $this->get($page['uri']);

            $response->assertOk();
            $response->assertSee('<title>'.e($page['title']).' — '.e(config('app.name', 'Lentera Quran')).'</title>', false);
            $response->assertSee($page['heading']);
            $response->assertSee('wire:navigate', false);
            $response->assertSee('x-persist="audio-player"', false);
            $response->assertSee('id="lentera-audio-element"', false);
            $response->assertSee((string) config('quran.source_name'));
            $response->assertSee((string) config('quran.translator_name'));
        }
    }

    public function test_surah_detail_page_displays_real_surah_and_ayahs_from_database(): void
    {
        $surah = Surah::find(2) ?? Surah::factory()->create([
            'id' => 2,
            'nama_arab' => 'البقرة',
            'nama_latin' => 'Al-Baqarah',
            'arti' => 'Sapi Betina',
            'jumlah_ayat' => 286,
            'tempat_turun' => 'madinah',
        ]);

        $ayah = Ayah::where('surah_id', $surah->id)->where('nomor_ayat', 1)->first() ?? Ayah::factory()->create([
            'surah_id' => $surah->id,
            'nomor_ayat' => 1,
            'teks_arab' => 'الٓمٓ',
            'teks_latin' => 'Alif Lām Mīm.',
            'terjemahan' => 'Alif Lam Mim.',
            'juz' => 1,
        ]);

        $response = $this->get(route('quran.show', $surah));

        $response->assertOk();
        $response->assertSee('Al-Baqarah');
        $response->assertSee($surah->arti);
        if ($ayah) {
            $response->assertSee($ayah->teks_arab, false);
        }
    }

    public function test_tahlil_detail_page_displays_real_tahlil_item_in_surah_detail_layout(): void
    {
        $response = $this->get(route('tahlil.show', 1));

        $response->assertOk();
        $response->assertSee('Pengantar Al-Fatihah kepada Rasulullah SAW');
        $response->assertSee('Urutan Ke-1');
    }

    public function test_doa_category_detail_page_displays_all_doas_in_category(): void
    {
        $response = $this->get(route('doa.show', 'doa-shalat'));

        $response->assertOk();
        $response->assertSee('Doa Shalat & Sesudah Shalat');
        $response->assertSee('Doa Shalat Tahajud');
        $response->assertSee('Doa Shalat Tarawih (Doa Kamilin)');
    }

    public function test_navbar_displays_login_button_for_guest_and_logout_for_authenticated_user(): void
    {
        $guestResponse = $this->get('/');
        $guestResponse->assertOk();
        $guestResponse->assertSee('Masuk');

        $user = User::factory()->create();
        $authResponse = $this->actingAs($user)->get('/');
        $authResponse->assertOk();
        $authResponse->assertSee($user->name);
        $authResponse->assertSee('Keluar');
    }

    public function test_login_page_works_and_redirects_to_beranda_while_dashboard_is_removed(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk Akun');

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('beranda', absolute: false));

        $this->get('/dashboard')->assertNotFound();
    }
}

