﻿﻿<?php
/*
Plugin Name: Revision Removal
Plugin URI: http://www.rmvalues.com/blog/
Description: Remove the revision posts from your database in order to reduce your database size and optimize the speed of your database load!
Author: RMvalues
Version: 2.0
Author URI: http://www.rmvalues.com/blog/

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

	if(!get_option('revision_removal_no')) {update_option("revision_removal_no",0);}
	if(!get_option('revision_removal_getPosts')) {update_option("revision_removal_getPosts",0);}
	

	$dr_locale = get_locale();
	$dr_mofile = dirname(__FILE__) . "/revision-removal-$dr_locale.mo";
	load_textdomain('revision-removal', $dr_mofile);
	
function revision_removal_main() {
    if (function_exists('add_options_page')) {
	add_options_page('Revision Removal', 'Revision Removal',8, basename(__FILE__), 'my_options_revision_removal');
    }
 }

add_action('admin_menu', 'revision_removal_main');

function my_options_revision_removal() {
	$dr_ver = '1.0 Beta';
	$get_my_posts = get_my_posts();
	$revision_removal_no = get_option('revision_removal_no');
	echo <<<EOT
	<div class="wrap">
		<h1>Revision Removal Control Panel  <font size=1>verion $dr_ver</font></h1>
<STYLE type=text/css>
.TPouttablew_nd02ht {font-family:verdana,arial,helvetica; border:1px solid; background:#FFFFFF; border-color:#0CB204; border-collapse:collapse;width:728px;height:90px; font-size:10px;}
.TPoutheaderw_nd02ht {text-align:center;background-color:#0CB204;height:20px;padding: 0 8px;}
.TPoutheaderw_nd02ht a {text-decoration:none;font-size:11px;color:#ffffff;font-weight:bold;}
.TPoutheaderw_nd02ht a:hover {color:#ffffff;}.TPtablew_nd02ht {font-family:verdana,arial,helvetica; background:#FFFFFF; font-size:10px;margin:6px 8px;height:90%;}
.TPcellw_nd02ht {font-weight:normal; font-style:normal; color:#000000;padding:0;}
a.TPcellw_nd02ht {font-family:verdana,arial,helvetica; text-decoration:underline; font-weight:bold; color:#0CB204;}
a:hover.TPcellw_nd02ht {color:#0CB204;}.TPfooterw_nd02ht {text-align:right;padding-bottom:0;}a.TPfooterw_nd02ht{font-size:11px;font-weight:bold; color:#0CB204;}a:hover.TPfooterw_nd02ht {color:#0CB204;}</STYLE><center><table cellpadding="0" cellspacing="0" border="0" class="TPouttablew_nd02ht"><tr valign="middle"><td class="TPoutheaderw_nd02ht"><a href="http://rmvalues.tradepub.com/c/pubRD.mpl/?sr=ps&_t=ps:w_nd02ht:&ch=rr1b&_m=01.00ev.1.0.0">Free IT - Software Magazines and eBooks</a></td></tr><tr valign="top"><td><script language="javascript" src="http://cts.tradepub.com/cts4/?ptnr=rmvalues&tm=w_nd02ht&cat=Infosoft&type=all&key=&trk=rr1b"></script></td></tr></table></center>
		<div style="background-color:lightgreen;"><p style="margin:10px;text-align:center;">
EOT;
		printf(__("Currently You have <span style='color:red;font-weight:bolder;'> %s </span> posts , and Revision Removal has removed a total of <span id='revs_no' style='color:red;font-weight:bolder;'> %s </span> post revisions now.",'revision-removal'), $get_my_posts,$revision_removal_no);
		echo '</p>';

	if (isset($_POST['del_act'])) {
		revision_removal_act();
		$del_no = $_POST['rev_no'];
		update_option("revision_removal_no",get_option("revision_removal_no") + $del_no);
		echo '<div class="updated" style="background-color:lightgreen;margin-top:50px;align:center;"><p><strong>';
		printf(__("Deleted <span style='color:red;font-weight:bolder;'> %s </span> revision posts !",'revision-removal'),$del_no);	
		echo "</strong></p></div></div><script>
		var del_no = document.getElementById('revs_no').innerHTML;
		document.getElementById('revs_no').innerHTML = Number(del_no)+ $del_no;
		</script>";
	}
	elseif (isset($_POST['get_rev'])) {
		get_my_revision();
		
	}
	elseif (isset($_POST['maintain_mysql'])) {
		if ($_POST['operation'] == 'OPTIMIZE' ) {echo maintain_mysql('OPTIMIZE');}
		else echo maintain_mysql('CHECK');
	}
	else {
		echo '<center><form method="post" action="">';
		echo '<input class="button" type="submit" name="get_rev" value="';
		_e('Check Revision Posts','revision-removal');
		echo '" />  <input class="button" type="submit" name="maintain_mysql" value="';
		_e('Optimize Your Database','revision-removal');
		echo '" /></form></center>';

	}
	
	echo '<div style="background-color:lightgreen;"><br />';
	_e('Revision Post is the new features of WordPress ver 2.6 and above. Every time you made a change to your post or page, it will automatic save add a revision, just like a draft. As many as you made change, the more revision you will have in your database. It will not only increase your database size, but also increase your load time as the server need more time to access the database.','revision-removal');
	_e('For example if you have 20 revisions, you will have 20 extra drafts in your database.','revision-removal');
	echo '<br />';
	_e('Revision Manager is your choice to remove all the revisions quickly to help you to increase the speed of implementation of the SQL statement, and increase the speed of your server load.','revision-removal');
	echo '<br />';
	_e('Thank you for choosing us! Hope you like it.','revision-removal');
	echo '<br />';
	_e('Author','revision-removal');
	echo ':<a href="http://www.rmvalues.com/blog/" target="_blank">RMvalues</a>';
	echo '<br />';
	_e('<form target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post"><div class="paypal-donations"><input type="hidden" name="cmd" value="_donations" /><input type="hidden" name="business" value="KQ72ETN9PT75W" /><input type="hidden" name="return" value="http://www.rmvalues.com/tq.html" /><input type="hidden" name="item_name" value="Donate to RMvalues" /><input type="hidden" name="currency_code" value="MYR" /><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online." /><img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" /></div></form>','revision-removal');
	echo '<table><tr><td><a href="http://www.hostelworld.com/index.php?affiliate=rmvalues"><img src="http://reservations.bookhostels.com/images/abh/promos/banners_2009/Banner037-120x240-english-generic-hostels_bbs-non_groups.jpg" border="0" alt="Book Hostels Online Now"></a></td><td><script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US"></script><script type="text/javascript">FB.init("597437903a4e7aac3e6c54d3fa00df98");</script><fb:fan profile_id="166144202249" stream="0" connections="10" logobar="1" width="300"></fb:fan><div style="font-size:8px; padding-left:10px"><a href="http://www.facebook.com/RMvalues">RMvalues</a> on Facebook</div></td></tr></table>';
	echo '</div></div></div>';
}

function get_my_posts() {
	global $wpdb;
	
	$sql = "SELECT ID
			FROM (
			$wpdb->posts
			)
			WHERE `post_type` = 'post'";
	$results = $wpdb -> get_results($sql);
	return count($results);
}

function get_my_revision() {
	global $wpdb;
	
	$sql = "SELECT `ID`,`post_date`,`post_title`,`post_modified`
			FROM (
			$wpdb->posts
			)
			WHERE `post_type` = 'revision'
			ORDER BY `ID` DESC";
	$results = $wpdb -> get_results($sql);
	if($results) {
	$res_no = count($results);
	echo "<table class='widefat'><thead>";
	echo "<tr><th width=30> Id </th><th width=450> Title </th><th width=180> Post date </th><th width=180> Last modified </th></tr></thead>";
	for($i = 0 ; $i < $res_no ; $i++) {
		echo "<tr><td>".$results[$i] -> ID."</td>";
		echo "<td>".$results[$i] -> post_title."</td>";
		echo "<td>".$results[$i] -> post_date."</td>";
		echo "<td>".$results[$i] -> post_modified."</td></tr>";
	}
	echo "</table><br />";
	echo "Would you like to remove the revision posts ? <br />";
	echo <<<EOT
		<form method="post" action="">
		<input type="hidden" name="rev_no" value=" $res_no " />
EOT;
		echo '<input class="button-primary" type="submit" name="del_act" value="';
		printf(__('Yes , I don\'t want to see them!(A Total Of %s)','revision-removal'),$res_no);
		echo '" /><input class="button" type="submit" name="goback" value="';
		_e('No , I prefer to keep it!','revision-removal');
		echo '" /></form></div>';

	}
	else {echo "<div class=\"updated\" style=\"background-color:lightgreen;margin:50px 0 0 0;padding:6px;line-height:16pt;font-weight:bolder;text-align:center;\">";
	_e('Wow, Congratulation! You have no revision posts now.','revision-removal');
	echo "</div></div>";}
}

function revision_removal_act() {
	global $wpdb;
	
	$sql = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";
	$results = $wpdb -> get_results($sql);


}

function maintain_mysql($operation = "CHECK"){
		global $wpdb;
       
        $Tables = $wpdb -> get_results('SHOW TABLES IN '.DB_NAME);
        $query = "$operation TABLE ";

		$Tables_in_DB_NAME = 'Tables_in_'.DB_NAME;
        foreach($Tables as $k=>$v){
			$_tabName = $v -> $Tables_in_DB_NAME ;
           $query .= " `$_tabName`,";
        }

        $query = substr($query,0,strlen($query)-1);
        $result = $wpdb -> get_results($query);
		if ($operation == "OPTIMIZE") {
			return '<h3>'.__('Optimization of database completed.','revision-removal').'</h3>';
		}

        $res = "<table border=\"0\" class=\"widefat\">";
        $res .= "<thead><tr>
			<th>Table</th>
			<th>OP</th>
			<th>Status</th>
			</tr><thead>";
        $bgcolor = $color3;
		foreach($result as $j=>$o) {
            $res .= "<tr>";
            foreach ($o as $k=>$v) {
				$tdClass = $j%2 == 1 ? 'active alt' : 'inactive';
				if($k == 'Msg_type') continue;
				if($k == 'Msg_text' ) {
					if ($v == 'OK') {
					$res .= "<td class='$tdClass' ><font color='green'><b>$v</b></font></td>";
					}
					else {
					$res .= "<td class='$tdClass' ><font color='red'><b>$v</b></font></td>";
					}
				}
				else $res .= "<td class='$tdClass' >$v</td>";
            }
            $res .= "</tr>";
        }
        $res .= "<tfoot><tr><th colspan=3>".__('If the Status is green <font color=green>OK</font>, then indicated that is normal, does not need any operation, please return back; If is red, then please click on the following button to optimize.','revision-removal')."</th></tr></tfoot></table>";
		$res .= "<br /><form method='post' action=''>
			<input name='operation' type='hidden' value='OPTIMIZE' />
			<input name='maintain_mysql' type='hidden' value='OPTIMIZE' />
			<input name='submit' type='submit' class='button-primary' value='".__('Optimize your dataBase','revision-removal')."' /></form>";
        return $res;
    }

?>