<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('bookmarkable_type', 50);
            $table->unsignedBigInteger('bookmarkable_id');
            $table->string('catatan', 255)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'bookmarkable_type', 'bookmarkable_id']);
            $table->index(['bookmarkable_type', 'bookmarkable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};

