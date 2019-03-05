<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_agen');
            $table->integer('id_kategori');
            $table->string('alamat');
            $table->integer('id_jalur');
            $table->string('telepon');
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
        Schema::dropIfExists('agen');
    }
}
