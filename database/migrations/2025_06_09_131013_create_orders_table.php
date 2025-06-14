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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pemesan');
            $table->unsignedBigInteger('id_sales')->nullable();
            $table->enum('status_order', ['pending', 'proses', 'selesai', 'batal'])->default('pending');
            $table->bigInteger('total_harga');
            $table->timestamps();

            $table->foreign('id_pemesan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreign('id_sales')->references('id')->on('karyawans')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
