<?php
function csmp_settings_page_html() {
    // if current user have admin access.then only he can acces this page otherwise not
    if(!is_admin()) {
        return;
    }
    ?>
        <div class="wrap">
            <h1><?= esc_html(get_admin_page_title()); ?></h1>
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
    add_menu_page( 'Coming Soon Mode System', 'Coming Soon Mode', 'manage_options', 'csmp-settings', 'csmp_settings_page_html', 'dashicons-hammer', 30 );
}
add_action('admin_menu', 'csmp_register_menu_page');

//This function only for showing Sub-Level Administration Menu
/* function csmp_register_menu_page() {
    add_theme_page( 'CSMP System', 'Coming Soon Mode', 'manage_options', 'csmp-settings', 'csmp_settings_page_html', 30 );
}
add_action('admin_menu', 'csmp_register_menu_page'); */

function csmp_plugin_settings(){

    // register a new section in the "wpac-setings" page
    add_settings_section( 'csmp_label_settings_section', 'What you want to do. Just Select
    ', 'csmp_plugin_settings_section_cb', 'csmp-settings' );

}
add_action('admin_init', 'csmp_plugin_settings');

// Section 
function csmp_plugin_settings_section_cb(){
    echo '<div class="container">
    <div class="field">
      <p class="control">
        <label class="checkbox">
          <input type="checkbox" id="Check1" value="Value1" onclick="selectOnlyThis(this.id)" /> Live
        </label>
      </p>
          <p class="control">
        <label class="checkbox">
          <input type="checkbox" id="Check2" value="Value1" onclick="selectOnlyThis(this.id)" /> Maintenance Mode
        </label>
      </p>
      <p class="control">
        <label class="checkbox">
    <input type="checkbox" id="Check3" value="Value1" onclick="selectOnlyThis(this.id)" /> Coming Soon Mode
        </label>
      </p>
    </div>
  </div>';
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
