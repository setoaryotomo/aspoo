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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 255)->collation('utf8_unicode_ci');
            $table->string('email', 255)->collation('utf8_unicode_ci');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username', 255)->collation('utf8_unicode_ci');
            $table->string('password', 255)->collation('utf8_unicode_ci');
            $table->rememberToken();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();


            $table->unique('email', 'users_email_unique'); // Add a unique index for the 'email' column
            $table->unique('username', 'users_username_unique'); // Add a unique index for the 'username' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
