<?php
/**
 * Front page template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main front-page">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="hero-title">
                <span class="hero-team-name"><?php bloginfo( 'name' ); ?></span>
            </h1>
            <p class="hero-tagline"><?php bloginfo( 'description' ); ?></p>
            <div class="hero-cta">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'driver' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Meet the Drivers', 'toga-racing' ); ?>
                </a>
                <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'gallery' ) ) ); ?>" class="btn btn-outline">
                    <?php esc_html_e( 'View Gallery', 'toga-racing' ); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Esports Division -->
    <section class="section featured-drivers-section division-section-esports">
        <div class="container">
            <h2 class="section-title division-title-esports"><?php esc_html_e( 'Esports Division', 'toga-racing' ); ?></h2>
            <p class="section-subtitle"><?php esc_html_e( 'Our competitive racing lineup.', 'toga-racing' ); ?></p>

            <div class="drivers-grid">
                <?php
                $esports_drivers = new WP_Query( array(
                    'post_type'      => 'driver',
                    'posts_per_page' => 6,
                    'meta_query'     => array(
                        array( 'key' => '_toga_driver_status', 'value' => 'active' ),
                        array( 'key' => '_toga_driver_division', 'value' => 'esports' ),
                    ),
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) );

                if ( $esports_drivers->have_posts() ) :
                    while ( $esports_drivers->have_posts() ) : $esports_drivers->the_post();
                        get_template_part( 'template-parts/content', 'driver' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="no-drivers"><?php esc_html_e( 'Esports drivers coming soon!', 'toga-racing' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Academy Division -->
    <section class="section featured-drivers-section division-section-academy">
        <div class="container">
            <h2 class="section-title division-title-academy"><?php esc_html_e( 'Academy Division', 'toga-racing' ); ?></h2>
            <p class="section-subtitle"><?php esc_html_e( 'The next generation of TOGA Racing talent.', 'toga-racing' ); ?></p>

            <div class="drivers-grid">
                <?php
                $academy_drivers = new WP_Query( array(
                    'post_type'      => 'driver',
                    'posts_per_page' => 6,
                    'meta_query'     => array(
                        array( 'key' => '_toga_driver_status', 'value' => 'active' ),
                        array( 'key' => '_toga_driver_division', 'value' => 'academy' ),
                    ),
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) );

                if ( $academy_drivers->have_posts() ) :
                    while ( $academy_drivers->have_posts() ) : $academy_drivers->the_post();
                        get_template_part( 'template-parts/content', 'driver' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="no-drivers"><?php esc_html_e( 'Academy drivers coming soon!', 'toga-racing' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="section latest-news-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e( 'Latest News', 'toga-racing' ); ?></h2>
            <p class="section-subtitle"><?php esc_html_e( 'Stay up to date with TOGA Racing.', 'toga-racing' ); ?></p>

            <div class="posts-grid">
                <?php
                $news = new WP_Query( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                ) );

                if ( $news->have_posts() ) :
                    while ( $news->have_posts() ) : $news->the_post();
                        get_template_part( 'template-parts/content', 'post' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="no-posts"><?php esc_html_e( 'No news yet. Start writing posts from the WordPress admin!', 'toga-racing' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
