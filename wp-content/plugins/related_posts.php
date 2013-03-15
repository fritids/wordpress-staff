<?php

/*
Plugin Name: related_posts
Plugin URI: http://www.wrdsb.ca
Description: Add other page slugs as tags - Works ONLY with Wordpress >= 2.3
Version: 2.0
Author: Michael Denny
Notes: Updated June 2011 to included delete buttons and 3.0 compatability
*/

add_action('edit_page_form', 'addthetags');
add_filter('posts_where', 'addpagetowhere' );

function addthetags() {
	global $post_ID;
	$tags = get_tags_to_edit( $post_ID );
	?>

<h2>Related Procedures / Policies</h2>
<script type="text/javascript">
function addMsg(text,element_id) {
document.getElementById(element_id).value += text;
}
</script>
<div id="tagsdiv-post_tag" class="postbox " >
  <div class="handlediv" title="Click to toggle"><br />
  </div>
  <h3 class='hndle'><span>Related Posts</span></h3>
  <div class="inside">
    <div class="tagsdiv" id="post_tag">
      <div class="jaxtag">
        <div class="nojs-tags hide-if-js">
          <p>Add or remove tags</p>
          <textarea name="tax_input[post_tag]" rows="3" cols="20" class="the-tags" id="tax-input-post_tag" ></textarea>
        </div>
        <div class="ajaxtag hide-if-no-js">
          <label class="screen-reader-text" for="new-tag-post_tag">Post Tags</label>
          <p>
            <input type="text" style="width: 100%; height: 50px;" cols="30" id="new-tag-post_tag" name="newtag[post_tag]" class="newtag form-input-tip" autocomplete="off" value="<?php echo $tags.","; ?>" />
            <input type="button" class="button tagadd" value="Update/Add" tabindex="3" />
          <div class="tagchecklist"></div>
          </p>
          <label>
            <select name="select" size="12" multiple="MULTIPLE" id="select" style="height: 200px; width: 50%;">
              <?php echo build_options_list(); ?>
            </select>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
	build_options_list();
}

function addpagetowhere( $where ) {
  if( is_tag() ) {
    $where = preg_replace(
       "/ ([0-9a-zA-Z_]*\.?)post_type = 'post'/",
       "(${1}post_type = 'post' OR ${1}post_type = 'page')", $where );
   }

  return $where;
}

function build_options_list() {
	global $wpdb;
	$options = "";
	$pages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status = 'publish' AND post_type = 'page' ORDER by post_title"); 
	foreach ($pages as $p)
		{
		$option .= '<option value="'.$p->ID.'" onclick="addMsg(\''.$p->post_name.', \',\'new-tag-post_tag\'); return false;">'.$p->post_title.'</option>';
		}
	return($option);
	
}

?>
