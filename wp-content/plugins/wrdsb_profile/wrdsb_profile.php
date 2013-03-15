<?php
/*
Plugin Name: WRDSB Profile
Plugin URI: http://staff.wrdsb.ca
Description: WRDSB Profile
Author: Michael Denny
Version: 0.1

*/
add_filter( 'the_content', 'wrdsb_user_profile' );

function wrdsb_user_profile($content) 
	{
	//echo strpos($content,'[wrdsb_profile]');
	if (strpos($content,'[wrdsb_profile]')>0)
		{
		return wrdsb_create_profile();	
		}
	else
		{
		return $content;
		}
	}
	
function wrdsb_create_profile()
	{
		global $current_user;
	get_currentuserinfo();
	//$the_return .= 'Username: ' . $current_user->user_login . "\n";
   //$the_return .= 'User email: ' . $current_user->user_email . "\n";
   // $the_return .= 'User first name: ' . $current_user->user_firstname . "\n";
   // $the_return .= 'User last name: ' . $current_user->user_lastname . "\n";
   // $the_return .= 'User display name: ' . $current_user->display_name . "\n";
   // $the_return .= 'User ID: ' . $current_user->ID . "\n";
	$the_return .= '<div id="wrdsb-profile">
        <div class="profile-avatar"></div>
        <div class="profile-data">
        <h3>'. $current_user->user_login .'</h3>
        <p>Title / Position Information<br />
'. $current_user->user_email .'<br />
<a href="#">Edit Profile</a></p>
        
        </div>
        
        </div>';
	return $the_return;
	}
	
add_action('wp_head', 'wrdsb_profile_style');

function wrdsb_profile_style()
	{
	echo '
	<style type="text/css">
	#wrdsb-profile {
	padding: 10px;
	width: 100%;
	height: 90px;
	border: 1px solid #ECE9D8;
	margin: 0px;
	margin-bottom: 10px;
}
.profile-avatar {
	height: 90px;
	width: 90px;
	display: block;
	background-color: #9F9;
	float: left;
	margin-right: 15px;
	background-image: url('.WP_PLUGIN_URL.'/wrdsb_profile/images/avatar.png);
}
.profile-data h3, .profile-data p {
	margin: 0px !important;
	padding: 0px !important;

}
.profile-data h3 {
	font-size: 24px !important;
	color: #006699 !important;
	line-height: 24px !important;
	margin: 0px !important;
	padding: 0px !important;
}
.profile-data p {
	font-size: 12px !important;
	color: #666666 !important;
	line-height: 16px !important;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
}
	</style>
	';
	}
?>
