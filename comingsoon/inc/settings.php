<?php

//This function only for showing Top Level Administration Menu
function csmp_register_menu_page() {
    add_menu_page( 'Coming Soon Mode System', 'Coming Soon Mode', 'manage_options', 'csmp-settings', 'csmp_settings_page_html', 'dashicons-hammer', 30 );
}
add_action('admin_menu', 'csmp_register_menu_page');

// maintenance mode code
function maintenance_mode() {
  if ( !current_user_can( 'administrator' ) ) {
    wp_die('Thanks for visiting Brainstronforce site, But We are doing some maintenance work. So Please Visit after some time .');
  }
}
add_action('get_header', 'maintenance_mode');

// 

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
                ?>
            </form>
        </div>
<!-- chooes page for display -->
    <div style="margin-top: 10px;">
    <h2>Choose Page</h2>
        <select name="page-dropdown"
    onchange=''> 
    <option value=""><?php echo attribute_escape(__('Choose page')); ?></option> 
    <?php 
        $pages = get_pages(); 
        foreach ($pages as $pagg) {
            $option = '<option value="'.get_page_link($pagg->ID).'">';
            $option .= $pagg->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
    </div>
    <!--  -->
    
    <!-- for custom option to allow who's able to accesse the live site  -->
    <div style="margin-top: 10px;">
    <h2>Who Can Access Live Site</h2>
    <select type="checkbox" id="roles" name="roles" class="fre-chosen-single">
  <?php
     foreach (get_editable_roles() as  $role_name => $role_info) {
       echo '<option value="'.$role_name.'">' . $role_info['name'] . '</option>';
     }?>
  </select>
    </div>

    <div>
        <h2>Theme Compatibility</h2>
        <form action="/action_page.php">
  <input type="checkbox">
  <label for="vehicle1">Disable Header</label><br>
  <input type="checkbox">
  <label for="vehicle1">Disable Footer</label><br>
  <input type="checkbox">
  <label for="vehicle1">Disable Sidebar</label><br>
  <input type="checkbox">
  <label for="vehicle1">Load only Content Area</label>
</form>
    </div>
<!--  -->

    <?
        submit_button( 'Save Changes' );
}



function csmp_plugin_settings(){
    // register a new section in the "wpac-setings" page
    add_settings_section( 'csmp_label_settings_section', 'Choose Mode', 'csmp_plugin_settings_section_cb', 'csmp-settings' );

}
add_action('admin_init', 'csmp_plugin_settings');

// Section 
function csmp_plugin_settings_section_cb(){
    echo '
    <div class="custom-select" style="width:100%;">
    <select>
     <option value="1">Live</option>
      <option value="2">Coming Soon</option>
      <option value="3">Maintainance</option>
    </select>
    </div> 
    ';
}

