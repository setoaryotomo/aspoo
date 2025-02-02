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
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('foto', 255)->collation('utf8_unicode_ci');
            $table->string('alamat', 255)->collation('utf8_unicode_ci');
            $table->date('tanggal_lahir');
            $table->string('provinsi', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('kota', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('kecamatan', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('kelurahan', 255)->collation('utf8_unicode_ci')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
