<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaksi');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah_barang');
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();
    
            // Foreign keys
            $table->foreign('id_transaksi')
                ->references('id')
                ->on('transaksi')
                ->onDelete('cascade');
    
                $table->foreign('barang_id')->references('id_barang')->on('barangs')->onDelete('cascade');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
