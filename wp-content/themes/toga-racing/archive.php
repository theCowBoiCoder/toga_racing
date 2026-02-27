<?php
/**
 * Archive template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="page-hero">
        <div class="container">
            <?php the_archive_title( '<h1 class="page-title section-title">', '</h1>' ); ?>
            <?php the_archive_description( '<p class="page-description">', '</p>' ); ?>
        </div>
    </section>

    <section class="section">
        <div class="container">

            <?php if ( have_posts() ) : ?>

                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
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
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();
