<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMensagensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mensagens', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_remetente')->unsigned();
			$table->integer('id_destinatario')->unsigned();
			$table->foreign('id_remetente')->references('id')->on('usuarios');
			$table->foreign('id_destinatario')->references('id')->on('usuarios');
			$table->text('mensagem');
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
		Schema::drop('mensagens');
	}

}
