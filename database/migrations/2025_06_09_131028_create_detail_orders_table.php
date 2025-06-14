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
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_type');
            $table->unsignedBigInteger('id_jenis');
            $table->unsignedBigInteger('id_chassis');
            $table->date('tanggal_selesai')->nullable();
            $table->integer('qty');
            $table->bigInteger('harga_order');
            $table->timestamps();

            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('id_type')->references('id')->on('type_dumps')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id')->on('jenis_dumps')->onDelete('cascade');
            $table->foreign('id_chassis')->references('id')->on('chassis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
