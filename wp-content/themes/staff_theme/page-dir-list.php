<?php
/*
Template Name: Folder/Directory Listing
*/
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
       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div><h3><a href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); ?>
          </a></h3>
        
		
        
        <?php
		$pass = get_post_custom();
		if ($pass['password'][0] != '')
			{
			if ($_POST['action'] == 'pwd' AND $_POST['post_password'] == $pass['password'][0])
				{
				the_content();
				get_folder_contents();
				}
			else
				{
				echo '<form action="?" method="post"><input type="hidden" name="action" value="pwd" />
				<p>' . __("This content is password protected. To view it please enter your password below:", 'psc') . '</p>
				<p><label for="' . $label . '">' . __("Password:", 'psc') . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__("Submit", 'psc') . '" /></p>
				</form>
			';
				}
			}
	
		?>
          
              <?php 
			if (is_active_sidebar('content'))
				{
				?>
                <div class="content-widget">
                 <?php
				dynamic_sidebar('content');
				?>
                </div>
                <?php
				}
		?>
        </div>
        <?php endwhile; endif; ?>
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
function get_folder_contents()
	{
	$pass = get_post_custom();
	if ($pass['dir_path'][0] != '')
		{
		$dir =  $pass['dir_path'][0];	
		$dirlist = array();
		if ($handle = opendir($dir)) 
			{
			while (false !== ($entry = readdir($handle))) 
				{
				if ($entry != "." && $entry != "..") 
					{
					$dirlist[$entry] = $entry;
					}
				}
			closedir($handle);
			ksort($dirlist);
			foreach ($dirlist as $d)
				{
				echo '<a href="http://staff.wrdsb.ca/training/'.$dir.$d.'" target="_new">'.$d.'</a><br />';	
				}
			}
		}	
	}
?>