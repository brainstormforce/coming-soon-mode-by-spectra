<?php
/**
 * REST API Controller for Coming Soon Mode by Spectra
 *
 * @package Coming_Soon_Mode_By_Spectra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * CSM_REST_API class
 */
class CSM_REST_API {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        register_rest_route(
            'csm/v1',
            '/settings',
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_settings' ),
                    'permission_callback' => array( $this, 'permissions_check' ),
                ),
                array(
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => array( $this, 'update_settings' ),
                    'permission_callback' => array( $this, 'permissions_check' ),
                ),
            )
        );

        register_rest_route(
            'csm/v1',
            '/roles',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_roles' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            )
        );
    }

    /**
     * Check if user has permission to access the API
     *
     * @return bool
     */
    public function permissions_check() {
        return current_user_can( 'manage_options' );
    }

    /**
     * Get plugin settings
     *
     * @return WP_REST_Response
     */
    public function get_settings() {
        $settings = array(
            'csm_mode'           => get_option( 'csm_mode', 'live' ),
            'csm_show_page'      => get_option( 'csm_show_page', '' ),
            'csm_page'           => get_option( 'csm_page', array() ),
            'csm_template'       => get_option( 'csm_template', 'page' ),
            'csm_who_can_access' => get_option( 'csm_who_can_access', 'logged' ),
            'csm_roles'          => get_option( 'csm_roles', array() ),
            'csm_appearance'     => get_option( 'csm_appearance', 'loadonly_content' ),
            'dis_header'         => get_option( 'dis_header', false ) === 'on',
            'dis_footer'         => get_option( 'dis_footer', false ) === 'on',
            'dis_sidebar'        => get_option( 'dis_sidebar', false ) === 'on',
        );

        return rest_ensure_response( $settings );
    }

    /**
     * Update plugin settings
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function update_settings( $request ) {
        $params = $request->get_params();

        // Update mode
        if ( isset( $params['csm_mode'] ) ) {
            update_option( 'csm_mode', sanitize_text_field( $params['csm_mode'] ) );
        }

        // Update show page
        if ( isset( $params['csm_show_page'] ) ) {
            update_option( 'csm_show_page', sanitize_text_field( $params['csm_show_page'] ) );
        }

        // Update template
        if ( isset( $params['csm_template'] ) ) {
            update_option( 'csm_template', sanitize_text_field( $params['csm_template'] ) );
        }

        // Update excluded pages
        if ( isset( $params['csm_page'] ) && is_array( $params['csm_page'] ) ) {
            $pages = array_map( 'sanitize_text_field', $params['csm_page'] );
            update_option( 'csm_page', $pages );
        }

        // Update who can access
        if ( isset( $params['csm_who_can_access'] ) ) {
            update_option( 'csm_who_can_access', sanitize_text_field( $params['csm_who_can_access'] ) );
        }

        // Update roles
        if ( isset( $params['csm_roles'] ) && is_array( $params['csm_roles'] ) ) {
            $roles = array_map( 'sanitize_text_field', $params['csm_roles'] );
            update_option( 'csm_roles', $roles );
        }

        // Update appearance
        if ( isset( $params['csm_appearance'] ) ) {
            update_option( 'csm_appearance', sanitize_text_field( $params['csm_appearance'] ) );
        }

        // Update header, footer, sidebar options
        update_option( 'dis_header', isset( $params['dis_header'] ) && $params['dis_header'] ? 'on' : '' );
        update_option( 'dis_footer', isset( $params['dis_footer'] ) && $params['dis_footer'] ? 'on' : '' );
        update_option( 'dis_sidebar', isset( $params['dis_sidebar'] ) && $params['dis_sidebar'] ? 'on' : '' );

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Settings saved successfully!', 'csm' ),
        ) );
    }

    /**
     * Get available user roles
     *
     * @return WP_REST_Response
     */
    public function get_roles() {
        global $wp_roles;
        $all_roles = $wp_roles->roles;
        $roles = array();

        foreach ( $all_roles as $role_id => $role_info ) {
            $roles[ $role_id ] = $role_info['name'];
        }

        return rest_ensure_response( $roles );
    }
}

// Initialize the REST API
new CSM_REST_API();
