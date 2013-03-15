<?php /* Template Name: Vendors */ ?>
<?php
$the_page_title = get_the_title();
?>
<?php
		$args=array('post_type'=>'post','posts_per_page' => '1000', 'cat' => '5', 'orderby' => 'title', 'order' => 'ASC');
		$the_query = new WP_Query($args);
		//$the_query = new WP_Query;

?>

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
		<h3><?php echo $the_page_title; ?></h3>
        <ul>
        <?php if ($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
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