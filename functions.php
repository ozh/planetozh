<?php
/**
 * planetOzh theme functions and definitions.
 */

/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * @return void
 */
function planetozh_setup(): void {
    load_theme_textdomain( 'planetozh', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
            'search-form', 'comment-form', 'comment-list',
            'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );

    register_nav_menus( [
            'primary' => __( 'Primary Menu', 'planetozh' ),
            'footer'  => __( 'Footer Menu', 'planetozh' ),
    ] );

    add_image_size( 'planetozh-featured', 800, 420, true );
    add_image_size( 'planetozh-thumbnail', 400, 260, true );
}
add_action( 'after_setup_theme', 'planetozh_setup' );

/**
 * Enqueue theme stylesheets and scripts.
 * Loads Google Fonts, main stylesheet, dark-mode toggle JS,
 * and comment-reply script on singular posts with open comments.
 *
 * @return void
 */
function planetozh_scripts(): void {
    wp_enqueue_style(
            'planetozh-fonts',
            'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,700;1,9..144,400;1,9..144,700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=JetBrains+Mono:wght@400&display=swap',
            [],
            null
    );

    wp_enqueue_style(
            'planetozh-style',
            get_stylesheet_uri(),
            [ 'planetozh-fonts' ],
            wp_get_theme()->get( 'Version' )
    );

    wp_enqueue_script(
            'planetozh-theme-toggle',
            get_template_directory_uri() . '/assets/js/theme-toggle.js',
            [],
            wp_get_theme()->get( 'Version' ),
            true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'planetozh_scripts' );

/**
 * Register theme widget areas (main sidebar and footer area).
 *
 * @return void
 */
function planetozh_widgets_init(): void {
    register_sidebar( [
            'name'          => __( 'Main Sidebar', 'planetozh' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Main sidebar widgets.', 'planetozh' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
    ] );

    register_sidebar( [
            'name'          => __( 'Footer Area', 'planetozh' ),
            'id'            => 'footer-1',
            'description'   => __( 'Footer widget area.', 'planetozh' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
    ] );
}
add_action( 'widgets_init', 'planetozh_widgets_init' );

/**
 * Estimate reading time for a post based on word count (200 wpm).
 *
 * @param  int|null $post_id  Post ID, or null for current post in the loop.
 * @return string             Localized string, e.g. "4 min read".
 */
function planetozh_reading_time( $post_id = null ): string {
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    $minutes = max( 1, (int) ceil( $words / 200 ) );
    return sprintf( _n( '%d min read', '%d min read', $minutes, 'planetozh' ), $minutes );
}

/**
 * Return a CSS class name cycling through 6 color variants based on term ID.
 * Used to assign consistent badge colors to tags and categories.
 *
 * @param  int    $cat_id  Term ID.
 * @return string          CSS class, e.g. "cat-color-3".
 */
function planetozh_cat_color_class( $cat_id ): string {
    return 'cat-color-' . ( ( ( (int) $cat_id - 1 ) % 6 ) + 1 );
}

/**
 * Override default excerpt word count.
 *
 * @return int  Number of words.
 */
function planetozh_excerpt_length(): int {
    return 60;
}
add_filter( 'excerpt_length', 'planetozh_excerpt_length' );

/**
 * Override the default excerpt trailing string.
 *
 * @return string  Ellipsis character appended to trimmed excerpts.
 */
function planetozh_excerpt_more(): string {
    return '…';
}
add_filter( 'excerpt_more', 'planetozh_excerpt_more' );

/**
 * Filter body classes. Currently a passthrough; extend to add custom classes.
 *
 * @param  string[] $classes  Existing body classes.
 * @return string[]           Filtered body classes.
 */
function planetozh_body_classes( $classes ) {
    return $classes;
}
add_filter( 'body_class', 'planetozh_body_classes' );

/**
 * Register theme settings in the WordPress Customizer.
 * Adds sections for Hero, Sidebar About block, and Footer.
 *
 * @param  WP_Customize_Manager $wp_customize  Customizer manager instance.
 * @return void
 */
function planetozh_customize_register( $wp_customize ): void {
    $wp_customize->add_section( 'planetozh_hero', [
            'title'    => __( 'Hero Section', 'planetozh' ),
            'priority' => 30,
    ] );

    $wp_customize->add_setting( 'hero_kicker', [
            'default'           => __( 'personal blog', 'planetozh' ),
            'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'hero_kicker', [
            'label'   => __( 'Kicker text', 'planetozh' ),
            'section' => 'planetozh_hero',
            'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'hero_title', [
            'default'           => __( 'Things I think about, <em>mostly code.</em>', 'planetozh' ),
            'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'hero_title', [
            'label'   => __( 'Hero title (HTML allowed)', 'planetozh' ),
            'section' => 'planetozh_hero',
            'type'    => 'textarea',
    ] );

    $wp_customize->add_setting( 'hero_desc', [
            'default'           => __( 'WordPress, open-source, PHP, web things — and occasionally the rest.', 'planetozh' ),
            'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'hero_desc', [
            'label'   => __( 'Hero description', 'planetozh' ),
            'section' => 'planetozh_hero',
            'type'    => 'textarea',
    ] );

    $wp_customize->add_setting( 'hero_badges', [
            'default'           => 'WordPress, PHP, open-source, Linux, web',
            'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'hero_badges', [
            'label'   => __( 'Badges (comma-separated)', 'planetozh' ),
            'section' => 'planetozh_hero',
            'type'    => 'text',
    ] );

    $wp_customize->add_section( 'planetozh_about', [
            'title'    => __( 'Sidebar About Block', 'planetozh' ),
            'priority' => 35,
    ] );

    $wp_customize->add_setting( 'about_name', [
            'default'           => get_bloginfo( 'name' ),
            'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'about_name', [
            'label'   => __( 'Display name', 'planetozh' ),
            'section' => 'planetozh_about',
            'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'about_bio', [
            'default'           => __( 'Developer, open-source contributor, occasional writer. Making things on the web since 1996.', 'planetozh' ),
            'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'about_bio', [
            'label'   => __( 'Short bio', 'planetozh' ),
            'section' => 'planetozh_about',
            'type'    => 'textarea',
    ] );

    $wp_customize->add_section( 'planetozh_footer', [
            'title'    => __( 'Footer', 'planetozh' ),
            'priority' => 40,
    ] );

    $wp_customize->add_setting( 'footer_copyright', [
            'default'           => '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. Things &amp; stuff.',
            'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'footer_copyright', [
            'label'   => __( 'Copyright text', 'planetozh' ),
            'section' => 'planetozh_footer',
            'type'    => 'textarea',
    ] );
}
add_action( 'customize_register', 'planetozh_customize_register' );

/**
 * Define the list of extra social-link fields for the user profile.
 * Add or remove entries here; profile form, save logic, and footer
 * links all derive from this single source of truth.
 *
 * @return array<string, string>  Map of meta_key => display label.
 */
function planetozh_social_fields(): array {
    return [
            'github_url'     => '@ozh@Github',
            'mastodon_url'   => '@ozh@Mastodon',
            'twitter_url'    => 'Twitter / X',
            'linkedin_url'   => 'LinkedIn',
            'wp_profile_url' => 'wp.org profile',
            'website_url'    => 'ozh.org',
    ];
}

/**
 * Render extra social-link fields on the user profile edit screen.
 *
 * @param  WP_User $user  The user object being edited.
 * @return void
 */
function planetozh_extra_profile_fields( $user ): void {
    ?>
    <h3><?php esc_html_e( 'Social Links', 'planetozh' ); ?></h3>
    <table class="form-table">
        <?php foreach ( planetozh_social_fields() as $key => $label ) : ?>
            <tr>
                <th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
                <td><input type="url" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>"
                           value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>"
                           class="regular-text"></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}
add_action( 'show_user_profile', 'planetozh_extra_profile_fields' );
add_action( 'edit_user_profile', 'planetozh_extra_profile_fields' );

/**
 * Save extra social-link fields when the user profile is updated.
 *
 * @param  int $user_id  ID of the user being saved.
 * @return void
 */
function planetozh_save_extra_profile_fields( $user_id ): void {
    if ( ! current_user_can( 'edit_user', $user_id ) ) return;
    foreach ( array_keys( planetozh_social_fields() ) as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_user_meta( $user_id, $key, esc_url_raw( $_POST[ $key ] ) );
        }
    }
}
add_action( 'personal_options_update', 'planetozh_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'planetozh_save_extra_profile_fields' );

/**
 * Output the primary tag badge for a post as a colored pill link.
 * "Primary" is defined as the tag with the highest post count.
 *
 * @param  int|null $post_id  Post ID, or null for current post in the loop.
 * @return void
 */
function planetozh_post_primary_tag( $post_id = null ): void {
    $tags = get_the_tags( $post_id );
    if ( empty( $tags ) ) {
        return;
    }
    usort( $tags, function( $a, $b ) {
        return $b->count - $a->count;
    } );
    $tag   = $tags[0];
    $color = planetozh_cat_color_class( $tag->term_id );
    printf(
            '<a href="%s" class="cat %s">%s</a>',
            esc_url( get_tag_link( $tag->term_id ) ),
            esc_attr( $color ),
            esc_html( $tag->name )
    );
}

/**
 * Output all tags for a post as pill links wrapped in .post-tags.
 *
 * @param  int|null $post_id  Post ID, or null for current post in the loop.
 * @return void
 */
function planetozh_post_tags( $post_id = null ): void {
    $tags = get_the_tags( $post_id );
    if ( empty( $tags ) ) {
        return;
    }
    echo '<div class="post-tags">';
    foreach ( $tags as $tag ) {
        printf(
                '<a href="%s" class="tag">%s</a>',
                esc_url( get_tag_link( $tag->term_id ) ),
                esc_html( $tag->name )
        );
    }
    echo '</div>';
}

/**
 * Output linked year/month/day archive breadcrumb for a post.
 *
 * @param  bool   $short_month  Use numeric month (true) or full name (false). Default true.
 * @param  string $sep          Separator between date parts. Default '/'.
 * @param  bool   $echo         Echo output (true) or return it (false). Default true.
 * @param  bool   $lastmod      Use last-modified date instead of publish date. Default false.
 * @return string|void          HTML string if $echo is false, void otherwise.
 */
function planetozh_archives_links( $short_month = true, $sep = '/', $echo = true, $lastmod = false ) {
    $func      = $lastmod ? 'get_the_modified_time' : 'get_the_time';
    $year      = call_user_func( $func, 'Y' );
    $year_link = get_year_link( $year );
    $month     = $short_month ? call_user_func( $func, 'm' ) : call_user_func( $func, 'F' );
    $month_num = call_user_func( $func, 'm' );
    $month_link = get_month_link( $year, $month_num );
    $day       = call_user_func( $func, 'd' );
    $day_link  = get_day_link( $year, $month_num, $day );

    $output = "<a href='$year_link'>$year</a>$sep<a href='$month_link'>$month</a>$sep<a href='$day_link'>$day</a>";

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
}

/**
 * Output a human-readable "time since publish" string, e.g. "2 years and 3 days ago".
 *
 * @param  string $before   String prepended to the output. Default ''.
 * @param  string $after    String appended to the output. Default ''.
 * @param  bool   $echo     Echo output (true) or return it (false). Default true.
 * @param  bool   $lastmod  Use last-modified date instead of publish date. Default false.
 * @return string|void      Formatted age string if $echo is false, void otherwise.
 */
function planetozh_date_since( $before = '', $after = '', $echo = 1, $lastmod = false ) {
    $func = $lastmod ? 'get_the_modified_time' : 'get_the_time';
    $days = (int) ( ( strtotime( date( 'Y-m-d' ) ) - strtotime( call_user_func( $func, 'Y-m-d' ) ) ) / 86400 );

    if ( $days === 0 ) {
        $output = 'today';
    } elseif ( $days === 1 ) {
        $output = 'yesterday';
    } else {
        $diff   = abs( time() - strtotime( call_user_func( $func, 'Y-m-d' ) ) );
        $years  = intval( $diff / ( 60 * 60 * 24 * 365 ) );
        $diff  -= $years * 60 * 60 * 24 * 365;
        $months = intval( $diff / ( 60 * 60 * 24 * 30 ) );
        $diff  -= $months * 60 * 60 * 24 * 30;
        $weeks  = intval( $diff / ( 60 * 60 * 24 * 7 ) );
        $diff  -= $weeks * 60 * 60 * 24 * 7;
        $days   = intval( $diff / ( 60 * 60 * 24 ) );

        $output  = '';
        $output .= $years  > 0 ? ( $years  === 1 ? '1 year '   : "$years years "   ) : '';
        $output .= ( $years > 0 && $months > 0 ) ? ', ' : '';
        $output .= $months > 0 ? ( $months === 1 ? '1 month '  : "$months months " ) : '';
        $output .= $days   > 0 ? ( $days   === 1 ? 'and 1 day ' : "and $days days " ) : '';
        $output  = trim( $output . ' ago ', 'and ' );
    }

    $output = $before . $output . $after;

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
}

/**
 * Convenience wrapper for planetozh_date_since() using last-modified date.
 *
 * @param  string $before  String prepended to the output. Default ''.
 * @param  string $after   String appended to the output. Default ''.
 * @param  bool   $echo    Echo output (true) or return it (false). Default true.
 * @return string|void     Formatted age string if $echo is false, void otherwise.
 */
function planetozh_date_since_lastmod( $before = '', $after = '', $echo = 1 ) {
    return planetozh_date_since( $before, $after, $echo, true );
}

/**
 * Walker that renders a flat list of <a> links for the footer nav menu,
 * bypassing WordPress's default <ul><li> structure.
 */
class Planetozh_Footer_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $output .= sprintf(
                '<a href="%s">%s</a>',
                esc_url( $data_object->url ),
                esc_html( $data_object->title )
        );
    }
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}
