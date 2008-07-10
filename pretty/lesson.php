<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Extract manual and lesson id from GET query
	$manual_id = intval($_GET['manual_id']);
	$lesson_id = intval($_GET['lesson_id']);
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlobject = $sslive->GetLesson($manual_id, $lesson_id);
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
					<br class="clear"/>
				</div>

				
			</div>
		<div id="footer">
			
<p>This product is brought to you by <a href="/about/bluemango.php">Blue Mango Learning Systems</a></p>
<p><a href="/about/contact_us.php">Contact Us</a></p>
		</div>
	</body>
</html>
