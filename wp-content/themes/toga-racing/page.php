<?php
/**
 * Standard page template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="page-hero">
        <div class="container">
            <h1 class="page-title section-title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php
            while ( have_posts() ) :
                the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

</main>

<?php
get_footer();
