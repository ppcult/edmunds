<?php

/**
 * Core
 *
 * The core of any web-project by Lowie Huyghe
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.1
 */

namespace Core\Database\Seeders;

use Illuminate\Support\Facades\DB;

/**
 * Seeder base to extend from
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.1
 */
class BaseSeeder
{
	/**
	 * Table for deleting the records
	 * @var string
	 */
	protected $table;

	/**
	 * Delete the records
	 */
	public function delete()
	{
		DB::table($this->table)->delete();
	}

	/**
	 * Fill the table
	 */
	public function fill()
	{

	}

}
