<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAreasUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas_usuarios', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('area_id')->unsigned()->index();
			$table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
			$table->integer('usuario_id')->unsigned()->index();
			$table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('areas_usuarios');
	}

}
