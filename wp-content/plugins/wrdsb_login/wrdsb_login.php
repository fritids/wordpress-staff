<?php
/*
Plugin Name: WRDSB Admin Login
Plugin URI: http://www.wrdsb.ca
Description: Rebrands WordPress with corp. Identity
Author: Michael Denny
<?php echo WP_PLUGIN_URL; ?>
Version: 0.1
*/

add_action('login_head', 'wrdsb_styles');

add_action('admin_head', 'wrdsb_styles');

function wrdsb_styles()
	{
	echo '<style type="text/css"><!--';
	echo '
	#login h1 a{
		background-image: url('.WP_PLUGIN_URL.'/wrdsb_login/wrdsb_login_logo.gif);
		background-repeat: no-repeat;
		background-position: center top;
	}
	img#header-logo	{
	display: none;
	}
	h1#site-heading {
		background-image: url('.WP_PLUGIN_URL.'/wrdsb_login/wrdsb_admin_logo.gif);
		background-position: left center;
		background-repeat: no-repeat;
	background-position: left 5px;
		padding-left: 40px;
		margin-left: 15px;
	}';
	echo '//--></style>';
	}
?>