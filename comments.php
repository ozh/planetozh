<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$cookiehash] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php
				return;
            }
        }
?>

<!-- You can start editing here. -->

<h4 id="comments"><?php comments_number('No Comment yet','One Reply','% Blablas' );?></h4>

<?php

if ( have_comments() ) : ?>
<ol class="commentlist">
	<?php wp_list_comments(); ?></ol>
<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) :
		// If comments are open, but there are no comments.
	else : // comments are closed
	endif;
endif;

?>



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

	<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><small>Website (optional, but l33t)</small></label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></p>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>

<p><small>
<?php //wp_ozh_automoderate_status() ?>
<strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?><br />
<strong>Gravatars:</strong> Curious about the little images next to each commenter's name ? Go to <a href="http://www.gravatar.com">Gravatar</a> and sign for a free account<br />
<strong>Spam:</strong> Various spam plugins may be activated. I'll put pins in a Voodoo doll if you spam me.</small></p>



</form>

<h2 id="endofcomments"> </h2> 


<?php endif; // if you delete this the sky will fall on your head ?>
