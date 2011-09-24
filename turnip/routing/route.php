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

/**
 * \turnip\routing\route
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
	 * _c_route
	 *
	 * A compiled representation of the route.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_c_route;

	/**
	 * __construct
	 *
	 * @access public
	 * @param string $route
	 */
	public function __construct($route)
	{
		$this->_route = $route;
		$this->_compile();
	}

	/**
	 * matches
	 *
	 */
	

	/**
	 * _compile
	 *
	 * Converts the route, which may include
	 * :named-parameters, to a valid regular-
	 * -expression.
	 *
	 * @access protected
	 */
	protected function _compile()
	{
		$route = $this->_route;
		$route = preg_replace('/:([\w\d]+)/', '(P<$1>.+)', $route);
		$route = '/^' . $route . '\/?$/i';

		var_dump($route);
	}
}