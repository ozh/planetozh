<section id="hero">
  <div class="hero-inner">

<!--    <div class="hero-kicker">-->
<!--      --><?php //echo esc_html( get_theme_mod( 'hero_kicker', __( 'personal blog', 'planetozh' ) ) ); ?>
<!--    </div>-->

    <h2 class="hero-title">
      <?php echo wp_kses_post( get_theme_mod( 'hero_title', __( 'Things, life and stuff, <em>mostly code.</em>', 'planetozh' ) ) ); ?>
    </h2>

<!--    <p class="hero-desc">-->
<!--      --><?php //echo esc_html( get_theme_mod( 'hero_desc', get_bloginfo( 'description' ) ) ); ?>
<!--    </p>-->

<!--    --><?php
//    $badges_raw = get_theme_mod( 'hero_badges', 'WordPress, PHP, open-source, Linux, web' );
//    $badges     = array_filter( array_map( 'trim', explode( ',', $badges_raw ) ) );
//    if ( $badges ) :
//    ?>
<!--    <div class="hero-badges">-->
<!--      --><?php //foreach ( $badges as $badge ) : ?>
<!--        <span class="hero-badge">--><?php //echo esc_html( $badge ); ?><!--</span>-->
<!--      --><?php //endforeach; ?>
<!--    </div>-->
<!--    --><?php //endif; ?>

      <div class="hero-stamp">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/stamp.png"
               alt="<?php bloginfo('name'); ?>">
      </div>

  </div>
</section>
