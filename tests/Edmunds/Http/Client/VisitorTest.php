<?php

/**
 * Edmunds
 *
 * The core of any web-project by Lowie Huyghe
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 */

namespace EdmundsTest;

use Edmunds\Bases\Tests\BaseTest;
use Edmunds\Auth\Auth;
use Edmunds\Http\Client\Visitor;
use Edmunds\Auth\Models\User;

/**
 * Testing Visitor-class
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 */
class VisitorTest extends BaseTest
{
	/**
	 * Test Id
	 */
	public function testId()
	{
		$id = Visitor::getInstance()->id;

		$this->assertTrue($id != null);
	}

	/**
	 * Test User
	 */
	public function testUser()
	{
		// not logged in
		Auth::getInstance()->logout();
		$this->assertTrue(Visitor::getInstance()->user == null);

		// make user
		$user = $this->createUser();

		// logged in
		Auth::getInstance()->setUser($user);
		$this->assertTrue(Visitor::getInstance()->user != null);

		// logged out
		Auth::getInstance()->logout();
		$this->assertTrue(Visitor::getInstance()->user == null);
	}

	/**
	 * Test LoggedIn
	 */
	public function testLoggedIn()
	{
		// not logged in
		Auth::getInstance()->logout();
		$this->assertTrue(!Visitor::getInstance()->loggedIn);

		// make user
		$user = $this->createUser();

		// logged in
		Auth::getInstance()->setUser($user);
		$this->assertTrue(Visitor::getInstance()->loggedIn);

		// logged out
		Auth::getInstance()->logout();
		$this->assertTrue(!Visitor::getInstance()->loggedIn);
	}

	/**
	 * Test Context
	 */
	public function testContext()
	{
		$this->assertTrue(Visitor::getInstance()->context != null);
	}

	/**
	 * Test Localization
	 */
	public function testLocalization()
	{
		$this->assertTrue(Visitor::getInstance()->localization != null);
	}

	/**
	 * Test Location
	 */
	public function testLocation()
	{
		$this->assertTrue(Visitor::getInstance()->location != null);
	}

	/**
	 * Create a new fresh user to work with
	 * @return User
	 */
	protected function createUser()
	{
		$user = call_user_func(config('app.auth.models.user') . '::dummy');

		$user->id = null;

		$user->save();

		return $user;
	}
}
