<?php
/**
 * Template part for displaying driver cards
 *
 * @package TOGA_Racing
 */

$driver_id   = get_the_ID();
$number      = get_post_meta( $driver_id, '_toga_driver_number', true );
$role        = get_post_meta( $driver_id, '_toga_driver_role', true );
$nationality = get_post_meta( $driver_id, '_toga_driver_nationality', true );
$status      = get_post_meta( $driver_id, '_toga_driver_status', true );
?>

<article id="driver-<?php the_ID(); ?>" <?php post_class( 'driver-card' ); ?>>
    <a href="<?php the_permalink(); ?>" class="driver-card-link">

        <div class="driver-card-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'driver-card', array( 'class' => 'driver-card-photo' ) ); ?>
            <?php else : ?>
                <div class="driver-card-placeholder">
                    <span class="driver-card-number"><?php echo $number ? esc_html( $number ) : '#'; ?></span>
                </div>
            <?php endif; ?>

            <?php if ( $number ) : ?>
                <span class="driver-card-number-overlay">#<?php echo esc_html( $number ); ?></span>
            <?php endif; ?>
        </div>

        <div class="driver-card-content">
            <h3 class="driver-card-name"><?php the_title(); ?></h3>

            <?php if ( $role ) : ?>
                <span class="driver-card-role"><?php echo esc_html( $role ); ?></span>
            <?php endif; ?>

            <?php if ( $nationality ) : ?>
                <span class="driver-card-nationality"><?php echo esc_html( $nationality ); ?></span>
            <?php endif; ?>
        </div>

        <div class="driver-card-hover">
            <span class="view-profile"><?php esc_html_e( 'View Profile', 'toga-racing' ); ?></span>
        </div>

    </a>
</article>
