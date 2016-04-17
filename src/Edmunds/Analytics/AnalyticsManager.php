<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Analytics;

use Edmunds\Analytics\Drivers\GaWarehouse;
use Edmunds\Analytics\Drivers\NewrelicWarehouse;
use Edmunds\Analytics\Drivers\PiwikWarehouse;
use Edmunds\Bases\Analytics\BaseWarehouse;
use Edmunds\Bases\Structures\BaseStructure;

/**
 * The analytics manager
 */
class AnalyticsManager extends BaseStructure
{
	/**
	 * The driver
	 * @var string
	 */
	protected $driver;

	/**
	 * The warehouses
	 * @var array
	 */
	protected $warehouses = [];

	/**
	 * Constructor
	 * @param string $driver
	 */
	public function __construct($driver = null)
	{
		parent::__construct();

		$this->driver = $driver;
	}

	/**
	 * Get a warehouse by name
	 * @param  string $name
	 * @return BaseWarehouse
	 */
	public function warehouse($name = null)
	{
		$name = $name ?: $this->getDefaultDriver();

		return $this->warehouses[$name] = $this->get($name);
	}

	/**
	 * Create a new piwik warehouse
	 * @return PiwikWarehouse
	 */
	protected function createPiwikDriver()
	{
		if (!isset($this->warehouses['piwik']))
		{
			$this->warehouses['piwik'] = new PiwikWarehouse('piwik');
		}
		return $this->warehouses['piwik'];
	}

	/**
	 * Create a new google analytics warehouse
	 * @return GaWarehouse
	 */
	protected function createGaDriver()
	{
		if (!isset($this->warehouses['ga']))
		{
			$this->warehouses['ga'] = new GaWarehouse('ga');
		}
		return $this->warehouses['ga'];
	}

	/**
	 * Create a new new relic warehouse
	 * @return NewrelicWarehouse
	 */
	protected function createNewrelicDriver()
	{
		if (!isset($this->warehouses['newrelic']))
		{
			$this->warehouses['newrelic'] = new NewrelicWarehouse('newrelic');
		}
		return $this->warehouses['newrelic'];
	}

	/**
	 * Get the name of the default driver
	 * @return string
	 */
	protected function getDefaultDriver()
	{
		return $this->driver ?? config('app.analytics.default', null);
	}

	/**
	 * Fetch a warehouse by name
	 * @param  strin $name
	 * @return BaseWarehouse
	 */
	protected function get($name)
	{
		if (!isset($this->warehouses[$name]))
		{
			$this->warehouses[$name] = call_user_func(array($this, 'create' . ucfirst($name) . 'Driver'));
		}
		return $this->warehouses[$name];
	}

	/**
	 * Check if analytics are enabled
	 * @return boolean
	 */
	public static function isEnabled()
	{
		return config('app.analytics.enabled', true);
	}
}