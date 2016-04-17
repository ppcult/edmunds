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

namespace Edmunds\Database\Seeds;

use Edmunds\Bases\Database\Seeds\BaseSeeder;
use Edmunds\Localization\Models\Location;
use Edmunds\Auth\Models\User;

/**
 * Seeder for the user_locations-table
 *
 * @author      Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright   Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license     http://LicenseUrl
 */
class UserLocationsTableSeeder extends BaseSeeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		$users = call_user_func_array(config('app.auth.models.user'). '::all', array());

		foreach ($users as $user)
		{
			if (Location::where('user_id', '=', $user->id)->get()->count() == 0)
			{
				$location = Location::dummy();
				$location->user()->associate($user);
				$location->save();
			}
		}
	}
}
