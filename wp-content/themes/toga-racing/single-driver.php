<?php
/**
 * Single Driver Profile Template
 *
 * @package TOGA_Racing
 */

get_header();

$driver_id     = get_the_ID();
$nationality   = get_post_meta( $driver_id, '_toga_driver_nationality', true );
$number        = get_post_meta( $driver_id, '_toga_driver_number', true );
$status        = get_post_meta( $driver_id, '_toga_driver_status', true );
$role          = get_post_meta( $driver_id, '_toga_driver_role', true );
$division      = get_post_meta( $driver_id, '_toga_driver_division', true );
if ( empty( $division ) ) $division = 'esports';
?>

<main id="primary" class="site-main single-driver-page division-page-<?php echo esc_attr( $division ); ?>">

    <!-- Driver Hero -->
    <section class="driver-hero">
        <div class="container">
            <div class="driver-hero-inner">

                <!-- Driver Photo -->
                <div class="driver-photo-wrapper">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'driver-profile', array( 'class' => 'driver-photo' ) ); ?>
                    <?php else : ?>
                        <div class="driver-photo-placeholder">
                            <span class="driver-number-large"><?php echo $number ? esc_html( $number ) : '#'; ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Driver Info -->
                <div class="driver-info">
                    <?php if ( $number ) : ?>
                        <span class="driver-number-badge">#<?php echo esc_html( $number ); ?></span>
                    <?php endif; ?>

                    <h1 class="driver-name"><?php the_title(); ?></h1>

                    <div class="driver-meta-tags">
                        <span class="driver-tag driver-division division-badge-<?php echo esc_attr( $division ); ?>">
                            <?php echo esc_html( ucfirst( $division ) ); ?>
                        </span>
                        <?php if ( $role ) : ?>
                            <span class="driver-tag driver-role"><?php echo esc_html( $role ); ?></span>
                        <?php endif; ?>

                        <?php if ( $nationality ) : ?>
                            <span class="driver-tag driver-nationality"><?php echo esc_html( $nationality ); ?></span>
                        <?php endif; ?>

                        <?php if ( $status ) : ?>
                            <span class="driver-tag driver-status status-<?php echo esc_attr( $status ); ?>">
                                <?php echo esc_html( ucfirst( $status ) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Driver Social Links -->
                    <?php toga_racing_driver_social_links( $driver_id ); ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Driver Stats -->
    <?php
    $stats = toga_racing_get_driver_stats( $driver_id );
    if ( ! empty( $stats ) ) :
    ?>
    <section class="section driver-stats-section">
        <div class="container">
            <div class="stats-grid">
                <?php foreach ( $stats as $stat ) : ?>
                    <div class="stat-card">
                        <span class="stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
                        <span class="stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Driver Bio -->
    <section class="section driver-bio-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e( 'About', 'toga-racing' ); ?></h2>
            <div class="driver-bio-content entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <!-- Back to Drivers -->
    <section class="section driver-back-section">
        <div class="container">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'driver' ) ); ?>" class="btn btn-outline">
                &laquo; <?php esc_html_e( 'Back to All Drivers', 'toga-racing' ); ?>
            </a>
        </div>
    </section>

</main>

<?php
get_footer();
