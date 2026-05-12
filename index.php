<?php get_header(); ?>

<div id="page" class="site-content">
  <div id="primary" class="content-area">
    <main id="posts" class="site-main">

      <?php if ( have_posts() ) : ?>

        <div class="section-label">
          <?php
          if ( is_search() ) {
              printf( esc_html__( 'Search results for: %s', 'planetozh' ), get_search_query() );
          } elseif ( is_category() ) {
              single_cat_title();
          } elseif ( is_tag() ) {
              $tag = get_queried_object();
              printf(
                  '%s <span class="archive-count">(%s)</span>',
                  esc_html( $tag->name ),
                  sprintf( _n( '%s post', '%s posts', $tag->count, 'planetozh' ), number_format_i18n( $tag->count ) )
              );
          } elseif ( is_archive() ) {
              the_archive_title();
          } elseif ( is_home() && is_front_page() && ! is_paged() ) {
              esc_html_e( 'Latest posts', 'planetozh' );
          }
          ?>
        </div>

        <?php
        $is_front = is_home() && is_front_page() && ! is_paged();
        $is_first = true;
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content-post', null, [
                    'is_featured' => $is_front && $is_first && !has_tag( 'shorties' ),
            ] );
            $is_first = false;
        endwhile;
        ?>

        <?php
        the_posts_pagination( [
            'mid_size'  => 2,
            'prev_text' => '&larr; ' . __( 'Newer', 'planetozh' ),
            'next_text' => __( 'Older', 'planetozh' ) . ' &rarr;',
        ] );
        ?>

      <?php else : ?>

        <div class="no-results">
          <h2 class="page-title"><?php esc_html_e( 'Nothing here yet.', 'planetozh' ); ?></h2>
          <p><?php esc_html_e( 'It looks like nothing was found.', 'planetozh' ); ?></p>
          <?php get_search_form(); ?>
        </div>

      <?php endif; ?>

    </main><!-- #posts -->
  </div><!-- #primary -->

  <?php get_sidebar(); ?>

</div><!-- #page -->

<?php get_footer(); ?>
