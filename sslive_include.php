<?php
	// Include ScreenSteps Live class file
	require_once('sslive_class.php');
	
	// Create ScreenSteps Live object using your domain and API key
	//$sslive = new SSLiveAPI('example.screenstepslive.com', 'http');
	//$sslive->SetAPIKey('12e5317e88');
	
	//$sslive = new SSLiveAPI('bluemango.screenstepsdev.com', 'http');
	//$sslive->SetAPIKey('5776879a8844170');

	$sslive = new SSLiveAPI('bluemango.screenstepsdev.com', 'http');
	$sslive->SetUserCredentials('treader', 'test');
?>