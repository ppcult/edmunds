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

namespace Core\Http\Client;
use Core\Models\User;
use Core\Bases\Structures\BaseStructure;

/**
 * The helper responsible for localization
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.1
 *
 * @property string $locale The default locale
 * @property string $fallback The fallback locale
 */
class Localization extends BaseStructure
{
	/**
	 * Constructor
	 * @param Context $browser
	 * @param Location $location
	 * @param User $user
	 */
	public function __construct($browser, $location, $user)
	{
		parent::__construct();

		$locale = null;

		//Use user for locale
		if ($user && !$locale)
		{
			$locale = $user->locale;
		}

		//Use location for locale
		if ($location && !$locale)
		{
			//
		}

		//Use browser for locale
		if ($browser && !$locale)
		{
			$locale = $browser->locale;
		}

		//Use app-settings
		if (!$locale)
		{
			$locale = env('APP_LOCALE');
		}

		//Set
		$this->locale = $locale;
		$this->fallback = env('APP_FALLBACK_LOCALE');
	}

}