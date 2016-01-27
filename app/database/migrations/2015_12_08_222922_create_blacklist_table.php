<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlacklistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blacklist', function($table){
			$table->increments('id');
			$table->string('blockid');
			$table->string('childid');
			$table->string('parentusername');
			$table->string('website');
			$table->string('blockstatus');
			$table->date('fromDate');
			$table->date('toDate');
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
		Schema::drop('blacklist');
	}

}
