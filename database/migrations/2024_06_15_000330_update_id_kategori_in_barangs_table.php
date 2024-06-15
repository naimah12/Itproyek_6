<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            
            DB::table('barangs')->whereNull('id_kategori')->update(['id_kategori' => 2]); // Ganti '1' dengan id_kategori yang valid jika diperlukan

            // Ubah id_kategori menjadi unsignedBigInteger dan tidak nullable
            $table->unsignedBigInteger('id_kategori')->nullable(false)->change();

            // Tambahkan foreign key
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->integer('id_kategori')->nullable()->change();
        });
    }
};
