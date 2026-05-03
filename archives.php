<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>	

<div id="content" class="single">


<!-- google_ad_section_start -->

<div class="post">

<div class="storytitle">
<span class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link : <?php the_title_rss() ?>"><?php the_title(); ?></a></span>
</div> <!-- storytitle -->
	<div class="meta">
<?php
$total = wp_ozh_postviews();
echo "<span>Viewed: $total times</span>";
?>
<?php edit_post_link("x"); ?>
</div> <!-- meta -->


		<div class="storycontent">


<p>Caution, lengthy list ahead ! You'll find here everything I've written on this site. I need to think a bit about some clever and prettier way to present this, but for now here it is.</p>

<h2>All Pages :</h2>
<ul>
	<?php wp_list_pages('title_li='); ?>
</ul>


<h2>All blog posts :</h2>
<ul>
	<?php $archive_query = new WP_Query('showposts=9999');
		while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a> <strong><?php comments_number('0', '1', '%'); ?></strong></li>
	<?php endwhile; ?>
</ul>


		</div> <!-- storycontent -->

<!-- google_ad_section_end -->

</div> <!-- post -->


</div> <!-- content -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>
