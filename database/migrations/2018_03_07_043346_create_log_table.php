<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('log', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('id_user');
					$table->string('nama_tabel');
					$table->string('id_objek');
					$table->string('aktivitas');
					$table->timestamps();
					$table->softDeletes();
					$table->integer('created_by');
					$table->integer('updated_by');
					$table->integer('deleted_by');
			});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}
