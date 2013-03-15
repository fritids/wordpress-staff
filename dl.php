<?php
//print_r($_GET);
if (@$_GET['file'] != "")
	{
	$path = $_GET['file'];
	$mm_type="application/octet-stream"; // modify accordingly to the file type of $path, but in most cases no need to do so
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Type: " . $mm_type);
	header("Content-Length: " .(string)(filesize($path)) );
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header("Content-Transfer-Encoding: binary\n");
	readfile($path); // outputs the content of the file
	exit();
}	

?>