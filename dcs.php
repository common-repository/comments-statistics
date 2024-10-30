<?php

/*
Plugin Name: Display Comments Statistics
Version: 1.6.0
Plugin URI: http://www.marblehole.com/comments-plugin
Description: Display comments statistics about platforms and browsers with icons (originally created by Mario Gamito / R.I.P).
Author: Marco Rodrigues
Authors URI: http://www.marblehole.com
*/

function display_comment_stats()
{
	global $wpdb;

	$image_url = get_settings('siteurl') . "/wp-content/plugins/comments-statistics";

	echo"<ul><h2>Writing</h2>";

	// Check number of posts published
	$num_posts = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish'");

	echo $num_posts."&nbsp;articles<br />";

	// Check number of approved/non-approved comments
	$num_comments = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments" );
	$non_approved = $wpdb->get_var("SELECT COUNT(comment_approved) FROM $wpdb->comments WHERE comment_approved = '0'"); 

	echo $num_comments."&nbsp;comments";

	echo "<ul><h2>Comments</h2>platforms<br />";

	// Get information about platforms
	$windows = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Windows%'");
	$linux = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Linux%'");
	$macos = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%MAC OS X%'");
	$wp = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%WordPress%'");
	$sun = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%SunOS%'");

	$platform = array("windows" => $windows, "linux" => $linux, "macos" => $macos, "wp" => $wp, "sun" => $sun);

	arsort($platform);

	foreach($platform as $key => $val){
		echo "<img src=\"".$image_url."/".$key.".png\" alt=\"".$key."\" title=\"".$key."\" /> ";
	        echo $val."<br />";	
	}

	// Get information about browsers
	echo "<br />browsers<br />";

	$firefox = $wpdb->get_var("SELECT COUNT( comment_agent ) FROM $wpdb->comments WHERE comment_agent LIKE '%Mozilla/5.0 (Windows%' OR comment_agent LIKE '%Mozilla/5.0 (Macintosh%' OR comment_agent LIKE '%Mozilla/5.0 (X11%'"); 
	$ie = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%MSIE%'");
	$safari = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Safari%'");
	$opera = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Opera%'");
	$iceweasel = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%IceWeasel%'");
	$konqueror = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Mozilla/5.0 (compatible; Konqueror%'");
	$lynx = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%ELinks%'");
	$netnewswire = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Netnews%'");
	$epiphany = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Epiphany%'");
	$bonecho = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%BonEcho%'");
	$flock = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Flock%'");
	$chrome = $wpdb->get_var("SELECT COUNT(comment_agent) from $wpdb->comments WHERE comment_agent LIKE '%Chrome%'");

	$browser = array("firefox" => $firefox, "ie" => $ie, "safari" => $safari, "opera" => $opera, "iceweasel" => $iceweasel, "konqueror" => $konqueror, "lynx" => $lynx, "netnewswire" => $netnewswire, "epiphany" => $epiphany, "bonecho" => $bonecho, "chrome" => $chrome, "flock" => $flock);

	arsort($browser);

	foreach($browser as $key => $val) {
        	echo "<img src=\"".$image_url."/".$key.".png\" alt=\"".$key."\" title=\"".$key."\" />&nbsp;".$val."&nbsp;<br />";
	}
	echo"</ul>";
}

add_action('post_submit', 'display_comment_stats');

?>
