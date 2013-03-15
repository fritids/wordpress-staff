<?php
/*
Template Name: procedure stuff
*/
?>

<?php //get_header();?>
<?php
	 //query_posts( 'post_parent=71' );
	//query_posts( 'orderby=title&order=DESC' );
$parents = array('1043','1044','1045','1046');
foreach ($parents as $p)
	{
	//$args=array('post_type'=>'page','post_parent' => $p, 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => '1000', 'cat' => '-325');
	$args=array('post_type'=>'page','post_parent' => $p, 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => '1000');
	$the_query = new WP_Query($args);
	//print_r($the_query);
	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  
	?>
<?php

$thelink = str_replace("http://staff.wrdsb.ca/policyprocedure/","http://staff.wrdsb.ca/policyprocedure/dl.php?file=",$post->post_content);
$thelink = str_replace('PDF','pdf',$thelink);
$linkstart = strpos(" ".$thelink,'<a href="',0);
$linkend = strpos($thelink,'pdf">',0);
//http://www.wrdsb.ca/staff/policyprocedure/wp-content/uploads/2010/04/3006_Student_Trustees.pdf
$cat = get_the_category();
$thenulllink = '';
foreach ($cat as $c)
	{
	if ($c->slug == 'protected')
		{
		$thenulllink = '<a href="#" onClick="alert(\'This procedure is not published for confidentiality, health and safety purposes. If you require more information please contact the Assistant to the Superintendent Learning Services (519-570-0003 ext 4250)\')" >'.$post->post_title.'</a><br />';
		}
	}

if ($linkstart >= 1)
	{
	if ($thenulllink != '')
		{
		echo $thenulllink;	
		}
	else
		{
		echo substr($thelink,$linkstart-1,$linkend-$linkstart+4).'">'.$post->post_title.'</a><br />';
		}
		//echo $post->post_content;
	}
?>
<?php endwhile; endif; 
		
	}?>