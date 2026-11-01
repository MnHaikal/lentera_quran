<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahlil_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('urutan')->index();
            $table->string('judul', 150);
            $table->text('teks_arab');
            $table->text('teks_latin');
            $table->text('terjemahan');
            $table->unsignedTinyInteger('jumlah_baca')->default(1);
            $table->string('keterangan', 255)->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahlil_items');
    }
};

