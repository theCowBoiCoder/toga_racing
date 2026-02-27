<?php
/**
 * Template Tags - Helper functions
 *
 * @package TOGA_Racing
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display social media icons for the team (from Customizer)
 *
 * @param string $context 'header' or 'footer'
 */
function toga_racing_social_icons( $context = 'header' ) {
    $platforms = array(
        'twitter'   => array( 'label' => 'Twitter / X',  'icon' => 'X' ),
        'discord'   => array( 'label' => 'Discord',      'icon' => 'DC' ),
        'youtube'   => array( 'label' => 'YouTube',      'icon' => 'YT' ),
        'twitch'    => array( 'label' => 'Twitch',       'icon' => 'TW' ),
        'instagram' => array( 'label' => 'Instagram',    'icon' => 'IG' ),
        'tiktok'    => array( 'label' => 'TikTok',       'icon' => 'TT' ),
        'facebook'  => array( 'label' => 'Facebook',     'icon' => 'FB' ),
        'steam'     => array( 'label' => 'Steam',        'icon' => 'ST' ),
    );

    $has_links = false;

    // SVG icons map
    $svg_icons = toga_racing_get_svg_icons();

    echo '<div class="social-icons social-icons-' . esc_attr( $context ) . '">';

    foreach ( $platforms as $key => $platform ) {
        $url = get_theme_mod( 'toga_racing_social_' . $key, '' );

        if ( ! empty( $url ) ) {
            $has_links = true;
            $svg = isset( $svg_icons[ $key ] ) ? $svg_icons[ $key ] : '<span class="social-text-icon">' . esc_html( $platform['icon'] ) . '</span>';

            printf(
                '<a href="%s" class="social-icon social-icon-%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
                esc_url( $url ),
                esc_attr( $key ),
                esc_attr( $platform['label'] ),
                $svg
            );
        }
    }

    if ( ! $has_links ) {
        echo '<!-- No social links configured. Set them in Appearance > Customize > Social Media Links -->';
    }

    echo '</div>';
}

/**
 * Display driver social media links
 *
 * @param int $driver_id
 */
function toga_racing_driver_social_links( $driver_id ) {
    $socials = array(
        'twitter'   => 'Twitter / X',
        'twitch'    => 'Twitch',
        'youtube'   => 'YouTube',
        'discord'   => 'Discord',
        'instagram' => 'Instagram',
        'tiktok'    => 'TikTok',
        'steam'     => 'Steam',
    );

    $svg_icons = toga_racing_get_svg_icons();
    $has_links = false;

    echo '<div class="driver-social-links">';

    foreach ( $socials as $key => $label ) {
        $value = get_post_meta( $driver_id, '_toga_driver_' . $key, true );

        if ( ! empty( $value ) ) {
            $has_links = true;

            // Discord is a username, not a URL
            if ( $key === 'discord' ) {
                $svg = isset( $svg_icons[ $key ] ) ? $svg_icons[ $key ] : '<span class="social-text-icon">DC</span>';
                printf(
                    '<span class="social-icon social-icon-%s driver-discord" title="%s: %s">%s</span>',
                    esc_attr( $key ),
                    esc_attr( $label ),
                    esc_attr( $value ),
                    $svg
                );
            } else {
                $svg = isset( $svg_icons[ $key ] ) ? $svg_icons[ $key ] : '<span class="social-text-icon">' . esc_html( substr( $label, 0, 2 ) ) . '</span>';
                printf(
                    '<a href="%s" class="social-icon social-icon-%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
                    esc_url( $value ),
                    esc_attr( $key ),
                    esc_attr( $label ),
                    $svg
                );
            }
        }
    }

    if ( ! $has_links ) {
        echo '<p class="no-social">' . esc_html__( 'No social links added yet.', 'toga-racing' ) . '</p>';
    }

    echo '</div>';
}

/**
 * Get driver stats as array
 *
 * @param int $driver_id
 * @return array
 */
function toga_racing_get_driver_stats( $driver_id ) {
    $stat_fields = array(
        'wins'          => __( 'Wins', 'toga-racing' ),
        'podiums'       => __( 'Podiums', 'toga-racing' ),
        'poles'         => __( 'Pole Positions', 'toga-racing' ),
        'championships' => __( 'Championships', 'toga-racing' ),
        'races'         => __( 'Races', 'toga-racing' ),
    );

    $stats = array();

    foreach ( $stat_fields as $key => $label ) {
        $value = get_post_meta( $driver_id, '_toga_driver_stat_' . $key, true );
        if ( $value !== '' && $value !== false ) {
            $stats[] = array(
                'label' => $label,
                'value' => $value,
            );
        }
    }

    return $stats;
}

