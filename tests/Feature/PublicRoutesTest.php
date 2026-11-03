<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    public function test_beranda_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_quran_index_page_is_accessible(): void
    {
        $response = $this->get('/al-quran');
        $response->assertStatus(200);
    }

    public function test_quran_juz_amma_page_is_accessible(): void
    {
        $response = $this->get('/al-quran/juz-amma');
        $response->assertStatus(200);
    }

    public function test_quran_show_page_is_accessible(): void
    {
        $response = $this->get('/al-quran/1');
        $response->assertStatus(200);
    }

    public function test_invalid_surah_number_returns_404(): void
    {
        $response = $this->get('/al-quran/115');
        $response->assertStatus(404);

        $responseZero = $this->get('/al-quran/0');
        $responseZero->assertStatus(404);
    }

    public function test_tahlil_page_is_accessible(): void
    {
        $response = $this->get('/tahlil');
        $response->assertStatus(200);
    }

    public function test_doa_page_is_accessible(): void
    {
        $response = $this->get('/doa');
        $response->assertStatus(200);
    }

    public function test_quran_index_supports_prd_query_filters(): void
    {
        $response = $this->get('/al-quran?q=fatihah&juz=30&tempat=mekah');
        $response->assertStatus(200);

        $responseMadinah = $this->get('/al-quran?tempat=madinah');
        $responseMadinah->assertStatus(200);
    }

    public function test_quran_show_supports_target_ayah_jumping(): void
    {
        $response = $this->get('/al-quran/2?ayat=255');
        $response->assertStatus(200);
        $response->assertSee('ayat-255');
    }

    public function test_doa_index_supports_kategori_query(): void
    {
        $response = $this->get('/doa?kategori=doa-shalat');
        $response->assertStatus(200);
    }
}

