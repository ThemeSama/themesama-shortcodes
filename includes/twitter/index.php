<?php	
	require 'twitteroauth/twitteroauth.php';
	
	// consumer & access - You can change with your api keys
	$consumer_key = 'KYNYpTLGjWS6kyrX8bp3g';
	$consumer_secret = '4aP4QmIwgm4Q1Z0gKbg71Xf9k7FcyB5f1ESotaFMY';
	$access_token = '26801505-Mw5yYbTkYkPk1krsbnqWvtJRa4ObnoJ0mQY7C12GH';
	$access_token_secret = 'FoboP30bZbPeREzOa7Vfao74aj4LuHKnBYYAtb4sZFhdr';
	
	// Call Twitter Class
	global $TS_TWITTER;
	$TS_TWITTER = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
?>