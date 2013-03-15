<?php
/**
 * Plugin Name: WRDSB Centralized Links, Buttons, Address and Messaging
 * Plugin URI: http://www.wrdsb.ca
 * Description: Centralized Links Display
 * Version: 0.1
 * Author: Michael Denny
 */
?>
<?php
function wrdsb_links_display()
	{
	global $wpdb;
	$links = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."links"); 
	echo '<div id="linkcat-2" class="widget_links wrdsb_links widget clearfix"><h2>WRDSB Links</h2>
	<ul class="xoxo blogroll">';
	foreach ($links as $l)
		{
		echo '<li><a href="'.$l->link_url.'" title="'.$l->link_name.'" target="new">'.$l->link_name.'</a></li>';
		}
	echo '</ul></div>';
	}
	
function wrdsb_insert_buttons()
	{
	global $wpdb;
	$button = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."posts WHERE post_type = 'wrdsb_buttons' AND post_status = 'publish'"); 
	$attachment = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."posts WHERE post_type = 'attachment'"); 
	$thebanners = unserialize(get_option('wrdsb_banners_options'));
	if (count($button) > 0 OR count($thebanners) > 0)
		{
		echo '<div id="wrdsb_buttons">';
		foreach($button as $b)
			{
			foreach($attachment as $a)
				{
				if ($a->post_parent == $b->ID)
					{
					echo '<a href="'.$a->post_excerpt.'" target="new"><img alt="'.$b->post_title.'" title="'.$b->post_title.'" src="'.$a->guid.'" /></a>';	
					}
				}
			}
		// add custom buttons
		if (count($thebanners) > 0)
			{
			foreach($thebanners as $key=>$b)
				{
				//echo '<img src="'.$b['banner'].'" /><br />'.$b['description'].'';
				echo '<a href="'.$b['link'].'" class="custom_side_button" style="background-image: url('.$b['banner'].');color:'.$b['colour'].';">'.$b['description'].'</a>';
				}
			}
		echo '</div>';
		}
	
	}
?>
<?php	

	
add_action( 'init', 'create_post_type' );

function create_post_type() 
	{
	global $user_login;
	get_currentuserinfo();
	if (current_user_can('update_plugins')) 
		{
		register_post_type( 'wrdsb_buttons',
			array(
				'labels' => array('name' => __( 'Buttons' ),'singular_name' => __( 'Buttons' )),
				'public' => true,
				'has_archive' => true,
				'capability_type' => 'post',
			)
		);
	}
}
?>
<?php
//Define menu
add_action('admin_menu', 'wrdsb_school_info_manager');


//Add menu to admin panel
function wrdsb_school_info_manager() 
	{
add_submenu_page( 'themes.php', 'manage_school_information', 'Manage School Info', 1, 'manage_school_information', 'manage_school_information');
	}
	
function manage_school_information() 
	{
	?>
    <div class="wrap">
    <h2>School Information Manager</h2>
    <form id="form1" name="form1" method="post" action="">
    
    <?php build_school_info_table($_POST); ?>
    <input type="Submit">
    </form>
    </div>
    <?php
	}

?>
<?php
function build_school_info_table($post_data)
	{
	global $wpdb;
	$id = get_bloginfo('url');
	$id = str_replace('http://schools.wrdsb.ca/','',$id);
	//print_r($post_data);
	$commit = array();
	if (isset($post_data))
		{
		foreach($post_data as $key=>$p)
			{
			$commit[$key] = $p;
			}
		$uid = substr($key,0,strpos($key,'_',0));
		$link_key = $key;
		$link_value = $pd;
		$wpdb->update(schools_schools,$commit,array('field_school_code_value' => $id));
		}

	$titles = array('field_school_name'=>'School Name','field_school_type_value'=>'School Group','field_school_street_value'=>'Address', 'field_school_city_value'=>'City','field_school_postalcode_value'=>'Postal Code','field_school_phone_value'=>'Phone','field_school_fax_value'=>'Fax','field_school_organization_value'=>'School Type','field_school_attendance_line_value'=>'Attendance Phone','field_school_hours_value'=>'School Hours','field_school_office_hours_value'=>'Office Hours','field_school_website_value'=>'Website','field_school_municipality_value'=>'Municipality','field_school_messagebox_value'=>'field_school_messagebox_value','field_school_break_times_value'=>'Break Times','field_school_code_value'=>'School Code');
	
	$list = $wpdb->get_results( "SELECT * FROM schools_schools where field_school_code_value LIKE '$id'" );
	//print_r($list);
	?>
    <table>
    <?php
	if (count($list) > 0)
		{
		foreach ($list['0'] as $key=>$l)
			{
			if ($key == 'field_school_name' AND $l == "" )
				{
				$l = get_bloginfo('name');
				}
			if ($key == 'field_school_name' OR $key == 'field_school_type_value' OR $key == 'field_school_organization_value' OR $key == 'field_school_website_value' OR $key == 'field_school_code_value' )
				{
				$edit = 'readonly="readonly"';	
				}
			echo '<tr><td><label for="'.$key.'"><strong>'.$titles[$key].'</strong></label></td>';
			echo '<td><input type="text" size="60" name="'.$key.'" id="'.$key.'" value="'.$l.'" '.$edit.'/></td></tr>';	
			$edit = "";
			//echo "'".$key."'=>'".$key."',";
			}
		?>
		</table>
    <?php
		}
	else
		{
		echo "No Data available";
		}
	}
?>
<?php
function wrdsb_school_info_display()
	{
	global $wpdb;
	$id = get_bloginfo('url');
	$id = str_replace('http://schools.wrdsb.ca/','',$id);
	$list = $wpdb->get_results( "SELECT * FROM schools_schools where field_school_code_value LIKE '$id'" );
	//print_r($list);
	echo '<div class="content">
          <div class="org fn">'.$list[0]->field_school_name.'</div>
          <div class="adr">
            <div>'.$list[0]->field_school_street_value.'</div>
            <p> <span class="locality">'.$list[0]->field_school_city_value.', Ontario</span><span class="postal-code"></span><br />
              <span class="country-name">Canada</span> </p>
            <p>'.$list[0]->field_school_postalcode_value.'</p>
          </div>
          <div class="tel">'.$list[0]->field_school_phone_value.'</div>
        </div>';
	
	}


?>
<?php
function wrdsb_global_news()
	{
	global $wpdb;
	$links = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1"); 
	if (count($links) > 0)
		{
		$id = $links[0]->ID;
		$cat_rel = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."term_relationships WHERE object_id = $id");
		$term_id = $cat_rel['0']->term_taxonomy_id;
		$cat = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."terms WHERE term_id = $term_id");  
		echo '<div class="wrdsb-news wrdsb-news-'.$cat['0']->slug.'">';
		echo '<h2>'.$links[0]->post_title.'</h2>';
		echo '<p class="date">Posted: '.date('F j, Y - g:i A', strtotime($links[0]->post_date)).'</p>';
		echo apply_filters('the_content', $links[0]->post_content);
		echo '</div>';
		}
	}
?>