<?php
/**
 * Template part for displaying no results
 *
 * @package TOGA_Racing
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h2 class="page-title section-title"><?php esc_html_e( 'Nothing Found', 'toga-racing' ); ?></h2>
    </header>

    <div class="page-content">
        <?php if ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, no results matched your search. Please try again with different keywords.', 'toga-racing' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'toga-racing' ); ?></p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'Back to Home', 'toga-racing' ); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
