<aside id="secondary" class="widget-area">

  <!-- About block -->
  <div class="about-block">
    <div class="about-avatar-wrap">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/ozh5.jpg"/>
    </div>
    <span class="about-name">Ozh</span><span class="about-bio"> : WordPress published author,
          maker of <a href="https://yourls.org/">YOURLS</a>, wine enthusiast and a metal head.
          Read <a href="<?php echo esc_url( get_page_link( get_page_by_path( 'about' ) ) ?: home_url( '/about/' ) ); ?>">more about me</a>.
    </span>
  </div>

  <?php if ( is_single() or is_page() ) : ?>
  <div class="widget widget_post_info">
      <h3 class="widget-title">This post</h3>
      <span class="post-info">Written on <?php planetozh_archives_links( false, ' / ' ); ?> (<?php planetozh_date_since(); ?>)</span>
      <?php if (get_the_time('mdy') != get_the_modified_time('mdy')) {
      echo '<span class="post-info">Last updated: ';
          echo get_the_modified_time('Y/m/d');
          echo ' (';
          planetozh_date_since_lastmod();
          echo ")</span>\n";
      }
      ?>
  </div>
  <?php endif; ?>

  <!-- Recent Posts -->
  <div class="widget">
    <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'planetozh' ); ?></h3>
    <?php
    $recent = new WP_Query( [
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ] );
    if ( $recent->have_posts() ) :
    ?>
    <div class="sb-post-list">
      <?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
      <div class="sb-post-item">
        <a href="<?php the_permalink(); ?>" class="sb-post-title"><?php the_title(); ?></a>
        <div class="sb-post-meta">
          <?php
          $tags  = get_the_tags();
          if ( $tags ) {
              usort( $tags, function( $a, $b ) { return $b->count - $a->count; } );
              $tag   = $tags[0];
              $color = planetozh_cat_color_class( $tag->term_id );
              printf(
                  '<a href="%s" class="cat %s" style="font-size:10px;padding:2px 7px">%s</a>',
                  esc_url( get_tag_link( $tag->term_id ) ),
                  esc_attr( $color ),
                  esc_html( $tag->name )
              );
          }
          ?>
          <span><?php echo esc_html( get_the_date( 'Y/m/d' ) ); ?></span>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php endif; ?>
  </div>

  <!-- Topics (tag cloud) -->
  <?php
  $tags = get_tags( [ 'orderby' => 'count', 'order' => 'DESC', 'number' => 30 ] );
  if ( $tags ) :
  ?>
  <div class="widget widget_tag_cloud">
    <h3 class="widget-title"><?php esc_html_e( 'Topics', 'planetozh' ); ?></h3>
    <div class="tagcloud">
      <?php foreach ( $tags as $tag ) :
          $color = planetozh_cat_color_class( $tag->term_id );
      ?>
        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="cat <?php echo esc_attr( $color ); ?>">
          <?php echo esc_html( $tag->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Any registered widgets (optional extra) -->
  <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
  <?php endif; ?>

  <!-- RSS subscribe -->
  <div class="widget">
    <h3 class="widget-title"><?php esc_html_e( 'Subscribe', 'planetozh' ); ?></h3>
    <a href="<?php bloginfo( 'rss2_url' ); ?>" class="rss-subscribe-link">
      <span class="rss-icon-css" aria-hidden="true"></span>
      <?php esc_html_e( 'RSS feed', 'planetozh' ); ?>
    </a>
  </div>

</aside><!-- #secondary -->
