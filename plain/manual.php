<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('sslive_include.php');
	
	// Extract manual id from GET query
	$manual_id = intval($_GET['manual_id']);
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlobject = $sslive->GetManual($manual_id);

	print ('<p><a href="manuals.php">Return to manuals</a></p>' . "\n");
	
	if ($xmlobject) {
		$manual_id = $xmlobject->id;
		
		print ('<h2>'. $xmlobject->title . '</h2>');

		if (count($xmlobject->sections->section) == 0) {
			print "<p>Manual has no sections.</p>";
		} else {
			foreach ($xmlobject->sections->section as $section) {
				print ('<h3>' . $section->title . '</h3>');
				
				print ("<ul>\n");
				foreach ($section->lessons->lesson as $lesson) {
					print ('<li><a href="lesson.php?manual_id=' . $manual_id . '&lesson_id=' . $lesson->id . '">' . 
						$lesson->title . "</a></li>\n");
				}
				print ("</ul>\n");
			}
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>