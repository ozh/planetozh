<?php get_header(); ?>

<div id="page" class="site-content">
  <div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- Post header -->
        <header class="single-post-header">

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

          <h1 class="single-post-title"><?php the_title(); ?></h1>

          <div class="single-post-meta">
            <?php
            printf(
                esc_html__( 'By %s', 'planetozh' ),
                '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
            );
            ?>
            <?php if ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
              <span class="edit-post-link">
                <a href="<?php echo esc_url( get_edit_post_link() ); ?>">
                  <?php esc_html_e( 'Edit this post', 'planetozh' ); ?>
                </a>
              </span>
            <?php endif; ?>
          </div>

        </header><!-- .single-post-header -->

        <?php if ( has_post_thumbnail() ) : ?>
          <div class="single-post-thumbnail">
            <?php the_post_thumbnail( 'full' ); ?>
          </div>
        <?php endif; ?>

        <!-- Post content -->
        <div class="entry-content">
          <?php the_content(); ?>
          <?php
          wp_link_pages( [
              'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'planetozh' ),
              'after'  => '</div>',
          ] );
          ?>
        </div><!-- .entry-content -->

        <!-- Post footer -->
        <footer class="single-post-footer">

          <!-- Tags -->
          <div class="single-post-tags">
            <?php planetozh_post_tags(); ?>
          </div>

          <!-- Post navigation -->
          <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'planetozh' ); ?>">
            <div class="nav-previous">
              <?php
              $prev = get_previous_post();
              if ( $prev ) :
                  echo '<span class="post-nav-label">' . esc_html__( '← Previous', 'planetozh' ) . '</span>';
                  echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" class="post-nav-title">' . esc_html( get_the_title( $prev ) ) . '</a>';
              endif;
              ?>
            </div>
            <div class="nav-next">
              <?php
              $next = get_next_post();
              if ( $next ) :
                  echo '<span class="post-nav-label">' . esc_html__( 'Next →', 'planetozh' ) . '</span>';
                  echo '<a href="' . esc_url( get_permalink( $next ) ) . '" class="post-nav-title">' . esc_html( get_the_title( $next ) ) . '</a>';
              endif;
              ?>
            </div>
          </nav>

        </footer><!-- .single-post-footer -->

      </article>

      <?php comments_template(); ?>

    <?php endwhile; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

  <?php get_sidebar(); ?>

</div><!-- #page -->

<?php get_footer(); ?>
