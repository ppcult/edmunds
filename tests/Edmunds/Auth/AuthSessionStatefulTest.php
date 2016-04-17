<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace EdmundsTest\Auth;

use EdmundsTest\Auth\AuthTest;

/**
 * Testing Auth-class
 */
class AuthSessionStatefulTest extends AuthTest
{
	/**
	 * Creates the application.
	 */
	public function createApplication()
	{
		$_ENV['APP_STATEFUL'] = true;
		$_ENV['APP_AUTH_GUARD'] = 'session';

		return parent::createApplication();
	}
}