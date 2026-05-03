<?php

if(!defined('get_template_directory()'))
	define(get_template_directory(),dirname(__FILE__));

define('OZHFEEDCACHE',str_replace('\\','/',get_template_directory().'/feeds'));
define('LIB_MAGPIE','/home/ozh/lib/magpie');
define('LIB_SIMPLEPIE','/home/ozh/lib/simplepie');


function planetozh_feed_get($name) {
	$feeds = array (
		//'book' => 'http://planetozh.com/bookmarks/feed/',
		'book' => 'http://feeds.delicious.com/v2/rss/Ozh?count=15',
		'lastfm' => 'http://planetozh.com/projects/lastfm/xml.php',
		);

	if (!planetozh_feed_is_fresh($name))
		planetozh_feed_getfeed($name,$feeds[$name]);
	return file_get_contents(OZHFEEDCACHE.'/'.$name.'.html');
}


function planetozh_feed_is_fresh($file,$age=3) {
	$lastmod = @filemtime(OZHFEEDCACHE.'/'.$file.'.html');
	$time = time();
	
	$fresh = (($time - $lastmod) > $age) ? false : true ;

	return $fresh;	
}


function planetozh_feed_getfeed($name,$url,$cache=1,$cachetime=1800) {
	$cachedir = OZHFEEDCACHE;
	switch($name) {
		case 'book':
			$feed = planetozh_feed_simplepie($name,$url,$cache,$cachetime,$cachedir);
			break;
		case 'lastfm':
			$feed = planetozh_feed_magpie($name,$url,$cache,$cachetime,$cachedir);
			break;
		default:
	}
	if ($feed) {
		planetozh_feed_save($name,$feed);
		return true;
	} else {
		return false;
	}
}


// 10 latest items
function planetozh_feed_simplepie($name,$url,$cache,$cachetime,$cachedir) {
	require_once(LIB_SIMPLEPIE.'/simplepie.inc');
	$feed = new SimplePie();
	$feed->enable_caching($cache);
	$feed->cache_max_minutes($cachetime);
	$feed->cache_location($cachedir);
	$feed->feed_url($url);
	$feed->init();
	$result = "<p>My recent bookmarks</p>\n<ul>\n";
	$loop = 0;
	foreach($feed->data['items'] as $item) {
		$loop++;
		if ($loop>10) break;
		switch($name) {
			case 'book':
				$link = $item->data['link']['alternate'][0];
				$title = htmlentities($item->data['title']);
				$desc = htmlentities($item->data['description']);
				$tags = implode(', ',$item->data['category']);

				$intitle = $title.' (';
				if ($desc) $intitle .= $desc.'. ';
				$intitle .= 'Tags: '.$tags.')';

				$result .= "<li><a rel=\"nofollow\" href=\"$link\" title=\"$intitle\">".snippet_text($title,5)."</a></li>\n";
				break;
			default:
				$result = "oops? parser error?";
		}
	}
	$result .= "</ul>\n";
	return $result;
}


function planetozh_feed_magpie($feed,$url,$cache,$cachetime,$cachedir) {
	require_once(LIB_MAGPIE.'/rss_fetch.inc');
	define('MAGPIE_CACHE_ON', $cache);
	define('MAGPIE_CACHE_AGE', $cachetime);
	define('MAGPIE_CACHE_DIR', $cachedir);

	$xml = fetch_rss( $url );
	$result = '<p>'.$xml->channel['description'];
	$result .= "</p>\n<ul>";
	foreach ($xml->items as $item) {
		switch($feed) {
			case 'lastfm':
				$result .= utf8_encode(sprintf ("<li>%s <em>by %s</em></li>\n",$item['title'],$item['artist']));
				break;
			default:
				$result = "oops? parser error?";
		}
	}
	$result .= "</ul>\n";
	return $result;
}


function planetozh_feed_save($feed,$content) {
	$log=fopen(OZHFEEDCACHE.'/'.$feed.'.html','w');
	fputs($log,$content);
	fclose($log);
}


// Snippet
if(!function_exists('snippet_text')) {
   function snippet_text($text, $length = 0) {
      $words = preg_split('/\s+/', ltrim($text), $length + 1);
      if(count($words) > $length) {
         return rtrim(substr($text, 0, strlen($text) - strlen(end($words)))).' ...';
      } else {
         return $text;
      }
   }
}


?>
