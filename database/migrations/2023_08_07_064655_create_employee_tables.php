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
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nip', 255)->collation('utf8_unicode_ci')->unique();
            $table->string('fullname', 255)->collation('utf8_unicode_ci');
            $table->date('dob');
            $table->text('address')->collation('utf8_unicode_ci');
            $table->text('photo')->collation('utf8_unicode_ci');
            $table->text('ktp_photo')->collation('utf8_unicode_ci');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->index('dob');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
};
