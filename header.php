<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="wrapper" class="site">

  <!-- ===== HEADER ===== -->
  <header id="site-header" class="site-header">
    <div class="header-inner">

      <div class="header-stamp">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/stamp.png"
             alt="<?php bloginfo('name'); ?>"
             width="48" height="48">
      </div>

      <div class="site-name">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <?php bloginfo( 'name' ); ?>
        </a><span class="motto"><em> &dash; </em>a virtual <span class="hilite">.postcard</span> from <span class="hilite">$me</span> to <span class="hilite">myself();</span></span>
      </div>

      <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'planetozh' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'fallback_cb'    => 'planetozh_fallback_menu',
        ] );
        ?>
      </nav>

      <button id="theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark/light mode', 'planetozh' ); ?>">
        <span id="theme-icon" aria-hidden="true">🌙</span>
      </button>

    </div>
  </header><!-- #site-header -->

  <?php
  // Hero section on front page only
  if ( is_front_page() && ! is_paged() ) :
      get_template_part( 'template-parts/hero' );
  endif;
  ?>
