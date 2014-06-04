<?php

/**
* 
* Tests default plugins
*
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/a_classExists.php 1.2 2009/03/02 10:31:03EST ANDERSONJL Exp  $
* 
*/

error_reporting(E_ALL);

function __autoload($class) {
    echo "(trying autoload) ";
    return false;
}


require_once 'Savant2.php';

$savant =& new Savant2();

echo "<pre>";

echo "PHP " . PHP_VERSION . " Savant2: ";
var_dump($savant->_classExists('Savant2'));
echo "\n\n";

echo "PHP " . PHP_VERSION . " SavantX: ";
var_dump($savant->_classExists('SavantX'));
echo "\n\n";

$savant->setAutoload(true);

echo "PHP " . PHP_VERSION . " Savant2 with __autoload(): ";
var_dump($savant->_classExists('Savant2'));
echo "\n\n";

echo "PHP " . PHP_VERSION . " SavantX with __autoload(): ";
var_dump($savant->_classExists('SavantX'));
echo "\n\n";


echo "</pre>";


?>