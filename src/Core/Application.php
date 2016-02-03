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

namespace Core;
use Core\Analytics\Tracking\PageviewLog;
use Core\Database\Migrations\Migrator;
use Core\Exceptions\AbortHttpException;
use Core\Http\Client\Auth;
use Core\Http\Client\Visitor;
use Core\Http\Request;
use Core\Http\Response;
use Core\Providers\HttpServiceProvider;
use Core\Registry;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

/**
 * The structure for application
 *
 * @author		Lowie Huyghe <iam@lowiehuyghe.com>
 * @copyright	Copyright (C) 2015, Lowie Huyghe. All rights reserved. Unauthorized copying of this file, via any medium is strictly prohibited. Proprietary and confidential.
 * @license		http://LicenseUrl
 * @since		Version 0.
 */
class Application extends \Laravel\Lumen\Application
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
	 * Dispatch the incoming request.
	 *
	 * @param  SymfonyRequest|null $request
	 * @return Response
	 */
	public function dispatch($request = null)
	{
		try
		{
			if ($this->isDownForMaintenance())
			{
				abort(503);
			}

			$response = parent::dispatch($request);
		}
		catch (AbortHttpException $e)
		{
			$response = Response::getInstance()->getResponse();
		}

		$this->logPageView($response, isset($exception) ? $exception : null);
		// and send them all
		Registry::warehouse()->flush();

		return $response;
	}

	/**
	 * Handle a route found by the dispatcher.
	 *
	 * @param  array  $routeInfo
	 * @return mixed
	 */
	protected function handleFoundRoute($routeInfo)
	{
		if (isset($routeInfo[1]['uses']))
		{
			list($controller, $method) = explode('@', $routeInfo[1]['uses']);

			// change method
			$routeInfo[1]['uses'] = implode('@', array($controller, 'responseFlow'));

			// change parameters
			$routeInfo[2] = array($method, $routeInfo[2]);
		}

		return parent::handleFoundRoute($routeInfo);
	}

	/**
	 * Throw an HttpException with the given data.
	 *
	 * @param  int     $code
	 * @param  string  $message
	 * @param  array   $headers
	 * @return void
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 */
	public function abort($code, $message = '', array $headers = [])
	{
		switch($code)
		{
			case 200:
				throw new AbortHttpException($message);
			case 401:
				throw new UnauthorizedHttpException('Basic', $message);
			case 403:
				throw new AccessDeniedHttpException($message);
			case 404:
				throw new NotFoundHttpException($message);
			case 503:
				throw new ServiceUnavailableHttpException(null, $message);
			default:
				throw new HttpException($code, $message, null, $headers);
		}
	}

	/**
	 * Log the pageview
	 * @param Response $response
	 * @param Exception $exception
	 */
	protected function logPageView($response, $exception = null)
	{
		if (!$this->runningInConsole() && !$this->isDownForMaintenance())
		{
			$pageview = new PageviewLog();

			//Fetch title
			$regex = "/<title>((.|\n)*?)<\/title>/i";
			$matches = array();
			if (preg_match($regex, $response->getContent(), $matches))
			{
				$pageview->title = trim($matches[1]);
			}

			$pageview->log();
		}
	}

}
