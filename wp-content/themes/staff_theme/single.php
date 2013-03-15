<?php get_header();?>

<div id="page-feature"> </div>
<div id="content-wrapper">
  <div id="content-block"> <a name="content" id="content"></a>
    <?php $meta = get_post_custom($page_id); ?>
    <div class="post <?php echo $meta[status][0];?>">
      <h2>
        <?php bloginfo('name'); ?>
      </h2>
      <?php edit_post_link('Edit'); ?>
      <div class="breadcrumbs">
        <?php
if(function_exists('bcn_display'))
{
	bcn_display();
}
?></div>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>      
      <h3><a href="<?php the_permalink() ?>" rel="bookmark">
        <?php the_title(); ?>
        </a></h3>
      <p class="date">
        <?php the_date(); ?>
      </p>

      <?php the_content(); ?>
       <?php if (get_option('wrdsb_post_comments') == 'on')
	   	{
		echo '<br /><hr /><br /><br />';
		comments_template();	
		}
	   
	   ?>
      <?php endwhile; endif; ?>
    </div>
  </div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
</div>
</div>
</body></html>