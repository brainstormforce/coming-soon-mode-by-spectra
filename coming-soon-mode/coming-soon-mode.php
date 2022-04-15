<?php
/**
Plugin Name: BSF - Coming Soon Mode
Plugin URI: https://brainstormforce.com/
Description: Most lightweight WP maintanence and coming soon plugin ever.
Version: 1.0
Author: Brainstromforce
Author URI: https://brainstormforce.com
License: GPLv2 or later
Text Domain: csm
*/
define('CSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); 
require_once( CSM_PLUGIN_DIR . '/admin.php' ); 
/** Load admin settings */
   
add_action('template_redirect', 'csm_redirect');
function csm_redirect(){
    global $post;
    $redirect_page_id = get_option('csm_show_page');  
    if ( is_admin() || (int) $post->ID == (int)$redirect_page_id  ) { 
        /** check if in admin panel or current page = page need redirect => do nothing */
        return;
    }   
      
    $redirect = false;
    $csm_mode = get_option('csm_mode', 'live'); 
    if($csm_mode == 'comming-soon' || $csm_mode == 'maintainance'){
        if(is_user_logged_in()){
            $csm_who_can_access = get_option('csm_who_can_access', 'logged'); 
            
            if( $csm_who_can_access == 'custom'){
                $csm_roles = is_array( get_option('csm_roles')) ? get_option('csm_roles') : array();
                $user = wp_get_current_user();
                $user_role = $user->roles[0];
                if ( !in_array( $user_role, $csm_roles ) ) { 
                    $redirect = true;
                }
            } 
        }
        else{
            $redirect = true;
        }
    }
    if($redirect){
        
        wp_redirect( esc_url( get_page_link( $redirect_page_id ) ) );
        exit;
    } 
}
