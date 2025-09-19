<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePerfisUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfis_usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('perfil_id')->unsigned()->index();
			$table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');
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
		Schema::drop('perfis_usuarios');
	}

}
