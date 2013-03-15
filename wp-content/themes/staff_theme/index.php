<?php get_header();?>

<div id="page-feature"> </div>
<div id="content-wrapper">
  <div id="content-block"> <a name="content" id="content"></a>
    <?php $meta = get_post_custom($page_id); ?>
    <?php $front_page_cat = get_option('wrdsb_theme_setting_frontcat'); ?>
    <?php $number_of_posts = get_option('posts_per_page'); ?>
    <?php //echo $number_of_posts; ?>
    <?php
	if ($front_page_cat != "")
		{
		$args=array('post_type'=>'post','posts_per_page' => $number_of_posts, 'cat' => $front_page_cat);
		$the_query = new WP_Query($args);
		}
	else
		{
		$the_query = new WP_Query();
		}
	
	?>
    <div class="post">
      <h2>
        <?php bloginfo('name'); ?>
      </h2>
    </div>
     	<?php
    if(function_exists('wrdsb_global_news'))
		{
		wrdsb_global_news();
		}
    ?>
    <?php $x = 0; ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post post-<?php echo $post->ID; ?>">
      <h3><a href="<?php the_permalink() ?>" rel="bookmark">
        <?php the_title(); ?>
        </a></h3>
      <p class="date">
        <?php the_date(); ?>
      </p>
      <?php 
	  if ($x == 0)
	  	{
		the_content();
		$x=1;
		}
	else
		{
		//the_excerpt();	
		the_content();
		?>
      <!-- <p class="readmore" ><a href="<?php the_permalink(); ?>">Read more...</a></p> -->
      <?php
		}
		?>
    </div>
    <?php endwhile; endif; ?>
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
    <?php if ($content_left != "" AND $content_right !="" ) {?>
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
</body></html>