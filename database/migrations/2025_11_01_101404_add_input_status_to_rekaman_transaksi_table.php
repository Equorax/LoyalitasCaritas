<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rekaman_transaksi', function (Blueprint $table) {
            // Tambahkan kolom input_status dengan enum VALID/INVALID dan default 'INVALID'
            $table->enum('input_status', ['VALID', 'INVALID'])->default('INVALID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('rekaman_transaksi', function (Blueprint $table) {
            // Hapus kolom input_status jika rollback
            $table->dropColumn('input_status');
        });
    }
};