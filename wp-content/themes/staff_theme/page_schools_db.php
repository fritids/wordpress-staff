<?php
/*
Template Name: School Lists DB
*/
global $wpdb;
?>
<?php
if ($_GET['contact'] != '')
	{
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
      <style type="text/css">
  <!--
  body {
	  font-family: Verdana, Arial, Helvetica, sans-serif;
	  font-size: 12px;
	  color: #FFFFFF;
	  margin: 0px;
	  padding: 0px;
		  background-color: #01499a;
  }
  p {
	  padding: 0px;
	  margin-top: 0px;
	  margin-right: 0px;
	  margin-bottom: 7px;
	  margin-left: 0px;
  }
  a {
	color: #FFF;	  
  }
  -->
      </style>

</head>
    <body>
    <?php
	$liveposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM depts_info WHERE alpha_code LIKE '".strtoupper($_GET['contact'])."'"));
	$granular_title = $_GET['contact'];
	echo '<strong>'.$liveposts['0']->full_name.'</strong><br />';
	echo $liveposts['0']->address.'<br />';
	echo $liveposts['0']->city.', '.$liveposts['0']->province.'<br />';
	echo $liveposts['0']->postal_code.'<br /><br />';
	echo '<strong>(T): </strong>'.$liveposts['0']->phone_no.'<br />';
	echo '<strong>(F): </strong>519 '.$liveposts['0']->fax_no.'<br /><br />';
	echo '<strong>Superintendent: <br /></strong>'.substr($liveposts['0']->super,0,strpos($liveposts['0']->super,'[')).'<br /><br />';
	echo '<strong>Principal: <br /></strong>'.$liveposts['0']->principal.'<br />';
	if ($liveposts['0']->vp != '' ) echo '<strong>Vice Principal(s): </strong>'.$liveposts['0']->vp.'<br />';
	?>
    </body>
    </html>
    <?php
	}
