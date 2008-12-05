<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract Space id from GET query
	$space_id = intval($_GET['space_id']);
	
	$xmlArray = $sslive->GetSpace($space_id);

	print ('<p><a href="spaces.php">Return to Spaces</a></p>' . "\n");
	
	if ($xmlArray) {
		$space_id = $xmlArray['id'];
		
		print ('<h2>'. $xmlArray['title'] . '</h2>');

		if (count($xmlArray['assets']['asset']) == 0) {
			print "<p>Space has no assets.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlArray['assets']['asset'] as $asset) {
				if (strtolower($asset['type']) == 'manual')
					$url = 'manual.php?manual_id';
				else
					$url = 'bucket.php?bucket_id';
					
				print ('<li><a href="' . $url . '=' . $asset['id'] . '&space_id=' . $space_id . '">' . $asset['title'] . "</a></li>\n");
			}
			print ("</ul>\n");
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>