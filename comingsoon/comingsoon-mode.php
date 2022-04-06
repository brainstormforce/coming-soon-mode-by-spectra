<?php
/*
* Plugin Name: Comingsoon Mode
* Plugin URI: https://brainstormforce.com/
* Author: Yogesh S
* Author URI: https://brainstormforce.com/
* Description: Website maintenance Mode 
* Version: 1.0.0
* License: GPL2
* Text Domain: csmp
*/

//If this file is called directly, abort.
if (!defined( 'WPINC' )) {
    die;
}

//Define Constants
if ( !defined('CSMP_PLUGIN_VERSION')) {
    define('CSMP_PLUGIN_VERSION', '1.0.0');
}
if ( !defined('CSMP_PLUGIN_DIR')) {
    define('CSMP_PLUGIN_DIR', plugin_dir_url( __FILE__ ));
}

//Include Scripts & Styles
if( !function_exists('csmp_plugin_scripts')) {
    function csmp_plugin_scripts() {
        wp_enqueue_style('csmp-css', CSMP_PLUGIN_DIR. 'assets/css/style.css');
        wp_enqueue_script('csmp-js', CSMP_PLUGIN_DIR. 'assets/js/main.js', 'jQuery', '1.0.0', true );
    }
    add_action('wp_enqueue_scripts', 'csmp_plugin_scripts');
}

//Settings Menu & Page
require plugin_dir_path( __FILE__ ). 'inc/settings.php';
?>