<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract Space id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	
	$isSearching = isset($_GET['search_term']) && !empty($_GET['search_term']);
	
	if ($isSearching) 
	{
		$xmlArray = $sslive->SearchSpace($space_id, $_GET['search_term']);
		$spaceTitle = $_GET['space_title'];
	} else {
		$xmlArray = $sslive->GetSpace($space_id);
		$spaceTitle = $xmlArray['title'];
	}

	print ('<p><a href="spaces.php">Return to Spaces</a></p>' . "\n");
	
	print ('<p>Search space: ');
	print ('<form method="get" action="space.php?">');
	print ('<input name="search_term" type="text">');
	print ('<input name="space_id" type="hidden" value="'. $space_id . '">');
	print ('<input name="space_title" type="hidden" value="'. $spaceTitle . '">');
	print ('</form>');
	
	print ('<h2>'. $spaceTitle . '</h2>');
	
	if (is_array($xmlArray)) {
		if (isset($_GET['search_term'])) 
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
					if (strtolower($lesson['asset']['type']) == 'manual') {
						print ('<li><a href="lesson.php?space_id=' . $space_id . '&manual_id=' . $lesson['asset']['id'] . '&lesson_id=' . $lesson['id'] . '">' . 
							$lesson['title'] . "</a></li>\n");
					} else {
						print ('<li><a href="lesson.php?space_id=' . $space_id . '&bucket_id=' . $lesson['asset']['id'] . '&lesson_id=' . $lesson['id'] . '">' . 
							$lesson['title'] . "</a></li>\n");
					}
				}
				print ("</ul>\n");
			}
		}
		else
		{
			//////////
			// No searching
			//////////
			$space_id = $xmlArray['id'];
	
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
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>