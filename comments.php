<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

  <?php if ( have_comments() ) : ?>

    <h2 class="comments-title">
      <?php
      $count = get_comments_number();
      printf(
          /* translators: %d = number of comments */
          esc_html( _n( '%d comment', '%d comments', $count, 'planetozh' ) ),
          number_format_i18n( $count )
      );
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments( [
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 40,
          'callback'    => 'planetozh_comment',
      ] );
      ?>
    </ol>

    <?php the_comments_pagination( [
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ] ); ?>

  <?php endif; ?>

  <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'planetozh' ); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- #comments -->

<?php
/**
 * Custom comment template callback.
 */
function planetozh_comment( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
      <div class="comment-meta">
        <div class="comment-avatar">
          <?php echo get_avatar( $comment, 36 ); ?>
        </div>
        <span class="comment-author-name"><?php comment_author(); ?></span>
        <span class="comment-date">
          <time datetime="<?php comment_date( DATE_W3C ); ?>">
            <?php comment_date(); ?>
          </time>
        </span>
        <?php edit_comment_link( __( 'Edit', 'planetozh' ), '<span class="edit-link">', '</span>' ); ?>
      </div>

      <div class="comment-content">
        <?php if ( '0' === $comment->comment_approved ) : ?>
          <p class="comment-awaiting"><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'planetozh' ); ?></em></p>
        <?php endif; ?>
        <?php comment_text(); ?>
      </div>

      <?php
      comment_reply_link( array_merge( $args, [
          'add_below' => 'comment',
          'depth'     => $depth,
          'max_depth' => $args['max_depth'],
          'before'    => '<div class="reply">',
          'after'     => '</div>',
      ] ) );
      ?>
    </li>
    <?php
}

