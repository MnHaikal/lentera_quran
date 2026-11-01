<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tafsirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayah_id')->unique()->constrained('ayahs')->cascadeOnDelete();
            $table->string('sumber', 100);
            $table->longText('isi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tafsirs');
    }
};

