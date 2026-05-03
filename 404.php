<?php get_header(); ?>	

<div id="content">

<div class="post">
<h1>Ooopsy ! Page not found :/</h1>
	<div id="erreur404"></div>
	<p>Unfortunately, the fine content you were expecting has been moved to /dev/null or something similar. I feel very embarrassed and ashamed now. I swear. So, what to do now ?</p>

	<h2>Search</h2>
	<p>I suggest that you try this Search form, it will probably give you what you were expecting. Sorry about the inconvenience.</p>
	<form method="get" action="<?php echo get_option('siteurl'); ?>/index.php">
	<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" /><input type="submit" name="Submit" value="&raquo;" />
	</form>

	<h2>Check my "Projects"</h2>
	<p> Most of my interesting stuffs reside in my Projects "portfolio", you really should visit this corner of my site. Great stuff are waiting for you, there. I promise.</p>

	<h2>Browse the archives</h2>
	<p>Well, you're here now, so why not hang around a little bit ? On the Archives page, you will see every stuff I wrote in a glance.</p>

	<h2>Go back to the root</h2>
	<p>You can also randomly browse from the main page and discover a bit more about this site and, why not, eventually like it. 

	<h2>Contact</h2>
	<p>If you have the feeling that what you were looking for <strong>had</strong> had to be here, you can always give my Contact form a chance. The ability to find my contact form will be an ultimate test to check whether you're really motivated about complaining or not :P</p>


</div>

</div> <!-- content -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>	


