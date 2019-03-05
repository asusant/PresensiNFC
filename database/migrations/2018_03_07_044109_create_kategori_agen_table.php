<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategoriAgenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('kategori_agen', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('kategori');
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
        Schema::dropIfExists('kategori_agen');
    }
}
