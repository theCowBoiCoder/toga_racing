<?php
/**
 * Footer template
 *
 * @package TOGA_Racing
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">

            <!-- Footer Top -->
            <div class="footer-top">

                <!-- Footer Branding -->
                <div class="footer-branding">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="footer-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-title-link">
                            <span class="footer-title"><?php bloginfo( 'name' ); ?></span>
                        </a>
                    <?php endif; ?>
                    <p class="footer-tagline"><?php bloginfo( 'description' ); ?></p>
                </div>

                <!-- Footer Navigation -->
                <div class="footer-nav">
                    <h4 class="footer-heading"><?php esc_html_e( 'Quick Links', 'toga-racing' ); ?></h4>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>

                <!-- Footer Social -->
                <div class="footer-social-section">
                    <h4 class="footer-heading"><?php esc_html_e( 'Follow Us', 'toga-racing' ); ?></h4>
                    <div class="footer-social">
                        <?php toga_racing_social_icons( 'footer' ); ?>
                    </div>
                </div>

                <!-- Footer Widgets -->
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="footer-widgets">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="copyright">
                    &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>.
                    <?php esc_html_e( 'All rights reserved.', 'toga-racing' ); ?>
                </p>
            </div>

        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
