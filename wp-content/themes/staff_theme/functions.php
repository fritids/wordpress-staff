<?php
add_action('admin_head', 'staff_management_styles');
?>
<?php
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'=> 'Sidebar',
		'id' => 'sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name'=> 'Footer Left',
		'id' => 'left',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name'=> 'Footer Centre',
		'id' => 'centre',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name'=> 'Footer Right',
		'id' => 'right',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
		register_sidebar(array(
		'name'=> 'Header Top',
		'id' => 'top',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
		register_sidebar(array(
		'name'=> 'Content Body',
		'id' => 'content',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
		register_sidebar(array(
		'name'=> 'Content Left',
		'id' => 'content-left',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
		register_sidebar(array(
		'name'=> 'Content right',
		'id' => 'content-right',
		'before_widget' => '<div id="%1$s" class="%2$s widget clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}
?>
<?php
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_theme_page('Theme Options', 'Theme Options', 8, 'my_plugin_options', 'my_plugin_options');
	
}

function my_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>

<div class="wrap">
<?php
//check for post data
if (isset($_POST['wrdsb_post_comments_form']))
	{
	update_option( 'wrdsb_post_comments', $_POST['wrdsb_post_comments'] );	
	}

if (isset($_POST['category']))
	{
	update_option( 'wrdsb_theme_setting_frontcat', $_POST['category'] );	
	}

if (isset($_POST['school']))
	{
	update_option( 'wrdsb_theme_setting', $_POST['school'] );	
	}
?>
<?php 
//set variables
$optval = get_option('wrdsb_theme_setting'); 
$catval = get_option('wrdsb_theme_setting_frontcat'); 
$comval = get_option('wrdsb_post_comments');
?>

 <!-- <h2>WRDSB Theme Options</h2>
  <p>Please select your school.</p>-->
  <form id="form1" name="form1" method="post" action="">
   <!-- <p>
      <?php
	  $school_list = array('BCI'=>'bci','CHC'=>'chc','ECU'=>'eci','EDS'=>'eds','FHC'=>'fhc','GCI'=>'gci','GPS'=>'gps','GRC'=>'grc','HRH'=>'hrh','JHS'=>'jhs','KCI'=>'kci','PHS'=>'phs','JAM'=>'jam','SSS'=>'sss','WCI'=>'wci','WOD'=>'wod');
  foreach ($school_list as $sl)
  	{
	$check = "";
	if ($sl == $optval)
		{
		$check = 'checked="checked"';	
		}
	echo '<input name="school" type="radio" id="school" value="'.$sl.'" '.$check.'/>'.strtoupper($sl).'<br/>';	
	}
  ?>
    </p>
    <p>
      <label>
        <input type="submit" name="button" id="button" value="Submit" />
      </label>
    </p>
 -->
  <?php 
  //query for categories
  global $wpdb;
  $terms = ($wpdb->get_results("SELECT * FROM ".$wpdb->prefix."terms")); 
  $tax = ($wpdb->get_results("SELECT * FROM ".$wpdb->prefix."term_taxonomy WHERE taxonomy = 'category'"));
  $the_categories = array();
  foreach($tax as $tx)
  	{
	foreach ($terms as $te)
		{
		if ($te->term_id == $tx->term_id)
			{
			$the_categories[$te->term_id]=$te->name;	
			}
		}
	}
  ?>
 <!-- <h2>Front Page Options</h2>
  <p>Please select the Category and/or number of posts for homepage</p>
<?php
	foreach($the_categories as $key=>$tc)
	{
	if ($key == $catval)
		{
		$check = 'checked="checked"';	
		}
	echo '<input name="category" type="radio" value="'.$key.'" '.$check.'/>'.$tc.'<br />';
	$check = '';
	}
	echo '<input name="category" type="radio" value="" '.$check.'/>None<br />';
?>    -->
    <p>
<h2>Post Comments</h2>
  <input name="wrdsb_post_comments" type="checkbox" id="wrdsb_post_comments" <?php if ($comval == "on") echo 'checked="checked"';?> />
  <input name="wrdsb_post_comments_form" type="hidden" value="wrdsb_post_comments_form" />
  <label for="wrdsb_post_comments"></label> 
  Enable Post Comments
  <br />
  <br />
<input type="submit" name="submit" id="submit" value="Submit" />

    
</div>
<?php

}
?>
<?php
function search_style($results,$search,$type)
	{
	$results = strip_tags($results);
	$start = strpos($results,$search);
	$replace = '<span class="highlighter">'.substr($results,stripos($results,$search),strlen($search))."</span>";
	if (stripos($results,$search) > 0)
		{
		if ($type == 'content')
			{
			$results =  "[...]".substr($results,$start-50,150)."[...]";
			$results = str_ireplace($search,$replace,$results);
			return $results;
			}
		else
			{
			$results = str_ireplace($search,$replace,$results);
			return $results;
			}
		}
	if (stripos($results,$search) == 0)
		{
		if ($type == 'content')
			{
			$results = str_ireplace($search,$replace,$results);
			return substr($results,0,150)."...";
			}
		else
			{
			$results = str_ireplace($search,$replace,$results);
			return substr($results,0,150);
			
			}
		}
	}
	
function bettersearch($searchstring)
	{
	$s_exclude = array('the','and');
	$query_string = "";
	$thesearch = strtolower($searchstring);
	$thesearch = str_replace('%20',' ',$thesearch);
	$thesearch = str_replace('.',' ',$thesearch);
	$thesearch=preg_replace('/[^0-9a-z\-\_ ]+/i', '', $thesearch);
	$search_terms = explode(' ',$thesearch);
	$resultsrank = array();
	foreach ($search_terms as $st)
		{
		$query_string .= "post_title LIKE '%".$st."%' AND post_type != 'revision' AND post_type != 'attachment' AND post_status = 'publish' OR ";
		$query_string .= "post_content LIKE '%".$st."%' AND post_type != 'revision' AND post_type != 'attachment'  AND post_status = 'publish' OR ";
		}
	$query_string = substr($query_string,0,-3);
	global $wpdb;
	$newSearch = ($wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE ".$query_string."")); 
	$x = 1;
	foreach ($newSearch as $ns)
		{
		$resultsrank[$ns->ID]->ID = $ns->ID;
		$resultsrank[$ns->ID]->title = $ns->post_title;
		$resultsrank[$ns->ID]->content = strip_tags($ns->post_content);
		$resultsrank[$ns->ID]->rank = "0";
		$resultsrank[$ns->ID]->guide = $ns->guid;
		$x++;
		}
	
	//////////////////////////////////////////////////////////		
	//rank for *all words* in content
	
	if (count($search_terms) > 1)
		{
		foreach ($resultsrank as $rr)
			{
			foreach ($search_terms as $st)
				{
				if (ereg($st,strtolower($rr->content)))
					{
					$allwords++;
					}
				}
				if ($allwords == count($search_terms))
					{	
					$resultsrank[$rr->ID]->rank = "4";
					}
			$allwords = 0;
			}
			
		}
	//////////////////////////////////////////////////////////	
	//rank for *exact* phrase in content
	foreach ($resultsrank as $rr)
		{
		if($thesearch)
			{
			if (ereg($thesearch,strtolower($rr->content)))
				{
				if ($resultsrank[$rr->ID]->rank != "1")
					{
					$resultsrank[$rr->ID]->rank = "3";
					}
				}
			}
		}
	//////////////////////////////////////////////////////////		
	//rank for *all words* in title
	
	if (count($search_terms) > 1)
		{
		foreach ($resultsrank as $rr)
			{
			foreach ($search_terms as $st)
				{
				if (ereg($st,strtolower($rr->title)))
					{
					$allwords++;
					}
				}
				if ($allwords == count($search_terms))
					{
					$resultsrank[$rr->ID]->rank = "3";
					}
			$allwords = 0;
			}
			
		}
	//////////////////////////////////////////////////////////
	//rank for *exact* phrase in title
	foreach ($resultsrank as $rr)
		{
		if($thesearch)
				{
			if (ereg($thesearch,strtolower($rr->title)))
				{
				$resultsrank[$rr->ID]->rank = "1";
				}
			}
		}
	//////////////////////////////////////////////////////////		
	//list results based on rank rating.
	$rankrate =  array('1','2','3','4');
	foreach ($rankrate as $rate)
		{
		//echo $rate;
		foreach ($resultsrank as $rr)
			{
			if ($rr->rank == $rate)
				{
				//echo "\n\r". $rr->rank. " : " .$rr->ID. " : ".$rr->title;
				}
			if ($rr->rank == $rate)
				{
				?>
<div class="searchresult">
<h4><a href="<?php echo get_site_url().'/?page_id='.$rr->ID.'' ?>" rel="bookmark" name="what" id="what">
  <?php 				
				$cleaned_result =  preg_replace('/[^0-9a-z(). ]+/i', ' ', $rr->title,$searchstring);
				//echo $cleaned_result;
				echo search_style($rr->title,$searchstring,'title');
				?>
  </a></h4>
<?php
				$cleaned_result =  preg_replace('/[^0-9a-z(). ]+/i', ' ', $rr->content,$searchstring);
				echo search_style($rr->content,$searchstring,'content');
				echo '<br /><a href="'.get_site_url().'/?page_id='.$rr->ID.'">';
				echo get_site_url();
				echo "/?page_id=".$rr->ID;
				echo'</a></div>';
				$search_flag = 1;
				}
			}

		}
				if(!$search_flag)
			{
			?>
<h3>No search results matched your critieria.</h3>
<?php
$current_user = wp_get_current_user();
$body = $searchstring. " | " . $current_user->data->user_email;
if (strpos($searchstring,'slimstat') < 1)
	{
	$subject = "Search Result | ".get_site_url();
	//wp_mail( 'michael_denny@wrdsb.on.ca', $subject, $body, '', '' ); 	  
	}
?>
<?php
			}




	}



// gets included in the site header
function header_style() {
    ?>
<style type="text/css">
	#header-image 
		{
		background-color: #C00;
		background: url(<?php header_image(); ?>);
		clear: both;
		border: 10px solid #FFF;
		height: 280px !important;
		width: 938px !important;
		background-position: center center;
		}
    </style>
<?php
}

// gets included in the admin header
function admin_header_style() {
    ?>
<style type="text/css">
        #headimg {
            width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
            height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
        }
    </style>
<?php
}

define('HEADER_TEXTCOLOR', 'ffffff');
define('HEADER_IMAGE', '%s/images/headers/path.jpg' );
define('HEADER_IMAGE_WIDTH', 958); // use width and height appropriate for your theme
define('HEADER_IMAGE_HEIGHT', 300);

add_custom_image_header('header_style', 'admin_header_style');

?>
<?php
function dc_install() 
	{
	global $wpdb;
	$table_name = $wpdb->prefix . "staff_links";   
	$sql = "CREATE TABLE $table_name (
	  id int(16) NOT NULL AUTO_INCREMENT,
	  uid varchar(32) NOT NULL,
	  link_key varchar(32) NOT NULL,
	  link_value varchar(1028) NOT NULL,
	  UNIQUE KEY id (id)
	);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	}

?>
<?php
function list_staff()
	{
	$thelist = array();
	$thewebs = array();
	global $wpdb;
	$order = array(
	"Principal",
	"Vice Principal",
	"Temp Elementary VP",
	"Head Secretary",
	"Secretary - Head Elementary",
	"Secretary",
	"Elementary School Secretary",
	"Sec Elem",
	"Elementary Secretary-Special Education",
	"Library & Distribution Clerk",
	"Head Custodian",
	"Hd Cust 'B'",
	"Hd Cust 'C'",
	"Hd Cust 'D'",
	"Custodial III",
	"Custodian",
	"TERM ELEM SSM",
	"Long Term THR"
	);
	
	
	$exclude = array(
	"Supply SS Monitr",
	"Cas/Supply/Hrly",
	"FLOA-ELM",
	"TERM ELEM SSM",
	"FLOA-SUP",
	"Spec Sup Wker",
	"PT Term EA Auto",
	"TERM Elem. Supervision Monitor"
	);
	
	
	
	
	$titles = array(
	"Principal" => "Principal",
	"V.P./Elem" => "Vice Principal",
	"Vice Principal" => "Vice Principal",
	"Temp Elementary VP" => "Vice Principal",
	"Secy Comp Elem" => "Office Manager",
	"Head Secretary" => "Head Secretary",
	"Secretary - Head Elementary" =>  "Head Secretary",
	"Elementary School Secretary" => "Secretary",
	"Sec Elem" => "Secretary",
	"Secretary" => "Secretary",
	"Elementary Secretary-Special Education" => "Secretary",
	"Library &amp; Distribution Clerk" => "Library & Distribution Clerk",
	"Head Custodian" => "Head Custodian",
	"Custodian" => "Custodian",
	"Hd Cust 'C'" => "Head Custodian",
	"Hd Cust 'D'" => "Head Custodian",
	"Custodial III" => "Custodian",
	"Custodian" => "Custodian",
	"Teacher" => "Teacher",
	"Tchr/ESL" => "Teacher",
	"Sal LTO - Elem SL-Regular" => "Teacher",
	"Special Ed Resource Teacher" => "Special Ed Resource Teacher",
	"Special Ed Class Teacher" => "Special Ed Class Teacher",
	"Long Term Occasional Elem - Spec Ed" => "Teacher",
	"Long Term Occasional - Salaried Elem" => "Teacher",
	"Occ'l LT Elem Sp" => "Teacher",
	"Long Term Occasional - Salaried Elem" => "Teacher",
	"Sal LTO - Elem Rep SL 'Regular'" => "Teacher",
	"Tchr/ESL" => "Teacher",
	"Tchr/SERT" => "Teacher",
	"Curr & Prog Dev" => "Teacher",
	"ECE Core Day" => "DECE",
	"Early Literacy Teacher" => "Early Literacy Teacher",
	"Learning Support Teacher" => "Learning Support Teacher",
	"PERM FDK Core Day" =>  "Educational Assistant",
	"Educational Assistant" => "Educational Assistant",
	"EA Dev Chal Elem" => "Educational Assistant",
	"EA-Dev Chal" => "Educational Assistant",
	"EA-Beh Com Elem" => "Educational Assistant",
	"EA-D - (Other)" => "Educational Assistant",
	"Elem LTO Salried" => "Educational Assistant",
	"PT Term EA Auto" => "Educational Assistant",
	"EA-Special Education (Home School)" => "Educational Assistant",
	"Educational Assistant (Other)" => "Educational Assistant",
	"EA-SpEd(HomeSch)" => "Educational Assistant",
	"Salaried E.A.'s" => "Educational Assistant",
	"ESL - Long Term Occasional" => "ESL",
	"EA-Orthopaedic" => "Educational Assistant", 
	"EA-Language" => "Educational Assistant",
	"EA-Behaviour Communications (Elem)" => "Educational Assistant",
	"Eduactional Assistant Dev Chal Elem" => "Educational Assistant",
	"EA-Other" => "Educational Assistant",
	"EA-Developmentally Challenged" =>  "Educational Assistant",
	"Term EA Developmentally Challenged" => "Educational Assistant",
	"TA - Other" => "Educational Assistant",
	"Term - Other" => "Educational Assistant",
	"EA-Area Composite" => "Educational Assistant",
	"Term - Orthopaedic" => "Educational Assistant",
	"Supply EA Elementary" => "Educations Assistant",
	"Educational Assistant - Autistic" => "Educational Assistant",
	"Term Educational Assistant-Autistic" =>  "Educational Assistant",
	"Full Leave of Absence - Support" =>   "Educational Assistant",
	"CHILD &amp; YOUTH WORKERS" => "Child and Youth Worker",
	"CHILD & YOUTH WORKERS" => "Child and Youth Worker",
	"Child & Youth Workers" => "Child and Youth Worker",
	"CYW-Suspension Program" => "Child and Youth Worker",
	"Term - Home School" => "Educational Assistant",
	"Child &amp; Youth Workers" => "Child and Youth Worker",
	"Special Support Worker" => "Educational Assistant",
	"Term - Language" => "Educational Assistant",
	"PT E.A. Auto" => "Educational Assistant",
	"EA-Life Skills" => "Educational Assistant",
	"Term Behav/Comm" => "Educational Assistant",
	"Term Educational Assistant Dev Chal Elem" => "Educational Assistant",
	"TERM Elem. Supervision Monitor" => "",
	"TA - Other (D" => "Educational Assistant",
	"Early Literacy Teacher-LOG Funded" => "Special Educaton Resource Teacher",
	"Teacher - Guidance" => "Guidance",
	"Long Term THR" => " ",
	"" => "&nbsp");
	?>
	
	<!-- 
	<?php
	global $theurl;
	if (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') > 0)
		{
		echo 'IE';
		$theurl = 'http://tweb.wrdsb.on.ca/';
		}
	else
		{
		$theurl = 'http://teachers.wrdsb.ca/'	;
		}
	
	 ?>
	 -->
	<?php
	//an employee at a single location with two titles will not be listed by both titles. The primary locaton marker does not allow for no-primary loc employees to be be displayed on alt web, but does allow for duel duty teachrs to display on their home site. or something
	$id = get_bloginfo('url');
	//$id = str_replace('http://schools.wrdsb.ca/','',$id);
	$id = str_replace('http://','',$id);
	$id = str_replace('.wrdsb.ca','',$id);
	$id = str_replace('schools/','',$id);
	$list = $wpdb->get_results( "SELECT * FROM schools_directory where location_alpha LIKE '$id' and loc_primary LIKE 'Y' and active LIKE 'ACTIVE' order by last_name ASC" );
	foreach ($list as $l)
		{
		if ($l->phone != '' AND $l->phone_x != '')
			{
			$voicemail = $l->phone;
			break;	
			}
		}
	$voicemail = substr($voicemail,0,3).'-'.substr($voicemail,3,3).'-'.substr($voicemail,6,4);
	$thelist = build_the_list($order,$list);
	$list = prune_the_list($order,$list);
	$displaylinks = get_the_links();
	echo '<table id="staff_list">';
	echo '<tr class="tabletitle"><td colspan="4">Voicemail: '.$voicemail.'</td></tr>';
	echo '<tr class="tableheading"><td>Name</td><td>Role</td><td>Links</td><td>Voicemail.</td></tr>';
	$x = 0;
	$switch = 'even';
	foreach ($thelist as $l)
		{
		if ($titles[$l['job_description']] != '' AND $displaylinks[$l['uid'].'_public'] == 'visible')
			{
			echo '<tr>';
			echo '<td><strong>'.substr($l['first_name'],0,1).'. '.$l['last_name'].'</strong></td>';
			echo '<td><em>'.$titles[$l['job_description']].'</em></td>';
			echo '<td>'.build_link($displaylinks,$l['uid']).'</td>';	
			echo '<td>'.substr($l['phone_x'],1,4).'</td>';
			echo '</tr>';				
			}
		}
	foreach ($list as $l)
		{
		if ($titles[$l['job_description']] != '' AND $displaylinks[$l['uid'].'_public'] == 'visible')
			{
			echo '<tr>';
			echo '<td><strong>'.substr($l['first_name'],0,1).'. '.$l['last_name'].'</strong></td>';
			echo '<td><em>'.$titles[$l['job_description']].'</em></td>';	
			echo '<td>'.build_link($displaylinks,$l['uid']).'</td>';
			echo '<td>'.substr($l['phone_x'],1,4).'</td>';
			echo '</tr>';	
			}
		}
	echo '</table>';
	}
?>
<?php
function build_the_list($order,$list)
	{
	$thelist = array();
		$x = 0;
		foreach ($order as $o)
			{
			foreach($list as $key=>$l)
				{
				if 	($l->job_description == $o)
					{
					$thelist[$x]['first_name'] = $l->first_name;
					$thelist[$x]['last_name'] = $l->last_name;
					$thelist[$x]['job_description'] = $l->job_description;		
					$thelist[$x]['phone_x'] = $l->phone_x;
					$thelist[$x]['uid'] = $l->uid;
					unset($list[$key]);
					$x++;
					}
				}
			}
	return($thelist);
	}
?>
<?php
function prune_the_list($order,$list)
	{
	$thelist = array();
		$x = 0;
		foreach ($list as $key=>$l)
			{
			foreach($order as $o)
				{
				if 	($l->job_description == $o)
					{
					$flag = 1;
					}
				}
			if ($flag == 0)
				{

				$thelist[$x]['first_name'] = $l->first_name;
				$thelist[$x]['last_name'] = $l->last_name;
				$thelist[$x]['job_description'] = $l->job_description;		
				$thelist[$x]['phone_x'] = $l->phone_x;
				$thelist[$x]['uid'] = $l->uid;	
				unset($list[$key]);
				$x++;
				}
			$flag = 0;
			}
	return($thelist);
	}
?>
<?php
function get_the_links()
	{
	global $wpdb;
	$displaylinks = array();
	$links = $wpdb->get_results( "SELECT * FROM schools_staff_links" );
	foreach ($links as $l)
		{
		$displaylinks[$l->link_key] = $l->link_value;
		}
	return $displaylinks;
	}
?>
<?php
function build_link($displaylinks,$uid)
	{
	if ($displaylinks[$uid.'_link1'] != "")
		{
		$linkset .= link_filter($displaylinks[$uid.'_link1']);
		}
	if ($displaylinks[$uid.'_link2'] != "")
		{
		$linkset .= '<br/>'.link_filter($displaylinks[$uid.'_link2']);
		}
	if ($displaylinks[$uid.'_link3'] != "")
		{
		$linkset .= '<br/>'.link_filter($displaylinks[$uid.'_link3']);
		}
	return $linkset;	
	}
?>
<?php
function link_filter($link)
	{
	switch ($link)
		{
		case strpos($link,'teachers.wrdsb.ca')>0:
			$pretty_link = 'WRDSB Website';
			$class = "staff-wrdsb";
			break;
		case strpos($link,'facebook')>0:
			$pretty_link = 'Facebook';
			$class = "staff-facebook";
			break;
		case strpos($link,'blogger')>0:
			$pretty_link = 'Blogger';
			$class = "staff-blogger";
			break;
		
		case strpos($link,'wordpress')>0:
			$pretty_link = 'Wordpress Blog';
			$class = "staff-wordpress";
			break;
		case strpos($link,'twitter')>0:
			$pretty_link = 'Twitter';
			$class = "staff-twitter";
			break;
		case strpos($link,'wiki')>0:
			$pretty_link = 'Wiki';
			$class = "staff-wiki";
			break;
		case strpos($link,'linkedin')>0:
			$pretty_link = 'LinkedIn';
			$class = "staff-linkedin";
			break;
		default:
			$pretty_link = $link;
		}
	return '<a href="'.$link.'" target = "new" class="staff-links '.$class.'">'.$pretty_link.'</a>';
	}
?>
<?php
function staff_management_styles()
	{
	?>
          <style>
#staff_list_admin {
	color:#666666;
}
#staff_list_admin td {
	padding: 10px;
}	  
#staff_list_admin .even td {
	background-color: #F8F7F1;
}
#staff_list_admin .active_hidden td {
	background-color: #f6dcdc !important;
}
#staff_list_admin .tableheading {
	background-color: #F2F7FA;
	padding: 10px;
	font-style: strong !important;
	font-size: 16px;
	text-align: center;
}
</style>
	
    <?php
    }
?>