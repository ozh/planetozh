<?php get_header(); ?>	

<div id="content" class="single">


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- google_ad_section_start -->

<div class="post">

<div class="storytitle">
<span class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></span>
</div> <!-- storytitle -->
	<div class="meta">
	<span class="filedin">In: <?php planetozh_tag_list() ?></span><br/>
	<span class="feedback"><?php comments_number('0 blabla', '1 blabla', '% blablas' );  ?></span>
	<span class="days_since">On: <?php planetozh_archives_links(true,' / '); ?></span>
	<?php edit_post_link("x"); ?>
        <?php if (function_exists('wp_ozh_yourls_url')) { ?>
                <br/><span class="short_url"><strong>Shorter URL</strong> for this post: <?php wp_ozh_yourls_url(); ?></span>
        <?php } ?>

</div> <!-- meta -->


<div class="storycontent">
<div class="KonaBody">

<?php if (is_attachment()) echo "This attached file belongs to <a href='".dirname($_SERVER['REQUEST_URI'])."/'>this article</a>"; ?>

    	<?php the_content("<span class=\"readmore\">Read More</span>"); ?>
<?php link_pages('<span class="npage">Page: ', '</span>', 'number', '', '', '#%'); ?>

		<?php // link_pages('<span class="npage">Pages :', '</span><br />', 'number','','','Page %', 'kk'); ?>
</div> <!-- storycontent -->
</div> <!-- kona -->

<!-- google_ad_section_end -->

     		<!--
     		<?php if ('open' == $post->comment_status) { ?>
	     	<?php trackback_rdf(); ?>
				<?php } ?>
	     	-->

<?php if (function_exists('wp_ozh_yourls_url')) { ?>
<h4>Shorter URL</h4>
<p>Want to share or tweet this post? Please use this short URL: <strong><?php wp_ozh_yourls_url(); ?></strong></p>
<?php } ?>


<h4 id="metadata">Metastuff</h4>
<div class="commentsmeta">
<p><small>This entry "<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a>"
was posted on <?php the_time('d/m/Y') ?> at <?php the_time() ?> and is tagged with <?php planetozh_tag_list() ?><br />
<?php if ('open' == $post->comment_status) { ?>
Watch this discussion : Comments <a href="<?php bloginfo_rss('comments_rss2_url'); ?>">RSS 2.0</a>.
<?php } ?>
<?php if ('open' == $post->ping_status) { ?>
You can <a href="<?php trackback_url(display); ?> ">trackback</a> this post from your own site
<?php } ?>
</small></p></div>

		<?php
			comments_template();
		?>

<h4 id="endofcomments">Read more ?</h4> 

		<div class="prevnextleft">
			<div class="previouspage">
			<?php previous_post('&nbsp;&laquo; %&nbsp;', '', 'yes', 'no', 1, ''); ?>
			</div><!-- previousnews -->
		</div><!-- prevnextleft -->
		<div class="prevnextright">
			<div class="nextpage">
			<?php next_post('&nbsp;% &raquo;&nbsp;', '', 'yes', 'no', 1, ''); ?>
			</div><!-- nextnews -->
		</div><!-- prevnextright -->

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
