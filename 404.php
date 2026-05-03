<?php get_header(); ?>

<div id="page" class="site-content">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">

      <section class="no-results not-found">
        <h1 class="page-title"><?php esc_html_e( '404 — Not Found', 'planetozh' ); ?></h1>
        <p><?php esc_html_e( 'This page doesn\'t exist. Maybe it moved, maybe it never existed.', 'planetozh' ); ?></p>
        <?php get_search_form(); ?>
      </section>

    </main>
  </div>

  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

