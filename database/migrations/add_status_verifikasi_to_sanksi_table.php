<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sanksi', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('sanksi', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};