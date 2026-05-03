<?php // Do not delete these lines
	if ('comments-paged.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>
			
			<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
			
			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<h4 id="comments"><?php comments_number('No Comment yet','One Reply','% Blablas' );?></h4> 

<?php if ($comments) : ?>

	<ol class="commentlist">

	<?php $author_said= array("said","wrote","thought","replied","commented"); ?>

	<!-- Comment page numbers -->
	<?php if ($paged_comments->pager->num_pages() > 1): ?>
	<p class="comment-page-numbers">Pages: <?php paged_comments_print_pages(); ?></p>
	<?php endif; ?>
	<!-- End comment page numbers -->

	<?php foreach ($comments as $comment) : ?>

	<?php /* Changes every other comment to a different class */	
			if ('comment_odd' == $oddcomment) $oddcomment = 'comment_even';
			else $oddcomment = 'comment_odd';
			if ($comment->user_id == 1) $oddcomment .= ' comment_ozh';
	?>
	
	<?php
	$grav_default = get_bloginfo('template_directory') . "/images/gravatar_default.gif";
	$grav_size = 40;
	if ($comment->comment_type == "pingback" || $comment->comment_type == "trackback") {
		$grav_url = get_bloginfo('template_directory') . "/images/gravatar_trackback.gif";
	} else {
		$grav_email = strtolower($comment->comment_author_email);
		$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($grav_email)."&amp;default=".urlencode($grav_default)."&amp;size=".$grav_size;
	}
	?>



		<li class="<?php echo $oddcomment ?>" id="comment-<?php comment_ID() ?>">
		<div class="commenthead">
		<div class="gravatar"><a title="<?php comment_author(); ?>">
		<img src="<?php echo get_bloginfo('template_directory') ?>/images/pixel.gif" class="gravatar_img" style="background: url('<?php echo $grav_url; ?>');" alt="<?php comment_author(); ?>" />
		</a></div>
		<div class="commentcounter"><?php echo $comment_number; $comment_number += $comment_delta;?></div>
		<span class="author_link_raquo"><span class="author_link">
		<?php
		if ($comment->comment_type == "pingback" || $comment->comment_type == "trackback") {
			$url    = get_comment_author_url();
			$author = get_comment_author();
			if (strlen($author) > 40) { $author = substr($author, 0, 40) . '...' ;}
			echo "<a href='$url' rel='external'>$author</a>";
		} else {
			comment_author_link();
		}
		?></span>
		<?php if (function_exists('wp_ozh_getCountryName')) { ?>
		<img alt="<?php wp_ozh_getCountryName(1,$comment->comment_author_IP) ?>" src="/images/flags/flag_<?php wp_ozh_getCountryCode(1,$comment->comment_author_IP) ?>.gif" />
		<?php } ?>
		&raquo;
		</span><br />
		<small>
		<?php 
		if ($comment->comment_type == "pingback" || $comment->comment_type == "trackback") {
			echo $comment->comment_type ;
		} else {
			echo $author_said[array_rand($author_said,1)] . ', ';
		}
		?> on <?php comment_date('d/M/y') ?> at <?php comment_time() ?> <a href="<?php echo paged_comments_url('comment-'.get_comment_ID()); ?>" title="permalink for this comment">#</a> <?php edit_comment_link('x','',''); ?></small> :
		</div>

		<?php if ($comment->comment_approved == '0') : ?>
			<strong class="red">(Your comment is awaiting moderation)</strong>
		<?php endif; ?>

		<?php comment_text() ?>
		</li>


	<?php endforeach; /* end for each comment */ ?>


<?php
//	if (planetozh_testpub('sidebar'))
//		planetozh_adsense('300x250', 'sidebar');
?>

<?php /*

<li class="comment_even">
<div class="gravatar">
<img src="<?php echo get_bloginfo('template_directory') ?>/images/pixel.gif" class="gravatar_img" style="background: url('<?php echo $grav_default; ?>');" />
</div>

<script type="text/javascript"><!--
google_ad_client = "pub-3914611346872512";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text";
google_ad_channel ="2656772941";
google_color_border = "91A6D1";
google_color_bg = "91A6D1";
google_color_link = "100884";
google_color_url = "100884";
google_color_text = "303060";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
</li>

<?php */ ?>


	</ol>



<!-- Comment page numbers -->
<?php if ($paged_comments->pager->num_pages() > 1): ?>
<p class="comment-page-numbers"><?php _e("Pages:"); ?> <?php paged_comments_print_pages(); ?></p>
<?php endif; ?>
<!-- End comment page numbers -->

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
  		<p>No comments yet. You could get "First Post!" which would bring you fame, luxury cars and chicks.</p>
	<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>
		
	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<h4 id="respond">Leave a Reply</h4>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
	<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>

<?php else : ?>

	<p><input type="text" name="author" id="author" class="styled" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	<label for="author"><small>Name (required)</small></label></p>

	<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	<label for="email"><small>Mail (required, will not be published, <a href="http://www.gravatar.com/">Gravatar</a> enabled)</small></label></p>

	<p id="p_comment_url"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><small>LEAVE THIS FIELD EMPTY</small></label></p>

<?php endif; ?>

<div id="comment_guidelines"><p><strong>Comment Guidelines or Die</strong></p>
<ul><li><strong>HTML:</strong> You can use these tags: &lt;a href=""&gt; &lt;em&gt; &lt;i&gt; &lt;b&gt; &lt;strong&gt; &lt;blockquote&gt;</li>
	<li><strong>Posting code:</strong> Post <strong>raw</strong> code (no &lt;> &amp;lt; etc) within appropriate tags : [php][/php], [css][/css], [html][/html], [js][/js], [sql][/sql], [xml][/xml], or generic [code][code]</li>
	<!-- <li class="red"><strong>PLUGIN SUPPORT</strong>: No.</li> -->
	<li><strong>Gravatars:</strong> Curious about the little images next to each commenter's name ? Go to <a href="http://www.gravatar.com">Gravatar</a>.</li>
	<li><strong>Spam:</strong> Various spam plugins on patrol. I'll put pins in a Voodoo doll if you spam me.</li>
	<li class="red"><strong>I will mark as Spam</strong> test comments, all comments with SEO names (ie "My Cool Online Shop" instead of "Joe") or containing forum-like signatures.</li>
</ul>
</div>

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></p>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>


</form>


<?php endif; // if you delete this the sky will fall on your head ?>
