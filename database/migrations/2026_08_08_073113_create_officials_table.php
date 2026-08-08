<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->unsignedTinyInteger('level')->comment('1=Kepala Desa, 2=Sekretaris, 3=Kaur/Kasi, 4=Kepala Dusun');
            $table->string('photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->year('period_start')->nullable();
            $table->year('period_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index(['level', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
