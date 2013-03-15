<?php
/*
Template Name: policy stuff
*/
?>

<?php //get_header();?>
<?php
	 //query_posts( 'post_parent=71' );
	//query_posts( 'orderby=title&order=DESC' );
$parents = array('1052','1054','1055','1056','1057','1059','1060');
foreach ($parents as $p)
	{
	$args=array('post_type'=>'page','post_parent' => $p, 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => '1000', 'cat' => '-325');
	$the_query = new WP_Query($args);
	//print_r($the_query);
	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  
	?>
<?php
$post->post_content = str_replace("http://staff.wrdsb.ca/policyprocedure/","http://staff.wrdsb.ca/policyprocedure/dl.php?file=",$post->post_content);
$linkstart = strpos(" ".$post->post_content,'<a href="',0);
$linkend = strpos($post->post_content,'pdf">',0);
//http://www.wrdsb.ca/staff/policyprocedure/wp-content/uploads/2010/04/3006_Student_Trustees.pdf

if ($linkstart >= 1)
	{
	echo substr($post->post_content,$linkstart-1,$linkend-$linkstart+4).'">'.$post->post_title.'</a><br />';
	}
?>
<?php endwhile; endif; 
		
	}?>