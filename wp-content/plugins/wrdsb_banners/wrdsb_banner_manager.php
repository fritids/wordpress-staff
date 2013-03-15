<?php
/**
 * Plugin Name: WRDSB Banner Manager
 * Plugin URI: http://www.wrdsb.ca
 * Description: Manages Banners
 * Version: 0.1
 * Author: Michael Denny
 */
?>
<?php
//Define menu
add_action('admin_menu', 'wrdsb_button_manager');


//Add menu to admin panel
function wrdsb_button_manager() 
	{
	add_submenu_page( 'themes.php', 'manage_buttons', 'Buttons', 1, 'manage_buttons', 'manage_buttons');
	}
	
function manage_buttons() 
	{
	?>
    <div class="wrap">
    <h2>Custom Buttons</h2>
	<form id="form1" name="form1" method="post" action="">
    <div id="wrdsb_banners">
        <div id="w_b_left" style="float:left;width:75%">
        <?php
		if ($_POST['button'] == 'add')
			{
			process_add($_POST);
			next_page();
			}
		if ($_POST['button'] == 'remove')
			{
			process_remove($_POST);
			next_page();
			}
		if ($_POST['button'] != 'remove' and $_POST['button'] != 'add')
			{
			echo '<div class="postbox" style="margin-right:40px;"><h3 style="padding:7px;">Button Gallery</h3>';
			foreach(the_banners() as $key=>$b)
				{
				echo '<div class="postbox" style="padding:10px;width:280px;float:left;margin-right:20px;margin-left:10px;background:white;"><form id="form1" name="form1" method="post" action="">';
				echo '<p><img src="'.$b['image'].'" /><br /></p>';
				echo '<input type="hidden" name="image" id="image" value="'.$b['image'].'"/>';
				echo '<input type="hidden" name="colour" id="colour" value="'.$b['colour'].'"/>';
				if ($b['description']=='')
					{
					echo '<strong>Title</strong><br /><input name="description" type="text" id="description" value="" size="45" /><br />';	
					}
				else
					{
				echo 'Title<br /><input name="description" type="text" id="description" value="'.$b['description'].'" size="45" readonly="readonly"/><br />';
					}
				if ($b['link']=='')
					{
					echo 'Link <br /><input name="link" type="text" id="link" value="" size="45" /><br />';	
					}
				else
					{
				echo 'Link <br /><input name="link" type="text" id="link" value="'.$b['link'].'" size="45" readonly="readonly"/><br />';
					}
				
				echo '<input type="submit" name="button" id="button" value="add" />';	
				echo '</form></div>';
				}
			echo '<br / style="width:100%;clear:both;"></div>';
			}
        //echo '<br />'.plugins_url();
        ?>
       
        </div>
        <div id="w_b_right" style="float:right;width:25%;">
        <?php 
		if ($_POST['button'] != 'remove' AND $_POST['button'] != 'add')
			{
			get_banners();
			}
			?>
       
        </div>
    </div>
    </div>
    <?php
	}
?>
<?php
function the_banners()
	{
	$path = plugins_url();
	$path .= '/wrdsb_banners/images/';
	$banners = array(
	"0"=>array('image'=>$path.'mental_health.png','link'=>'http://staff.wrdsb.ca/mentalhealth/','description'=>'','colour'=>'white'),
	"1"=>array('image'=>$path.'system_leaders.png','link'=>'http://staff.wrdsb.ca/resources/category/system-leaders/','description'=>'','colour'=>'red'),
	"2"=>array('image'=>$path.'tip.png','link'=>'http://www.wrdsb.ca/sites/www.wrdsb.ca/files/TIP%20Line%20Flyer%20-%20FACTSHEET.PDF','description'=>'','colour'=>'black'),
	"3"=>array('image'=>$path.'training.png','link'=>'http://training.staff.wrdsb.ca','description'=>'','colour'=>'white'),
	"4"=>array('image'=>$path.'etr.jpg','link'=>'http://staff.wrdsb.ca/training','description'=>'','colour'=>'white'),
	"5"=>array('image'=>$path.'pdplace.jpg','link'=>'http://pdplace.wrdsb.on.ca','description'=>'','colour'=>'white'));
	//echo "<pre>";
	//print_r($banners);
	//echo "</pre>";
	return $banners;
	
	}
?>
<?php
function process_add($post)
	{
	$new = array('banner'=>$post['image'],'link'=>$post['link'],'description'=>$post['description'],'colour'=>$post['colour']);
	$thebanners = unserialize(get_option('wrdsb_banners_options'));
	$x = 0;
	$banner_update = array();
	foreach ($thebanners as $b)
		{
		$banner_update[$x] = $b;
		$x++;
		}
	$banner_update[$x]=$new;
   	$update = serialize($banner_update);
 	update_option('wrdsb_banners_options', $update);
	}
?>
<?php
function process_remove($post)
	{
	//print_r($post);
	$banners = unserialize(get_option('wrdsb_banners_options'));
	$banner_update = array();
	$x=0;
	//print_r($banners);
	foreach ($banners as $key=>$b)
		{
		if ($post['image'] == $key)
			{
				
			}
		else
			{
			$banner_update[$x] = $b;
			$x++;	
			}
		}
		//print_r($banner_update);
	$update = serialize($banner_update);
 	update_option('wrdsb_banners_options', $update);
	}
?>
<?php
function get_banners()
	{
	echo "<h2>Current Buttons</h2>";
	echo "<style>a.custom_side_button {
	display: block;
	height: 50px;
	width: 240px;
	line-height: 50px;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif !important;
	font-size: 18px !important;
	letter-spacing: -1px;
	text-indent: 12px;
	font-weight: bold;
}</style>";	
	$banners = unserialize(get_option('wrdsb_banners_options'));
	echo '<div class="button-box postbox" style="padding:10px;width:280px;float:left;margin-right:20px;">';
	foreach($banners as $key=>$b)
		{
			//print_r($b);
		echo '<form id="form1" name="form1" method="post" action="">';
		//echo '<p><img src="'.$b['banner'].'" /><br />'.$b['description'].'</p>';
		echo '<a href="'.$b['link'].'" class="custom_side_button" style="background-image: url('.$b['banner'].');color:'.$b['colour'].'">'.$b['description'].'</a>';
		echo '<input type="hidden" name="image" id="image" value="'.$key.'"/>';
		echo '<input type="submit" name="button" id="button" value="remove" /><br /><br />';	
		echo '</form>';
		}
	echo '</div>';
	}
?>
<?php
function next_page()
	{
	//echo bloginfo('url');
	echo '<h3><a href="'.get_bloginfo('url').'/wp-admin/themes.php?page=manage_buttons">Click Here to continue...</a></h3>';	
	}
?>
<?php
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