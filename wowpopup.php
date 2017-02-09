<?php

/**
 * @link              https://www.wowthemes.net
 * @since             1.0.0
 * @package           Wowpopup
 *
 * @wordpress-plugin
 * Plugin Name:       Wow Popup
 * Plugin URI:        https://www.wowthemes.net/wow_plugins/
 * Description:       Flexible, yet extremely easy to set up WordPress plugin for PopUps, FlyIns and Notice Bars. Boost your sales in no time, convert your visitors to members, watchers, subscribers, you name it! 
 * Version:           1.0.0
 * Author:            WowThemesNet
 * Author URI:        https://www.wowthemes.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wowpopup
 * Domain Path:       /languages
 * @fs_premium_only /public/img/
 */
if ( !defined( 'ABSPATH' ) ) {
    die;
}
// if direct access
// Create a helper function for easy SDK access.
function wow_fs()
{
    global  $wow_fs ;
    
    if ( !isset( $wow_fs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/freemius/start.php';
        $wow_fs = fs_dynamic_init( array(
            'id'             => '732',
            'slug'           => 'wowpopup',
            'type'           => 'plugin',
            'public_key'     => 'pk_916e5afd8b2fb43cb3a09547f3f1e',
            'is_premium'     => false,
            'has_addons'     => false,
            'has_paid_plans' => true,
            'trial'          => array(
            'days'               => 7,
            'is_require_payment' => false,
        ),
            'menu'           => array(
            'slug'    => 'edit.php?post_type=wow_popup_type',
            'support' => false,
        ),
            'is_live'        => true,
        ) );
    }
    
    return $wow_fs;
}

// Init Freemius.
wow_fs();
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
        $this->version = '1.0.0';
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