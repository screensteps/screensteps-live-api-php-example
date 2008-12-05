<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $_GET['space_id'];
	$manual_id = $_GET['manual_id'];
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlArray = $sslive->GetManual($space_id, $manual_id);

	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $xmlArray['space']['title'] . '"</a></p>' . "\n");
	
	if (is_array($xmlArray)) {
		$manual_id = $xmlArray['id'];
		
		print ('<h2>'. $xmlArray['title'] . '</h2>');

		if (count($xmlArray['chapters']['chapter']) == 0) {
			print "<p>Manual has no chapters.</p>";
		} else {
			foreach ($xmlArray['chapters']['chapter'] as $chapter) {
				print ('<h3>' . $chapter['title'] . '</h3>');
				
				print ("<ul>\n");
				foreach ($chapter['lessons']['lesson'] as $lesson) {
					print ('<li><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $manual_id . '&lesson_id=' . $lesson['id'] . '">' . 
						$lesson['title'] . "</a></li>\n");
				}
				print ("</ul>\n");
			}
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>