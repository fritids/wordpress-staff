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
        <h3>Page not found!</h3>
        <?php 
		$term = explode('/',$_SERVER["REQUEST_URI"]);
		echo "<p><strong>Searching for: <em>".$term[count($term)-1]."</em></strong></p>";
		?>
		<?php bettersearch($term[count($term)-1]); ?>
        <p></p>
      </div>
    </div>
  </div>
  <?php //get_sidebar();?>
  <?php get_footer(); ?>
</div>
</div>
</body>
</html>