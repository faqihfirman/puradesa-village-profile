<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_head_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->default('Kepala Desa');
            $table->string('photo_path')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_head_messages');
    }
};
