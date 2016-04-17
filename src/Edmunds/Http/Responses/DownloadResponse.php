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

namespace Edmunds\Http\Responses;

use Edmunds\Bases\Responses\BaseResponse;

/**
 * A download response
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 *
 * @property string $filePath
 * @property string $name
 */
class DownloadResponse extends BaseResponse
{
	/**
	 * Constructor
	 * @property string $filePath
	 * @property string $name
	 */
	public function __construct($filePath, $name = null)
	{
		parent::__construct();

		$this->filePath = $filePath;
		$this->name = $name;
	}

	/**
	 * Get the response
	 * @param array $data
	 * @return \Illuminate\Http\Response
	 */
	public function getResponse($data = array())
	{
		$data = $this->processData($data);

		return response()->download($this->filePath, $this->name);
	}

}
