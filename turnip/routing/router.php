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

namespace turnip\routing;
use \turnip\routing\route,
	\turnip\routing\exception;

/**
 * \turnip\routing\router
 *
 * @author Filipe Dobreira <http://github.com/FilipeD>
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
	 * @param array $routes
	 */
	public function __construct(array $routes = array())
	{
		$this->addRoutes($routes);
	}

	/**
	 * addRoutes
	 *
	 * Adds a new set of routes to this instance's stack.
	 *
	 * Example input:
	 *
	 *	array(
	 *		array('/gallery', $handler),
	 *		array('/', $handler),
	 *		array('/', $handler)
	 *	)
	 *
	 * @todo Seriously missing an array.extend method short of some
	 * 		 call_user_func_array hackery.
	 * @access public
	 * @param array $routes
	 * @return \turnip\routing\router
	 */
	public function addRoutes(array $routes)
	{
		foreach($routes as $route)
		{
			$this->_routes[] = $route;
		}

		return $this;
	}

	/**
	 * _isValidRoute
	 *
	 * @access protected
	 * @param mixed $route
	 * @return bool
	 */
	protected function _isValidRoute($route)
	{
		return (is_array($route) && isset($route[0], $route[1]));
	}

	/**
	 * dispatch
	 *
	 * Checks the stored routes for a match, given
	 * a \turnip\client\request instance. Returns
	 * true if a match was found and successfully handled.
	 *
	 * Structure of $this->_routes (example):
	 *
	 *	array(
	 *		array(
	 *			'/' 	   => <handler>,
	 *			'/thing'   => <handler>
	 *		)
	 *		array(
	 *			'/'        => <handler>,
	 *			'/gallery' => <handler>
	 *		)
	 *	)
	 *
	 * <handler> may be a handler, or a reference
	 * to an appropriate handler that this router
	 * understands. 
	 *
	 * @todo validating a route should be done in the route class.
	 * @todo refine description
	 * @access public
	 * @param \turnip\client\request $request
	 * @return bool
	 */
	public function dispatch(\turnip\client\request $request)
	{
		foreach($this->_routes as $route)
		{
			if(!$this->_isValidRoute($route))
			{
				throw new exception("Invalid route format. Routes are represented as two values: (/route/path, handler).");
			}

			$handler = $route[1];
			$route   = new route($route[0]);

			if(false !== ($matches = $route->matches(' < REQUEST URI > ')))
			{
				// . . .
			}
		}

		return false;
	}
}