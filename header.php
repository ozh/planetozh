<?php

$without = array('planetozh.css', 'style.css', 'iecss.css'); // not these ones
$files = glob(get_template_directory().'/*.css');
$cssfiles = '';
foreach($files as $file) {
    $file = basename($file);
    if (!in_array($file,$without)) {
        $file = str_replace('.css','',basename($file));
        $cssfiles .= "$file,";
    }
}
$cssfiles = 'planetozh,'.trim($cssfiles,',');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/1">
<title>
	<?php planetozh_title() ?>
</title>
<link rel="icon" href="/favicon.ico" /> 
<link rel="image_src" href="http://planetozh.com/images/ozh_100_75.gif" />
<link rel="shortcut icon"  href="/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php /*
<meta name="keywords" content="Ozh <?php planetozh_metadescription();?>" />
*/ ?>
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<meta name="author" content="Ozh" />
<meta name="template" content="planetOzh - http://planetOzh.com/" />
<meta name="robots" content="index,follow,all" />
<meta name="revisit-after" content="1 day" />
<meta name="copyright" content="Ozh - planetozh.com" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link href="<?php bloginfo('template_directory'); ?>/combine.php?type=css&amp;files=<?php echo $cssfiles; ?>" rel="stylesheet" type="text/css" />
<!--[if IE]> <link href="<?php bloginfo('template_directory'); ?>/iecss.css" rel="stylesheet" type="text/css"> <![endif]-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<?php if (is_single()) { ?>
<link rel="alternate" type="application/rss+xml" title="<?php the_title(); ?> RSS Comments Feed" href="<?php echo comments_rss();?>" />
<?php } ?>
<link rel="search" href="http://planetozh.com/opensearchdescription.xml" type="application/opensearchdescription+xml" title="planetOzh.com" />
<script type="text/javascript">
	planetozh_path = '<?php bloginfo('template_directory'); ?>';
</script>
<meta name="geo.region" content="FR-44" />
<meta name="geo.placename" content="Nantes" />
<meta name="geo.position" content="47.15984;2.988281" /> 
<meta name="ICBM" content="47.15984;2.988281" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
</head>

<body id="planetozh">

<div id="wrap">

<div id="header">
	<h1><span><?php planetozh_title() ?></span></h1>
	<h2><span><?php planetozh_metadescription();?></span></h2>

	<ul id="navlist">
	<li><a id="nav-news" href="<?php echo get_option('siteurl'); ?>/" title="The (English) Blog">Blog</a></li>
	<li><a id="nav-archives" href="<?php echo get_option('siteurl'); ?>/archives/" title="What I've written about">Archives</a></li>
	<li><a id="nav-gallery" href="/gallery/" title="Gallery &amp; Photos">Gallery</a></li>
	<li><a id="nav-projects" href="<?php echo get_option('siteurl'); ?>/my-projects/" title="Code I wrote">Projects</a></li>
	<li><a id="nav-contact" href="<?php echo get_option('siteurl'); ?>/contact/" title="Contact me">Contact</a></li>
	<li><a id="nav-about" href="<?php echo get_option('siteurl'); ?>/about/" title="About. Colophon. A propos.">A propos</a></li>
	</ul>
			
	<div id="navlistmark">
		<?php planetozh_navmark() ?>
	</div>		
	
</div> <!-- header -->


<div id="container">
