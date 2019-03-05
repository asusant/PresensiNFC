<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('masuk', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('id_barang');
					$table->integer('id_satuan');
					$table->integer('qty');
					$table->integer('id_supplier');
					$table->integer('harga_beli');
					$table->integer('id_transaksi');
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
        Schema::dropIfExists('masuk');
    }
}
