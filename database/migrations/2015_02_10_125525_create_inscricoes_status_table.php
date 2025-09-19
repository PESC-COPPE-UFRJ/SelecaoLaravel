<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInscricoesStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inscricoes_status', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('inscricao_id')->unsigned()->index();
			$table->foreign('inscricao_id')->references('id')->on('inscricoes')->onDelete('cascade');
			$table->integer('status_id')->unsigned()->index();
			$table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
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
		Schema::drop('inscricoes_status');
	}

}
