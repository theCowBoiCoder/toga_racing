<?php
/**
 * Template Name: Gallery
 * Description: Image gallery page with lightbox and category filtering.
 *
 * @package TOGA_Racing
 */

get_header();
?>

<main id="primary" class="site-main gallery-page">

    <!-- Page Header -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-title section-title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="page-description"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php else : ?>
                <p class="page-description"><?php esc_html_e( 'Race screenshots, liveries, and team moments.', 'toga-racing' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="section gallery-section">
        <div class="container">

            <?php
            // Get all image categories (using WordPress media categories)
            $gallery_cats = get_terms( array(
                'taxonomy'   => 'category',
                'hide_empty' => true,
            ) );
            ?>

            <!-- Category Filters -->
            <?php if ( ! empty( $gallery_cats ) && ! is_wp_error( $gallery_cats ) ) : ?>
                <div class="gallery-filters">
                    <button class="gallery-filter active" data-filter="all">
                        <?php esc_html_e( 'All', 'toga-racing' ); ?>
                    </button>
                    <?php foreach ( $gallery_cats as $cat ) : ?>
                        <button class="gallery-filter" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Gallery Grid -->
            <div class="gallery-grid" id="gallery-grid">
                <?php
                // Display gallery from page content (WordPress gallery blocks)
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                endif;

                // Also show attached images
                $images = get_posts( array(
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent'    => get_the_ID(),
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ) );

                if ( ! empty( $images ) ) :
                    foreach ( $images as $image ) :
                        $full_url  = wp_get_attachment_image_url( $image->ID, 'full' );
                        $thumb_url = wp_get_attachment_image_url( $image->ID, 'gallery-thumb' );
                        $alt       = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );
                        $caption   = $image->post_excerpt;
                ?>
                    <div class="gallery-item" data-category="all">
                        <a href="<?php echo esc_url( $full_url ); ?>"
                           class="gallery-lightbox-trigger"
                           data-caption="<?php echo esc_attr( $caption ); ?>">
                            <img src="<?php echo esc_url( $thumb_url ); ?>"
                                 alt="<?php echo esc_attr( $alt ); ?>"
                                 loading="lazy">
                            <div class="gallery-item-overlay">
                                <span class="gallery-zoom-icon">&#x1f50d;</span>
                            </div>
                        </a>
                        <?php if ( $caption ) : ?>
                            <p class="gallery-caption"><?php echo esc_html( $caption ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="gallery-lightbox" class="lightbox" aria-hidden="true">
        <div class="lightbox-overlay"></div>
        <div class="lightbox-content">
            <button class="lightbox-close" aria-label="<?php esc_attr_e( 'Close', 'toga-racing' ); ?>">&times;</button>
            <button class="lightbox-prev" aria-label="<?php esc_attr_e( 'Previous', 'toga-racing' ); ?>">&lsaquo;</button>
            <button class="lightbox-next" aria-label="<?php esc_attr_e( 'Next', 'toga-racing' ); ?>">&rsaquo;</button>
            <img class="lightbox-image" src="" alt="">
            <p class="lightbox-caption"></p>
        </div>
    </div>

</main>

<?php
get_footer();
