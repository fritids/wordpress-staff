<?php
/*
Template Name: School Lists
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
<?php
$args = array( 'post_type' => 'school', 'posts_per_page' => 200, 'orderby' => 'title', 'order' => 'asc');
$loop = new WP_Query( $args );
?>
<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<?php
//create table if there are not tags of cats specified
if ($_GET['cat'] == '' AND $_GET['tag'] == '')
	{
	echo '<table id="staff_list schools">';
	echo '<thead><tr class="tableheading"><th>Name</th><th>Website</th><th>Type</th><th>Features</th></tr></thead>';
	$x = 1;
	$odd = 1;
	while ( $loop->have_posts() ) : $loop->the_post();
		$school_url = get_post_custom($post->ID);
		$posttags = get_the_tags();
		$cats = get_the_category();
		if ($odd == $x%2)
			{
			$rowclass = 'odd';
			}
		else
			{
			$rowclass = 'even';	
			}
		echo '<tr class="'.$rowclass.'"><td class="school-name"><strong><a href="'.$post->guid.'">'.get_the_title().'</a></strong></td><td>';
		echo '<a href="'.$school_url['school_url'][0].'" target="_new">'.$school_url['school_url'][0].'</a></td><td><a href="?cat='.$cats['0']->slug.'">'.$cats['0']->name.'</a></td><td>';
		
		if ($posttags) 
			{
			foreach($posttags as $tag) 
				{
				echo '<a href="?tag='.$tag->slug.'">'.$tag->name.'</a><br />'; 
				}
			}
		echo "</td></tr>";
		$x++;
	endwhile;
	echo "</table>";
	}
	
	
// CATEGORY 
elseif (isset($_GET['cat']))
	{
	$granular_title = get_term_by('slug',$_GET['cat'],'category');
	echo "<h3>".$granular_title->name."</h3>";
	$args = array( 'post_type' => 'school', 'posts_per_page' => 200, 'orderby' => 'title', 'order' => 'asc');
	$loop = new WP_Query( $args );
	echo "<table>";
	while ( $loop->have_posts() ) : $loop->the_post();
		$school_url = get_post_custom($post->ID);
		$posttags = get_the_tags();
		$cats = get_the_category();
		if ($cats['0']->slug == $_GET['cat'])
			{
			echo '<tr><td><strong><a href="'.$post->guid.'">'.get_the_title().'</a></strong></td><td>';
			echo '<a href="'.$school_url['school_url'][0].'" target="_new">'.$school_url['school_url'][0].'</a></td><td><a href="?cat='.$cats['0']->slug.'">'.$cats['0']->name.'</a></td><td>';
			if ($posttags) 
				{
				foreach($posttags as $tag) 
					{
					echo '<a href="?tag='.$tag->slug.'">'.$tag->name.'</a><br />'; 
					}
				}
			echo "</td></tr>";
			}
	endwhile;
	echo "</table>";
	}
//


// TAGS
elseif (isset($_GET['tag']))
	{
	$granular_title = get_term_by('slug',$_GET['tag'],'post_tag');
	echo "<h3>".$granular_title->name."</h3>";
	$args = array( 'post_type' => 'school', 'posts_per_page' => 200, 'orderby' => 'title', 'order' => 'asc');
	$loop = new WP_Query( $args );
	echo "<table>";
	while ( $loop->have_posts() ) : $loop->the_post();
		$school_url = get_post_custom($post->ID);
		$posttags = get_the_tags();
		$cats = get_the_category();
		$tagflag = 0;
		if ($posttags)
			{
			foreach($posttags as $tag) 
				{
				if ($tag->slug == $_GET['tag'])
					{
					$tagflag = 1;	
					}
				}
			}
		if ($tagflag == 1)
			{
			echo '<tr><td><strong><a href="'.$post->guid.'">'.get_the_title().'</a></strong></td><td>';
			echo '<a href="'.$school_url['school_url'][0].'" target="_new">'.$school_url['school_url'][0].'</a></td><td><a href="?cat='.$cats['0']->slug.'">'.$cats['0']->name.'</a></td><td>';
			if ($posttags) 
				{
				foreach($posttags as $tag) 
					{
					echo '<a href="?tag='.$tag->slug.'">'.$tag->name.'</a><br />'; 
					}
				}
			echo "</td></tr>";
			$tagflag = 0;
			}
	endwhile;
	echo "</table>";
	}
//	
	
?>
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