<?php

/*
 *	This file is part of turnip by Filipe Dobreira
 *
 *	turnip is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	turnip is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with turnip.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace turnip;

/**
 * \turnip\router
 *
 * @author Filipe Dobreira <github.com/FilipeD>
 * @package turnip
 */
class router
{
	/**
	 * _routes
	 *
	 * @access protected
	 * @var array
	 */
	protected $_routes;

	/**
	 * __construct
	 *
	 * @access public
	 * @param array $listeners
	 */
	public function __construct(array $listeners)
	{
		$this->_routes = array();

		foreach($listeners as $listener)
		{
			$className = "\\turnip\\ext\\$listener";
			$class     = new $className;

			$reflection = new \ReflectionClass($class);
			$methods    = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach((array) $methods as $method)
			{
				$doc = $method->getDocComment();
				if(preg_match_all('/@route *(.+)/i', $doc, $matches))
				{
					if(!isset($matches[1]))
					{
						continue;
					}

					foreach($matches[1] as $route)
					{
						$this->_routes[] = array(trim($route), array($className, $method->getShortName()));
					}
				}
			}
		}
	}

	/**
	 * dispatch
	 *
	 * @access public
	 * @param \turnip\application $app
	 */
	public function dispatch(\turnip\application $app)
	{
		ksort($this->_routes);
		foreach($this->_routes as $route)
		{
			$callable = $route[1];
			$route    = str_replace('/', '\/', $route[0]);
			$route    = preg_replace('/:([a-zA-Z0-9_\-\.\!\~\*\\\'\(\)\:\@\&\=\$\+,%]+)/', '(?P<$1>.+)', $route);
			$route    = '/^' . $route . '\/?$/i';

			if(preg_match($route, $app->getClient()->getRequestUri(), $matches))
			{
				if($matches)
				{
					array_shift($matches);
					$app->getClient()->addToInput($matches);
				}

				// instantiate the callable class:
				$callable[0] = new $callable[0];
				
				$ext = call_user_func($callable, $app);
				// routes can be skipped by returning false.
				if($ext === false)
				{
					continue;
				}

				return $ext;
			}
		}
	}
}