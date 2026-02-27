<?php
/**
 * Driver Archive Template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Page Header -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-title section-title"><?php esc_html_e( 'Our Drivers', 'toga-racing' ); ?></h1>
            <p class="page-description"><?php esc_html_e( 'Meet the talented drivers who represent TOGA Racing.', 'toga-racing' ); ?></p>
        </div>
    </section>

    <section class="section">
        <div class="container">

            <!-- Division Filter Tabs -->
            <div class="division-tabs">
                <button class="division-tab active" data-division="all">
                    <?php esc_html_e( 'All Drivers', 'toga-racing' ); ?>
                </button>
                <button class="division-tab tab-esports" data-division="esports">
                    <?php esc_html_e( 'Esports', 'toga-racing' ); ?>
                </button>
                <button class="division-tab tab-academy" data-division="academy">
                    <?php esc_html_e( 'Academy', 'toga-racing' ); ?>
                </button>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="drivers-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content', 'driver' ); ?>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '&laquo; Previous',
                        'next_text' => 'Next &raquo;',
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <p class="no-drivers"><?php esc_html_e( 'No drivers found. Add drivers from the WordPress admin.', 'toga-racing' ); ?></p>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
