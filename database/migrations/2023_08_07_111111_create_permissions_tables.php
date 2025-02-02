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
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('code', 255)->collation('utf8_unicode_ci');
            $table->string('description', 255)->collation('utf8_unicode_ci')->nullable();
            $table->bigInteger('menu_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            // You can set the primary key explicitly if you want, but it's optional since bigIncrements will automatically make the 'id' column as the primary key.
            // $table->primary('id');

            $table->unique('code', 'permissions_code_unique'); // Add a unique index for the 'code' column

            // Add foreign key constraint
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
