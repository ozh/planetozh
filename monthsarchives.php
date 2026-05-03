<?php
global $wpdb;
$archive_uri = get_option('home')."/archives/";
$now = gmdate('Y-m-d H:i:s'); // get the current GMT date

$qy = mysql_query("SELECT distinct year(post_date) as year, post_status 
		FROM $tableposts 
		WHERE post_status='publish' 
		AND post_date <= NOW() 
		ORDER BY year desc");
	// loop to create the small archive block with year/month links
	while($years = mysql_fetch_array($qy)) {
	echo('<strong><a href="'.$archive_uri.$years[year].'">'.$years[year].'</a>:</strong> ');
		$qm = mysql_query("SELECT distinct month(post_date) as month 
			FROM $tableposts 
			ORDER BY month asc") or die(mysql_error());
		while($date = mysql_fetch_array($qm)) {
			$q = mysql_query("SELECT *, year(post_date) as year, month(post_date) as month 
			FROM $tableposts 
			WHERE year(post_date)='$years[year]' 
			AND month(post_date)='$date[month]' 
			AND post_status='publish' 
			AND post_date <= NOW() 
			ORDER BY id desc") or die(mysql_error()); 
			$sm =	ucfirst(strftime("%b", strtotime("$date[month]/01/2001"))); // get the shortened month name; strtotime() localizes
			$pd = sprintf("%02s", $date[month]); // pad the month with a zero if needed 	
			if(mysql_num_rows($q)) { echo('<a href="'.$archive_uri.$years[year].'/'.$pd.'/">'.$sm.'</a> '); }
			else {
				if ($sm == "Dec") {
					if ($smPrev == "Nov") { echo('<span class="emptymonth">'.$sm.'</span> '); }
				}
				else { echo('<span class="emptymonth">'.$sm.'</span> '); }
			}
			$smPrev=$sm;
		}
		echo('<br />');
	}
	echo ('<br /><br />');


?>