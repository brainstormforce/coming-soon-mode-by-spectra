<?php
/**
 * Signup handling for Coming Soon Mode by Spectra
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class CSM_Signup {
    public function __construct() {
        add_action( 'init', array( $this, 'register_cpt' ) );
        add_action( 'wp_ajax_csm_signup', array( $this, 'handle_signup' ) );
        add_action( 'wp_ajax_nopriv_csm_signup', array( $this, 'handle_signup' ) );
    }

    public function register_cpt() {
        register_post_type( 'csm_signup', array(
            'public'       => false,
            'show_ui'      => false,
            'supports'     => array( 'title', 'custom-fields' ),
            'capability_type' => 'post',
        ) );
    }

    public function handle_signup() {
        check_ajax_referer( 'csm_signup', 'nonce' );

        $name  = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
        $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

        if ( empty( $email ) ) {
            wp_send_json_error( __( 'Invalid email', 'csm' ) );
        }

        $post_id = wp_insert_post( array(
            'post_type'   => 'csm_signup',
            'post_title'  => $email,
            'post_status' => 'publish',
        ) );

        if ( $post_id ) {
            update_post_meta( $post_id, 'name', $name );
            wp_send_json_success();
        }

        wp_send_json_error();
    }
}

new CSM_Signup();
