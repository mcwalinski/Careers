<?php

/**
* 
* Example plugin for unit testing.
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/resources/Savant2_Plugin_example_extend.php 1.2 2009/03/02 10:31:08EST ANDERSONJL Exp  $
*
*/

$this->loadPlugin('example');

class Savant2_Plugin_example_extend extends Savant2_Plugin_example {
	
	var $msg = "Extended Example! ";
	
}
?>