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

  
/* Add footer functionality */
add_action('wp_footer', 'showfooter');

/* 
 * Note: The admin menu is now handled by class-csm-admin.php
 * This function is kept for backward compatibility but doesn't register a menu
 */
function csm_admin_menu() 
{
    // Menu registration is now handled by CSM_Admin class
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

/**
 * Define constants
 *
 * @since  1.0.0
 * @return void
 */
function csm_settings()
{
    global $wpdb;
    $pages = $wpdb->get_results("Select ID, post_title from {$wpdb->posts} where post_type = 'page' and post_status = 'publish'");
    ?>
    <div class="wrap">
</div>
    <div class="wrap">

    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo plugin_dir_url( __FILE__ ) . 'js/custom.js'?>"></script>
<link href="<?php echo plugin_dir_url( __FILE__ ) . 'css/admin.css'?>" rel="stylesheet" />

  
<?php
}
