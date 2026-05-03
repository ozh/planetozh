<?php
/*
Template Name: TagCloud
*/
?>
<?php get_header(); ?>	

<div id="content" class="single">


<!-- google_ad_section_start -->

<div class="post">

<div class="storytitle">
<span class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></span>
</div> <!-- storytitle -->
<?php edit_post_link("x"); ?>


		<div class="storycontent">

<p>What do I write and blog about? Here is a list of all categories (tags) I've used and filed posts under. Bigger category means more posts, of course. Happy browsing!</p>

<div class="bigcloud">
<?php planetozh_category_cloud(9, 45) ?>
</div>

		
		</div> <!-- storycontent -->

<!-- google_ad_section_end -->

</div> <!-- post -->


</div> <!-- content -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>
