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
        Schema::create('cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            // $table->bigInteger('barang_id')->unsigned();
            $table->bigInteger('created_by_user_id')->unsigned();
            $table->timestamps();

            // Add foreign key constraints
            // $table->foreign('barang_id')->references('id')->on('barang');
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
        Schema::dropIfExists('cabang');
    }
};
