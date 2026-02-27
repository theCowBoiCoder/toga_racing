<?php
/**
 * Header template
 *
 * @package TOGA_Racing
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <header id="masthead" class="site-header">
        <div class="container header-inner">

            <!-- Site Branding -->
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link">
                        <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'toga-racing' ); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => 'toga_racing_fallback_menu',
                ) );
                ?>
            </nav>

            <!-- Header Social Icons -->
            <div class="header-social">
                <?php toga_racing_social_icons( 'header' ); ?>
            </div>

        </div>
    </header>
