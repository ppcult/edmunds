<?php

/**
 * Edmunds
 *
 * The fast PHP framework for building web applications.
 *
 * @license   This file is subject to the terms and conditions defined in file 'license.md', which is part of this source code package.
 */

namespace Edmunds\Bases\Http\Controllers;

use Edmunds\Http\Client\Input;
use Edmunds\Http\Request;
use Edmunds\Http\Response;
use Edmunds\Http\Client\Visitor;
use Edmunds\Validation\Validator;
use Laravel\Lumen\Routing\Controller;

/**
 * Controller base to extend from
 */
class BaseController extends Controller
{
	/**
	 * The default output type of the response, only used when set
	 * @var int
	 */
	protected $outputType;

	/**
	 * The current request
	 * @var Request
	 */
	protected $request;

	/**
	 * The current request
	 * @var Response
	 */
	protected $response;

	/**
	 * The input
	 * @var Input
	 */
	protected $input;

	/**
	 * The visitor
	 * @var Visitor
	 */
	protected $visitor;

	/**
	 * The constructor for the BaseController
	 */
	function __construct()
	{
		$this->request = Request::getInstance();
		$this->response = Response::getInstance();
		$this->visitor = Visitor::getInstance();
		$this->input = Input::getInstance();

		$this->response->outputType = $this->outputType ?? config('app.outputtype', $this->response->outputType);
	}

	/**
	 * The response flow of the controller
	 * @param string $method
	 * @param array $parameters
	 */
	public function responseFlow($method, $parameters)
	{
		//Initialiaz this controller
		$this->initialize();

		//Call the tight method
		$response = call_user_func_array(array($this, $method), $parameters);

		//set the status of the response
		if ($response === true || $response === false)
		{
			$this->response->assign('success', $response);
		}

		return $this->response->getResponse();
	}

	/**
	 * Function called after construct
	 */
	public function initialize()
	{
		//
	}

}
