<?php
/* add admin menu for plugin */
function csm_admin_menu()
{
    add_menu_page(__('Coming Soon Mode', 'csm'), __('Coming Soon Mode - Settings', 'csm'), 'activate_plugins', 'csm-settings', 'csm_settings');
    
}
add_action('admin_menu', 'csm_admin_menu');
add_action('wp_footer',  'showfooter');
/* end */

/** register settings */
add_action( 'admin_init', 'register_csm_settings' );

function showfooter(){
    global $post;
    
    $dis_header = get_option('dis_header');
    $dis_footer = get_option('dis_footer');
    $dis_sidebar = get_option('dis_sidebar');
    $loadonly_content = get_option('loadonly_content');
    $getpage = get_option('csm_show_page');
    $pageid = $post->ID;

   
    if ($dis_header == "on" && $pageid == $getpage && !is_user_logged_in()) {
        echo "<style>
     .site-header,#site-header, #header,header{
        display:none !important;
        }
        </style>";

    }
    if ($dis_footer == "on" && $pageid == $getpage && !is_user_logged_in()) {
        echo "<style>
     .site-footer,#site-footer, #footer,footer{
        display:none !important;
        }
        </style>";

    }
    if ($dis_sidebar == "on" && $pageid == $getpage && !is_user_logged_in()) {

        echo "<style>
      .sidebar-main,.sidebar,#sidebar  .site-sidebar,#site-sidebar{
           display:none !important;
           }
           .content-area,#main,#primary{
               width:100% !important;
               margin:0px !important;
           }
           </style>";
   

    }
    if ($loadonly_content == "on" && $pageid == $getpage && !is_user_logged_in()) {
        echo "<style>
     .site-header,#site-header,.sidebar-main, #header,header,#footer,footer,.sidebar,#sidebar  .site-sidebar,#site-sidebar ,.site-footer,#site-footer{
        display:none !important;
        }
        .content-area,#main,#primary{
            width:100% !important;
            margin:0px !important;
        }
        </style>";

    }
}

function register_csm_settings() { 
    register_setting( 'csm-settings', 'csm_show_page' ); 
	register_setting( 'csm-settings', 'csm_mode' );   
    register_setting( 'csm-settings', 'csm_who_can_access' );
    register_setting( 'csm-settings', 'csm_roles' );
    register_setting( 'csm-settings', 'csm_hide_page' );
    register_setting( 'csm-settings', 'includePages' );
    register_setting( 'csm-settings', 'dis_header' );
    register_setting( 'csm-settings', 'dis_footer' );
    register_setting( 'csm-settings', 'dis_sidebar' );
    register_setting( 'csm-settings', 'loadonly_content' );
    


}

