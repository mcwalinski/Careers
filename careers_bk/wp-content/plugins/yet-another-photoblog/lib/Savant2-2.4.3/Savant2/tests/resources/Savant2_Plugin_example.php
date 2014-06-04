<?php

/**
* 
* Example plugin for unit testing.
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/resources/Savant2_Plugin_example.php 1.2 2009/03/02 10:31:08EST ANDERSONJL Exp  $
*
*/

require_once 'Savant2/Plugin.php';

class Savant2_Plugin_example extends Savant2_Plugin {
	
	var $msg = "Example: ";
	
	function plugin()
	{
		echo $this->msg . "this is an example!";
	}
}
?>