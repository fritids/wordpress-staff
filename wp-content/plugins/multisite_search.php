<?php
/**
 * Plugin Name: WRDSB Multisite Search
 * Plugin URI: http://www.wrdsb.ca
 * Description: Multisite Search
 * Version: 0.1
 * Author: Michael Denny
 */
?>
<?php
//Define menu
add_action('admin_menu', 'wrdsb_');


//Add menu to admin panel
function wrdsb_() 
	{
	add_submenu_page( 'tools.php', 'manage_search', 'Multisite Search', 1, 'manage_search', 'manage_search');
	}
	
function manage_search() 
	{
	?>
    <div class="wrap">
    <h2>Multisite Search</h2>
    <?php
	print_r($_POST);
	if ($_POST['wrdsbsearchsettings'] == 'd722fe1f89d83c587e006b4f0eae42da')
		{
		update_search_settings($_POST);
		}
	echo get_all_sites();
	?>
    </div>
    <?php
	
	}
?>
<?php
function get_all_sites() 
	{
	global $wpdb;
	
	//get options values
	$options = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."options WHERE option_name = 'wrdsb_multisite_search'");
	//print_r($options);
	$options = unserialize($options['0']->option_value);
	
	//if the options table does not exist, create it.
	if (count($options) == 0)
		{
		$wpdb->query("INSERT into ".$wpdb->base_prefix."options (option_name) VALUES ('wrdsb_multisite_search')");
		}
	//get all the blog ids
	$blogs = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."blogs");

	?>
<form id="mssearch" name="mssearch" method="post" action="">
  <p>
        <?php
		foreach ($blogs as $b)
			{
			if ($b->public > -2)
				{
		?>
                <label style="padding:5px;font-size:16px;display:block;background-color:#EEE;">
        <?php
				}
				else
				{
		?>
        		<label style="padding:5px;font-size:16px;display:block;background-color:#FFA6AC;">
        <?php
				}
		?>
        <input name="<?php echo $b->blog_id; ?>" type="checkbox" id="<?php echo $b->blog_id; ?>" value="search" <?php if($options[$b->blog_id] == 'index') { echo 'checked="checked"'; }?> />
        <?php echo $b->path; ?></label>
        <br />
		<?php
			}
		?>
    </p>
    <input name="wrdsbsearchsettings" type="hidden" value="d722fe1f89d83c587e006b4f0eae42da" />
    <input type="submit" id="submit" value="Submit" />
  </form>
    <?php
	}
?>
<?php
function update_search_settings($data)
	{
	global $wpdb;
	echo '<p>Options Updated</p>';
	$serial = array();
	foreach ($data as $key=>$d)
		{
		if ($d == 'search')
			{
			$serial[$key]="index";
			}
		}
	$insert = serialize($serial);
	$insert = str_replace('"','\"',$insert);
	$wpdb->query("UPDATE ".$wpdb->base_prefix."options SET option_value = '$insert' WHERE option_name = 'wrdsb_multisite_search'");
	}
?>
<?php
function wrdsb_multi_search($searchstring)
	{
	global $wpdb;
	$options = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."options WHERE option_name = 'wrdsb_multisite_search'");
	$options = unserialize($options['0']->option_value);
	//print_r($options);
	foreach ($options as $key=>$o)
		{
		//echo $key;
		}
	//$options = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."18_posts WHERE post_title LIKE '1000%' ");
	//print_r($options);
	//echo $searchstring."<br />";
	//****************************
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
	//echo $query_string;
	global $wpdb;
	
	
	$query = "SELECT * FROM ".$wpdb->base_prefix."18_posts WHERE ".$query_string."";
	//echo $query."<br />___________________________<br /><br /><br />";
	$x=0;
	$uber = array();
	foreach ($options as $key=>$o)
		{
		$newSearch = ($wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."".$key."_posts WHERE ".$query_string.""));
		//print_r($newSearch);
		$uber = array_merge($uber,$newSearch);
		}
	
	
	
	
	
	//$newSearch = ($wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."18_posts WHERE ".$query_string.""));
	//$newSearch2 = ($wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."7_posts WHERE ".$query_string.""));
	//$uber = array_merge($newSearch,$newSearch2);
	$newSearch = $uber;
	//print_r($newSearch);
	foreach($uber as $s)
		{
		//echo $s->post_title."<br />";	
		}
	
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
<h4><a href="<?php echo $rr->guide; ?>" rel="bookmark" name="what" id="what">
  <?php 				
				$cleaned_result =  preg_replace('/[^0-9a-z(). ]+/i', ' ', $rr->title,$searchstring);
				//echo $cleaned_result;
				echo search_style($rr->title,$searchstring,'title');
				?>
  </a></h4>
<?php
				$cleaned_result =  preg_replace('/[^0-9a-z(). ]+/i', ' ', $rr->content,$searchstring);
				echo search_style($rr->content,$searchstring,'content');
				echo '<br /><a href="'.$rr->guide.'">';
				echo $rr->guide;
				//echo "/?page_id=".$rr->ID;
				echo'</a></div>';
				$search_flag = 1;
				//print_r($rr);
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