/* show settings form */
function csm_settings(){
    global $wpdb;
    $pages = $wpdb->get_results("Select ID, post_title from {$wpdb->posts} where post_type = 'page' and post_status = 'publish'");
?>
    <div class="wrap"><h2><?php _e('Coming Soon Mode Settings', 'obwoos'); ?></h2> </div>
    <div class="wrap">
        <div class="postbox">
            <div class="inside">
                 
                <form method="post" action="options.php" class="csm-option-form">
                    <?php settings_fields( 'csm-settings' ); ?>
                    <?php do_settings_sections( 'csm-settings' ); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php _e('Choose Mode', 'csm'); ?>:</th>
                            <td>  
                                 
                                <?php 
                                $csm_mode = get_option('csm_mode', 'live');
                                                     
                                ?> 
                                <label><input type="radio" name="csm_mode" value="live" <?php echo $csm_mode == 'live' ? 'checked':''; ?> /> <?php _e('Live', 'csm')?></label><br />
                                <label><input type="radio" name="csm_mode" value="maintainance" <?php echo $csm_mode == 'maintainance' ? 'checked':''; ?> /> <?php _e('Maintainance', 'csm')?></label><br />
                                <label><input type="radio" name="csm_mode" value="comming-soon" <?php echo $csm_mode == 'comming-soon' ? 'checked':''; ?> /> <?php _e('Coming Soon', 'csm')?></label><br />
                            </td>
                        </tr>
                        <tr valign="top" class="csm-choose-page" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                            <th scope="row"><?php _e('Choose Page', 'csm'); ?>:</th>
                            <td>  
                                 
                            <?php 
                                    
                            $dropdown_args = array(
                                'post_type'        => 'page', 
                                'selected'         => get_option('csm_show_page'),
                                'name'             => 'csm_show_page', 
                            );
                            wp_dropdown_pages($dropdown_args); 
                            
                            ?> 
                            </td>
                        </tr>
                        <tr valign="top" class="csm-who-can-access" style="display:<?php echo $csm_mode == 'live' ? 'none' : 'table-row'; ?>">
                            <th scope="row"><?php _e('Who Can Access Live Site', 'csm'); ?>:</th>
                            <td>   
                            <?php 
                                $csm_who_can_access = get_option('csm_who_can_access', 'logged');
                                                     
                                ?> 
                                <label><input type="radio" name="csm_who_can_access" value="logged" <?php echo $csm_who_can_access == 'logged' ? 'checked':''; ?> /> <?php _e('All logged-in users', 'csm')?></label><br />
                                <label><input type="radio" name="csm_who_can_access" value="custom" <?php echo $csm_who_can_access == 'custom' ? 'checked':''; ?> /> <?php _e('Custom', 'csm')?></label><br /> 
                                <div style="margin-left: 30px;margin-top: 10px;display:<?php echo $csm_who_can_access == 'logged' ? 'none' : 'block' ?>" class="csm-custom-roles">
                                <?php
                                global $wp_roles;
                                $roles = $wp_roles->roles; 
                                $csm_roles = is_array( get_option('csm_roles')) ? get_option('csm_roles') : array(); 
                                foreach($roles as $role => $role_info){
                                   echo '<label><input type="checkbox" name="csm_roles[]" value="'.$role.'"'. ( in_array($role, $csm_roles) ? 'checked':'' ). ' /> '.$role_info['name'].'</label><br />';
                                }
                                ?>
                                </div>
                            </td>
                        </tr>
<!-- Theme Compatibility part starting from here  -->
                            <th scope="row"><?php _e('Theme Compatibility', 'csm'); ?>:</th>
                        <tr>
                <th scope="row">
                            <td>

<input <?php if (get_option('dis_header')){
                                    echo 'checked="checked"';
                                } ?> name="dis_header"  type="checkbox" />
                        <label for=""><?php _e('Disable Header', 'csm'); ?></label>                            
                    </td>
        </td>
        </tr>
        <th scope="row">
                            <td>
<input <?php if (get_option('dis_footer')){
                                    echo 'checked="checked"';
                                } ?> name="dis_footer"  type="checkbox" />
                        <label for=""><?php _e('Disable Footer', 'csm'); ?></label>                            
                    </td>
        </td>
        </tr>
        <th scope="row">
                            <td>
<input <?php if (get_option('dis_sidebar')){
                                    echo 'checked="checked"';
                                } ?> name="dis_sidebar"  type="checkbox" />
                        <label for=""><?php _e('Disable Sidebar', 'csm'); ?></label>                            
                    </td>
        </td>
        </tr>
        <th scope="row">
                            <td>
<input <?php if (get_option('loadonly_content')){
                                    echo 'checked="checked"';
                                } ?> name="loadonly_content"  type="checkbox" />
                        <label for=""><?php _e('Load Only Content', 'csm'); ?></label>                            
                    </td>
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
    <script>
        jQuery(document).ready(function(){
            jQuery('input[name="csm_mode"]').change(function(){
                let mode = jQuery(this).val();
                 
                if(mode == 'live'){
                    jQuery('.csm-choose-page').hide();
                    jQuery('.csm-who-can-access').hide();
                }
                else{
                    jQuery('.csm-choose-page').css('display','table-row');
                    jQuery('.csm-who-can-access').css('display','table-row');
                }
            })
        })
        jQuery(document).ready(function(){
            jQuery('input[name="csm_who_can_access"]').change(function(){
                let csm_who_can_access = jQuery(this).val();
                 
                if(csm_who_can_access == 'logged'){
                    jQuery('.csm-custom-roles').hide();
                }
                else{
                    jQuery('.csm-custom-roles').show();
                }
            })
        })
        
    </script>

  
<?php
}
 
function cms_admin_style() { 
    echo "
    <style type='text/css'>
    .csm-option-form label {
        display: inline-block;
        margin: 0 0 8px 0;
    }
    </style>
    ";
}
add_action( 'admin_head', 'cms_admin_style' );
