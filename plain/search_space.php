<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	$search_term = 'answer'; //$GET['search_term']
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlArray = $sslive->SearchSpace($space_id, $search_term);

	print ('<p><a href="spaces.php">Return to Spaces</a></p>' . "\n");
	
	if (is_array($xmlArray)) {
		$bucket_id = $xmlArray['id'];
		
		print ('<h2>'. $xmlArray['title'] . '</h2>');

		if (count($xmlArray['lessons']['lesson']) == 0) {
			print "<p>No lessons found.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlArray['lessons']['lesson'] as $lesson) {
				// Just linking to first asset
				if (strtolower($lesson['asset'][0]['type']) == 'manual') {
					print ('<li><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $lesson['asset'][0]['id'] . '&lesson_id=' . $lesson['id'] . '">' . 
						$lesson['title'] . "</a></li>\n");
				} else {
					print ('<li><a href="lesson.php?space_id=' . $space_id . '&bucket_id=' . $lesson['asset'][0]['id'] . '&lesson_id=' . $lesson['id'] . '">' . 
						$lesson['title'] . "</a></li>\n");
				}
			}
			print ("</ul>\n");
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>