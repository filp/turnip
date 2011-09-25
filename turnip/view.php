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
 * \turnip\view
 *
 * @author Filipe Dobreira <github.com/FilipeD>
 * @package turnip
 */
class view
{
	/**
	 * _properties
	 *
	 * @access protected
	 * @var array
	 */
	protected $_properties;

	/**
	 * _fileRoot
	 *
	 * @access protected
	 * @var string
	 */
	protected $_fileRoot;

	/**
	 * __construct
	 *
	 * @access public
	 * @param array $defaultProperties
	 */
	public function __construct(array $defaultProperties = array())
	{
		$this->_properties = $defaultProperties;
	}

	/**
	 * setFileRoot
	 *
	 * @access public
	 * @param string $fileRoot
	 * @return \turnip\view
	 */
	public function setFileRoot($fileRoot)
	{
		$this->_fileRoot = $fileRoot;
		return $this;
	}

	/**
	 * with
	 *
	 * @access public
	 * @param array $properties
	 * @return \turnip\view
	 */
	public function with(array $properties)
	{
		$this->_properties = array_merge($this->_properties, $properties);
		return $this;
	}

	/**
	 * renderFile
	 *
	 * @access public
	 * @param string $filePath
	 * @return string
	 */
	public function renderFile($filePath)
	{
		if($this->_properties)
		{
			extract($this->_properties);
		}

		ob_start();
		require   $this->_fileRoot . DIRECTORY_SEPARATOR
		        . ltrim($filePath, '/' . DIRECTORY_SEPARATOR);
		return ob_get_clean();
	}
}