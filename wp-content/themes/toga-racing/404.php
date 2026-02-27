<?php
/**
 * 404 Page Template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="error-404-section">
        <div class="container">
            <div class="error-404-content">
                <span class="error-code">404</span>
                <h1 class="error-title"><?php esc_html_e( 'Off Track!', 'toga-racing' ); ?></h1>
                <p class="error-message">
                    <?php esc_html_e( 'Looks like you\'ve gone off the racing line. The page you\'re looking for doesn\'t exist.', 'toga-racing' ); ?>
                </p>
                <div class="error-actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Back to Home', 'toga-racing' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'driver' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'View Drivers', 'toga-racing' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
