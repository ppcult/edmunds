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

namespace Core\Analytics\Tracking\GA;

use Core\Bases\Analytics\Tracking\GA\BaseLog;

/**
 * The structure for transaction reports
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.1
 *
	//E-Commerce
 * @property string $transactionId
 * @property string $transactionAffiliation
 * @property double $transactionRevenue
 * @property double $transactionShipping
 * @property double $transactionTax
 * @property string $currencyCode
 */
class TransactionLog extends BaseLog
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->hitType = 'transaction';
	}

}