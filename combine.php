<?php

/************************************************************************
 * CSS and Javascript Combinator 0.5
 * Copyright 2006 by Niels Leenheer
 */

if (!$_GET) {
	redirect('http://planetozh.com/blog/');
	die();	
}

function redirect($url){
    if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header('Location: '.$url); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

function timer_start() {
	global $timestart;
	$mtime = explode(' ',microtime());
	$timestart = $mtime[1] + $mtime[0];
	return true;
}

function timer_stop($display = 0, $precision = 5) {
	global $timestart, $timeend;
	$mtime = explode(' ',microtime());
	$timeend = $mtime[1] + $mtime[0];
	$timetotal = number_format($timeend-$timestart,$precision);
	
	if ($display)
		echo $timetotal ;
	return $timetotal;
}

timer_start();

$cache    = true;
$cachedir = dirname(__FILE__) . '/cache';
$cssdir   = dirname(__FILE__) . '/';
$jsdir    = dirname(__FILE__) . '/js';

// Determine the directory and type we should use
switch ($_GET['type']) {
    case 'css':
        $base = realpath($cssdir);
        $ext = '.css';
        break;
    case 'javascript':
    case 'js':
        $base = realpath($jsdir);
        $ext = '.js';
        break;
    default:
        header ("HTTP/1.0 503 Not Implemented");
        echo "<h1>Yeah right. 503 Not Implemented.</h1>\n<p>Not, like, you know... implemented</p>\n";
        exit;
};

$type = $_GET['type'];
$elements = explode(',', $_GET['files']);
array_walk($elements, function(&$v,$k){global $ext;$v = $v . $ext;});

// Determine last modification date of the files
$lastmodified = 0;
//while (list(,$element) = each($elements)) {
foreach($elements as $element) {
    $path = realpath($base . '/' . $element);
    
    if (($type == 'javascript' && substr($path, -3) != '.js') || 
        ($type == 'css' && substr($path, -4) != '.css')) {
        header ("HTTP/1.0 403 Forbidden");
        echo "<h1>Yeah right... 403 Forbidden !</h1>\n<p>Forbidden, dude.</p>\n";
        exit;    
    }

    if (substr($path, 0, strlen($base)) != $base || !file_exists($path)) {
        header ("HTTP/1.0 404 Not Found");
        echo "<h1>Oops ?</h1>\n<p>File $element not found ?!</p>\n";
        exit;
    }
    
    $lastmodified = max($lastmodified, filemtime($path));
}

// Send Etag hash
$hash = $lastmodified . '-' . md5($_GET['files']);
header ("Etag: \"" . $hash . "\"");

if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && 
    stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"') 
{
    // Return visit and no modifications, so do not send anything
    header ("HTTP/1.0 304 Not Modified");
    header ('Content-Length: 0');
} 
else 
{
    // First time visit or files were modified
    if ($cache) 
    {
        // Determine supported compression method
        $gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
        $deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');

        // Determine used compression method
        $encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');

        // Check for buggy versions of Internet Explorer
        if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') && 
            preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
            $version = floatval($matches[1]);
            
            if ($version < 6)
                $encoding = 'none';
                
            if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1')) 
                $encoding = 'none';
        }
        
        // Try the cache first to see if the combined files were already generated
        $cachefile = 'cache-' . $hash . '.' . $type . ($encoding != 'none' ? '.' . $encoding : '');
        
        if (file_exists($cachedir . '/' . $cachefile)) {
            if ($fp = fopen($cachedir . '/' . $cachefile, 'rb')) {

                if ($encoding != 'none') {
                    header ("Content-Encoding: " . $encoding);
                }
            
                header ("Content-Type: text/" . $type);
                header ("Content-Length: " . filesize($cachedir . '/' . $cachefile));
    
                fpassthru($fp);
                fclose($fp);
                exit;
            }
        }
    }

    // Get contents of the files
    $contents = '';
    reset($elements);
    foreach($elements as $element) {
        $path = realpath($base . '/' . $element);
        $contents .= "\n\n" . file_get_contents($path);
    }
    
    $contents .= "\n\n/* File combination in ".timer_stop().' seconds */';

    // Send Content-Type
    header ("Content-Type: text/" . $type);
    
    if (isset($encoding) && $encoding != 'none') 
    {
        // Send compressed contents
        $contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
        header ("Content-Encoding: " . $encoding);
        header ('Content-Length: ' . strlen($contents));
        echo $contents;
    } 
    else 
    {
        // Send regular contents
        header ('Content-Length: ' . strlen($contents));
        echo $contents;
    }

    // Store cache
    if ($cache) {
        if ($fp = fopen($cachedir . '/' . $cachefile, 'wb')) {
            fwrite($fp, $contents);
            fclose($fp);
        }
    }
}