/**
 * Get SVG icons for social platforms
 *
 * @return array
 */
function toga_racing_get_svg_icons() {
    return array(
        'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'discord'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.492c-1.53-.69-3.17-1.2-4.885-1.49a.075.075 0 0 0-.079.036c-.21.369-.444.85-.608 1.23a18.566 18.566 0 0 0-5.487 0 12.36 12.36 0 0 0-.617-1.23A.077.077 0 0 0 8.562 3c-1.714.29-3.354.8-4.885 1.491a.07.07 0 0 0-.032.027C.533 9.093-.32 13.555.099 17.961a.08.08 0 0 0 .031.055 20.03 20.03 0 0 0 5.993 2.98.078.078 0 0 0 .084-.026c.462-.62.874-1.275 1.226-1.963.021-.04.001-.088-.041-.104a13.201 13.201 0 0 1-1.872-.878.075.075 0 0 1-.008-.125c.126-.093.252-.19.372-.287a.075.075 0 0 1 .078-.01c3.927 1.764 8.18 1.764 12.061 0a.075.075 0 0 1 .079.009c.12.098.245.195.372.288a.075.075 0 0 1-.006.125c-.598.344-1.22.635-1.873.877a.075.075 0 0 0-.041.105c.36.687.772 1.341 1.225 1.962a.077.077 0 0 0 .084.028 19.963 19.963 0 0 0 6.002-2.981.076.076 0 0 0 .032-.054c.5-5.094-.838-9.52-3.549-13.442a.06.06 0 0 0-.031-.028zM8.02 15.278c-1.182 0-2.157-1.069-2.157-2.38 0-1.312.956-2.38 2.157-2.38 1.21 0 2.176 1.077 2.157 2.38 0 1.312-.956 2.38-2.157 2.38zm7.975 0c-1.183 0-2.157-1.069-2.157-2.38 0-1.312.955-2.38 2.157-2.38 1.21 0 2.176 1.077 2.157 2.38 0 1.312-.946 2.38-2.157 2.38z"/></svg>',
        'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'twitch'    => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z"/></svg>',
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>',
        'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
        'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'steam'     => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.979 0C5.678 0 .511 4.86.022 11.037l6.432 2.658c.545-.371 1.203-.59 1.912-.59.063 0 .125.004.188.006l2.861-4.142V8.91c0-2.495 2.028-4.524 4.524-4.524 2.494 0 4.524 2.031 4.524 4.527s-2.03 4.525-4.524 4.525h-.105l-4.076 2.911c0 .052.004.105.004.159 0 1.875-1.515 3.396-3.39 3.396-1.635 0-3.016-1.173-3.331-2.727L.436 15.27C1.862 20.307 6.486 24 11.979 24c6.627 0 11.999-5.373 11.999-12S18.605 0 11.979 0zM7.54 18.21l-1.473-.61c.262.543.714.999 1.314 1.25 1.297.539 2.793-.076 3.332-1.375.263-.63.264-1.319.005-1.949s-.75-1.121-1.377-1.383c-.624-.26-1.29-.249-1.878-.03l1.523.63c.956.4 1.409 1.5 1.009 2.455-.397.957-1.497 1.41-2.454 1.012zm11.415-9.303c0-1.662-1.353-3.015-3.015-3.015-1.665 0-3.015 1.353-3.015 3.015 0 1.665 1.35 3.015 3.015 3.015 1.663 0 3.015-1.35 3.015-3.015z"/></svg>',
    );
}

/**
 * Fallback menu when no primary menu is set
 */
function toga_racing_fallback_menu() {
    echo '<ul id="primary-menu" class="primary-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'toga-racing' ) . '</a></li>';
    echo '<li><a href="' . esc_url( get_post_type_archive_link( 'driver' ) ) . '">' . esc_html__( 'Drivers', 'toga-racing' ) . '</a></li>';

    // Check if gallery page exists
    $gallery_page = get_page_by_path( 'gallery' );
    if ( $gallery_page ) {
        echo '<li><a href="' . esc_url( get_permalink( $gallery_page ) ) . '">' . esc_html__( 'Gallery', 'toga-racing' ) . '</a></li>';
    }

    echo '</ul>';
}
