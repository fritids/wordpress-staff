<?php get_header();?>
  <div id="page-feature"> </div>
  <div id="content-wrapper">
    <div id="content-block"> <a name="content" id="content"></a>
      <?php $meta = get_post_custom($page_id); ?>
      <div class="post <?php echo $meta[status][0];?>">
        <h2><?php bloginfo('name'); ?></h2>
        <?php edit_post_link('Edit'); ?>
        <div class="breadcrumbs">
          <?php
if(function_exists('bcn_display'))
{
	bcn_display();
}
?>
        </div>
        <h3>Search Results</h3>
       <?php 
	   if (function_exists('wrdsb_multi_search'))
			{
			wrdsb_multi_search($_GET['s']);	
			}
		else
			{
			bettersearch($_GET['s']);	
			}
		?>
      </div>
    </div>
  </div>
  <?php get_sidebar();?>
  <?php get_footer(); ?>
</div>
</div>
</body>
</html>