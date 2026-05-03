<?php get_header(); ?>	

<div id="content" class="index">

<?php if(function_exists('tgInTranslatedPage') && (tgInTranslatedPage())) { ?>
<p id="plznote_translated">Please note: This page is an <strong>automated</strong> translation, originally written in English. <em>Errare Babelfishum Est.</em></p>
<?php } ?>

<!-- google_ad_section_start -->

<?php if (have_posts()) { ?>
<?php while ( have_posts() ) : the_post() ?>

<?php if (planetozh_is_asides()) { ?>
	<div class="aside">
	<span class="aside_body">
	<?php
	if (function_exists('wp_ozh_click_modifyhrefs')) {
		echo wp_ozh_click_modifyhrefs(wptexturize($post->post_content));
	} else {
		echo wptexturize($post->post_content);
	}
	?>
	</span>
	<span class="aside_end"><?php echo ' '; comments_popup_link('(0)', '(1)', '(%)')?><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><strong> &laquo;</strong></a> <?php edit_post_link('x'); ?></span>
	</div>
<?php } else { ?>
	<div class="post">
	<div class="storytitle">
	<h1 class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"
	title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></h1>
	</div> <!-- storytitle -->
	<div class="meta">
	<span class="feedback"><?php comments_popup_link('0 blabla', '1 blabla', '% blablas'); ?></span>
	<span class="filedin">In: <?php planetozh_tag_list(); ?></span>
	<span class="days_since">On: <?php planetozh_archives_links(true,' / '); ?></span>
	<?php if (function_exists('wp_ozh_yourls_url')) { ?>
        	<span class="short_url">Short URL: <?php wp_ozh_yourls_url(); ?></span>
        <?php } ?>

	<?php edit_post_link("<strong>x</strong>"); ?>
	</div> <!-- meta -->
	
	<div class="storycontent">
	<div class="KonaBody">
	<?php the_content("<span class=\"readmore\">Read More</span>"); ?>
	<?php link_pages('<span class="npage">Page: ', '</span>', 'number', '', '', '#%'); ?>
	</div> <!-- kona -->
	</div> <!-- storycontent -->
	<!--
	<?php if ('open' == $post->comment_status) { ?>
 	<?php trackback_rdf(); ?>
	<?php } ?>
	-->
	</div> <!-- post -->
<?php } // end if in category "shorties" ?>

<?php endwhile ?>
<?php } else { ?>

        <div class="post">
        <div class="storytitle">
        <h1 class="title">No post !</h1>
        </div> <!-- storytitle -->

        <div class="storycontent">
        <div class="KonaBody">
	<p>Sorry, no post were found.</p>
        </div> <!-- kona -->
        </div> <!-- storycontent -->
        </div> <!-- post -->

<?php } ?>
<div class="prevnextleft">
<div class="previouspage">
<?php posts_nav_link("</div>\n</div>\n<div class=\"prevnextright\">\n<div class=\"nextpage\">\n", '&nbsp;&laquo; Previous page&nbsp;', '&nbsp;Next page &raquo;&nbsp;'); ?>
</div>
</div>

</div> <!-- content -->

<!-- google_ad_section_end -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>	
