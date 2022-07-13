<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->unsignedBigInteger('id_m_buku');
            $table->unsignedBigInteger('id_m_user');
            $table->string('jumlah');
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('tanggal_pengembalian');
            $table->dateTime('tanggal_dikembalikan')->nullable();
            $table->enum('status', ['pinjam', 'kembali'])->default('pinjam');
            $table->integer('denda')->nullable();

            $table->foreign('id_m_buku')->references('id')->on('m_buku');
            $table->foreign('id_m_user')->references('id')->on('user_auth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_item_det');
    }
}
