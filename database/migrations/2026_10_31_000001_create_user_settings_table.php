<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('ukuran_font_arab')->default(28);
            $table->boolean('tampilkan_latin')->default(true);
            $table->boolean('tampilkan_terjemahan')->default(true);
            $table->enum('tema', ['terang', 'gelap', 'sistem'])->default('sistem');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};

