<?php 
if (function_exists('wrdsb_force_login'))
	{
	wrdsb_force_login();	
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php wp_title('&laquo;', true, 'right'); ?>
<?php bloginfo('name'); ?>
</title>
<style type="text/css" media="screen">
@import url( <?php bloginfo('stylesheet_url');
?> );
</style>
<?php wp_head(); ?>
<?php if (function_exists('z_taxonomy_image_url')) 
		{
		ob_start();
		echo z_taxonomy_image_url(); 
		$myStr = ob_get_contents();
		ob_end_clean();
		}
		?>
<?php
global $wpdb;
$dc = $wpdb->prefix.'options';
if($results = $wpdb->get_results( "SELECT * FROM $dc WHERE option_name = 'siteurl'" ))
	{
	$realurl = $results[0]->option_value;
	}
?>

</head>
<body>
<div id="wrapper">
<div id="top-wrapper">
  <div id="header">
   <div class="wrdsb-home"><a href="http://www.wrdsb.ca" target="_blank"><span>Waterloo Region District School Board</span></a></div>
  <?php $name = get_bloginfo('name');
  $name = str_replace('Public','<br />Public', $name);
  ?>
    <h1><a href="<?php bloginfo('url');?>"><?php echo $name;?></a></h1>
  </div>
  <div id="search">
    <ul>
      <?php
	  if (is_user_logged_in())
	  	{
		?><li class="logout"><a href="<?php echo wp_logout_url(); ?>">Logout</a></li><?php
		}
	else
		{
		?><li><a href="<?php echo $realurl; ?>/wp-admin">Login</a></li><?php
		}
		//echo get_site_url();
	  ?>
    </ul>
    <div id="block-search-0" class="block block-search">
      <div class="content">
        <form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
          <div>
          <label for="s">Search</label>
            <input type="text" name="s" id="s" size="15" />
            <input type="submit" name="op" id="edit-submit" value="Search"  class="form-submit" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="top-menu">
    <?php 
	if (!function_exists('dynamic_sidebar'))
		{
	?>
    <ul>
      <?php wp_list_pages('depth=1&title_li='); ?>
    </ul>
    <?php 	}
		else 
		{ 
		if (is_active_sidebar('top'))
			{
			dynamic_sidebar('top');
			}
		else
			{
				?>
    <ul>
      <?php wp_list_pages('depth=1&title_li='); ?>
    </ul>
    <?php
			}

		}
		?>
  </div>
</div>
<?php
if (get_header_image() != "" AND strpos(get_header_image(),'/images/headers/path.jpg')<1 AND is_front_page() OR $banner['banner'][0] != "" OR $myStr != "")
	{
	?>
<div id="header-image"></div>

<?php
	}


?>
