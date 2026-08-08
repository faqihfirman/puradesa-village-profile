<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->unsignedInteger('visits')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_stats');
    }
};
