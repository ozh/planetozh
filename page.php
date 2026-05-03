<?php get_header(); ?>

<div id="page" class="site-content">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="single-post-header">
          <h1 class="single-post-title"><?php the_title(); ?></h1>
          <?php if ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
            <div class="single-post-meta">
              <span class="edit-post-link">
                <a href="<?php echo esc_url( get_edit_post_link() ); ?>">
                  <?php esc_html_e( 'Edit this page', 'planetozh' ); ?>
                </a>
              </span>
            </div>
          <?php endif; ?>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
          <div class="single-post-thumbnail">
            <?php the_post_thumbnail( 'full' ); ?>
          </div>
        <?php endif; ?>

        <div class="entry-content">
          <?php the_content(); ?>
        </div>

      </article>

      <?php if ( comments_open() || get_comments_number() ) : ?>
        <?php comments_template(); ?>
      <?php endif; ?>

    <?php endwhile; ?>

    </main>
  </div>

  <?php get_sidebar(); ?>

</div><!-- #page -->

<?php get_footer(); ?>

