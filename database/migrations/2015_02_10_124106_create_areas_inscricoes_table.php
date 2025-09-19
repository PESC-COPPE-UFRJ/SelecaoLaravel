<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAreasInscricoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas_inscricoes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('area_id')->unsigned()->index();
			$table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
			$table->integer('inscricao_id')->unsigned()->index();
			$table->foreign('inscricao_id')->references('id')->on('inscricoes')->onDelete('cascade');
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
		Schema::drop('areas_inscricoes');
	}

}
