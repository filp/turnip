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

namespace turnip\ext;

/**
 * \turnip\ext\example
 *
 * @author Filipe Dobreira <github.com/FilipeD>
 * @package turnip
 */
class example extends \turnip\extension
{
	/**
	 * index
	 *
	 * routes are a mix of named parameters and regex.
	 * the :msg parameter is optional
	 *
	 * @route /:msg?
	 *
	 * @access public
	 * @param \turnip\application $app
	 * @return string
	 */
	public function index(\turnip\application $app)
	{
		echo $this->getView()
			 	  ->with(array('foo' => $app->getClient()->getInput('msg', 'welcome to the home page :|')))
			 	  ->renderFile('home.php');
	}
}