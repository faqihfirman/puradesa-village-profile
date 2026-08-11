<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('economic_potentials', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->longText('content')->nullable()->after('description');
            $table->string('maps_url')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('economic_potentials', function (Blueprint $table) {
            $table->dropColumn(['slug', 'content', 'maps_url']);
        });
    }
};
