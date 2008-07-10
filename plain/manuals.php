<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('sslive_include.php');
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlobject = $sslive->GetManuals();
	
	print ("<h2>Manuals</h2>\n");
	
	if ($xmlobject) {
		if (count($xmlobject) == 0) {
			print "<p>No manuals found.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlobject as $manual) {
				print ('<li><a href="manual.php?manual_id=' . $manual->id . '">' . $manual->title . "</a></li>\n");
			}
			print ("</ul>\n");
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>