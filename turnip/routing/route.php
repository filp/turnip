<?php

/*
 * This file is part of turnip by Filipe Dobreira
 *
 * turnip is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * turnip is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with turnip.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace turnip\routing;

/**
 * \turnip\routing\route
 *
 * Improved regular expression for matching named parameters
 * taken from the Slim micro-framework: http://slimframework.com
 *
 * @author Filipe Dobreira <http://github.com/FilipeD>
 * @package turnip
 */
class route
{
	/**
	 * _route
	 *
	 * The route (uri) that this instance represents.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_route;

	/**
	 * __construct
	 *
	 * @access public
	 * @param string $route
	 */
	public function __construct($route)
	{
		$this->_route = $route;
	}

	/**
	 * matches
	 *
	 * Matches this route against a given uri. If a
	 * match is found, returns array of matched params,
	 * else returns false.
	 *
	 * @access public
	 * @param string $uri
	 * @return bool|array
	 */
	public function matches($uri)
	{
		$route = str_replace('/', '\/', $this->_route);
		$route = preg_replace('/:([a-zA-Z0-9_\-\.\!\~\*\\\'\(\)\:\@\&\=\$\+,%]+)/', '(?P<$1>.+)', $route);
		$route = '/^' . $route . '\/?$/i';

		if(preg_match($route, $uri, $matches))
		{
			return $matches;
		}

		return false;
	}
}