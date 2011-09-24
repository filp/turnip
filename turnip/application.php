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
 * \turnip\application
 *
 * @todo improve/add dependency injection methods
 * @author Filipe Dobreira <http://github.com/FilipeD>
 * @package turnip
 */
class application
{
	/**
	 * _autoloader
	 *
	 * @access protected
	 * @var \turnip\autoloader
	 */
	protected $_autoloader;

	/**
	 * _router
	 *
	 * @access protected
	 * @var \turnip\routing\router
	 */
	protected $_router;

	/**
	 * _request
	 *
	 * @access protected
	 * @var \turnip\client\request
	 */
	protected $_request;

	/**
	 * _config
	 * 
	 * @todo review
	 * @access protected
	 * @var \turnip\stdClass
	 */
	protected $_config;

	/**
	 * __construct
	 *
	 * @access public
	 * @param array $config
	 */
	public function __construct(array $config = array())
	{
		/**
		 * @todo this looks a bit iffy.
		 * @todo this doesn't really belong in the construct.
		 */ 
		if(!class_exists('\\turnip\\autoloader'))
		{
			require 'autoloader.php';
		}

		$this->_autoloader = new autoloader;
		$this->_router     = new routing\router;
		$this->_request    = new client\request;
	}

	/**
	 * getAutoloader
	 *
	 * @access public
	 * @return \turnip\autoloader
	 */
	public function getAutoloader()
	{
		return $this->_autoloader;
	}

	/**
	 * getRouter
	 *
	 * @access public
	 * @return \turnip\routing\router
	 */
	public function getRouter()
	{
		return $this->_router;
	}

	/**
	 * getClientRequest
	 *
	 * @access public
	 * @return \turnip\client\request
	 */
	public function getClientRequest()
	{
		return $this->_request;
	}
}