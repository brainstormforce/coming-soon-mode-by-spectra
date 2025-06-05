<?php

/**
 * Coming Soon Mode By Spectra Setting
 *
 * PHP version 7.1
 *
 * @category Components
 * @package  Components
 * @author   Brainstrom Force <username@brainstormforce.com>
 * @license  GPLv2 or later
 * @link     https://brainstormforce.com/
 */

/**
 * Plugin Name: Coming Soon Mode by Spectra
 * Plugin URI: https://wordpress.org/plugins/coming-soon-mode-by-spectra/
 * Description: Lightweight Coming Soon mode plugin to make your website inaccessible to the public while under development or maintenance.
 * Version: 1.0.0
 * Author: Brainstorm Force
 * Author URI: https://brainstormforce.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: csm
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 5.6
 * Tested up to: 6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Define constants
 */
define( 'CSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CSM_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'CSM_PLUGIN_VERSION', '1.0.0' );
define( 'CSM_TEMPLATES_DIR', CSM_PLUGIN_DIR . 'templates/' );

/**
 * Include required files
 */
require_once CSM_PLUGIN_DIR . 'includes/class-csm-admin.php';
require_once CSM_PLUGIN_DIR . 'includes/class-csm-rest-api.php';


/**
 * Load plugin text domain
 */
function csm_load_textdomain() {
    load_plugin_textdomain( 'csm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'csm_load_textdomain' );

/**
 * Check if in admin panel or current page = page need redirect => do nothing
 *
 * @return void
 **/
function csm_redirect() {
    global $post;

    $csm_mode = get_option( 'csm_mode', 'live' );

    if ( $csm_mode === 'comming-soon' || $csm_mode === 'maintainance' ) {
        $template         = get_option( 'csm_template', 'page' );
        $redirect_page_id = get_option( 'csm_show_page' );
        $selected         = (array) get_option( 'csm_show_page' );
        $selected1        = (array) get_option( 'csm_page' );
        $csm_page         = array_merge( $selected, $selected1 );

        if ( is_admin() || ( $post && (int) $post->ID == (int) $redirect_page_id ) || ( $post && in_array( (int) $post->ID, $csm_page ) ) ) {
            return;
        }

        $redirect = false;

        /* if Coming soon or Maintenance mode */
        if ( is_user_logged_in() ) {
            /* if user not login then redirect */
            $csm_who_can_access = get_option( 'csm_who_can_access', 'logged' );
            /* get option  */
            
            if ( $csm_who_can_access == 'custom' ) {
                /* if custom role */
                $csm_roles = is_array( get_option( 'csm_roles' ) ) ? get_option( 'csm_roles' ) : array();
                /* get role list saved in settings */
                $user = wp_get_current_user(); 
                /* get current user info */
                $user_role = $user->roles[0]; 
                /*  current user role */
                if ( ! in_array( $user_role, $csm_roles ) ) {
                    /* if current user role is not in roles list in setting then redirect */
                    $redirect = true; 
                    /* set redirect true */
                }
            } 
        } else {
            $redirect = true; 
            /* set redirect true */
        }

        if ( $redirect ) {
            if ( 'page' === $template && $redirect_page_id ) {
                wp_redirect( esc_url( get_page_link( $redirect_page_id ) ) );
            } else {
                $template_file = CSM_TEMPLATES_DIR . $template . '.php';
                if ( file_exists( $template_file ) ) {
                    include $template_file;
                } else {
                    wp_die( __( 'Coming Soon', 'csm' ) );
                }
            }
            exit;
        }
    }
}
add_action( 'template_redirect', 'csm_redirect' );

/**
 * Add settings link to plugin page
 *
 * @param array $links Plugin action links.
 * @return array
 */
function csm_add_plugin_page_settings_link( $links ) {
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=csm-settings' ) . '">' . __( 'Settings', 'csm' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'csm_add_plugin_page_settings_link' );