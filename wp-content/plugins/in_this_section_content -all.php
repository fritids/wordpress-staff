<?php
/*
Plugin Name: In this Section ALL Children
Plugin URI: http://staff.wrdsb.ca
Description: Hides some top-level menu items - displays all children
Author: Michael Denny
Version: 0.1

*/
function ssr_allkids_menu() 
	{
	$this_page = get_the_ID();
	global $post;
	$the_menu = wp_list_pages('echo=0&child_of='.$this_page.'&sort_column=ASC&depth=0&title_li=');
	if (is_home())
		{
		//echo "homepage";
		}
	else
		{
		if($the_menu != "")
			{
			?>
            <h2>In this Section</h2>
			<ul>
			<?php echo $the_menu; ?>
			</ul>
			<?php
			}
        }	
}
 
function ssr_allkids_custom_menu($args) {
  extract($args);
  echo $before_widget;
  ssr_allkids_menu();
  echo $after_widget;
}
 
function ssr_allkids_custom_menu_init() {
register_sidebar_widget(__('In this section all kids'), 'ssr_allkids_custom_menu');
}
 
add_action("plugins_loaded", "ssr_allkids_custom_menu_init");
?>
