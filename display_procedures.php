<?php
include('wp-config.php');

$connect = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)
or die('Could not connect to mysql server.' );

mysql_select_db(DB_NAME, $connect)
or die('Could not select database.');


$parents = array('1043','1044','1045','1046');
foreach ($parents as $p)
	{
	$sql = "SELECT * FROM staff_18_posts WHERE post_parent = $p AND post_type LIKE 'page' ORDER BY post_title";
	$result = mysql_query($sql);
			if (mysql_num_rows($result) > 0)
				{
				while($row = mysql_fetch_object($result))
					{
						$link = str_replace("http://staff.wrdsb.ca/policyprocedure/","http://staff.wrdsb.ca/policyprocedure/",$row->post_content);
						$linkstart = strpos(" ".$link,'<a href="',0);
						$linkend = strpos($link,'pdf">',0);
						//print_r($row);
						//echo $row->post_title."<br />";
						if (strpos($row->post_title,'3040') > 0)
							{
							echo "boom";
							}
						if ($linkstart >= 1)
							{
							if ($row->ID == '145' OR $row->ID == '150')
								{
								echo '<a href="#" onClick="alert(\'This procedure is not published for confidentiality, health and safety purposes. If you require more information please contact the Assistant to the Superintendent Learning Services (519-570-0003 ext 4250)\')" >'.$row->post_title.'</a><br />';
								}
							else
								{
								echo substr($link,$linkstart-1,$linkend-$linkstart+4).'">'.$row->post_title.'</a><br />';
								}
							}
					}
				}
	}
	mysql_close();
?>