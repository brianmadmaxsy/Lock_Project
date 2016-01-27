<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user',function($table){
			$table->increments('id');
			$table->string('userid');
			$table->string('firstname');
			$table->string('lastname');
			$table->string('username');
			$table->string('password');
			$table->string('email');
			$table->string('contact');
			$table->string('accttype');
			$table->string('picture');
			$table->string('occupation');
			$table->string('gender');
			$table->string('birthday');
			$table->string('city');
			$table->string('home');
			$table->rememberToken();
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
		Schema::drop('user');
	}

}
