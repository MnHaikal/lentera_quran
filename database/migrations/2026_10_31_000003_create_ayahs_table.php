<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('surah_id');
            $table->unsignedSmallInteger('nomor_ayat');
            $table->text('teks_arab');
            $table->text('teks_latin');
            $table->text('terjemahan');
            $table->unsignedTinyInteger('juz');
            $table->unsignedSmallInteger('halaman')->nullable();
            $table->string('audio_url', 255)->nullable();
            $table->timestamps();

            $table->foreign('surah_id')->references('id')->on('surahs')->cascadeOnDelete();
            $table->unique(['surah_id', 'nomor_ayat']);
            $table->index('juz');
            $table->fullText(['terjemahan', 'teks_latin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};

