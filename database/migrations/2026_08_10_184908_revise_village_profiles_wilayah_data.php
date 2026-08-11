<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'boundary_north', 'boundary_south', 'boundary_east', 'boundary_west',
                'total_hamlets',
            ]);

            $table->json('population_by_religion')->nullable()->after('total_families');
            $table->json('population_by_marital_status')->nullable()->after('population_by_religion');
            $table->json('population_by_education')->nullable()->after('population_by_marital_status');
            $table->json('population_by_occupation')->nullable()->after('population_by_education');
            $table->json('population_by_age_group')->nullable()->after('population_by_occupation');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'population_by_religion', 'population_by_marital_status',
                'population_by_education', 'population_by_occupation', 'population_by_age_group',
            ]);

            $table->string('boundary_north')->nullable();
            $table->string('boundary_south')->nullable();
            $table->string('boundary_east')->nullable();
            $table->string('boundary_west')->nullable();
            $table->unsignedInteger('total_hamlets')->default(0);
        });
    }
};
