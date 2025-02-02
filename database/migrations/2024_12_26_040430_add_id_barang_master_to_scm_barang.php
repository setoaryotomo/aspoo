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
        Schema::table('scm_barang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_barang_master')->nullable();

            // Add foreign key constraints
            $table->foreign('id_barang_master')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scm_barang', function (Blueprint $table) {
            //
        });
    }
};
