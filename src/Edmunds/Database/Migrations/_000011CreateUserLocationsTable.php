<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for userLocations-table
 */
trait _000011CreateUserLocationsTable
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		app('db')->connection()->getSchemaBuilder()->create('user_locations', function (Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->primary('user_id');
			$table->string('ip');

			$table->string('continent_code', 10)->nullable();
			$table->string('continent_name')->nullable();

			$table->string('country_code', 10)->nullable();
			$table->string('country_name')->nullable();

			$table->string('region_code', 10)->nullable();
			$table->string('region_name')->nullable();

			$table->string('city_name')->nullable();
			$table->string('postal_code', 32)->nullable();

			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->string('timezone')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		app('db')->connection()->getSchemaBuilder()->drop('user_locations');
	}
}