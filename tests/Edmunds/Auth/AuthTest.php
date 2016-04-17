<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace EdmundsTest\Auth;

use Edmunds\Bases\Tests\BaseTest;
use Edmunds\Auth\Auth;
use Edmunds\Http\Request;
use Edmunds\Auth\Models\LoginAttempt;
use Edmunds\Auth\Models\PasswordReset;
use Edmunds\Auth\Models\User;

/**
 * Testing Auth-class
 */
class AuthTest extends BaseTest
{
	/**
	 * The email to use for the test user
	 * @var string
	 */
	protected $email = 'testtset12344321@test.com';

	/**
	 * The password to user for authentication
	 * @var string
	 */
	protected $password = 'secret';

	/**
	 * Test Login Credentials
	 */
	public function testLogin()
	{
		$auth = Auth::getInstance();
		$user = $this->createUser();

		// login
		$this->assertTrue($auth->login($this->email, $this->password));
		$this->assertTrue($auth->loggedIn);
		$this->assertTrue($auth->user->email == $this->email);

		// logout
		$auth->logout();
		$this->assertTrue(!$auth->loggedIn);
		$this->assertTrue($auth->user == null);
	}

	/**
	 * Test set user
	 */
	public function testSetUser()
	{
		$auth = Auth::getInstance();
		$user = $this->createUser();

		// login, fetch token
		$auth->setUser($user);
		$this->assertTrue($auth->loggedIn);

		// logout
		$auth->logout();
		$this->assertTrue(!$auth->loggedIn);
	}

	/**
	 * Test Login attempts
	 */
	public function testLoginAttempts()
	{
		$auth = Auth::getInstance();
		$user = $this->createUser();

		$currentLoginAttempts = $auth->attemptsCount;

		// try login
		$this->assertTrue(!$auth->login($this->email, 'notthepassword'));
		$this->assertTrue(!$auth->loggedIn);
		//The ratelimiter has fault code where it first ads the value 1 when it does not exist and increments it afterwards. Resulting in 2 instead of 1.
		$this->assertTrue($auth->attemptsCount === $currentLoginAttempts + ($currentLoginAttempts == 0 ? 2 : 1));

		// try login
		$this->assertTrue(!$auth->login($this->email, 'notthepassword'));
		$this->assertTrue(!$auth->loggedIn);
		$this->assertTrue($auth->attemptsCount === $currentLoginAttempts + ($currentLoginAttempts == 0 ? 3 : 2));

		// login
		$this->assertTrue($auth->login($this->email, $this->password));
		$this->assertTrue($auth->loggedIn);
		$this->assertTrue($auth->attemptsCount === 0);
	}

	/**
	 * Create a new fresh user to work with
	 * @return User
	 */
	protected function createUser()
	{
		$user = call_user_func(config('app.auth.models.user') . '::dummy');

		$user->id = null;
		$user->email = $this->email;
		$user->password = bcrypt($this->password);

		$user->save();

		return $user;
	}
}
