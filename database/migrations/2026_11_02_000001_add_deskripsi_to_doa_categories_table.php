<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doa_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('doa_categories', 'deskripsi')) {
                $table->string('deskripsi', 255)->nullable()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doa_categories', function (Blueprint $table) {
            if (Schema::hasColumn('doa_categories', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};

