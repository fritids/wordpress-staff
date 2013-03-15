<?php
/*
Plugin Name: Admin Message
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.1.0
Author URI:
WDP ID: 5
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('admin_menu', 'admin_message_plug_pages');
add_action('admin_notices', 'admin_message_output');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function admin_message_output() {
	$admin_message = get_site_option('admin_message');
	if ( !empty( $admin_message ) && $admin_message != 'empty' ){
		?>
		<div id="message" class="updated"><p><?php echo stripslashes( $admin_message ); ?></p></div>
		<?php
	}
}

function admin_message_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_site_admin() ) {
		add_submenu_page('ms-admin.php', 'Admin Message', 'Admin Message', 10, 'admin-message', 'admin_message_page_output');
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function admin_message_page_output() {
	global $wpdb, $wp_roles, $current_user;
	
	if(!current_user_can('manage_options')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$admin_message = get_site_option('admin_message');
			if ( $admin_message == 'empty' ) {
				$admin_message = '';
			}
			?>
			<h2><?php _e('Admin Message') ?></h2>
            <form method="post" action="ms-admin.php?page=admin-message&action=process">
            <table class="form-table">
            <tr valign="top">
            <th scope="row"><?php _e('Message') ?></th>
            <td>
            <textarea name="admin_message" type="text" rows="5" wrap="soft" id="admin_message" style="width: 95%"/><?php echo $admin_message ?></textarea>
            <br /><?php _e('HTML allowed') ?></td>
            </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			<input type="submit" name="Reset" value="<?php _e('Reset') ?>" />
            </p>
            </form>
			<?php
		break;
		//---------------------------------------------------//
		case "process":
			if ( isset( $_POST[ 'Reset' ] ) ) {
				update_site_option( "admin_message", "empty" );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='ms-admin.php?page=admin-message&updated=true&updatedmsg=" . urlencode(__('settings cleared.')) . "';
				</script>
				";			
			} else {
				$admin_message = $_POST[ 'admin_message' ];
				if ( $admin_message == '' ) {
					$admin_message = 'empty';
				}
				update_site_option( "admin_message", stripslashes($admin_message) );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='ms-admin.php?page=admin-message&updated=true&updatedmsg=" . urlencode(__('Settings saved.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>