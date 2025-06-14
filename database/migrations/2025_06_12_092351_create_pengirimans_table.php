<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimansTable extends Migration
{
    public function up()
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('orders')->onDelete('cascade');
            $table->string('alamat', 250);
            $table->bigInteger('biaya');
            $table->date('tanggal_kirim')->nullable();
            $table->date('tanggal_sampai')->nullable();
            $table->enum('status', ['persiapan', 'dikirim', 'selesai'])->default('persiapan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengirimans');
    }
}