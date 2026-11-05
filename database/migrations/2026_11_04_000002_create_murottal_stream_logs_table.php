<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('murottal_stream_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedTinyInteger('surah_id')->default(1);
            $table->unsignedSmallInteger('ayah_number')->nullable();
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->string('qari', 100)->default('Misyari Rasyid Al-Afasi');
            $table->timestamps();

            $table->foreign('surah_id')->references('id')->on('surahs')->cascadeOnDelete();
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('murottal_stream_logs');
    }
};

