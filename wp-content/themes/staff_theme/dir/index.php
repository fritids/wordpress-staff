<?php include_once('functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html> 
<script type="text/javascript" src="jquery/jquery.js"></script>
<script type="text/javascript" src="jquery/page.js"></script>
<head> 
<title>Welcome!</title> 

<script type='text/javascript'> 
$(document).ready(function(){ 
$("#search_results").slideUp(); 
    $("#search_button").click(function(e){ 
        e.preventDefault(); 
        ajax_search(); 
    }); 
    $("#search_term").keyup(function(e){ 
        e.preventDefault(); 
        ajax_search(); 
    }); 

}); 
function ajax_search(){ 
  $("#search_results").show(); 
  var search_val=$("#search_term").val(); 
  $.post("./find.php<?php if (isset($_GET['schoolid'])) { echo "?var=".$_GET['schoolid']; }?>", {search_term : search_val}, function(data){
   if (data.length>0){ 
     $("#search_results").html(data); 
   } 
  }) 
  
} 
test();
</script> 

<script type="text/javascript">
jQuery(document).ready(function() {
$("#search_results").click(function() 
	{ 
	var hmm=$("#search_results").val();
	$("div#id_results").html('<?php echo $_SERVER['REQUEST_URI']; ?>');;   
	});

});
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head> 

<body style="overflow:hidden;">
<div id="staff-results">

<?php
if (isset($_GET['schoolid']))
	{
	?>
    <h2><a href="index.php">Return to search</a></h2>
    <div id="location_results">
    <?php
	include_once('find.php');
	}
	else
	{
	?>
	<div class="user-search">
    <h2 class="user-search">Please enter a <strong>Name</strong> or <strong>Location</strong></h2>
    <form id="searchform" method="post">
    <label for="search_term"></label>
    <input type="text" name="search_term" id="search_term" /> 
    </form> 
	</div>
	<div id="search_results">
    <?php
	}
?>
</div> 
<iframe src="" width="100%" height="95%" name="id_results" id="id_results" scrolling="no" frameborder="0">
<p>Your browser does not support iframes.</p>
</iframe>
</div>
</body> 
</html> 

