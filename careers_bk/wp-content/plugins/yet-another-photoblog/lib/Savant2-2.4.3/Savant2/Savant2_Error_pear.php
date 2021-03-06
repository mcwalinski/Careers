<?php

/**
* The base Savant2_Error class.
*/
require_once 'Savant2/Error.php';

/**
* The PEAR_Error class.
*/
require_once 'PEAR.php';

/**
* 
* Provides an interface to PEAR_ErrorStack class for Savant.
*
* $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/Savant2_Error_pear.php 1.2 2009/03/02 10:30:40EST ANDERSONJL Exp  $
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
* @package Savant2
* 
* @license LGPL http://www.gnu.org/copyleft/lesser.html
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as
* published by the Free Software Foundation; either version 2.1 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
* 
*/

class Savant2_Error_pear extends Savant2_Error {
	
	
	/**
	* 
	* Extended behavior for PEAR_Error.
	*
	* @access public
	*
	* @return void
	*
	*/
	
	function error()
	{
		// throw a PEAR_Error
		PEAR::throwError($this->text, $this->code, $this->info);
	}
}
?>