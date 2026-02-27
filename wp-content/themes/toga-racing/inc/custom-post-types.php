<?php
/**
 * Custom Post Types - Driver Profiles
 *
 * @package TOGA_Racing
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Driver Custom Post Type
 */
function toga_racing_register_driver_cpt() {
    $labels = array(
        'name'                  => _x( 'Drivers', 'Post type general name', 'toga-racing' ),
        'singular_name'         => _x( 'Driver', 'Post type singular name', 'toga-racing' ),
        'menu_name'             => _x( 'Drivers', 'Admin Menu text', 'toga-racing' ),
        'add_new'               => __( 'Add New Driver', 'toga-racing' ),
        'add_new_item'          => __( 'Add New Driver', 'toga-racing' ),
        'new_item'              => __( 'New Driver', 'toga-racing' ),
        'edit_item'             => __( 'Edit Driver', 'toga-racing' ),
        'view_item'             => __( 'View Driver', 'toga-racing' ),
        'all_items'             => __( 'All Drivers', 'toga-racing' ),
        'search_items'          => __( 'Search Drivers', 'toga-racing' ),
        'not_found'             => __( 'No drivers found.', 'toga-racing' ),
        'not_found_in_trash'    => __( 'No drivers found in Trash.', 'toga-racing' ),
        'featured_image'        => _x( 'Driver Photo', 'Overrides the "Featured Image" phrase', 'toga-racing' ),
        'set_featured_image'    => _x( 'Set driver photo', 'Overrides the "Set featured image" phrase', 'toga-racing' ),
        'remove_featured_image' => _x( 'Remove driver photo', 'Overrides the "Remove featured image" phrase', 'toga-racing' ),
        'use_featured_image'    => _x( 'Use as driver photo', 'Overrides the "Use as featured image" phrase', 'toga-racing' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'drivers' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
    );

    register_post_type( 'driver', $args );
}
add_action( 'init', 'toga_racing_register_driver_cpt' );

/**
 * Flush rewrite rules on theme activation
 */
function toga_racing_rewrite_flush() {
    toga_racing_register_driver_cpt();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'toga_racing_rewrite_flush' );

/**
 * Add meta boxes for driver details
 */
function toga_racing_driver_meta_boxes() {
    add_meta_box(
        'toga_driver_details',
        __( 'Driver Details', 'toga-racing' ),
        'toga_racing_driver_details_callback',
        'driver',
        'normal',
        'high'
    );

    add_meta_box(
        'toga_driver_social',
        __( 'Driver Social Media', 'toga-racing' ),
        'toga_racing_driver_social_callback',
        'driver',
        'normal',
        'default'
    );

    add_meta_box(
        'toga_driver_stats',
        __( 'Driver Stats', 'toga-racing' ),
        'toga_racing_driver_stats_callback',
        'driver',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'toga_racing_driver_meta_boxes' );

/**
 * Driver Details meta box callback
 */
function toga_racing_driver_details_callback( $post ) {
    wp_nonce_field( 'toga_driver_details_nonce', 'toga_driver_nonce' );

    $nationality    = get_post_meta( $post->ID, '_toga_driver_nationality', true );
    $racing_number  = get_post_meta( $post->ID, '_toga_driver_number', true );
    $status         = get_post_meta( $post->ID, '_toga_driver_status', true );
    $role           = get_post_meta( $post->ID, '_toga_driver_role', true );

    if ( empty( $status ) ) {
        $status = 'active';
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="toga_driver_nationality"><?php esc_html_e( 'Nationality', 'toga-racing' ); ?></label></th>
            <td>
                <input type="text" id="toga_driver_nationality" name="toga_driver_nationality"
                       value="<?php echo esc_attr( $nationality ); ?>" class="regular-text"
                       placeholder="<?php esc_attr_e( 'e.g. United Kingdom', 'toga-racing' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="toga_driver_number"><?php esc_html_e( 'Racing Number', 'toga-racing' ); ?></label></th>
            <td>
                <input type="text" id="toga_driver_number" name="toga_driver_number"
                       value="<?php echo esc_attr( $racing_number ); ?>" class="small-text"
                       placeholder="<?php esc_attr_e( 'e.g. 42', 'toga-racing' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="toga_driver_role"><?php esc_html_e( 'Role', 'toga-racing' ); ?></label></th>
            <td>
                <input type="text" id="toga_driver_role" name="toga_driver_role"
                       value="<?php echo esc_attr( $role ); ?>" class="regular-text"
                       placeholder="<?php esc_attr_e( 'e.g. Lead Driver, Reserve Driver, Team Manager', 'toga-racing' ); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="toga_driver_status"><?php esc_html_e( 'Status', 'toga-racing' ); ?></label></th>
            <td>
                <select id="toga_driver_status" name="toga_driver_status">
                    <option value="active" <?php selected( $status, 'active' ); ?>><?php esc_html_e( 'Active', 'toga-racing' ); ?></option>
                    <option value="inactive" <?php selected( $status, 'inactive' ); ?>><?php esc_html_e( 'Inactive', 'toga-racing' ); ?></option>
                    <option value="reserve" <?php selected( $status, 'reserve' ); ?>><?php esc_html_e( 'Reserve', 'toga-racing' ); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Driver Social Media meta box callback
 */
function toga_racing_driver_social_callback( $post ) {
    $socials = array(
        'twitter'   => __( 'Twitter / X', 'toga-racing' ),
        'twitch'    => __( 'Twitch', 'toga-racing' ),
        'youtube'   => __( 'YouTube', 'toga-racing' ),
        'discord'   => __( 'Discord Username', 'toga-racing' ),
        'instagram' => __( 'Instagram', 'toga-racing' ),
        'tiktok'    => __( 'TikTok', 'toga-racing' ),
        'steam'     => __( 'Steam', 'toga-racing' ),
    );
    ?>
    <table class="form-table">
        <?php foreach ( $socials as $key => $label ) :
            $value = get_post_meta( $post->ID, '_toga_driver_' . $key, true );
        ?>
        <tr>
            <th><label for="toga_driver_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
            <td>
                <input type="text" id="toga_driver_<?php echo esc_attr( $key ); ?>"
                       name="toga_driver_<?php echo esc_attr( $key ); ?>"
                       value="<?php echo esc_attr( $value ); ?>" class="regular-text"
                       placeholder="<?php echo esc_attr( $key === 'discord' ? 'username#1234' : 'https://' ); ?>">
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php
}

/**
 * Driver Stats meta box callback
 */
function toga_racing_driver_stats_callback( $post ) {
    $stats = array(
        'wins'           => __( 'Wins', 'toga-racing' ),
        'podiums'        => __( 'Podiums', 'toga-racing' ),
        'poles'          => __( 'Pole Positions', 'toga-racing' ),
        'championships'  => __( 'Championships', 'toga-racing' ),
        'races'          => __( 'Races Entered', 'toga-racing' ),
    );
    ?>
    <p class="description"><?php esc_html_e( 'Leave blank to hide stats section.', 'toga-racing' ); ?></p>
    <?php foreach ( $stats as $key => $label ) :
        $value = get_post_meta( $post->ID, '_toga_driver_stat_' . $key, true );
    ?>
    <p>
        <label for="toga_driver_stat_<?php echo esc_attr( $key ); ?>">
            <strong><?php echo esc_html( $label ); ?></strong>
        </label><br>
        <input type="number" id="toga_driver_stat_<?php echo esc_attr( $key ); ?>"
               name="toga_driver_stat_<?php echo esc_attr( $key ); ?>"
               value="<?php echo esc_attr( $value ); ?>" class="small-text" min="0">
    </p>
    <?php endforeach;
}

/**
 * Save driver meta data
 */
function toga_racing_save_driver_meta( $post_id ) {
    // Security checks
    if ( ! isset( $_POST['toga_driver_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['toga_driver_nonce'], 'toga_driver_details_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save driver details
    $text_fields = array(
        'toga_driver_nationality' => '_toga_driver_nationality',
        'toga_driver_number'      => '_toga_driver_number',
        'toga_driver_status'      => '_toga_driver_status',
        'toga_driver_role'        => '_toga_driver_role',
    );

    foreach ( $text_fields as $field => $meta_key ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $field ] ) );
        }
    }

    // Save social media links
    $social_fields = array( 'twitter', 'twitch', 'youtube', 'discord', 'instagram', 'tiktok', 'steam' );

    foreach ( $social_fields as $social ) {
        $field_name = 'toga_driver_' . $social;
        if ( isset( $_POST[ $field_name ] ) ) {
            $value = sanitize_text_field( $_POST[ $field_name ] );
            update_post_meta( $post_id, '_toga_driver_' . $social, $value );
        }
    }

    // Save stats
    $stat_fields = array( 'wins', 'podiums', 'poles', 'championships', 'races' );

    foreach ( $stat_fields as $stat ) {
        $field_name = 'toga_driver_stat_' . $stat;
        if ( isset( $_POST[ $field_name ] ) ) {
            $value = sanitize_text_field( $_POST[ $field_name ] );
            update_post_meta( $post_id, '_toga_driver_stat_' . $stat, $value );
        }
    }
}
add_action( 'save_post_driver', 'toga_racing_save_driver_meta' );

/**
 * Add custom columns to driver admin list
 */
function toga_racing_driver_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb']          = $columns['cb'];
    $new_columns['title']       = $columns['title'];
    $new_columns['driver_photo'] = __( 'Photo', 'toga-racing' );
    $new_columns['driver_number'] = __( '#', 'toga-racing' );
    $new_columns['driver_nationality'] = __( 'Nationality', 'toga-racing' );
    $new_columns['driver_role'] = __( 'Role', 'toga-racing' );
    $new_columns['driver_status'] = __( 'Status', 'toga-racing' );
    $new_columns['date']        = $columns['date'];

    return $new_columns;
}
add_filter( 'manage_driver_posts_columns', 'toga_racing_driver_columns' );

/**
 * Populate custom columns
 */
function toga_racing_driver_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'driver_photo':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
            } else {
                echo '—';
            }
            break;

        case 'driver_number':
            $number = get_post_meta( $post_id, '_toga_driver_number', true );
            echo $number ? esc_html( $number ) : '—';
            break;

        case 'driver_nationality':
            $nationality = get_post_meta( $post_id, '_toga_driver_nationality', true );
            echo $nationality ? esc_html( $nationality ) : '—';
            break;

        case 'driver_role':
            $role = get_post_meta( $post_id, '_toga_driver_role', true );
            echo $role ? esc_html( $role ) : '—';
            break;

        case 'driver_status':
            $status = get_post_meta( $post_id, '_toga_driver_status', true );
            $status_labels = array(
                'active'   => '<span style="color: #00ff0a; font-weight: bold;">Active</span>',
                'inactive' => '<span style="color: #999;">Inactive</span>',
                'reserve'  => '<span style="color: #f0ad4e;">Reserve</span>',
            );
            echo isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : '—';
            break;
    }
}
add_action( 'manage_driver_posts_custom_column', 'toga_racing_driver_column_content', 10, 2 );
