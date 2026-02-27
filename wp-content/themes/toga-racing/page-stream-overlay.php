<?php
/**
 * Template Name: Stream Overlay
 * Description: Clean OBS browser source overlay. Use URL params to customize:
 *   ?driver=DRIVER_SLUG  - Show specific driver info
 *   ?style=banner        - Top banner style (default)
 *   ?style=lowerthird    - Lower third style
 *   ?division=esports    - Force esports colors
 *   ?division=academy    - Force academy colors
 *
 * Example OBS Browser Source URLs:
 *   http://localhost:8080/stream-overlay/?driver=john-doe&style=banner
 *   http://localhost:8080/stream-overlay/?driver=john-doe&style=lowerthird
 *   http://localhost:8080/stream-overlay/ (team banner only, no driver)
 *
 * @package TOGA_Racing
 */

// Get URL parameters
$driver_slug  = isset( $_GET['driver'] ) ? sanitize_title( $_GET['driver'] ) : '';
$overlay_style = isset( $_GET['style'] ) ? sanitize_text_field( $_GET['style'] ) : 'banner';
$force_division = isset( $_GET['division'] ) ? sanitize_text_field( $_GET['division'] ) : '';

// Fetch driver data if slug provided
$driver_data = null;
$division = $force_division ?: 'esports';

if ( $driver_slug ) {
    $driver_posts = get_posts( array(
        'post_type'   => 'driver',
        'name'        => $driver_slug,
        'numberposts' => 1,
    ) );

    if ( ! empty( $driver_posts ) ) {
        $driver = $driver_posts[0];
        $driver_data = array(
            'name'       => $driver->post_title,
            'number'     => get_post_meta( $driver->ID, '_toga_driver_number', true ),
            'role'       => get_post_meta( $driver->ID, '_toga_driver_role', true ),
            'division'   => get_post_meta( $driver->ID, '_toga_driver_division', true ) ?: 'esports',
            'nationality'=> get_post_meta( $driver->ID, '_toga_driver_nationality', true ),
            'twitter'    => get_post_meta( $driver->ID, '_toga_driver_twitter', true ),
            'twitch'     => get_post_meta( $driver->ID, '_toga_driver_twitch', true ),
        );

        // Use driver's division unless forced
        if ( ! $force_division ) {
            $division = $driver_data['division'];
        }
    }
}

$division_class = ( $division === 'academy' ) ? 'banner-academy' : '';
$lower_class    = ( $division === 'academy' ) ? 'lower-third-academy' : '';
$site_name      = get_bloginfo( 'name' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Transparent background for OBS */
        html, body {
            background: transparent !important;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
    <?php wp_head(); ?>
</head>

<body class="stream-overlay-page">

<?php if ( $overlay_style === 'lowerthird' ) : ?>

    <!-- Lower Third Overlay -->
    <div class="stream-overlay">
        <div class="stream-lower-third <?php echo esc_attr( $lower_class ); ?>">
            <div class="stream-lower-accent"></div>
            <div class="stream-lower-third-content">
                <?php if ( $driver_data ) : ?>
                    <div class="stream-lower-name">
                        <?php if ( $driver_data['number'] ) : ?>
                            <span class="stream-driver-number">#<?php echo esc_html( $driver_data['number'] ); ?></span>
                        <?php endif; ?>
                        <?php echo esc_html( $driver_data['name'] ); ?>
                    </div>
                    <div class="stream-lower-detail">
                        <?php echo esc_html( $site_name ); ?>
                        <?php if ( $driver_data['role'] ) : ?>
                            &bull; <?php echo esc_html( $driver_data['role'] ); ?>
                        <?php endif; ?>
                        &bull; <?php echo esc_html( ucfirst( $division ) ); ?>
                    </div>
                <?php else : ?>
                    <div class="stream-lower-name"><?php echo esc_html( $site_name ); ?></div>
                    <div class="stream-lower-detail"><?php echo esc_html( ucfirst( $division ) ); ?> Division</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php else : ?>

    <!-- Banner Overlay (default) -->
    <div class="stream-overlay">
        <div class="stream-banner <?php echo esc_attr( $division_class ); ?>">

            <div class="stream-banner-left">
                <!-- Team Logo or Name -->
                <?php if ( has_custom_logo() ) : ?>
                    <div class="stream-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <span class="stream-team-name"><?php echo esc_html( $site_name ); ?></span>
                <?php endif; ?>

                <?php if ( $driver_data ) : ?>
                    <span class="stream-divider"></span>

                    <div class="stream-driver-info">
                        <?php if ( $driver_data['number'] ) : ?>
                            <span class="stream-driver-number">#<?php echo esc_html( $driver_data['number'] ); ?></span>
                        <?php endif; ?>

                        <span class="stream-driver-name"><?php echo esc_html( $driver_data['name'] ); ?></span>

                        <span class="stream-driver-division division-badge-<?php echo esc_attr( $division ); ?>">
                            <?php echo esc_html( ucfirst( $division ) ); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stream-banner-right">
                <?php if ( $driver_data && $driver_data['twitch'] ) : ?>
                    <span class="stream-social-handle">
                        <?php
                        // Extract username from Twitch URL
                        $twitch_handle = basename( rtrim( $driver_data['twitch'], '/' ) );
                        echo esc_html( $twitch_handle );
                        ?>
                    </span>
                <?php elseif ( $driver_data && $driver_data['twitter'] ) : ?>
                    <span class="stream-social-handle">
                        <?php
                        $twitter_handle = basename( rtrim( $driver_data['twitter'], '/' ) );
                        echo '@' . esc_html( $twitter_handle );
                        ?>
                    </span>
                <?php endif; ?>
            </div>

        </div>
    </div>

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
