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
 * PSR-0 standard autoloader:
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 *
 * @author Filipe Dobreira <github.com/FilipeD>
 * @package turnip
 */
class autoloader
{
	/**
	 * _map
	 * 
	 * An associative array mapping class names
	 * to absolute or relative file paths. Names
	 * on this list bypass the regular autoloader
	 * pattern.
	 *
	 * Might be useful once we start kicking in
	 * all that backwards compatibility.
	 *
	 * @access protected
	 * @var array
	 */
	protected $_map;

	/**
	 * _root
	 *
	 * The root path under which all files for this
	 * instance are loaded.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_root;

	/**
	 * __construct
	 *
	 * Registers this autoloader with the autoloader
	 * stack. (throw:true, prepend:true).
	 *
	 * @access public
	 * @see spl_autoload_register
	 */
	public function __construct()
	{
		spl_autoload_register(array($this, 'load'), true, true);
	}

	/**
	 * setRoot
	 *
	 * @see \turnip\autoloader::$_root
	 * @access public
	 * @param string $root
	 * @return \turnip\autoloader
	 */
	public function setRoot($root)
	{
		$this->_root = $root;
		return $this;
	}

	/**
	 * getRoot
	 *
	 * @see \turnip\autoloader::$_root
	 * @access public
	 * @return string|null
	 */
	public function getRoot()
	{
		return $this->_root;
	}

	/**
	 * unregister
	 *
	 * Unregister this autoloader instance from the
	 * autoloader stack.
	 *
	 * @access public
	 * @see spl_autoload_unregister
	 */
	public function unregister()
	{
		spl_autoload_unregister(array($this, 'load'));
	}

	/**
	 * map
	 * 
	 * Maps a single, or a list of class names
	 * to absolute or relative paths to their
	 * files.
	 *
	 * e.g:
	 * array('Registry' => 'legacy/registry.php')
	 *
	 * @access public
	 * @param array $map
	 */
	public function map(array $map)
	{
		$this->_map = array_merge((array) $this->_map, $map);
	}

	/**
	 * mappedTo
	 * 
	 * Given a class name, returns its mapped filename,
	 * or false if none is set.
	 *
	 * @access public
	 * @param string $className
	 * @return string|bool
	 */
	public function mappedTo($className)
	{
		return isset($this->_map[$className]) ? $this->_map[$className] : false;
	}

	/**
	 * load
	 *
	 * Given a class name, loads the corresponding file
	 * by applying the PSR-0 standard for autoloader 
	 * interoperability.
	 *
	 * The standard routine is ignored if the given
	 * class exists in the internal $_map list.
	 *
	 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
	 * @access public
	 * @param string $className
	 */
	public function load($className)
	{
		if(isset($this->_map[$className]))
		{
			$fileName = $this->_map[$className];
		}
		else
		{
			$className = ltrim($className, '\\');
			$fileName  = $this->_root ? $this->_root . DIRECTORY_SEPARATOR : '';
			$namespace = '';
			if ($lastNsPos = strripos($className, '\\')) {
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		    }

			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		}

	    require $fileName;
	}
}