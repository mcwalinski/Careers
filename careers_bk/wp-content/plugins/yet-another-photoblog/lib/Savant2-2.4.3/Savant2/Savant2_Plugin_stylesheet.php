<?php

/**
* Base plugin class.
*/
require_once 'Savant2/Plugin.php';

/**
* 
* Outputs a <link ... /> to a CSS stylesheet.
* 
* $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/Savant2_Plugin_stylesheet.php 1.2 2009/03/02 10:30:57EST ANDERSONJL Exp  $
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

class Savant2_Plugin_stylesheet extends Savant2_Plugin {

	/**
	* 
	* Output a <link ... /> to a CSS stylesheet.
	* 
	* @access public
	* 
	* @param object &$savant A reference to the calling Savant2 object.
	* 
	* @param string $href The HREF leading to the stylesheet file.
	* 
	* @return string
	* 
	*/
	
	function plugin($href)
	{
		return '<link rel="stylesheet" type="text/css" href="' .
			htmlspecialchars($href) . '" />';
	}

}

?>