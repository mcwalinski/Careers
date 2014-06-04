<?php
/**
* 
* Template for testing token assignment.
* 
* @version $Id: wordpress/careers/wp-content/plugins/yet-another-photoblog/lib/Savant2-2.4.3/Savant2/tests/templates/test.tpl.php 1.2 2009/03/02 10:31:16EST ANDERSONJL Exp  $
*
*/
?>
<p><?php echo $this->variable1 ?></p>
<p><?php echo $this->variable2 ?></p>
<p><?php echo $this->variable3 ?></p>
<p><?php echo $this->key0 ?></p>
<p><?php echo $this->key1 ?></p>
<p><?php echo $this->key2 ?></p>
<p><?php echo $this->reference1 ?></p>
<p><?php echo $this->reference2 ?></p>
<p><?php echo $this->reference3 ?></p>
<ul>
<?php foreach ($this->set as $key => $val) echo "<li>$key = $val</li>\n" ?>
</ul>
