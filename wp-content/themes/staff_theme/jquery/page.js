// JavaScript Document

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
  $.post("./dir/find.php<?php if (isset($_GET['schoolid'])) { echo "?var=".$_GET['schoolid']; }?>", {search_term : search_val}, function(data){
   if (data.length>0){ 
     $("#search_results").html(data); 
   } 
  }) 
} 

jQuery(document).ready(function() {
$("#search_results").click(function() 
	{ 
	var hmm=$("#search_results").val();
	$("div#id_results").html('<?php echo $_SERVER['REQUEST_URI']; ?>');;   
	});

});
