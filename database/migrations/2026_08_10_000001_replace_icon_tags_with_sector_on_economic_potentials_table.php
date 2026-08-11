<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('economic_potentials', function (Blueprint $table) {
            $table->dropColumn(['icon', 'tags']);
            $table->enum('sector', [
                'makanan_minuman',
                'warung_sembako',
                'pertanian',
                'peternakan_perikanan',
                'toko_bangunan',
                'jasa_servis',
                'kerajinan_tangan',
                'pakaian_fashion',
            ])->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('economic_potentials', function (Blueprint $table) {
            $table->dropColumn('sector');
            $table->string('icon')->comment('Nama ikon Lucide');
            $table->json('tags');
        });
    }
};
