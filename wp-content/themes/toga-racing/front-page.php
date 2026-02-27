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

    <!-- Featured Drivers Section -->
    <section class="section featured-drivers-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e( 'Our Drivers', 'toga-racing' ); ?></h2>
            <p class="section-subtitle"><?php esc_html_e( 'Meet the team behind the wheel.', 'toga-racing' ); ?></p>

            <div class="drivers-grid">
                <?php
                $drivers = new WP_Query( array(
                    'post_type'      => 'driver',
                    'posts_per_page' => 6,
                    'meta_key'       => '_toga_driver_status',
                    'meta_value'     => 'active',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) );

                if ( $drivers->have_posts() ) :
                    while ( $drivers->have_posts() ) : $drivers->the_post();
                        get_template_part( 'template-parts/content', 'driver' );
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p class="no-drivers"><?php esc_html_e( 'Drivers coming soon! Add drivers from the WordPress admin.', 'toga-racing' ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( $drivers->found_posts > 6 ) : ?>
                <div class="section-cta">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'driver' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'View All Drivers', 'toga-racing' ); ?>
                    </a>
                </div>
            <?php endif; ?>
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
