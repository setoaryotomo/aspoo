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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang', 255)->collation('utf8_unicode_ci')->primary();
            $table->string('nama_barang', 255)->collation('utf8_unicode_ci');
            $table->integer('harga_barang_jual');
            $table->integer('harga_barang_beli');
            $table->bigInteger('stock_global');
            $table->bigInteger('satuan_id')->unsigned();
            $table->bigInteger('created_by_user_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Add foreign key constraints
            $table->foreign('satuan_id')->references('id')->on('satuan');
            $table->foreign('created_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
