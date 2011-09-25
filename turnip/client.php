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
 * \turnip\client
 *
 * Abstraction of a client (user). This class provides
 * methods for both input and output, through adaptable
 * interfaces. (eventually, I mean)
 *
 * @todo review and cleanup
 * @author Filipe Dobreira <github.com/FilipeD>
 * @package turnip
 */
class client
{
	/**
	 * _requestUri
	 *
	 * @access protected
	 * @var string
	 */
	protected $_requestUri;

	/**
	 * _requestRoot
	 *
	 * @access protected
	 * @var string
	 */
	protected $_requestRoot;

	/**
	 * _input
	 *
	 * @access protected
	 * @var string
	 */
	protected $_input;

	/**
	 * __construct
	 *
	 * @access public
	 */
	public function __construct()
	{
		if($this->isCli())
		{
			// do something, man!
		}
		else
		{
			$this->_input = $_REQUEST;
		}
	}

	/**
	 * isCli
	 *
	 * Is this request done in a CLI context?
	 *
	 * @access public
	 * @return bool
	 */
	public function isCli()
	{
		return php_sapi_name() == 'CLI';	
	}

	/**
	 * addToInput
	 *
	 * Merges extra data to the client's input set.
	 * Used by exterior handlers, to provide client
	 * input from other sources in a single point.
	 *
	 * @access public
	 * @param array $extraInput
	 * @return \turnip\client
	 */
	public function addToInput(array $extraInput)
	{
		$this->_input = array_merge($this->_input, $extraInput);
		return $this;
	}

	/**
	 * getInput
	 *
	 * Return an input parameter, from $_REQUEST
	 * 
	 * @access public
	 * @param string $parameter
	 * @param mixed $default
	 * @return mixed
	 */
	public function getInput($parameter, $default = null)
	{
		return   isset($this->_input[$parameter])
			   ? $this->_input[$parameter]
			   : $default;
	}

	/**
	 * getRequestUri
	 *
	 * Returns the usable uri portion for this
	 * client's request.
	 *
	 * @access public
	 * @return string
	 */
	public function getRequestUri()
	{
		if($this->_requestUri === null)
		{
			$uri  = $_SERVER['REQUEST_URI'];
			$base = dirname($_SERVER['SCRIPT_NAME']);
			$this->_requestUri = substr($uri, strlen($base));
		}

		return $this->_requestUri;
	}

	/**
	 * getRequestRoot
	 *
	 * Returns the base path for this client's request.
	 *
	 * @access public
	 * @return string
	 */
	public function getRequestRoot()
	{
		if($this->_requestRoot === null)
		{
			$this->_requestRoot = dirname($_SERVER['SCRIPT_NAME']);
		}

		return $this->_requestRoot;
	}
}