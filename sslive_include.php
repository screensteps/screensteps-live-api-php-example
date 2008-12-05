<?php
	// Include ScreenSteps Live class file
	require_once('sslive_class.php');
	
	// Create ScreenSteps Live object using your domain and API key
	//$sslive = new SSLiveAPI('example.screenstepslive.com', '12e5317e88', 'http');
	//$sslive = new SSLiveAPI('bluemango.screenstepsdev.com', '5776879a8844170', 'http');
	$sslive = new SSLiveAPI('bmls.screenstepslive.com', '7fc90783ee62641', 'http');
	
	// Set to true to return manuals and lessons that are protected.
	$sslive->show_protected = false;
?>