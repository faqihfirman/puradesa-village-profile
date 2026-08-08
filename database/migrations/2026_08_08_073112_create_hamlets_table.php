<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hamlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('population');
            $table->unsignedInteger('families')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hamlets');
    }
};
