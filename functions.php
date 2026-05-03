<?php

//require_once(get_template_directory().'/functions-feed.php');

function is_googlesearch() {
	// /search/ AND &q= in url
	$url = $_SERVER['REQUEST_URI'];
	return ( (strpos($url,'&q=') !==false) && (strpos($url,'/search/') !==false  )) ? true : false ;
}

function planetozh_is_old($limit = 15) {
	$ageunix = time() - get_the_time('U');
	$days_old = floor($ageunix/(24*60*60));
	if ($days_old > $limit) {
		return true;
	} else {
		return false;
	}
}

function planetozh_is_fromsearchengine() {
	$ref = $_SERVER["HTTP_REFERER"];
	$SE = array('google.', 'web.info.com',
		'search.', 'del.icio.us/search',
		'soso.com', 
	);
	foreach ($SE as $url) {
		if (strpos($ref,$url)!==false) return true;
	}
	return false;	
}


function planetozh_regularvisitor() {
	global $wpdb;
	list ($visits, $last) = $wpdb->planetozhcookie;
	// ten days = 864000 seconds
	$time = time();
	$diff = $time - $last;
	
	/* regular visitor definition :
			visits >= 2
			last time visited <= 10 days	*/
	
	if ( ($visits >= 2) and ($diff <= 864000) ) {
		return true;
	} else {
		return false;
	}
	
}

function planetozh_myage($bday = '1972-03-23') {
	$days = (strtotime(date('Y-m-d')) - strtotime($bday)) / (60 * 60 * 24);
	return intval(($days / 365.25)*1000)/1000;
}

function planetozh_date_since_lastmod($before = '', $after = '', $echo = 1) {
	return planetozh_date_since($before, $after, $echo, true);
}

function planetozh_date_since($before = '', $after = '', $echo = 1, $lastmod = false) {
	global $post;
    $years = $months = $weeks = $days = 0;
	
	$func = $lastmod ? 'get_the_modified_time' : 'get_the_time';
		
	$days = (int)((strtotime(date('Y-m-d'))-strtotime(call_user_func($func,'Y-m-d')))/86400);
	
	if ($days == 0) {
		$output = "today";
	} elseif ($days == 1) {
		$output = "yesterday";
	} else {
	
		$diff = abs(time() - strtotime(call_user_func($func,'Y-m-d')));
		$years = intval($diff/(60*60*24*365));
		$diff -= ($years*60*60*24*365);
		$months = intval($diff/(60*60*24*30));
		$diff -= ($months*60*60*24*30);
		$weeks = intval($diff/(60*60*24*7));
		$diff -= ($weeks*60*60*24*7);
		$days = intval($diff/(60*60*24));
		$diff -= ($days*60*60*24);
		/*
		$hours = intval($diff/(60*60));
		$diff -= ($hours*60*60);
		$minutes = intval($diff/60);
		$diff -= ($minutes*60);
		$seconds = intval($diff);
		*/
		
		$output = '';
		$output .= ($years > 0) ? (($years==1)?'1 year ':"$years years "):'';
		$output .= ($months > 0) ? (($months==1)?'1 month ':"$months months "):'';
		$output .= ($weeks > 0) ? (($weeks==1)?'1 week ':"$weeks weeks "):'';
		$output .= ($days > 0) ? (($days==1)?'and 1 day ':"and $days days "): '';
		/*
		$output .= ($hours > 0) ? "$hours hours " : '';
		$output .= ($minutes > 0) ? "$minutes minutes " : '';
		$output .= ($seconds > 0) ? "$seconds secondes " : '';
		*/
		
		$output = trim($output.' ago ','and ');
	}

	$output = $before.$output.$after;
	
	if ($echo) {
	  echo $output;
	} else {
	  return $output;
	}
}


function planetozh_countwords_inpost() {

global $wpdb, $tableposts, $id;
$post = $wpdb->get_results("SELECT post_content FROM $tableposts WHERE id=$id");

$words = strip_tags($post[0]->post_content);
$words = explode(' ', $words);
$wordcount = count($words);
$wordcount = $wordcount;
$ret = number_format($wordcount) . " " . ($wordcount==1 ? "word" : "words");

return $ret;

}


function planetozh_countwords_incomments() {
}


/***************************************
 * Browsable year/month/day link
 **************************************/
function planetozh_archives_links($short_month=true, $sep = '/', $echo=true, $lastmod = false) {
	$func = $lastmod ? 'get_the_modified_time' : 'get_the_time';
	$year = call_user_func($func,'Y');
	$year_link = get_year_link($year);
	if ($short_month) {
					$month = call_user_func($func,'m');
	} else {
		$month = call_user_func($func,'F');
	}
	$month_link = get_month_link($year, call_user_func($func,'m'));
	$day = call_user_func($func,'d');
	$day_link = get_day_link($year, call_user_func($func,'m'), $day);

	$output = "<a href='$year_link'>$year</a>$sep<a href='$month_link'>$month</a>$sep<a href='$day_link'>$day</a>";
	if ($echo) {
		echo $output;
	} else {
		return $output;
	}
}

