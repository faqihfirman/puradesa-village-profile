<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->longText('history_content');
            $table->unsignedSmallInteger('founded_year');
            $table->string('illustration_path')->nullable();
            $table->text('vision');
            $table->decimal('area_size', 10, 2);
            $table->string('area_unit')->default('Ha');
            $table->unsignedInteger('altitude');
            $table->string('altitude_unit')->default('Mdpl');
            $table->string('boundary_north')->nullable();
            $table->string('boundary_south')->nullable();
            $table->string('boundary_east')->nullable();
            $table->string('boundary_west')->nullable();
            $table->unsignedInteger('total_population');
            $table->unsignedInteger('total_families');
            $table->unsignedInteger('total_hamlets');
            $table->decimal('map_center_lat', 10, 7);
            $table->decimal('map_center_lng', 10, 7);
            $table->unsignedTinyInteger('map_zoom')->default(14);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_profiles');
    }
};
