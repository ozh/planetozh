  <!-- ===== FOOTER ===== -->
  <footer id="colophon" class="site-footer">
    <div class="footer-inner">
      <div>
          <div class="footer-name" id="footer-planet">
          <span class="planet-core">
            <span class="planet-word">planet</span>Ozh
            <span class="planet-letters">
              <span class="pl" data-i="0">p</span>
              <span class="pl" data-i="1">l</span>
              <span class="pl" data-i="2">a</span>
              <span class="pl" data-i="3">n</span>
              <span class="pl" data-i="4">e</span>
              <span class="pl" data-i="5">t</span>
            </span>
          </span>
          </div>
          <div class="footer-copy"><span>🄯</span> Ozh 2000 - <?php echo date('Y'); ?>
        </div>
      </div>

      <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'planetozh' ); ?>">

        <?php if ( has_nav_menu( 'footer' ) ) : ?>
          <?php
          wp_nav_menu( [
              'theme_location' => 'footer',
              'container'      => false,
              'depth'          => 1,
              'fallback_cb'    => false,
              'items_wrap'     => '%3$s',
              'walker'         => new Planetozh_Footer_Nav_Walker(),
          ] );
          ?>
        <?php else : ?>
          <a href="<?php echo esc_url( get_page_link( get_page_by_path( 'about' ) ) ?: home_url( '/about/' ) ); ?>">
            <?php esc_html_e( 'About', 'planetozh' ); ?>
          </a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>">
            <?php esc_html_e( 'Archives', 'planetozh' ); ?>
          </a>
          <a href="<?php bloginfo( 'rss2_url' ); ?>">RSS</a>
        <?php endif; ?>

        <?php
        // Social links from user profile - always shown
        $admin = get_user_by( 'email', get_option( 'admin_email' ) );
        if ( $admin ) {
            foreach ( planetozh_social_fields() as $key => $label ) {
                $url = get_user_meta( $admin->ID, $key, true );
                if ( $url ) {
                    echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
                }
            }
        }
        ?>

      </nav>
    </div>
  </footer><!-- #colophon -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
