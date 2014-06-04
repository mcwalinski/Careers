<?php
	setcookie('VINEUSER', $_SERVER['HTTP_X_VINEUSER'], 0, '/');
	setcookie('VINEUSERTYPE', 'admin', 0, '/');
	header('Location: /careers/wp-login.php?redirect_to=/careers/wp-admin/index.php');
?>
