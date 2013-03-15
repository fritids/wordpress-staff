<?php
/**
 * Plugin Name: WRDSB Force Login and Subscriber Redirect
 * Plugin URI: http://www.wrdsb.ca
 * Description: Force login - required theme to be configured
 * Version: 0.1
 * Author: Michael Denny
 */

//add_action( 'widgets_init', 'wrdsb_top_menu' );
function wrdsb_force_login() 
	{
	if ( is_user_logged_in() ) 
		{
		}
	else
		{
		global $wpdb;
		echo network_home_url();
		echo curPageURL();
		print_r($post);
		header( 'Location: '.network_home_url().'wp-login.php?redirect_to='.curPageURL());
		}
	
	}

?>
<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<?php
add_action('admin_head', 'hide_the_back');

function hide_the_back()
	{
	global $current_user;
	get_currentuserinfo();
	//print_r($current_user->roles);
	foreach ($current_user->roles as $r)
		{
		$user_stuff = $r;
		}
     // get_currentuserinfo();
	//echo $user_stuff;
	 // echo $current_user->user_login;
	  if ($user_stuff == 'subscriber')
	  	{
	  ?>
      <style type="text/css">* {display: none;}</style>
      <meta http-equiv="refresh" content="0;URL=<?php echo get_settings('siteurl'); ?>" />
		<script type="text/javascript">
        <!--
        window.location = "<?php echo get_settings('siteurl'); ?>"
        //-->
        </script>
	  <?php 
		}


	}
?>