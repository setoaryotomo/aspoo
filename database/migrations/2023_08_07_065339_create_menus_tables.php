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
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 255)->collation('utf8_unicode_ci');
            $table->string('path', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('description', 255)->collation('utf8_unicode_ci')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('module_id')->unsigned()->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->unique('path');

            // Add foreign key constraints
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('module')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
