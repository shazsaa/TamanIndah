<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('care_level', ['mudah', 'sedang', 'perlu_perhatian'])->nullable()->after('temperature_range');
            $table->enum('placement_type', ['dalam_ruangan', 'luar_ruangan', 'keduanya'])->nullable()->after('care_level');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['care_level', 'placement_type']);
        });
    }
};
