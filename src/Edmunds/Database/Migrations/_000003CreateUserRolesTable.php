<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Database\Migrations;

use Edmunds\Database\Migrations\Traits\CreateEnumsPivotTable;

/**
 * Migration for user-roles-table
 */
trait _000003CreateUserRolesTable
{
	use CreateEnumsPivotTable;

	/**
	 * The table used for pivot
	 * @var string
	 */
	protected $table = 'user_roles';

	/**
	 * The name for id of model
	 * @var string
	 */
	protected $idModel = 'user_id';

	/**
	 * The name for id of enum
	 * @var string
	 */
	protected $idEnum = 'role_id';
}
