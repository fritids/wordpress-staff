<?php
/*
	Plugin Name: WRDSB Policy Procedure Content Filter
	Version: 1.0
	Plugin URI: http://www.wrdsb.ca
	Description: Policy Procedure Content Filter
	Author: Michael Denny

*/
add_filter( 'the_content', 'wrdsb_polypro_content_filter' );
/**
 * Add a icon to the beginning of every post page.
 *
 * @uses is_single()
 */
function wrdsb_polypro_content_filter( $content ) 
	{
	if ($content != "" and 1==1 AND strpos($content,'pdf">') > 0 OR $content != "" and 1==1 AND strpos($content,'xls">') > 0 OR $content != "" and 1==1 AND strpos($content,'doc">') > 0)
			{
			//the_content(); 
			//$content = get_the_content($more_link_text, $stripteaser, $more_file);
			//$content = apply_filters('the_content', $content);
			//$content = '<div class="polypro">'.$content;
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = str_replace('pdf">', 'pdf"><span class="download">Download</span> <br />', $content);
			$content = str_replace('xls">', 'xls"><span class="download">Download</span> <br />', $content);
			$content = str_replace('doc">', 'doc"><span class="download">Download</span> <br />', $content);
			$content .= '<p class="note">Please use this link <a href="'.get_bloginfo('url').'/?page_id='.get_the_ID().'">'.get_bloginfo('url').'/?page_id='.get_the_ID().'</a> when including this document in an Email, Word Document or PDF.</p>';
			
			// tags
			$tags = get_the_tags( $before, $separator, $after );
			if ($tags)
				{
				global $wpdb;
				$related = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status = 'publish' AND post_type = 'page' ORDER by post_title"); 

				if ($meta[status][0] == "")
					{
					$content .= '<div id="related">';
					$content .= "<h4>Related Information</h4>";
					$content .= '<ul>';
					foreach ($tags as $t)
						{
						foreach ($related as $r)
							{
							if ($r->post_name == $t->name)
								{
								$content .= '<li><a href="'.$r->guid.'">'.$r->post_title.'</a></li>';
								}
							}
						}
					$content .= '</ul>';
					$content .= '</div>';
					}
				}
			}
		else
			{
			//$content .= '<div id="pagelist">';
			//wp_list_pages('parent='.$p.'depth=1&sort_column=menu_order&title_li=');
			//$content .= '</div>';
			
			}
	return $content;	
}
?>
<?php
add_action('wp_head', 'wrdsb_polypro_styles');

function wrdsb_polypro_styles()
	{
	echo '<style type="text/css"><!--';
	echo '
.post a[href $=\'pdf\']  {
	border: 1px solid #fdcdcf;
	display: block;
	color: #333 !important;
	font-size: 12px;
	font-weight: bold;
	background-color: #fff4f5;
	background-image: url('.WP_PLUGIN_URL.'/wrdsb_policy_procedure/images/pdf_larger_icon.gif);
	background-position: 10px 10px;
	background-repeat: no-repeat;
	padding-top: 13px;
	padding-right: 10px;
	padding-bottom: 12px;
	padding-left: 60px;
	text-decoration:none;
}
.post a[href $=\'pdf\'] .download {
	font-size: 24px;
}
.post a[href $=\'xls\']  {
	border: 1px solid #acd4a4;
	display: block;
	color: #333 !important;
	font-size: 16px;
	font-weight: bold;
	background-color: #d4eccf;
	background-image: url('.WP_PLUGIN_URL.'/wrdsb_policy_procedure/images/xls_larger_icon.gif);
	background-position: 10px 10px;
	background-repeat: no-repeat;
	padding-top: 20px;
	padding-right: 10px;
	padding-bottom: 25px;
	padding-left: 60px;
	text-decoration:none;
}
.post a[href $=\'doc\']  {
	border: 1px solid #99afe6;
	display: block;
	color: #333 !important;
	font-size: 16px;
	font-weight: bold;
	background-color: #d3dfff;
	background-image: url('.WP_PLUGIN_URL.'/wrdsb_policy_procedure/images/doc_larger_icon.gif);
	background-position: 10px 10px;
	background-repeat: no-repeat;
	padding-top: 20px;
	padding-right: 10px;
	padding-bottom: 25px;
	padding-left: 60px;
	text-decoration:none;
}
.post a[href $=\'dot\']  {
	border: 1px solid #99afe6;
	display: block;
	color: #333 !important;
	font-size: 16px;
	font-weight: bold;
	background-color: #d3dfff;
	background-image: url('.WP_PLUGIN_URL.'/wrdsb_policy_procedure/images/doc_larger_icon.gif);
	background-position: 10px 10px;
	background-repeat: no-repeat;
	padding-top: 20px;
	padding-right: 10px;
	padding-bottom: 25px;
	padding-left: 60px;
	text-decoration:none;
}
.post a[href $=\'pdf\']:hover {
	background-color: #ffefc0;
	
}
.post a[href $=\'xls\']:hover {
	background-color: #ffefc0;
	
}
.post a[href $=\'dot\']:hover {
	background-color: #ffefc0;
	
}
.post a[href $=\'doc\']:hover {
	background-color: #ffefc0;
	}';
	echo '//--></style>';
	}
?>
<?php
function wrdsb_polypro_home_list_init() {
register_sidebar_widget(__('Policy / Procedures Home Page List'), 'wrdsb_polypro_home_list');
}
add_action("plugins_loaded", "wrdsb_polypro_home_list_init");

function wrdsb_polypro_home_list($args) {
  extract($args);
  echo $before_widget;
  polypro_list();
  echo $after_widget;
}

function polypro_list()
	{
	echo '<div id="policy">
		  <h4>Policies</h4>';
		  wp_list_pages('parent=71&depth=1&sort_column=menu_order&title_li=');
		  echo '</div><div id="procedure"><h4>Procedures</h4>';
		  wp_list_pages('parent=310&depth=1&sort_column=menu_order&title_li=');
		  echo '</div>';
	}
?>