<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('keuangan', function (Blueprint $table) {
					$table->increments('id');
					$table->string('aktivitas');
					$table->string('jumlah');
					$table->string('tipe');
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
        Schema::dropIfExists('keuangan');
    }
}
