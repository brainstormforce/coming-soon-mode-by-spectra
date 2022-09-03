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
add_action('admin_menu', 'csm_admin_menu');
add_filter('body_class',  'showfooter');
/* end */
/*dd code*/
add_action("admin_menu", "csm_admin_menu");
  
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
     * @param object $classes classes object.
     * 
     * @return void
     */
function showfooter($classes)
{
    global $post;
    $dis_header = get_option('dis_header');
    $dis_more_option= get_option('dis_more_option');
    $dis_footer = get_option('dis_footer');
    $dis_sidebar = get_option('dis_sidebar');
    $loadonly_content = get_option('csm_appearance');
    $getpage = get_option('csm_show_page');
    $pageid = $post->ID;
    $selected=(array) get_option('csm_show_page');
    $selected1=(array)get_option('csm_page');
    $csm_page = array_merge($selected, $selected1);
    if ($dis_header == "on" && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        $classes[] = 'header-hide';
    }
    if ($dis_footer == "on"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        $classes[] = 'footer-hide';
    }
    if ($dis_sidebar == "on"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        $classes[] = 'siderbar-hide';
    }
    if ($loadonly_content == "loadonly_content"  && !is_user_logged_in() && in_array($pageid, $csm_page)) {
        $classes[] = 'content-only';
    }
    
    return $classes;
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
    <div class="wrap"><h2><?php _e('Coming Soon Mode By Spectra', 'obwoos'); ?>
</h2> 
</div>
    <div class="wrap">
        <div class="postbox">
            <div class="error-msg"><?php //settings_errors(); ?></div>
            <div class="inside"> 
                <form method="post" action="options.php" class="csm-option-form">
                    <?php settings_fields('csm-settings'); ?>
                    <?php do_settings_sections('csm-settings'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php _e('Select Mode', 'csm'); ?></th>
                            <td>       
                                <?php 
                                $csm_mode = get_option('csm_mode', 'live');
                                ?> 
                                <label><input type="radio" name="csm_mode" value="live" <?php echo $csm_mode == 'live' ? 'checked':''; ?> /> <?php _e('Live', 'csm')?>
                                <p  class="description">If Live is selected then a website is visible for all. </p>
                                </label><br />
                               <!-- <label><input type="radio" name="csm_mode" value="maintainance" <?php echo $csm_mode == 'maintainance' ? 'checked':''; ?> /> <?php _e('Maintainance', 'csm')?></label><br />-->
                                <label><input type="radio" name="csm_mode" value="comming-soon" <?php echo $csm_mode == 'comming-soon' ? 'checked':''; ?> /> <?php _e('Coming Soon', 'csm')?>
                                <p  class="description">If Coming Soon is selected then the site visitors will redirect to the dedicated page.</p>
                                </label><br />
                            </td>
                        </tr>
                        <tr valign="top" class="csm-choose-page" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                            <th scope="row"><?php _e('Select Page', 'csm'); ?></th>
                            <td>  
                                 
                            <?php 
                                    
                            $dropdown_args = array(
                                'post_type'        => 'page', 
                                'selected'         => get_option('csm_show_page'),
                                'name'             => 'csm_show_page', 
                            );
                            wp_dropdown_pages($dropdown_args);  
                            ?> 
                            <p class="description">The site visitors will be redirected to the selected page if Coming Soon mode is active.</p>
                            </td>
                        </tr>
                        <tr valign="top" class="csm-choose-page" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                            <th scope="row"><?php _e('Exclude pages', 'csm'); ?></th>
                            <td>  
                                 
                            <select multiple="multiple" id="csm_page" name="csm_page[]">
                                <?php //echo esc_attr( __( 'Select page' ) ); ?></option> 
                                <?php 
                                
                                //$selected=array();
                                $selected=(array) get_option('csm_show_page');
                                $selected1=(array)get_option('csm_page');$f=array_merge($selected, $selected1);

                                $pages1 = get_pages(); 
                                
                                foreach ( $pages1 as $page ) {
                                    ?>
                                <option <?php if(in_array($page->ID, $f) ) {?> selected="selected" <?php } ?>
                                value=" <?php echo $page->ID; ?>"><?php echo $page->post_title;
                                ?></option>
                                <?php } ?>
                                </select>
                                <p class="description">The site visitors will be able to access selected page even Coming Soon mode is active.</p>
                            </td>
                        </tr>
                        <tr valign="top" class="csm-who-can-access" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                            <th scope="row"><?php _e('Live Site Access', 'csm'); ?></th>
                            <td>   
                            <?php 
                                $csm_who_can_access = get_option('csm_who_can_access', 'logged');
                                                     
                            ?> 
                                <label><input type="radio" name="csm_who_can_access" value="logged" <?php echo $csm_who_can_access == 'logged' ? 'checked':''; ?> /> <?php _e('All logged-in users', 'csm')?></label><br /><p></p>
                                <label><input type="radio" name="csm_who_can_access" value="custom" <?php echo $csm_who_can_access == 'custom' ? 'checked':''; ?> /> <?php _e('Custom', 'csm')?></label><br /> 									
                                <div style="margin-left: 30px;margin-top: 10px;display:<?php echo $csm_who_can_access == 'logged' ? 'none' : 'block' ?>" class="csm-custom-roles">
                                <?php
                                global $wp_roles;
                                $roles = $wp_roles->roles; 
                                $csm_roles = is_array(get_option('csm_roles')) ? get_option('csm_roles') : array(); 
                                foreach($roles as $role => $role_info){
                                    echo '<label><input type="checkbox" name="csm_roles[]" value="'.$role.'"'. ( in_array($role, $csm_roles) ? 'checked':'' ). ' /> '.$role_info['name'].'</label><br />';
                                }
                                ?>
                                </div>
                                <p  class="description">Select the users who can access the live site even Coming Soon mode is activated.</p>
                            </td>
                        </tr>              
                        <tr class="theme-compatibility" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                        <th scope="row">Page Appearance</th><td>
                        
                            <?php 
                            $loadonly_content = get_option('csm_appearance');
                            ?>
                            
                            <label><input type="radio" class="dis_more_option" name="csm_appearance" value="loadonly_content" <?php echo $loadonly_content == 'loadonly_content' ? 'checked':''; ?> /> 
                            <?php _e('Display Page Content Only', 'csm')?></label><br 
                            ><p></p>
                            <label><input type="radio" class="dis_more_option" name="csm_appearance" value="dis_more_option" 
                            <?php echo $loadonly_content == 'dis_more_option' ? 'checked':''; ?> /> <?php _e('More Custom Options', 'csm')?></label>									
                            <div class="chk_con" style="margin-left: 30px;margin-top: 10px;">
                            <!--<label for="">
                                <input <?php if (get_option('loadonly_content')) {
                                    echo 'checked="checked"';
                               } 
                                        ?> name="loadonly_content"  type="checkbox" />
                                        <?php _e('Display Page Content Only', 'csm'); ?></label>
                        <br />
                        <p></p>
                        <label for="">
                        <input class="dis_more_option" <?php if (get_option('dis_more_option')) {
                            echo 'checked="checked"';
                                                       } ?> name="dis_more_option" value="chk_con"  type="checkbox" />
                            <?php _e('More Custom Options', 'csm'); ?></label>-->                            
                        
                        
                        <label class="chk_con" for="">
                            <input <?php if (get_option('dis_header')) {
                                echo 'checked="checked"';
                                } ?> name="dis_header"  type="checkbox" />
                            <?php _e('Disable Header', 'csm'); ?></label>                            
                        <br />   
                        
                        <label class="chk_con" for=""><input <?php if (get_option('dis_footer')) {
                            echo 'checked="checked"';
                                                             } ?> 
                                                             name="dis_footer"  type="checkbox" />
                            <?php _e('Disable Footer', 'csm'); ?></label>                            
                            <br />
                            <label class="chk_con" for="">
                            <input <?php if (get_option('dis_sidebar')) {
                                    echo 'checked="checked"';
                                    } ?> name="dis_sidebar"  type="checkbox" />
                                    <?php _e('Disable Sidebar', 'csm'); ?></label></div>	
                                <p  class="description">Make the selected page more interactive by controlling the website components.</p>
                            </td>
                        </tr>
</tbody>
</table>
</table>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
    </div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) . 'js/custom.js'?>"></script>
<link href="<?php echo plugin_dir_url(__FILE__) . 'css/admin.css'?>" rel="stylesheet" />  
    <?php
}