else
	{
?>

<?php get_header();?>
  <div id="page-feature"> </div>
  <div id="content-wrapper">
    <div id="content-block"> <a name="content" id="content"></a>
      <?php $meta = get_post_custom($page_id); ?>
              <?php 
		$page_class = "front-page";
		if (!is_front_page())
			{
			$page_class = "the-post";
			}
		?>
<div class="post regpost post-<?php echo $post->ID; ?> <?php echo $page_class; ?>">
<h2><?php bloginfo('name'); ?></h2>
<?php edit_post_link('Edit'); ?>
<div class="breadcrumbs">
<?php
if(function_exists('bcn_display') AND !is_front_page())
	{
	bcn_display();
	}
?>
<?php
if(function_exists('wrdsb_global_news') and is_front_page())
	{
	wrdsb_global_news();
	}
?>
</div>

 
<?php
//create table if there are not tags of cats specified
if ($_GET['cat'] == '' AND $_GET['tag'] == '' AND $_GET['id'] == '' AND $_GET['contact'] == '')
	{
	$liveposts = @$wpdb->get_results( $wpdb->prepare("SELECT * FROM depts_info WHERE type_code LIKE 'School' AND panel != 'Other' ORDER BY alpha_code ASC") );
	echo '<h3><a href="'.get_permalink($post->ID).'" rel="bookmark">'.get_the_title().'</a></h3>';
			if (have_posts()) : while (have_posts()) : the_post();
		the_content();
		endwhile; endif;
	echo '<table id="staff_list" class="schools_list">';
	echo '<thead><tr class="tableheading"><th width="40%">Name</th><th>Website</th><th>Type</th><th>Features</th></tr></thead>';
	foreach ($liveposts as $l)
		{
		echo '<tr class=""><td class="school_name"><strong><a href="?id='.strtolower($l->alpha_code).'">'.str_replace('Public School','P.S.',$l->full_name).'</a></strong></td><td><a href="http://'.strtolower($l->alpha_code).'.wrdsb.on.ca" target="_blank">'.strtolower($l->alpha_code).'.wrdsb.on.ca</a></td><td><a href="?cat='.$l->panel.'">'.$l->panel.'</a></td><td><a href="?tag='.$l->city.'">'.$l->city.'</a><br /><a href="?tag='.$l->grades.'">'.str_replace('Gr', 'Grades',$l->grades).'</a>';
		if($l->french != "") echo '<br /><a href="?tag=french">Partial French Immersion</a></td></tr>';
		}
	
	echo "</table>";
	}
	
// School

elseif (isset($_GET['id']))
	{
	$liveposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM depts_info WHERE alpha_code LIKE '".strtoupper($_GET['id'])."'"));
	$granular_title = $_GET['id'];
	echo '<h3><a href="'.get_permalink($post->ID).'" rel="bookmark">'.$liveposts['0']->full_name.'</a></h3>';
	echo '<pre>';
	echo '<strong>School Type: </strong>'.str_replace('Gr','',$liveposts['0']->panel).'<br />';
	echo '<strong>Grades: </strong>'.str_replace('Gr','',$liveposts['0']->grades).'<br />';
	if ($liveposts['0']->french != '') echo '<strong>Partial French Immersion: </strong>'.str_replace('Immersion','',str_replace('Gr','',$liveposts['0']->french)).'<br />';
	echo '</pre>';
	echo '<strong>'.$liveposts['0']->full_name.'</strong><br />';
	echo $liveposts['0']->address.'<br />';
	echo $liveposts['0']->city.', '.$liveposts['0']->province.'<br />';
	echo $liveposts['0']->postal_code.'<br /><br />';
	echo '<strong>(T): </strong>'.$liveposts['0']->phone_no.'<br />';
	echo '<strong>(F): </strong>519 '.$liveposts['0']->fax_no.'<br />';
	echo '<strong>(W): </strong><a href="#">http://'.strtolower($liveposts['0']->alpha_code).'.wrdsb.on.ca</a><br /><br />';
	echo '<strong>Superintendent: </strong>'.substr($liveposts['0']->super,0,strpos($liveposts['0']->super,'[')).'<br />';
	echo '<strong>Principal: </strong>'.$liveposts['0']->principal.'<br />';
	if ($liveposts['0']->vp != '' ) echo '<strong>Vice Principal(s): </strong>'.$liveposts['0']->vp.'<br />';
	}
	
// CATEGORY 
elseif (isset($_GET['cat']))
	{
	$liveposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM depts_info WHERE type_code LIKE 'School' AND panel LIKE '".$_GET['cat']."' ORDER BY alpha_code ASC") );
	$granular_title = $_GET['cat'];
	echo '<h3><a href="'.get_permalink($post->ID).'" rel="bookmark">'.get_the_title().' - '.$granular_title.'</a></h3>';
		echo '<table id="staff_list" class="schools_list">';
	echo '<thead><tr class="tableheading"><th >Name</th><th>Website</th><th>Type</th><th>Features</th></tr></thead>';
	foreach ($liveposts as $l)
		{
		echo '<tr class=""><td class="school_name"><strong><a href="?id='.strtolower($l->alpha_code).'">'.$l->full_name.'</a></strong></td><td><a href="http://'.strtolower($l->alpha_code).'.wrdsb.on.ca" target="_blank">'.strtolower($l->alpha_code).'.wrdsb.on.ca</a></td><td><a href="?cat='.$l->panel.'">'.$l->panel.'</a></td><td><a href="?tag='.$l->city.'">'.$l->city.'</a><br /><a href="?tag='.$l->grades.'">'.str_replace('Gr', 'Grades',$l->grades).'</a>';
		if($l->french != "") echo '<br /><a href="?tag='.$l->french.'">'.$l->french.''.'</a></td></tr>';
		}
	
	echo "</table>";
	}
//


// TAGS
elseif (isset($_GET['tag']))
	{
	if ($_GET['tag'] == 'french') $_GET['tag'] = 'Immersion';
	$liveposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM depts_info WHERE type_code LIKE 'School' AND city LIKE '".$_GET['tag']."' OR type_code LIKE 'School' AND grades LIKE '".$_GET['tag']."' OR type_code LIKE 'School' AND french LIKE '%%".$_GET['tag']."' ORDER BY alpha_code ASC") );
	
	$granular_title = str_replace('Immersion','Partial French Immersion',str_replace('Gr','Grades',$_GET['tag']));
	echo '<h3><a href="'.get_permalink($post->ID).'" rel="bookmark">'.get_the_title().' - '.$granular_title.'</a></h3>';
	echo '<table id="staff_list" class="schools_list">';
	echo '<thead><tr class="tableheading"><th>Name</th><th>Website</th><th>Type</th><th>Features</th></tr></thead>';
	foreach ($liveposts as $l)
		{
		echo '<tr class=""><td class="school_name"><strong><a href="?id='.strtolower($l->alpha_code).'">'.$l->full_name.'</a></strong></td><td><a href="http://'.strtolower($l->alpha_code).'.wrdsb.on.ca" target="_blank">'.strtolower($l->alpha_code).'.wrdsb.on.ca</a></td><td><a href="?cat='.$l->panel.'">'.$l->panel.'</a></td><td><a href="?tag='.$l->city.'">'.$l->city.'</a><br /><a href="?tag='.$l->grades.'">'.str_replace('Gr', 'Grades',$l->grades).'</a>';
		if($l->french != "") echo '<br /><a href="?tag='.$l->french.'">'.$l->french.''.'</a></td></tr>';
		}
	
	echo "</table>";
	}
//	
	
?>
</div>
		<?php
        ob_start();
        dynamic_sidebar('content-left');
        $content_left = ob_get_contents();
        ob_end_clean();
        ob_start();
        dynamic_sidebar('content-right');
        $content_right = ob_get_contents();
        ob_end_clean();
        ?>
                                <?php
	  if ($content_wide != "")
	  	{

				echo $content_wide;

		}
	  ?>
          <?php if ($content_left != "" OR $content_right !="" ) {?>
                  <div id="ccolumns">

      <div id="cleft-widget">              
	  		<?php 
			if (is_active_sidebar('content-left'))
				{
				echo $content_left;
				}
			?>
            </div>
      <div id="cright-widget">
      	  		<?php 
			if (is_active_sidebar('content-right'))
				{
				echo $content_right;
				}
			?>
      </div>
      
      </div>
	  
	  <?php } ?>
    </div>
  </div>
  <?php get_sidebar();?>
  <?php get_footer(); ?>
</div>
</div>
</body>
</html>
<?php
	}
?>