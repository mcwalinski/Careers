<?php

/**
* 
* Example plugin for unit testing.
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/resources/Savant2_Plugin_cycle2.php 1.2 2009/03/02 10:31:07EST ANDERSONJL Exp  $
*
*/

require_once 'Savant2/Plugin.php';

class Savant2_Plugin_cycle extends Savant2_Plugin {
	function plugin()
	{
		return "REPLACES DEFAULT CYCLE";
	}
}
?>