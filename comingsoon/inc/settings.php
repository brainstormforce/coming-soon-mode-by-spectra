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

function csmp_plugin_settings(){
    // register a new section in the "wpac-setings" page
    add_settings_section( 'csmp_label_settings_section', 'Choose Mode', 'csmp_plugin_settings_section_cb', 'csmp-settings' );

}
add_action('admin_init', 'csmp_plugin_settings');

// Section 
function csmp_plugin_settings_section_cb(){
    echo '
    <div class="custom-select" style="width:200px;">
    <select>
     <option value="1">Live</option>
      <option value="2">Coming Soon</option>
      <option value="3">Maintainance</option>
    </select>
    <div>
    <h2>Choose Page</h2>
    <div class="custom-select" style="width:200px;">
    <select>
    <option value="0">Homepage</option>
    <option value="1">About Us</option>
    <option value="2">Contact Us</option>
    <option value="3">Blog</option>
    <option value="4">Review & Deals</option>
    </select>
    </div>
    <div>
    <h2>Who Can Access Live Site</h2>
    <div id="list1" class="dropdown-check-list" tabindex="100">
  <span class="anchor">Custom</span>
  <ul class="items">
    <li><input type="checkbox" />Administrator</li>
    <li><input type="checkbox" />Editor</li>
    <li><input type="checkbox" />Author</li>
    <li><input type="checkbox" />Subscriber</li>
  </ul>
  
</div>
    </div>
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

// <?php
// $page_titles = array();
// $args = array(
//     'post_type' => 'page',
//     'posts_per_page' => -1
// );

// $the_query = new WP_Query( $args ); 

// // If there are pages, let's loop
// if($the_query->have_posts()):  
//     while($the_query->have_posts()):
//         $the_query->the_post(); 
//         $page_titles[] = get_the_title();  // Add each page title to your array
//     endwhile; 

// else : 
//     // Do stuff if no pages
// endif;

// // Display array contents
// echo '<pre>';
// print_r($page_titles);
// echo '</pre>';
// ?