function planetozh_archives_links_lastmod($short_month=true, $sep = '/', $echo=true) {
	return planetozh_archives_links($short_month, $sep, $echo, true);
}



/***************************************
 * Category List
 * For use outside of the loop, returns
 * a comma separated list of categories
 **************************************/
function planetozh_category_list () {
	global $wp_query;
	if ( is_single() ) {
		$catlist = array();
		$cats = get_the_category($wp_query->post->ID);
		foreach($cats as $cat) {
			$catlist[] = str_replace('"','',$cat->cat_name);
		}
		return join(', ',$catlist);
	}
}



/***************************************
 * Meta Description
 * Returns content for the meta tag "content"
 * in <head>
 **************************************/
function planetozh_metadescription() {
	global $wp_query;
	$meta = get_bloginfo('name');
	if ( is_single() || is_page() ) {
		$meta .= ', ' . single_post_title('', false);
		$meta .= ', ' . planetozh_category_list();
	} else {
		$meta .= ', ' . get_bloginfo('description');
	}
	print $meta;
}

/***************************************
 * Optional Asides implementation
 **************************************/
function planetozh_is_asides() {
	return (strpos(planetozh_tag_list(false),'Shorties') !== false);
}
 
function planetozh_is_asides_old() {
     $planetozh_categories = array ();
     /* get all categories for the post we are processing */
     foreach((get_the_category()) as $cat) {
         $planetozh_categories[] = $cat->cat_name;
     }
     /* is one of these categories the same as our Asides cat ? */
     if (in_array("Shorties",$planetozh_categories)) {
             return true;
     } else {
             return false;
     }
}



/***************************************
 * Admin Cookie test
 **************************************/
function planetozh_is_admin() {
	if (preg_match("/wordpressuser[^=]*=admin/i", $_SERVER["HTTP_COOKIE"])) {
		return TRUE;
	} else {
		return FALSE;
	}
}


/***************************************
 * Category (Tag) Cloud
 **************************************/
