<?php

 /**
  * This is admin file of coming soon mode plugin.
  * php version 7.4.1

  * @category Components
  * @package  Components
  * @author   Brainstrom Force <username@example.com>
  * @license  GPLv2 or later
  * @link     https://brainstormforce.com/
  */

  
/* add admin menu for plugin */
function csm_admin_menu1()
{
   // add_menu_page(__('Coming Soon Mode', 'csm'), __('Coming Soon Mode - Settings', 'csm'), 'activate_plugins', 'csm-settings', 'csm_settings');
    
}
add_action('admin_menu', 'csm_admin_menu');
add_action('wp_footer',  'showfooter');
/* end */
/*dd code*/
add_action("admin_menu", "csm_admin_menu");
add_action('admin_enqueue_scripts', 'csm_enqueue_admin_assets');
add_action('rest_api_init', 'csm_register_rest');
  
/**
 * This is an example function

 * @return void
 */
function csm_admin_menu()
{
    add_submenu_page(
        'options-general.php',
        '',
        'Coming Soon Mode',
        'administrator',
        'csm-settings',
        'csm_settings'
    );
}

/*DD code
/** Register settings for plugin setting page
*/
add_action('admin_init', 'register_csm_settings');

    /**
     * Define constants showfooter
     *
     * @since  1.0.0
     * @return void
     */
function showfooter()
{
    global $post;
    $dis_header = get_option('dis_header');
    $dis_more_option= get_option('dis_more_option');$dis_footer = get_option('dis_footer');
    $dis_sidebar = get_option('dis_sidebar');
    $loadonly_content = get_option('csm_appearance');
    $getpage = get_option('csm_show_page');
    $pageid = $post->ID;
    
    $selected=(array) get_option('csm_show_page');
    $selected1=(array)get_option('csm_page');
    $csm_page = array_merge($selected, $selected1);


    if ($dis_header == "on" && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        ?>
        <link href="<?php echo plugin_dir_url( __FILE__ ) . 'css/admin1.css'?>" rel="stylesheet" />
        <?php 
    }

    if ($dis_footer == "on"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        ?>
        <link href="<?php echo plugin_dir_url( __FILE__ ) . 'css/admin2.css'?>" rel="stylesheet" />
        <?php

    }

    if ($dis_sidebar == "on"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {

       ?>
        <link href="<?php echo plugin_dir_url( __FILE__ ) . 'css/admin3.css'?>" rel="stylesheet" />
        <?php

    }
    if ($loadonly_content == "loadonly_content"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        ?>
        <link href="<?php echo plugin_dir_url( __FILE__ ) . 'css/admin4.css'?>" rel="stylesheet" />
        <?php

    }
}

/**
 * Define constants
 *
 * @since  1.0.0
 * @return void
 */
function register_csm_settings()
{
    register_setting('csm-settings', 'csm_show_page'); register_setting('csm-settings', 'csm_mode');   
    register_setting('csm-settings', 'csm_who_can_access');
    register_setting('csm-settings', 'csm_roles');
    register_setting('csm-settings', 'csm_hide_page');
    register_setting('csm-settings', 'includePages');register_setting('csm-settings', 'dis_more_option');register_setting('csm-settings', 'dis_header');
    register_setting('csm-settings', 'dis_footer');
    register_setting('csm-settings', 'dis_sidebar');
    register_setting('csm-settings', 'csm_appearance');
    register_setting('csm-settings', 'csm_page');
}

function csm_enqueue_admin_assets($hook)
{
    if ('settings_page_csm-settings' !== $hook) {
        return;
    }

    wp_enqueue_script(
        'csm-admin-dashboard',
        plugin_dir_url(__FILE__) . 'js/admin-dashboard.js',
        array('wp-element', 'wp-components', 'wp-api-fetch'),
        '1.0.0',
        true
    );

    $settings = array(
        'csm_mode'          => get_option('csm_mode', 'live'),
        'csm_show_page'     => get_option('csm_show_page'),
        'csm_page'          => (array) get_option('csm_page'),
        'csm_who_can_access'=> get_option('csm_who_can_access', 'logged'),
        'csm_roles'         => (array) get_option('csm_roles'),
        'dis_header'        => get_option('dis_header'),
        'dis_footer'        => get_option('dis_footer'),
        'dis_sidebar'       => get_option('dis_sidebar'),
        'csm_appearance'    => get_option('csm_appearance'),
        'roles'             => wp_roles()->roles,
        'pages'             => get_pages(array('post_status' => 'publish')),
        'nonce'             => wp_create_nonce('csm_save_settings'),
    );

    wp_localize_script('csm-admin-dashboard', 'csmSettings', $settings);
}

function csm_register_rest()
{
    register_rest_route(
        'csm/v1',
        '/settings',
        array(
            'methods'  => 'POST',
            'callback' => 'csm_save_settings',
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
        )
    );
}

function csm_save_settings($request)
{
    $params = $request->get_json_params();

    update_option('csm_mode', sanitize_text_field($params['csm_mode']));
    update_option('csm_show_page', intval($params['csm_show_page']));
    update_option('csm_page', array_map('intval', (array) $params['csm_page']));
    update_option('csm_who_can_access', sanitize_text_field($params['csm_who_can_access']));
    update_option('csm_roles', array_map('sanitize_text_field', (array) $params['csm_roles']));
    update_option('csm_appearance', sanitize_text_field($params['csm_appearance']));
    update_option('dis_header', sanitize_text_field($params['dis_header']));
    update_option('dis_footer', sanitize_text_field($params['dis_footer']));
    update_option('dis_sidebar', sanitize_text_field($params['dis_sidebar']));

    return array('success' => true);
}

/**
 * Define constants
 *
 * @since  1.0.0
 * @return void
 */
function csm_settings()
{
    ?>
    <div class="wrap">
        <div id="csm-admin-app"></div>
    </div>
    <?php
}
 
/**
 * This is cms admin style css
 *
 * @return void
 */	
/*function cms_admin_style() { 
 
    echo "
    <style type='text/css'>
    .postbox{
	border: none !important;
	background: none !important;
	box-shadow: none !important;
	}
	.csm-option-form label {
        display: inline-block;
        margin: 0 0 8px 0;
    }
	.select2{
width: 200px !important;
max-width:100%;
}
    </style>
    ";
}
add_action('admin_head', 'cms_admin_style');*/