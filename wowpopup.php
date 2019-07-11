<?php

/**
 * @link              https://www.wowthemes.net
 * @since             1.0.1
 * @package           Wowpopup
 *
 * @wordpress-plugin
 * Plugin Name:       Wow Popup
 * Plugin URI:        https://www.wowthemes.net/wow_plugins/
 * Description:       Flexible, yet extremely easy to set up WordPress plugin for PopUps, FlyIns and Notice Bars. Boost your sales in no time, convert your visitors to members, watchers, subscribers, you name it! 
 * Version:           1.0.1
 * Author:            WowThemesNet
 * Author URI:        https://www.wowthemes.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wowpopup
 * Domain Path:       /languages
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
        $this->version = '1.0.1';
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


