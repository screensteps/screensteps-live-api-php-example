<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	if (isset($_GET['manual_id'])) $manual_id = $sslive->CleanseID($_GET['manual_id']);
	if (isset($_GET['bucket_id'])) $bucket_id = $sslive->CleanseID($_GET['bucket_id']);
	$lesson_id = $sslive->CleanseID($_GET['lesson_id']);
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	if (isset($manual_id))
		$xmlArray = $sslive->GetManualLesson($space_id, $manual_id, $lesson_id);
	else
		$xmlArray = $sslive->GetBucketLesson($space_id, $bucket_id, $lesson_id);
	
	//pr($xmlArray);
	
	// Spaces link
	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $xmlArray['space']['title'] . '"</a></p>' . "\n");
	
	if (is_array($xmlArray)) 
	{
		if (isset($manual_id))
		{
			// Links for manual
			print ('<p><a href="manual.php?space_id=' . $space_id . '&manual_id=' . $manual_id . '">Return to Manual "' . $xmlArray['manual']['title'] . '"</a></p>' . "\n");
			
			if (!empty($pdfLink)) print '<p><a href="'. $pdfLink . '">Download PDF</a></p>';
			
			if (is_array($xmlArray['manual']['previous_lesson']))
			{
				print ('<p><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $manual_id . 
						'&lesson_id=' . $xmlArray['manual']['previous_lesson']['id'] . '">Previous Lesson "' . 
						$xmlArray['manual']['previous_lesson']['title'] . '"</a></p>' . "\n");
			}
						
			if (is_array($xmlArray['manual']['next_lesson']))
			{
				print ('<p><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $manual_id . 
						'&lesson_id=' . $xmlArray['manual']['next_lesson']['id'] . '">Next Lesson "' . 
						$xmlArray['manual']['next_lesson']['title'] . '"</a></p>' . "\n");
			}
		}
		else
		{
			// Links for bucket
			print ('<p><a href="bucket.php?space_id=' . $space_id . '&bucket_id=' . $bucket_id . '">Return to Bucket "' . $xmlArray['bucket']['title'] . '"</a></p>' . "\n");
		}
		
		// Lesson info
		print ('<h2>' . $xmlArray['title'] . "</h2>\n");
		if ( is_array($xmlArray['tags']['tag']) ) {
			print '<h3>Tags:</h3>';
			print '<ul>';
			foreach ($xmlArray['tags']['tag'] as $value) {
				print '<li>' . $value['name'] . '</li>';
			}
			print '</ul>';
		}
		print ('<p>' . $xmlArray['description'] . "</p>\n");
		
		// Steps
		if (!isset($xmlArray['steps']['step']) || count($xmlArray['steps']['step']) == 0)
		{
			print ("<p>Lesson has no steps.</p>\n");
		} else {
			foreach ($xmlArray['steps']['step'] as $step) {
				print ('<h3>' . $step['title'] . "</h3>\n");
				print ('<p>' . $step['instructions'] . "</p>\n");
				
				// Step media
				if (isset($step['media'])) {
					print ('<p><img src="' . $step['media'][0]['url'] . 
						'" width="' . $step['media'][0]['width'] . '" height="' . $step['media'][0]['height'] . '" />' . "\n");
					print ('<p></p>' . "\n");
				}
			}
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>