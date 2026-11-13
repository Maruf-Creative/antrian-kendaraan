<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kendaraan_id');
            $table->string('nomor_antrian', 20);
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('status', 20)->default('Menunggu');
            $table->timestamps();

            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('cascade');
            $table->unique(['nomor_antrian', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
