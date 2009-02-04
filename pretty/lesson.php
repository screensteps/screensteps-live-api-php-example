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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		
		
<link href="http://www.screensteps.com/styles/alt.css" media="screen" rel="Stylesheet" type="text/css" />

		
		<title>ScreenSteps: Learn More</title>

		<meta name="description" content="Create step by step visual software documentation or tutorials using screen captures or screen shots." />
		 
		<script type="text/javascript" src="http://www.screensteps.com/javascripts/mootools.js"></script>



	

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


		
		<meta name="keywords" content="online manual, manual, screen capture, screenshot, tutorials">
		<meta name="robots" content="index, follow" />
	</head>
	<body>

		
		<div id="wrapper">
				
		
<div id="navigation">
	<ul id="topNav">
		<li id="home-tab"><a href="/">Home</a></li>

		<li id="learn-tab"><a href="/product">Learn</a></li>
		<li id="download-tab"><a href="/downloads">Downloads</a></li>
		<li id="support-tab"><a href="/support">Support</a></li>
		<li id="purchase-tab"><a href="/purchase">Purchase</a></li>

	</ul>
	
	<ul id="rightNav">

		<li id="about-tab"><a href="/about/bluemango.php">About Us</a></li>
		<li id="blog-tab" class="right"><a href="/blog">Blog</a></li>
	</ul>
	<div class="clear"></div>
</div>	


				<div class="clear"></div>

				

<div id="sub_header">
	
	<table class="header" border="0">

		<tr>
			<td>
				<a href="/downloads"><img src="http://www.screensteps.com/images/layout/screensteps_logo_75.png" width="75" height="75" alt="Logo" id="logo"/></a>
			</td>
			<td>
				<a href="/downloads"><img src="http://www.screensteps.com/images/layout/header_text.gif" width="360" height="75" alt="tag line" id="tag_line"/></a>
			</td>
		</tr>
	</table>	

</div>			

				<div id="content">
<?php
	// Spaces link
	print ('<p><a href="space.php?space_id=' . $space_id . '">Return to Space "' . $xmlArray['space']['title'] . '"</a></p>' . "\n");
	
	if (is_array($xmlArray)) 
	{
		if (isset($manual_id))
		{
			// Links for manual
			print ('<p><a href="manual.php?space_id=' . $space_id . '&manual_id=' . $manual_id . '">Return to Manual "' . $xmlArray['manual']['title'] . '"</a></p>' . "\n");
			
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
					<br class="clear"/>
				</div>

				
			</div>
		<div id="footer">
			
<p>This product is brought to you by <a href="/about/bluemango.php">Blue Mango Learning Systems</a></p>
<p><a href="/about/contact_us.php">Contact Us</a></p>
		</div>
	</body>
</html>
