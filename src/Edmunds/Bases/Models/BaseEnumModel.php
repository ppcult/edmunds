<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Bases\Models;

use Edmunds\Bases\Models\BaseModel;
use Edmunds\Validation\Validator;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;

/**
 * The model of the enum-models
 *
 * @property int $id Database table-id
 * @property string $name Name of the value
 */
class BaseEnumModel extends BaseModel
{
	/**
	 * The fetched constants
	 * @var array
	 */
	private static $constants = array();

	/**
	 * Fetch all the defined constants
	 * @return array
	 */
	private static function getConstants()
	{
		$calledClass = get_called_class();

		//Check if already fetched
		if ( ! isset(self::$constants[$calledClass]))
		{
			//Get all the constants
			$reflect = new \ReflectionClass($calledClass);
			$constants = array_change_key_case($reflect->getConstants());
			//Filter some out
			foreach ($constants as $name => $value)
			{
				if (ends_with($name, array('_at')))
				{
					unset($constants[$name]);
				}
			}
			self::$constants[$calledClass] = $constants;
		}
		return self::$constants[$calledClass];
	}

	/**
	 * Get all of the models
	 * @param  array  $columns
	 * @return Collection
	 */
	public static function all($columns = [])
	{
		//Fetch required columns
		$columns = is_array($columns) ? $columns : func_get_args();

		//Process all constants
		$all = array();
		$constants = self::getConstants();
		$calledClass = get_called_class();
		foreach ($constants as $name => $value)
		{
			$object = new $calledClass();
			if (empty($columns) || in_array('id', $columns))
			{
				$object->id = $value;
			}
			if (empty($columns) || in_array('name', $columns))
			{
				$object->name = $name;
			}

			$all[] = $object;
		}

		return collect($all);
	}

	/**
	 * Find a model by its primary key or return new static.
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return BaseEnumModel
	 */
	public static function find($id, $columns = [])
	{
		//Fetch all and search for right id
		$all = self::all($columns);
		foreach ($all->all() as $enum)
		{
			if ($enum->id == $id)
			{
				return $enum;
			}
		}

		return null;
	}

	/**
	 * Get object with where
	 * @param $name
	 * @param $value
	 * @return static
	 */
	public static function where($name, $value)
	{
		$all = self::all();
		return $all->where($name, $value);
	}

	/**
	 * Enable or disable timestamps by default
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Add the validation of the model
	 */
	protected function addValidationRules(&$validator)
	{
		parent::addValidationRules($validator);

		$this->required = array_merge($this->required, array('name'));

		$validator->rule('id')->integer();
		$validator->rule('name')->max(32);
	}

	/**
	 * Define-function for the instance generator
	 * @param Generator $faker
	 * @return array
	 */
	protected static function factory($faker)
	{
		return array(
			'id' => rand(1,99),
			'name' => str_random(10),
		);
	}

}
