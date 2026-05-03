<?php
/**
 * Template part for displaying a single post card.
 * Handles both regular posts and shorties.
 * $args['is_featured'] (bool) - whether to apply is-featured class
 */
$is_featured = ! empty( $args['is_featured'] );
$is_shortie  = has_tag( 'shorties' );
$extra_class = $is_featured ? 'is-featured' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card ' . $extra_class . ( $is_shortie ? ' post-shortie' : '' ) ); ?>>

    <?php if ( $is_shortie ) : ?>

        <div class="post-content shortie-content">
            <?php the_content(); ?>
            <span class="shortie-meta">
                <a href="<?php the_permalink(); ?>"
                   class="shortie-permalink"
                   title="<?php esc_attr(the_title()); ?>">
                    <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                        <?php echo esc_html( get_the_date( 'Y/m/d G\hi' ) ); ?>
                    </time>
                #</a>
            </span>
        </div>

    <?php else : ?>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( $is_featured ? 'planetozh-featured' : 'planetozh-thumbnail' ); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="post-meta-top">
            <?php planetozh_post_primary_tag(); ?>
            <span class="post-dot" aria-hidden="true"></span>
            <span class="post-date">
        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
          <?php echo esc_html( get_the_date() ); ?>
        </time>
      </span>
            <span class="post-dot" aria-hidden="true"></span>
            <span class="post-rtime"><?php echo esc_html( planetozh_reading_time() ); ?></span>
        </div>

        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="post-excerpt">
            <?php the_excerpt(); ?>
        </div>

        <div class="post-footer-bar">
            <?php planetozh_post_tags(); ?>
            <a href="<?php the_permalink(); ?>" class="read-more">
                <?php esc_html_e( 'Read more', 'planetozh' ); ?>
            </a>
        </div>

    <?php endif; ?>

</article>
