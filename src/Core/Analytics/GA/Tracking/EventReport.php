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

namespace Core\Analytics\GA\Tracking;

use Core\Bases\Analytics\Tracking\BaseGAReport;

/**
 * The structure for event reports
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.1
 *
	//Event Tracking
 * @property string $eventCategory
 * @property string $eventAction
 * @property string $eventLabel
 * @property int $eventValue
 */
class EventReport extends BaseGAReport
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->hitType = 'event';
	}

}
