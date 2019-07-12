<?php
/*
Plugin Name: Wow Popup
Plugin URI: https://www.wowthemes.net/wowplugins/wowpopup-wp-plugin/
Description: Flexible, yet extremely easy to set up WordPress plugin for PopUps, FlyIns and Notice Bars. Boost your sales in no time, convert your visitors to members, watchers, subscribers, you name it! 
Version: 1.0.3
Author: WowThemes
Author URI: https://www.wowthemes.net
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
GitHub Plugin URI: https://github.com/wowthemesnet/wowpopup
*/
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class WowPopupPlugin
{
    private  $plugin_name ;
    private  $plugin_path ;
    private  $plugin_url ;
    private  $version ;
    public function __construct()
    {
        // Set up default vars
        $this->plugin_name = 'wowpopup';
        $this->version = '1.0.3';
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        // Set up activation hooks
        register_activation_hook( __FILE__, array( &$this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
        // Set up l10n
        load_plugin_textdomain( 'wowpopup', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
        // Add your own hooks/filters
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'init', array( &$this, 'init' ) );
        
    }
    
    //  Load Public CSS
    public function enqueue_styles()
    {
        wp_register_style(
            $this->plugin_name . '-maincss',
            plugin_dir_url( __FILE__ ) . 'public/css/wowpopup.min.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style( $this->plugin_name . '-maincss' );
    }
    
    public function activate( $network_wide )
    {
      
    }
    
    public function deactivate( $network_wide )
    {
    }
    
    public function init()
    {
        if ( !is_admin() ) {
            require plugin_dir_path( __FILE__ ) . 'public/wowpopup-display.php';
        }
    }

    

}
require plugin_dir_path( __FILE__ ) . 'includes/wowpopup-posttype.php';
new WowPopupPlugin();

//  Welcome Page

include plugin_dir_path( __FILE__ ) . 'includes/welcome.php';

register_activation_hook( __FILE__, 'wowpopup_welcome_screen_activate' );
function wowpopup_welcome_screen_activate() {
  set_transient( '_welcome_screen_activation_redirect', true, 30 );
}

add_action( 'admin_init', 'wowpopup_welcome_screen_do_activation_redirect' );
function wowpopup_welcome_screen_do_activation_redirect() {

    if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
        return;
    }

    delete_transient( '_welcome_screen_activation_redirect' );

    if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
        return;
    }

    wp_safe_redirect( add_query_arg( array( 'page' => 'wowpopup_options' ), admin_url( 'edit.php?post_type=wow_popup_type&' ) ) );
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function my_theme_register_required_plugins() {
	$plugins = array(		
		array(
			'name'   => 'Github Updater',
			'slug'   => 'github-updater',
			'source' => 'https://github.com/afragen/github-updater/archive/develop.zip',
		),
	);
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
    tgmpa( $plugins, $config );
}