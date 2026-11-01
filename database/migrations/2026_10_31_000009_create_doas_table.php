<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doa_category_id')->constrained('doa_categories')->restrictOnDelete();
            $table->string('judul', 150);
            $table->string('slug', 170)->unique();
            $table->text('teks_arab');
            $table->text('teks_latin');
            $table->text('terjemahan');
            $table->string('sumber', 255)->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doas');
    }
};

