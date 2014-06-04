<?php

/**
* 
* Tests default plugins
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/8_extend.php 1.2 2009/03/02 10:31:02EST ANDERSONJL Exp  $
* 
*/

error_reporting(E_ALL);

require_once 'Savant2.php';

$conf = array(
	'template_path' => 'templates',
	'resource_path' => 'resources'
);

$savant =& new Savant2($conf);

$savant->display('extend.tpl.php');

?>