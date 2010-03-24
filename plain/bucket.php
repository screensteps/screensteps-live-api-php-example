<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract id from GET query
	$space_id = $sslive->CleanseID($_GET['space_id']);
	$bucket_id = $sslive->CleanseID($_GET['bucket_id']);
	
	$isSearching = isset($_GET['search_term']) && !empty($_GET['search_term']);
	
	if ($isSearching) 
	{
		$xmlArray = $sslive->SearchBucket($space_id, $bucket_id, $_GET['search_term'], array('sort'=>'title'));
		$spaceTitle = $_GET['space_title'];
		$bucketTitle = $_GET['bucket_title'];
	} else {		
		$xmlArray = $sslive->GetBucket($space_id, $bucket_id, array('sort'=>'title'));
		// $xmlArray = $sslive->GetLessonsWithTagInBucket($space_id, $bucket_id, '2.1', array('sort'=>'title'));
		$spaceTitle = $xmlArray['space']['title'];
		$bucketTitle = $xmlArray['title'];
	}
	
	//pr($xmlArray);

	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $spaceTitle . '"</a></p>' . "\n");
	
	print ('<p>Search bucket: <form method="get" action="bucket.php?">');
	print ('<input name="search_term" type="text">');
	print ('<input name="space_id" type="hidden" value="'. $space_id . '">');
	print ('<input name="space_title" type="hidden" value="'. $spaceTitle . '">');
	print ('<input name="bucket_id" type="hidden" value="'. $bucket_id . '">');
	print ('<input name="bucket_title" type="hidden" value="'. $bucketTitle . '">');
	print ('</form>');
	
	print ('<h2>'. $bucketTitle . '</h2>');

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
					print ('<li><a href="lesson.php?space_id=' . $space_id . '&bucket_id=' . $bucket_id . '&lesson_id=' . $lesson['id'] . '">' . 
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
			$bucket_id = $xmlArray['id'];
	
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
			
			if ( is_array($xmlArray['tags']['tag']) ) {
				print '<h3>Tags in Bucket:</h3>';
				print '<ul>';
				foreach ($xmlArray['tags']['tag'] as $value) {
					print '<li>' . $value['name'] . '</li>';
				}
				print '</ul>';
			}
		}
	} else {
		print "Error:" . $sslive->last_error;
	}
	
	$sslive = NULL;
?>