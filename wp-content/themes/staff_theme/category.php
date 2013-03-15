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
        <?php
		
		?>
		<h3>Category: <?php single_cat_title(); ?></h3>
                <ul>
        <?php if (have_posts() ) : while ( have_posts() ) : the_post(); ?>
               <li> <a href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); ?>
          </a></li>
  
        <?php endwhile; endif; ?>
        </ul>
      </div>
    </div>
  </div>
  <?php get_sidebar();?>
  <?php get_footer(); ?>
</div>
</div>
</body>
</html>