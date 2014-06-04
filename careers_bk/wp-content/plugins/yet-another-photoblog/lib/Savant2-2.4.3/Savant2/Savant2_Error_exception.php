<?php

/**
* The base Savant2_Error class.
*/
require_once 'Savant2/Error.php';

/**
* A simple Savant2_Exception class.
*/
class Savant2_Exception extends Exception { };

/**
* 
* Throws PHP5 exceptions for Savant.
*
* $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/Savant2_Error_exception.php 1.2 2009/03/02 10:30:39EST ANDERSONJL Exp  $
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

class Savant2_Error_exception extends Savant2_Error {
	
	
	/**
	* 
	* Throws an Savant2_Exception in PHP5.
	* 
	* @return void
	* 
	*/
	
	function error()
	{
		// throw new Savant2_Exception($this->text, $this->code);
	}
}
?>