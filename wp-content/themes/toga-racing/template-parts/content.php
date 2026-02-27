<?php
/**
 * Template part for displaying posts
 *
 * @package TOGA_Racing
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
    <a href="<?php the_permalink(); ?>" class="post-card-link">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-card-image">
                <?php the_post_thumbnail( 'gallery-thumb', array( 'class' => 'post-card-thumb' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="post-card-content">
            <div class="post-card-meta">
                <time class="post-card-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </div>
            <h3 class="post-card-title"><?php the_title(); ?></h3>
            <p class="post-card-excerpt"><?php echo get_the_excerpt(); ?></p>
            <span class="post-card-read-more"><?php esc_html_e( 'Read More &rarr;', 'toga-racing' ); ?></span>
        </div>

    </a>
</article>
