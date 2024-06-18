<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->bigIncrements('id_barang');
            $table->string('nama_barang', 30);
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->decimal('harga', 8, 2);
            $table->string('foto', 80);
            $table->timestamps();
    
            // Foreign keys
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
