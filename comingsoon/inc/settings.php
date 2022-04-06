<?php
function csmp_settings_page_html() {
    // if current user have admin access.then only he can acces this page otherwise not
    if(!is_admin()) {
        return;
    }
    ?>
        <div class="wrap">
            <h1 style="padding:10px; background:#333;color:#fff"><?= esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php 
                    settings_fields( 'csmp-settings' );
                    do_settings_sections( 'csmp-settings' );
                    submit_button( 'Save Changes' );
                ?>
            </form>
        </div>
    <?

}

//This function only for showing Top Level Administration Menu
function csmp_register_menu_page() {
    add_menu_page( 'Coming Soon Mode Plugin System', 'Coming Soon Mode', 'manage_options', 'csmp-settings', 'csmp_settings_page_html', 'dashicons-hammer', 30 );
}
add_action('admin_menu', 'csmp_register_menu_page');

//This function only for showing Sub-Level Administration Menu
/* function csmp_register_menu_page() {
    add_theme_page( 'CSMP System', 'Coming Soon Mode', 'manage_options', 'csmp-settings', 'csmp_settings_page_html', 30 );
}
add_action('admin_menu', 'csmp_register_menu_page'); */

function csmp_plugin_settings(){

    // register 2 new settings for "csmp-settings" page
    register_setting( 'csmp-settings', 'cmps_Activate_btn_label' );
    register_setting( 'csmp-settings', 'csmp_Deactivate_btn_label' );

    // register a new section in the "wpac-setings" page
    add_settings_section( 'csmp_label_settings_section', 'CSMP Options', 'csmp_plugin_settings_section_cb', 'csmp-settings' );

    // register a new field in the "csmp-settings" page
    add_settings_field( 'wpac_like_label_field', 'Activate Maintenence Mode', 'csmp_like_label_field_cb', 'csmp-settings', 'csmp_label_settings_section' );
    // register a new field in the "csmp-settings" page
    add_settings_field( 'wpac_dislike_label_field', 'Deactivate Maintenence Mode', 'csmp_deactivate_label_field_cb', 'csmp-settings', 'csmp_label_settings_section' );
}
add_action('admin_init', 'csmp_plugin_settings');

// Section 
function csmp_plugin_settings_section_cb(){
    echo '<h1>What you want to do. Just Select</h1>
    <div class="custom-select" style="width:200px;">
    <select>
      <option value="1">Coming Soon</option>
      <option value="2">Maintainance</option>
      <option value="3">Live</option>
    </select>
  </div> 
    ';
}

// callback function
function csmp_like_label_field_cb(){ 
    $setting = get_option('cmps_activate_btn_label');
    ?>
    <input type="text" name="cmps_activate_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}

function csmp_deactivate_label_field_cb(){ 
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('csmp_deactivae_btn_label');
    // output the field
    ?>
    <input type="text" name="csmp_deactivae_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}