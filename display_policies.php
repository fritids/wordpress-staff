<?php
include('wp-config.php');

$connect = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)
or die('Could not connect to mysql server.' );

mysql_select_db(DB_NAME, $connect)
or die('Could not select database.');


$parents = array('1052','1054','1055','1056','1057','1059','1060');
foreach ($parents as $p)
	{
	$sql = "SELECT * FROM staff_18_posts WHERE post_parent = $p AND post_type LIKE 'page' ORDER BY post_title";
	$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0)
				{
				while($row = mysql_fetch_object($result))
					{
						$link = str_replace("http://staff.wrdsb.ca/policyprocedure/","http://staff.wrdsb.ca/policyprocedure/",$row->post_content);
						//print_r($row);
						$linkstart = strpos(" ".$link,'<a href="',0);
						$linkend = strpos($link,'pdf">',0);
						//print_r($row);
						//echo $row->post_title."<br />";
						if ($linkstart >= 1)
							{
							echo substr($link,$linkstart-1,$linkend-$linkstart+4).'">'.$row->post_title.'</a><br />';
							}
					}
				}
	}
	mysql_close();
?>