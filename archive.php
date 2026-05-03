<?php get_header(); ?>	

<div id="content" class="index">
<!-- google_ad_section_start -->

<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="title">Archive for the '<?php echo single_cat_title(); ?>' Category</h1>

	<?php /* If this is a daily archive */ } elseif (is_tag()) { ?>
	<h1 zclass="title">Archive for the "<?php single_tag_title(); ?>" Tag</h1>

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1 zclass="title">Archive for <?php the_time('F jS, Y'); ?></h1>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="title">Archive for <?php the_time('F, Y'); ?></h1>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1 class="title">Archive for <?php the_time('Y'); ?></h1>

	<?php /* If this is a search */ } elseif (is_search()) { ?>
	<h1 class="title">Search Results</h1>

	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1 class="pagetitle">Author Archive</h1>

	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="pagetitle">Blog Archives</h1>

	<?php } ?>




<?php while ( have_posts() ) : the_post() ?>

	<div class="post">
	<div class="storytitle">
	<h2 class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></h2>
	</div> <!-- storytitle -->
	<div class="meta">
	<span class="filedin">Filed in: <?php planetozh_tag_list(", ") ?></span><br/>
	<span class="days_since">Posted On: <?php planetozh_archives_links(true,' / '); ?></span><br/>
	<span class="feedback"><?php comments_popup_link('0 blabla', '1 blabla', '% blablas'); ?></span> 
	<?php edit_post_link("<strong>x</strong>"); ?>
	</div> <!-- meta -->

	<div class="storycontent"><p>
	<?php
	$ex = get_the_excerpt();
	if (strpos($ex,'[...]') === false) $ex.='[...]';
	echo $ex;
	?>
	&rarr; <strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>">Read more</a></strong></p>
	</div>

	
<?php /*
	<div class="storycontent">
	<?php the_content("<span class=\"readmore\">Read More (".planetozh_countwords_inpost().")</span>"); ?>
	<?php link_pages('<span class="npage">Page: ', '</span>', 'number', '', '', '#%'); ?>
	</div> <!-- storycontent -->
	<!--
	<?php if ('open' == $post->comment_status) { ?>
 	<?php trackback_rdf(); ?>
	<?php } ?>
	-->
*/ ?>

	</div> <!-- post -->


<?php endwhile ?>

<div class="prevnextleft">
<div class="previouspage">
<?php posts_nav_link("</div>\n</div>\n<div class=\"prevnextright\">\n<div class=\"nextpage\">\n", '&nbsp;&laquo; Previous page&nbsp;', '&nbsp;Next page &raquo;&nbsp;'); ?>
</div>
</div>


	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php //include (get_template_directory() . '/searchform.php'); ?>

	<?php endif; ?>


</div> <!-- content -->

<!-- google_ad_section_end -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>	
