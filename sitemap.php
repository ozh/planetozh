<?php get_header(); ?>	

<div id="content">

<h2><a href="<?php bloginfo('url'); ?>" alt="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h2>

<h2><?php the_title(); ?></h2>

<h3>All Pages :</h3>
<ul>
	<?php wp_list_pages('title_li='); ?>
</ul>


<h3>All blog posts :</h3>
<ul>
	<?php $archive_query = new WP_Query('showposts=9999');
		while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a> <strong><?php comments_number('0', '1', '%'); ?></strong></li>
	<?php endwhile; ?>
</ul>

<h3>Monthly :</h3>
<ul>
	<?php wp_get_archives('type=monthly'); ?>
</ul>

<h3>Topics :</h3>
<ul>
	<?php wp_list_cats('sort_column=name&optioncount=1'); ?>
</ul>

<h3>Feeds :</h3>
<ul>
	<li><a href="<?php bloginfo('rss_url'); ?>" alt="RSS 0.92 feed"><acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed</a></li>
	<li><a href="<?php bloginfo('rss2_url'); ?>" alt="RSS 2.0 feed"><acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed</a></li>
	<li><a href="<?php bloginfo('atom_url'); ?>" alt="Atom feed">Atom feed</a></li>
</ul>


</div> <!-- content -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>	
