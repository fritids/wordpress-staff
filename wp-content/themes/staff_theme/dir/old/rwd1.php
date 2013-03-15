<?php include_once('functions.php'); ?>
<html> 
<script type="text/javascript" src="jquery/jquery.js"></script>
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
  $.post("./find.php", {search_term : search_val}, function(data){
   if (data.length>0){ 
     $("#search_results").html(data); 
   } 
  }) 
} 
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


<style type="text/css">
<!--
#id_results {
	padding: 5px;
	width: 450px;
	float: left;
}
#searchform {
	float: left;
	width: 100%;
	clear: both;
}
#search_results {
	width: 150px;
	padding: 5px;
	float: left;
	margin-right: 10px;
}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head> 

<body>
<p>Just start typing.... </p>
<form id="searchform" method="post"><div>
      <label for="search_term"></label>
        <input type="text" name="search_term" id="search_term" /> 

  <!--<select name="search_term" id="search_term" onchange="MM_jumpMenu('parent',this,0)">
    <?php get_locatons(); ?>
  </select></div> 
  
  
  <input name="search_button" id="search_button" type="submit">-->
  
  
</form> 

    <div id="search_results"></div> 
    <iframe src ="" width="100%" height="95%" name="id_results" id="id_results" frameborder="0">
  <p>Your browser does not support iframes.</p>
</iframe>
</body> 
</html> 

