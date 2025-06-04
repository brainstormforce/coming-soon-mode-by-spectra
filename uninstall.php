<?php
/**
 * Uninstall Coming Soon Mode by Spectra
 *
 * @package Coming_Soon_Mode_By_Spectra
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete all plugin options
delete_option( 'csm_mode' );
delete_option( 'csm_show_page' );
delete_option( 'csm_page' );
delete_option( 'csm_who_can_access' );
delete_option( 'csm_roles' );
delete_option( 'csm_appearance' );
delete_option( 'dis_header' );
delete_option( 'dis_footer' );
delete_option( 'dis_sidebar' );
