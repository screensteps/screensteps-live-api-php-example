<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	$manual_id = $sslive->CleanseID($_GET['manual_id']);
	
	$isSearching = isset($_GET['search_term']) && !empty($_GET['search_term']);
	
	if ($isSearching) 
	{
		$xmlArray = $sslive->SearchManual($space_id, $manual_id, $_GET['search_term']);
		$spaceTitle = $_GET['space_title'];
		$manualTitle = $_GET['manual_title'];
	} else {
		$xmlArray = $sslive->GetManual($space_id, $manual_id);
		$spaceTitle = $xmlArray['space']['title'];
		$manualTitle = $xmlArray['title'];
	}
	
	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $spaceTitle . '"</a></p>' . "\n");

	print ('<p>Search manual: <form method="get" action="manual.php?">');
	print ('<input name="search_term" type="text">');
	print ('<input name="space_id" type="hidden" value="'. $space_id . '">');
	print ('<input name="space_title" type="hidden" value="'. $spaceTitle . '">');
	print ('<input name="manual_title" type="hidden" value="'. $manualTitle . '">');
	print ('<input name="manual_id" type="hidden" value="'. $manual_id . '">');
	print ('</form>');
	
	print ('<h2>'. $manualTitle . '</h2>');
	
	if (is_array($xmlArray)) {
		if ($isSearching) 
		{
			//////////
			// Searching
			//////////
			print ('<h2>Search Results For "' .  $_GET['search_term'] . '"</h2>');
	
			if (count($xmlArray['lesson']) == 0) {
				print "<p>No lessons found.</p>";
			} else {
				print ("<ul>\n");
				foreach ($xmlArray['lesson'] as $lesson) {
					print ('<li><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $manual_id . '&lesson_id=' . $lesson['id'] . '">' . 
						$lesson['title'] . "</a></li>\n");
				}
				print ("</ul>\n");
			}
		}
		else
		{
			//////////
			// No searching
			//////////					
			$manual_id = $xmlArray['id'];
				
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
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>