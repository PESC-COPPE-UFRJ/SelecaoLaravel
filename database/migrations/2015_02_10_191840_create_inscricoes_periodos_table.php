<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInscricoPeriodoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inscricoes_periodos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('inscricao_id')->unsigned()->index();
			$table->foreign('inscricao_id')->references('id')->on('inscricoes')->onDelete('cascade');
			$table->integer('periodo_id')->unsigned()->index();
			$table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
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
		Schema::drop('inscricoes_periodos');
	}

}
