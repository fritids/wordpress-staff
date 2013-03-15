<?php
/*
Template Name: Home Page Banners
*/
?>
<?php get_header();?>

<div id="page-feature">
  <div id="feature">
    <div id="feature-text">
      <h2>Quick Links</h2>
      <ul>
        <li><a href="http://www.wrdsb.ca/about-us/transportation/severe-weather" class="button-bus">Bus Delays &amp Cancellations </a></li>
        <li><a href="https://www.stswr.ca/Default.aspx" target="_blank" class="button-finder">School Finder</a></li>
        <li><a href="http://www.wrdsb.ca/about-us/school-year-calendar" class="button-calendar">School Calendars</a></li>
      </ul>
    </div>

      <div id="featured">
        <div id="container" class="cf">
          <section class="slider" style="width: 640px;">
            <div class="flexslider">
              <ul class="slides">
                <li> <a href="http://www.google.ca"><img src="http://departments.wrdsb.ca/wp-content/uploads/2013/01/test_banner.jpg" /></a> </li>
                <li> <img src="http://departments.wrdsb.ca/wp-content/uploads/2013/01/test_banner.jpg" /> </li>
                <li> <img src="http://departments.wrdsb.ca/wp-content/uploads/2013/01/test_banner.jpg" /> </li>
                <li> <img src="http://departments.wrdsb.ca/wp-content/uploads/2013/01/test_banner.jpg" /> </li>
              </ul>
            </div>
          </section>
        </div>

    </div>
  </div>
</div>
<div id="content-wrapper" class="is-home">
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
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div>
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
</body></html>