<?php
	// Include ScreenSteps Live include which loads ScreenSteps Live object and initializes it
	require_once('../sslive_include.php');
	
	// Retrieve SimpleXML object using ScreenSteps Live method.
	$xmlobject = $sslive->GetManuals();
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
					<h2>Available Manuals</h2>
<?php
	if ($xmlobject) {
		if (count($xmlobject) == 0) {
			print "<p>No manuals found.</p>";
		} else {
			print ("<ul>\n");
			foreach ($xmlobject as $manual) {
				print ('<li><a href="manual.php?manual_id=' . $manual->id . '">' . $manual->title . "</a></li>\n");
			}
			print ("</ul>\n");
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
