<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_children', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nomor_faktur', 255)->collation('utf8_unicode_ci');
            $table->string('kode_barang', 255)->collation('utf8_unicode_ci');
            $table->unsignedBigInteger('kode_diskon');
            $table->integer('harga_jual');
            $table->integer('jumlah_item');
            $table->integer('total_bayar');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Add foreign key constraints
            $table->foreign('nomor_faktur')->references('nomor_faktur')->on('penjualan')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang');
            $table->foreign('kode_diskon')->references('id')->on('diskon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_children');
    }
};
