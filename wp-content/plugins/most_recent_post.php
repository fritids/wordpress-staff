<?php
/*
Plugin Name: Most Recent Post Widget
Plugin URI: http://staff.wrdsb.ca
Description: Show latest post as widget
Author: Michael Denny
Version: 0.1
*/
function wrdsb_most_recent_post() 
	{
?>
<?php
	$args = array( 'numberposts' => '1' );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<h2>What\'s New?</h2>';
		echo '<p><strong>'.$recent["post_title"].'</strong></p> ';
		echo apply_filters('the_content', $recent['post_content']);
	}
?>


<?php
}
 
function wrdsb_custom_most_recent_post($args) {
  extract($args);
  echo $before_widget;
  wrdsb_most_recent_post();
  echo $after_widget;
}
 
function wrdsb_custom_most_recent_post_init() {
register_sidebar_widget(__('Most Recent Post'), 'wrdsb_custom_most_recent_post');
}
 
add_action("plugins_loaded", "wrdsb_custom_most_recent_post_init");

?>
