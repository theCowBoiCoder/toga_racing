<?php
/**
 * Theme Customizer - Social Media Links
 *
 * @package TOGA_Racing
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register customizer settings
 */
function toga_racing_customize_register( $wp_customize ) {

    // Social Media Section
    $wp_customize->add_section( 'toga_racing_social', array(
        'title'       => __( 'Social Media Links', 'toga-racing' ),
        'description' => __( 'Add your team social media URLs. Leave blank to hide.', 'toga-racing' ),
        'priority'    => 30,
    ) );

    $social_platforms = array(
        'twitter'   => array(
            'label'       => __( 'Twitter / X URL', 'toga-racing' ),
            'placeholder' => 'https://twitter.com/togaracing',
        ),
        'discord'   => array(
            'label'       => __( 'Discord Invite URL', 'toga-racing' ),
            'placeholder' => 'https://discord.gg/yourserver',
        ),
        'youtube'   => array(
            'label'       => __( 'YouTube URL', 'toga-racing' ),
            'placeholder' => 'https://youtube.com/@togaracing',
        ),
        'twitch'    => array(
            'label'       => __( 'Twitch URL', 'toga-racing' ),
            'placeholder' => 'https://twitch.tv/togaracing',
        ),
        'instagram' => array(
            'label'       => __( 'Instagram URL', 'toga-racing' ),
            'placeholder' => 'https://instagram.com/togaracing',
        ),
        'tiktok'    => array(
            'label'       => __( 'TikTok URL', 'toga-racing' ),
            'placeholder' => 'https://tiktok.com/@togaracing',
        ),
        'facebook'  => array(
            'label'       => __( 'Facebook URL', 'toga-racing' ),
            'placeholder' => 'https://facebook.com/togaracing',
        ),
        'steam'     => array(
            'label'       => __( 'Steam Group URL', 'toga-racing' ),
            'placeholder' => 'https://steamcommunity.com/groups/togaracing',
        ),
    );

    foreach ( $social_platforms as $key => $platform ) {
        $setting_id = 'toga_racing_social_' . $key;

        $wp_customize->add_setting( $setting_id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );

        $wp_customize->add_control( $setting_id, array(
            'label'       => $platform['label'],
            'section'     => 'toga_racing_social',
            'type'        => 'url',
            'input_attrs' => array(
                'placeholder' => $platform['placeholder'],
            ),
        ) );
    }

    // Hero Section
    $wp_customize->add_section( 'toga_racing_hero', array(
        'title'       => __( 'Hero Section', 'toga-racing' ),
        'description' => __( 'Customize the homepage hero section.', 'toga-racing' ),
        'priority'    => 25,
    ) );

    // Hero Background Image
    $wp_customize->add_setting( 'toga_racing_hero_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'toga_racing_hero_bg', array(
        'label'   => __( 'Hero Background Image', 'toga-racing' ),
        'section' => 'toga_racing_hero',
    ) ) );

    // Hero Overlay Opacity
    $wp_customize->add_setting( 'toga_racing_hero_overlay', array(
        'default'           => '0.7',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'toga_racing_hero_overlay', array(
        'label'       => __( 'Hero Overlay Opacity', 'toga-racing' ),
        'description' => __( '0 = transparent, 1 = solid black', 'toga-racing' ),
        'section'     => 'toga_racing_hero',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => '0',
            'max'  => '1',
            'step' => '0.1',
        ),
    ) );
}
add_action( 'customize_register', 'toga_racing_customize_register' );

/**
 * Output customizer CSS
 */
function toga_racing_customizer_css() {
    $hero_bg      = get_theme_mod( 'toga_racing_hero_bg', '' );
    $hero_overlay = get_theme_mod( 'toga_racing_hero_overlay', '0.7' );

    $css = '';

    if ( $hero_bg ) {
        $css .= '.hero-section { background-image: url(' . esc_url( $hero_bg ) . '); }';
    }

    if ( $hero_overlay ) {
        $css .= '.hero-overlay { opacity: ' . esc_attr( $hero_overlay ) . '; }';
    }

    if ( $css ) {
        echo '<style id="toga-racing-customizer-css">' . $css . '</style>';
    }
}
add_action( 'wp_head', 'toga_racing_customizer_css' );
