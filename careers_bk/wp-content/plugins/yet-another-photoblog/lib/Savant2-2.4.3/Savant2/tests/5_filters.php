<?php

/**
* 
* Tests filters and plugins
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/5_filters.php 1.2 2009/03/02 10:31:00EST ANDERSONJL Exp  $
* 
*/


error_reporting(E_ALL);

require_once 'Savant2.php';

$conf = array(
	'template_path' => 'templates',
	'resource_path' => 'resources'
);

$savant =& new Savant2($conf);

// set up filters
$savant->loadFilter('colorizeCode');
$savant->loadFilter('trimwhitespace');
$savant->loadFilter('fester', null, true);

// run through the template
$savant->display('filters.tpl.php');

// do it again to test object persistence
$savant->display('filters.tpl.php');

// do it again to test object persistence
$savant->display('filters.tpl.php');

echo "<hr />\n";
echo "<pre>";
print_r($savant);
echo "</pre>";

?>