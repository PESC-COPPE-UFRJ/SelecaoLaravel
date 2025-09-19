<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusPerfisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus_perfis', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id')->unsigned()->index();
			$table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
			$table->integer('perfil_id')->unsigned()->index();
			$table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');
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
		Schema::drop('menus_perfis');
	}

}
