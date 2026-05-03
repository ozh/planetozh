<?php
/*
Template Name: List Children
*/
?>
<?php get_header(); ?>	

<div id="content" class="single">


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- google_ad_section_start -->

<div class="post">

<div class="storytitle">
<span class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></span>
</div> <!-- storytitle -->
	<div class="meta">
	<?php if ('open' == $post->comment_status) { ?>
	<span class="feedback"><?php comments_number('0 blabla', '1 blabla', '% blablas' );  ?></span>
	<?php } ?>
	<span class="days_since">On: <?php the_date('Y/m/d'); ?></span>
	<?php
	if (function_exists('wp_ozh_postviews')) {
		$total = wp_ozh_postviews();
		echo "<span>Viewed: $total times</span>";
	}
	?>
	<?php edit_post_link("x"); ?>
        <?php if (function_exists('wp_ozh_yourls_url')) { ?>
                <br/><span class="short_url"><strong>Shorter URL</strong> for this page: <?php wp_ozh_yourls_url(); ?></span>
        <?php } ?>

</div> <!-- meta -->


		<div class="storycontent">

	<p>Under this section you'll find...</p>

<?php

    wp_list_pages("child_of=".$post->ID."&sort_column=menu_order&depth=3&title_li=");

?>


		<?php // link_pages('<span class="npage">Pages :', '</span><br />', 'number','','','Page %', 'kk'); ?>
		</div> <!-- storycontent -->

<!-- google_ad_section_end -->

     		<!--
	     	<?php trackback_rdf(); ?>
	     	-->

<?php if (function_exists('wp_ozh_yourls_url')) { ?>
<h4>Shorter URL</h4>
<p>Want to share or tweet this page? Please use this short URL: <strong><?php wp_ozh_yourls_url(); ?></strong></p>
<?php } ?>

<h4 id="metadata">Metastuff</h4>
<div class="commentsmeta">
<p><small>This page "<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a>"
was posted on <?php the_time('d/m/Y') ?> at <?php the_time() ?> <br />
<?php if ('open' == $post->comment_status) { ?>
Watch this discussion : Comments <a href="<?php bloginfo_rss('comments_rss2_url'); ?>">RSS 2.0</a>.
<?php } ?>
<?php if ('open' == $post->ping_status) { ?>
You can <a href="<?php trackback_url(display); ?> ">trackback</a> this post from your own site
<?php } ?>
</small></p></div>
	<?php
	if ('open' == $post->comment_status or $post->comment_count > 0 ) comments_template();
	?>

</div> <!-- post -->

	<!-- THE LOOP : ELSE -->
	<?php endwhile; else: ?>

	<?php
	include(get_bloginfo('template_directory').'/404.php');
	?>

<?php endif; ?>

</div> <!-- content -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>
