<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	$bucket_id = $sslive->CleanseID($_GET['bucket_id']);
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlArray = $sslive->GetBucket($space_id, $bucket_id);

	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $xmlArray['space'][0]['title'] . '"</a></p>' . "\n");
	
	if (is_array($xmlArray)) {
		$bucket_id = $xmlArray['id'];
		
		print ('<h2>'. $xmlArray['title'] . '</h2>');

		if (count($xmlArray['lessons']['lesson']) == 0) {
			print "<p>Bucket has no lessons.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlArray['lessons']['lesson'] as $lesson) {
				print ('<li><a href="lesson.php?space_id=' . $space_id . '&bucket_id=' . $bucket_id . '&lesson_id=' . $lesson['id'] . '">' . 
					$lesson['title'] . "</a></li>\n");
			}
			print ("</ul>\n");
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>