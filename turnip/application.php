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
 * \turnip\autoloader
 *
 * @author Filipe Dobreira <github.com/FilipeD>
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
	 * _client
	 *
	 * @access protected
	 * @var \turnip\client
	 */
	protected $_client;

	/**
	 * _router
	 *
	 * @access protected
	 * @var \turnip\router
	 */
	protected $_router;

	/**
	 * _config
	 *
	 * @access protected
	 * @var array
	 */
	protected $_config;

	/**
	 * __construct
	 *
	 * @access public
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->_config = $config;

		if(!class_exists('\\turnip\\autoloader'))
		{
			require 'autoloader.php';
		}

		$this->_autoloader = new autoloader;
		$this->getAutoloader()
		     ->setRoot(dirname(__DIR__));

		$this->_client     = new client;
		$this->_router     = new router(
								  isset($config['ext'])
								? $config['ext']
								: array()
							);
		$this->getRouter()->dispatch($this);
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
	 * getClient
	 *
	 * @access public
	 * @return \turnip\client
	 */
	public function getClient()
	{
		return $this->_client;
	}

	/**
	 * getRouter
	 *
	 * @access public
	 * @return \turnip\router
	 */
	public function getRouter()
	{
		return $this->_router;
	}
}