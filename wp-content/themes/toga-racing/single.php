<?php
/**
 * Single post template
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

            <!-- Post Header -->
            <header class="post-hero">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-hero-image">
                        <?php the_post_thumbnail( 'hero-banner' ); ?>
                        <div class="post-hero-overlay"></div>
                    </div>
                <?php endif; ?>

                <div class="container post-hero-content">
                    <div class="post-meta">
                        <time class="post-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        <?php if ( has_category() ) : ?>
                            <span class="post-categories"><?php the_category( ', ' ); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </div>
            </header>

            <!-- Post Content -->
            <section class="section">
                <div class="container content-narrow">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Post Tags -->
                    <?php if ( has_tag() ) : ?>
                        <div class="post-tags">
                            <?php the_tags( '<span class="tags-label">Tags:</span> ', ', ' ); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <nav class="post-navigation">
                        <?php
                        the_post_navigation( array(
                            'prev_text' => '<span class="nav-label">&laquo; Previous</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-label">Next &raquo;</span> <span class="nav-title">%title</span>',
                        ) );
                        ?>
                    </nav>
                </div>
            </section>

        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();
