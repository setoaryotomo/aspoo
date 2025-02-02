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
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('uuid', 255)->collation('utf8_unicode_ci');
            $table->text('connection')->collation('utf8_unicode_ci');
            $table->text('queue')->collation('utf8_unicode_ci');
            $table->longText('payload')->collation('utf8_unicode_ci');
            $table->longText('exception')->collation('utf8_unicode_ci');
            $table->timestamp('failed_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
};
