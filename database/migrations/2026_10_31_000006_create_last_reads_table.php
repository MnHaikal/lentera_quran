<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('last_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('surah_id');
            $table->unsignedBigInteger('ayah_id')->nullable();
            $table->timestamps();

            $table->foreign('surah_id')->references('id')->on('surahs')->cascadeOnDelete();
            $table->foreign('ayah_id')->references('id')->on('ayahs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('last_reads');
    }
};

