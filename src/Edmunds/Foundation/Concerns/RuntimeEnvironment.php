<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Foundation\Concerns;

use Edmunds\Encryption\ObfuscatorServiceProvider;

/**
 * The RuntimeEnvironment concern
 */
trait RuntimeEnvironment
{
	/**
	 * Check if local environment
	 * @return bool
	 */
	public function isLocal()
	{
		return $this->environment('local');
	}

	/**
	 * Check if production environment
	 * @return bool
	 */
	public function isProduction()
	{
		return $this->environment('production');
	}

	/**
	 * Check if testing environment
	 * @return bool
	 */
	public function isTesting()
	{
		return $this->environment('testing');
	}

	/**
	 * Determine if we are running unit tests.
	 *
	 * @return bool
	 */
	public function runningUnitTests()
	{
		return $this->isTesting();
	}

	/**
	 * Get or check the current application environment.
	 *
	 * @param  mixed
	 * @return string
	 */
	public function environment()
	{
		if ($this->isGae())
		{
			return $this->gaeEnvironment();
		}

		return call_user_func_array(array($this, 'parent::' . __FUNCTION__), func_get_args());
	}

	/**
	 * Get entrypoint
	 * @return string
	 */
	public function getEntrypoint()
	{
		return config('app.entrypoint', 'default');
	}
}