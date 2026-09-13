<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('water_frequency')->nullable()->after('description');
            $table->string('light_requirement')->nullable()->after('water_frequency');
            $table->string('temperature_range')->nullable()->after('light_requirement');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['water_frequency', 'light_requirement', 'temperature_range']);
        });
    }
};
