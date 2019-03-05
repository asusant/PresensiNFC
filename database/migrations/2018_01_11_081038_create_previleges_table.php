<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrevilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previleges', function (Blueprint $table) {
            $table->increments('id');
						$table->integer('id_level');
						$table->integer('id_menu');
						$table->integer('create');
						$table->integer('read');
						$table->integer('update');
						$table->integer('delete');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previleges');
    }
}
