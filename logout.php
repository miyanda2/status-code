<?php
	require_once('functions.php');

	$sessionHandler = new HmsSessionHandler();
	$sessionHandler->destroyAllSession();

	redirectTo('index.html');

?>