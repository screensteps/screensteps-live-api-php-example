<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlArray = $sslive->GetSpaces();

	print ("<h2>Spaces</h2>\n");
	
	if ($xmlArray) {
		if (count($xmlArray) == 0) {
			print "<p>No spaces found.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlArray['space'] as $space) {
				print ('<li><a href="space.php?space_id=' . $space['id'] . '">' . $space['title'] . 
					'</a> (<a href="search_space.php?space_id=' . $space['id'] . '">search space</a>)' . 
					"</li>\n");
			}
			print ("</ul>\n");
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>