function planetozh_category_cloud($font_min=9,$font_max=30,$limit=0) {

	echo 'unused';
	return;

	wp_tag_cloud('smallest=9&largest=30&number=9999&format=string');
	
	st_tag_cloud('number=100&largest=45&smallest=9&unit=px&maxcolor=#FF0000&mincolor=#00FF0B');
	
	global $wpdb;
	
	srand((double)microtime()*1000000); 
	
	$query  = "SELECT cat_ID, cat_name, category_nicename, category_description, category_parent
		FROM $wpdb->categories
		WHERE cat_ID > 0
		ORDER BY cat_name ASC";
	$categories = $wpdb->get_results($query);
	
	$cat_counts = $wpdb->get_results("SELECT cat_ID,
	COUNT($wpdb->post2cat.post_id) AS cat_count
	FROM $wpdb->categories 
	INNER JOIN $wpdb->post2cat ON (cat_ID = category_id)
	INNER JOIN $wpdb->posts ON (ID = post_id)
	WHERE post_status = 'publish'
	GROUP BY category_id");
	
	foreach ($cat_counts as $cat_count) {
		$count[$cat_count->cat_ID] = $cat_count->cat_count;
	}
	
	$count_max = max($count);
	
	foreach ($categories as $category) {
		$value=$count[$category->cat_ID];
		if ($value) {
			$text=$category->cat_name;
			if ($category->category_description != '') {$description = $category->category_description;} else {$description = $text;}
			$description = str_replace('"',"'",$description);
			$description = str_replace('&','&amp;',$description);
			$size=round($font_min+(($value * $font_max) / $count_max )) . 'px';
			$cat= get_category_link($category->cat_ID);
			echo "<span style=\"font-size:$size\"><a href=\"$cat\" title=\"$description ($value posts)\">$text</a></span>\n";
		}
	}
}

function planetozh_get_archives($short = true) {
	ob_start();
	wp_get_archives('show_post_count=true');
	$ob = '<ul>' . ob_get_contents() . '</ul>';
	ob_end_clean();
	// >xxxxxxx dddd</a> -> >xxx ddd
	if ($short) 
		$ob = str_replace(
			array('>January','>February','>March','>April','>May','>June','>July','>August','>September','>October','>November','>December'),
			array('>Jan','>Feb','>Mar','>Apr','>May','>Jun','>Jul','>Aug','>Sep','>Oct','>Nov','>Dec'),
			$ob);

	$count = preg_match_all('/<li>/',$ob,$out);
	$third = intval($count / 3);
	$remain = ($count % 3);
	$col1 = $col2 = $col3 = $third;
	if ($remain == 1) {
		$col1 += 1;
	} elseif ($remain == 2) {
		$col1 += 1;
		$col2 += 1;
	}
	
	$ob = str_replace('<ul>', '<ul class="col1">', $ob);
	
	$ob = str_replace('<li>', '<ozh>', $ob);
		
	$ob = preg_replace('/<ozh>/', '<li>', $ob, $col1);
	$ob = preg_replace('/<ozh>/', "</ul>\n<ul class=\"col2\"><li>", $ob, 1);
	$ob = preg_replace('/<ozh>/', '<li>', $ob, $col2 - 1 );
	$ob = preg_replace('/<ozh>/', "</ul>\n<ul class=\"col3\"><li>", $ob, 1);
	$ob = str_replace('<ozh>', '<li>', $ob);

	echo "$ob";
}

/* function for reinvigorate footer javascript call */
function planetozh_getvisitorname() {
	foreach ($_COOKIE as $k=>$v) {
		$k = substr($k,0,strlen($k)-33);
		$newcookie[$k] = $v;
	}

	if ($newcookie['comment_author']) {
		$visitor_name = $newcookie['comment_author'];
		$visitor_context = $newcookie['comment_author_url'];
	} elseif ($newcookie['wordpressuser']) {
		$visitor_name = 'Ozh';
		$visitor_context = 'http://planetozh.com/';
	}
	
	if ($visitor_name) {
		return(array('name'=>$visitor_name,'context'=>$visitor_context));
	} else {
		return false;
	}
}


function planetozh_logloadstats() {
	global $wpdb;
	$bb = $wpdb->ozhbbtimer;
	$total = $wpdb->ozhtotaltimer;

	foreach ($wpdb->queries as $query) {
		$queries += $query[1];
	}

	if (is_single()) {
		$type = 'single';
	} elseif (is_page()) {
		$type = 'page';
	} elseif (is_404()) {
		$type = '404';
	} else {
		$type = 'index';
	}

	//$type = is_single() ? 'single' : is_page() ? 'page' : is_404() ? '404' : 'index' ;
	$type .= ' '. str_replace('http://planetozh.com/blog/', '', $_SERVER['REQUEST_URI']);

	$nbqueries = $wpdb->num_queries;

	$stamp = date('Y-m-d :: H-i-s');
        $log=fopen('/home/planetozh/planetozh.com/blog/load.log','a');
        fputs($log,"$stamp :: $type :: $total :: $queries :: $nbqueries :: $bb\n");
	fclose($log);
}


function planetozh_footerstats($queries='frags',$seconds='seconds') {
	global $wpdb;
	$wpdb->ozhtotaltimer = timer_stop(0,9);
	$timer = timer_stop(0,3);
	echo $wpdb->num_queries . " $queries in " . $timer . " $seconds";
}


function planetozh_needlightbox($text) {
	global $wpdb;
	if (strpos($text,'rel="lightbox"') !== false) $wpdb->ozhneedslightbox = true;
	return $text;
}

function planetozh_addlightbox() {
	global $wpdb;
	if ($wpdb->ozhneedslightbox) {
		echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/combine.php?type=js&amp;files=effects,lightbox"></script>';
//		echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/js/effects.js"></script>';
//		echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/js/lightbox.js"></script>';
	}
}


function planetozh_navmark() {
    $news = $archives = $projects = $contact = $about = '';
	if (!is_404()) {
		$class= ' class="active"';
		if (is_page('about')) {
			$about = $class;
		} elseif (strpos($_SERVER["REQUEST_URI"],'/my-projects/') !== false) {
			$projects = $class;
		} elseif (is_page('contact')) {
			$contact = $class;
		} elseif (is_page('archives')) {
			$archives = $class;
		} else {
			$news = $class;
		}
	}
	
	echo <<<HTML
		<div id="mark-news" $news></div>
		<div id="mark-archives" $archives></div>
		<div id="mark-gallery"></div>
		<div id="mark-projects" $projects></div>
		<div id="mark-contact" $contact></div>
		<div id="mark-about" $about></div>
HTML;
	
}

function planetozh_title() {
	if (function_exists('optimal_title')) {
		optimal_title('&laquo;');
		bloginfo('name');
		if (!optimal_title('', 0)) echo ' &raquo; A virtual .postcard from $me to myself()';
	} else {
		bloginfo('name');
		wp_title();
	}

}

function planetozh_tag_list($echo = true) {
	/*
	global $wpdb, $id;
	if ($id != $wpdb->planetozh_tags[$id]) {
		$wpdb->planetozh_tags[$tags] = get_the_tag_list('', ', ');
		$wpdb->planetozh_tags[$id] = $id;
	}
	if ($echo) echo $wpdb->planetozh_tags[$tags];
	return $wpdb->planetozh_tags[$tags];
	*/
	$tags = get_the_tag_list('', ', ');
	if( $echo ) echo $tags;
	return $tags;
}
