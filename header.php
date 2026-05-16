<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php
// Open Graph & Twitter Card meta tags
$og_title       = is_singular() ? get_the_title() : get_bloginfo( 'name' );
$og_description = is_singular() ? get_the_excerpt() : get_bloginfo( 'description' );
$og_url         = is_singular() ? get_permalink() : home_url( '/' );
$og_site_name   = get_bloginfo( 'name' );
$og_image       = get_template_directory_uri() . '/assets/img/og-ozh.jpg';

// Use post thumbnail if available
if ( is_singular() && has_post_thumbnail() ) {
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
    if ( $thumb ) {
        $og_image = $thumb[0];
    }
}

// Clean description
$og_description = wp_strip_all_tags( $og_description );
$og_description = mb_substr( $og_description, 0, 200 );
?>
<meta name="fediverse:creator"   content="@ozh@fosstodon.org">
<meta property="og:type"         content="<?php echo is_singular() ? 'article' : 'website'; ?>">
<meta property="og:site_name"    content="<?php echo esc_attr( $og_site_name ); ?>">
<meta property="og:title"        content="<?php echo esc_attr( $og_title ); ?>">
<meta property="og:description"  content="<?php echo esc_attr( $og_description ); ?>">
<meta property="og:url"          content="<?php echo esc_url( $og_url ); ?>">
<meta property="og:image"        content="<?php echo esc_url( $og_image ); ?>">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"       content="<?php echo esc_attr( get_locale() ); ?>">
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="<?php echo esc_attr( $og_title ); ?>">
<meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>">
<meta name="twitter:image"       content="<?php echo esc_url( $og_image ); ?>">
<?php if ( is_singular() ) : ?>
    <meta property="article:published_time" content="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
    <meta property="article:modified_time"  content="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>">
<?php endif; ?>
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
