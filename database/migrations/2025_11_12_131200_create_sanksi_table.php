<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('jenis_sanksi_id')->constrained('jenis_sanksi')->onDelete('cascade');
            $table->date('tanggal_sanksi');
            $table->enum('status', ['AKTIF', 'SELESAI', 'BATAL'])->default('AKTIF');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanksi');
    }
};