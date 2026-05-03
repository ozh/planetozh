<?php get_header(); ?>

<div id="page" class="site-content">
  <div id="primary" class="content-area">
    <main id="posts" class="site-main">

      <div class="section-label">
        <?php printf( esc_html__( 'Search results for: %s', 'planetozh' ), '<span>' . get_search_query() . '</span>' ); ?>
      </div>

      <?php if ( have_posts() ) : ?>

        <?php
          while ( have_posts() ) :
              the_post();
              get_template_part( 'template-parts/content-post' );
          endwhile;
        ?>

        <div class="pagination">
          <?php the_posts_pagination( [
              'prev_text' => '&larr; ' . __( 'Previous', 'planetozh' ),
              'next_text' => __( 'Next', 'planetozh' ) . ' &rarr;',
          ] ); ?>
        </div>

      <?php else : ?>
        <p><?php esc_html_e( 'No results found.', 'planetozh' ); ?></p>
        <?php get_search_form(); ?>
      <?php endif; ?>

    </main>
  </div>

  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
