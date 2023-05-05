<?php
	IF (!$EWT_DB_NAME && !$EWT_DB_USER) {
		echo "Please check configuration and try again. [$EWT_DB_NAME&&!$EWT_DB_USER]<br>";
	}
	IF (!$EWT_DB_NAME) $EWT_DB_NAME = $EWT_DB_USER;
	$db = new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_NAME);
	$connectdb = $db->CONNECT_SERVER();
	//$db->query("SET NAMES 'utf8' ");
?>