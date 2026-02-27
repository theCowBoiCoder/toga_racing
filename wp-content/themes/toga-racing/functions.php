<?php
/**
 * TOGA Racing Theme Functions
 *
 * @package TOGA_Racing
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TOGA_RACING_VERSION', '1.0.0' );
define( 'TOGA_RACING_DIR', get_template_directory() );
define( 'TOGA_RACING_URI', get_template_directory_uri() );

/**
 * Theme setup
 */
function toga_racing_setup() {
    // Add title tag support
    add_theme_support( 'title-tag' );

    // Enable featured images
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'driver-card', 400, 500, true );
    add_image_size( 'driver-profile', 600, 750, true );
    add_image_size( 'gallery-thumb', 400, 300, true );
    add_image_size( 'hero-banner', 1920, 800, true );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary'   => esc_html__( 'Primary Menu', 'toga-racing' ),
        'footer'    => esc_html__( 'Footer Menu', 'toga-racing' ),
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for block styles
    add_theme_support( 'wp-block-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'toga_racing_setup' );

/**
 * Enqueue styles and scripts
 */
function toga_racing_scripts() {
    // Google Fonts - Inter
    wp_enqueue_style(
        'toga-racing-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Orbitron:wght@400;500;600;700;800;900&display=swap',
        array(),
        null
    );

    // Main theme stylesheet
    wp_enqueue_style(
        'toga-racing-style',
        TOGA_RACING_URI . '/assets/css/toga-racing.css',
        array( 'toga-racing-fonts' ),
        TOGA_RACING_VERSION
    );

    // WordPress default stylesheet (for theme header)
    wp_enqueue_style(
        'toga-racing-base',
        get_stylesheet_uri(),
        array( 'toga-racing-style' ),
        TOGA_RACING_VERSION
    );

    // Main theme script
    wp_enqueue_script(
        'toga-racing-script',
        TOGA_RACING_URI . '/assets/js/toga-racing.js',
        array(),
        TOGA_RACING_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script( 'toga-racing-script', 'togaRacing', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'siteUrl' => home_url(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'toga_racing_scripts' );

/**
 * Register widget areas
 */
function toga_racing_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'toga-racing' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'toga-racing' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widgets', 'toga-racing' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area.', 'toga-racing' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'toga_racing_widgets_init' );

/**
 * Include additional files
 */
require TOGA_RACING_DIR . '/inc/custom-post-types.php';
require TOGA_RACING_DIR . '/inc/customizer.php';
require TOGA_RACING_DIR . '/inc/template-tags.php';

/**
 * Custom excerpt length
 */
function toga_racing_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'toga_racing_excerpt_length' );

/**
 * Custom excerpt more text
 */
function toga_racing_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'toga_racing_excerpt_more' );

/**
 * Add custom body classes
 */
function toga_racing_body_classes( $classes ) {
    $classes[] = 'toga-racing-theme';

    if ( is_singular() ) {
        $classes[] = 'toga-singular';
    }

    if ( is_front_page() ) {
        $classes[] = 'toga-front-page';
    }

    return $classes;
}
add_filter( 'body_class', 'toga_racing_body_classes' );

/**
 * Customize admin dashboard branding
 */
function toga_racing_admin_footer_text() {
    return '<span id="footer-thankyou">TOGA Racing Team &mdash; Powered by WordPress</span>';
}
add_filter( 'admin_footer_text', 'toga_racing_admin_footer_text' );
