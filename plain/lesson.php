<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('sslive_include.php');
	
	// Extract manual and lesson id from GET query
	$manual_id = intval($_GET['manual_id']);
	$lesson_id = intval($_GET['lesson_id']);
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlobject = $sslive->GetLesson($manual_id, $lesson_id);
	
	print ('<p><a href="manual.php?manual_id=' . $manual_id . '">Return to manual</a></p>' . "\n");
	
	if ($xmlobject) {
		print ('<h2>' . $xmlobject->title . "</h2>\n");
		print ('<p>' . $xmlobject->description . "</p>\n");
		
		if (count($xmlobject->steps->step) == 0)
		{
			print ("<p>Lesson has no steps.</p>\n");
		} else {
			foreach ($xmlobject->steps->step as $step) {
				print ('<h3>' . $step->title . "</h3>\n");
				print ('<p>' . $step->instructions . "</p>\n");
				print ('<p><img src="' . $step->media->url . 
					'" width="' . $step->media->width . '" height="' . $step->media->height . '" />' . "\n");
				print ('<p></p>' . "\n");
			}
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>