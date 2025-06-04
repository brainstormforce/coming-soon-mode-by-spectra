<?php
/**
 * Admin functionality for Coming Soon Mode by Spectra
 *
 * @package Coming_Soon_Mode_By_Spectra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * CSM_Admin class
 */
class CSM_Admin {

    /**
     * Constructor
     */
    public function __construct() {
        // Add admin menu
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        
        // Register scripts and styles
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            'options-general.php',
            __( 'Coming Soon Mode', 'csm' ),
            __( 'Coming Soon Mode', 'csm' ),
            'manage_options',
            'csm-settings',
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $hook Current admin page.
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'settings_page_csm-settings' !== $hook ) {
            return;
        }

        // Enqueue WordPress components
        wp_enqueue_style( 'wp-components' );
        
        // Enqueue our React app
        $asset_file = include( CSM_PLUGIN_DIR . 'build/index.asset.php' );
        
        wp_enqueue_script(
            'csm-admin-app',
            plugins_url( 'build/index.js', dirname( __FILE__ ) ),
            $asset_file['dependencies'],
            $asset_file['version'],
            true
        );
        
        wp_enqueue_style(
            'csm-admin-styles',
            plugins_url( 'build/index.css', dirname( __FILE__ ) ),
            array( 'wp-components' ),
            $asset_file['version']
        );
        
        // Pass data to our app
        wp_localize_script(
            'csm-admin-app',
            'csm_data',
            array(
                'plugin_url' => plugins_url( '', dirname( __FILE__ ) ),
                'nonce'      => wp_create_nonce( 'wp_rest' ),
                'rest_url'   => esc_url_raw( rest_url() ),
            )
        );
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        ?>
        <div class="wrap">
            <div id="csm-react-root"></div>
        </div>
        <?php
    }
}

// Initialize the admin
new CSM_Admin();
