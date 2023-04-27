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
        Schema::create('tbl_temporary_file', function (Blueprint $table) {
            $table->increments('temporary_file_id');
            $table->string('temporary_file_folder');
            $table->string('temporary_file_name');
            $table->dateTime('temporary_file_created');
            $table->dateTime('temporary_file_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_temporary_file');
    }
};
