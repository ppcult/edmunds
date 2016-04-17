<?php

/**
 * Edmunds
 *
 * The core of any web-project by Lowie Huyghe
 *
 * @author      Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright   Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license     http://LicenseUrl
 */

namespace Edmunds\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for users-table
 *
 * @author      Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright   Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license     http://LicenseUrl
 */
trait _000001CreateUsersTable
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		app('db')->connection()->getSchemaBuilder()->create('users', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('locale', 10);
			$table->integer('gender_id')->unsigned();
			$table->string('api_token', 100)->nullable()->unique();
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		app('db')->connection()->getSchemaBuilder()->drop('users');
	}
}
