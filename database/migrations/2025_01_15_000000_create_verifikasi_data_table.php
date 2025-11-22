<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verifikasi_data', function (Blueprint $table) {
            $table->id();
            $table->string('tabel_terkait', 50)->comment('pelanggaran, prestasi, sanksi');
            $table->unsignedBigInteger('id_terkait');
            $table->unsignedBigInteger('user_verifikator')->nullable()->comment('User dengan role kesiswaan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
            
            $table->foreign('user_verifikator')->references('id')->on('users');
            
            $table->index('tabel_terkait');
            $table->index('id_terkait');
            $table->index('user_verifikator');
            $table->index('status');
            $table->index('created_at');
            
            $table->unique(['tabel_terkait', 'id_terkait']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi_data');
    }
};