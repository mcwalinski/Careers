<?php

/**
*
* Example plugin for unit testing.
* 
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/resources/Savant2_Plugin_fester.php 1.2 2009/03/02 10:31:09EST ANDERSONJL Exp  $
*
*/

require_once 'Savant2/Plugin.php';

class Savant2_Plugin_fester extends Savant2_Plugin {
	
	var $message = "Fester";
	var $count = 0;
	
	function Savant2_Plugin_fester()
	{
		// do some other constructor stuff
		$this->message .= " is printing this: ";
	}
	
	function plugin(&$text)
	{
		$output = $this->message . $text . " ({$this->count})";
		$this->count++;
		return $output;
	}
}
?>