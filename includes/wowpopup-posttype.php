<?php

if ( !defined( 'ABSPATH' ) ) {
    die;
}
// if direct access
//======================================================================
// Wow Popup Post Type
//======================================================================
function wow_popup_type()
{
    $labels = array(
        'name'                  => _x( 'Wow Popups', 'Post Type General Name', 'wowpopup' ),
        'singular_name'         => _x( 'Wow Popup', 'Post Type Singular Name', 'wowpopup' ),
        'menu_name'             => __( 'Wow Popup', 'wowpopup' ),
        'name_admin_bar'        => __( 'Wow Popup', 'wowpopup' ),
        'archives'              => __( 'Item Archives', 'wowpopup' ),
        'parent_item_colon'     => __( 'Parent Item:', 'wowpopup' ),
        'all_items'             => __( 'View All Popups', 'wowpopup' ),
        'add_new_item'          => __( 'Create New Popup', 'wowpopup' ),
        'add_new'               => __( 'Create New Popup', 'wowpopup' ),
        'new_item'              => __( 'New Item', 'wowpopup' ),
        'edit_item'             => __( 'Edit Item', 'wowpopup' ),
        'update_item'           => __( 'Update Item', 'wowpopup' ),
        'view_item'             => __( 'View Item', 'wowpopup' ),
        'search_items'          => __( 'Search Item', 'wowpopup' ),
        'not_found'             => __( 'Not found', 'wowpopup' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'wowpopup' ),
        'featured_image'        => __( 'Featured Image', 'wowpopup' ),
        'set_featured_image'    => __( 'Set featured image', 'wowpopup' ),
        'remove_featured_image' => __( 'Remove featured image', 'wowpopup' ),
        'use_featured_image'    => __( 'Use as featured image', 'wowpopup' ),
        'insert_into_item'      => __( 'Insert into item', 'wowpopup' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'wowpopup' ),
        'items_list'            => __( 'Items list', 'wowpopup' ),
        'items_list_navigation' => __( 'Items list navigation', 'wowpopup' ),
        'filter_items_list'     => __( 'Filter items list', 'wowpopup' ),
    );
    $args = array(
        'label'               => __( 'Wow Popup', 'wowpopup' ),
        'description'         => __( 'Post Type Description', 'wowpopup' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 10,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'wow_popup_type', $args );
}

add_action( 'init', 'wow_popup_type' );
class WowPopup_Meta_Box
{
    private  $screens = array( 'wow_popup_type' ) ;
    private  $fields = array(
        array(
        'id'    => 'popup-title',
        'label' => '<span class="metaboxfirsthead"> <b>Popup Content</b> (first, make sure you have added your content above and set a featured image)</span><hr><span class="afterhead">Popup Title</span>',
        'type'  => 'text',
    ),
        array(
        'id'    => 'button-text',
        'label' => 'Button Text',
        'type'  => 'text',
    ),
        array(
        'id'    => 'button-url',
        'label' => 'Action Link',
        'type'  => 'url',
    ),
        array(
        'id'      => 'select-button-target-link',
        'label'   => 'Open Action Link',
        'type'    => 'select',
        'options' => array(
        '_self'  => 'Same Window',
        '_blank' => 'New Window',
    ),
    ),
        array(
        'id'      => 'select-text-align',
        'label'   => 'Text Align',
        'type'    => 'select',
        'options' => array( 'left', 'center', 'right' ),
    ),
        array(
        'id'      => 'select-image-align',
        'label'   => 'Layout',
        'type'    => 'select',
        'options' => array(
        'defl' => 'Default (top image + bottom content)',
    ),
    ),
        array(
        'id'      => 'show-popup-entryorexit',
        'label'   => '<span class="metaboxfirsthead">Main Options</span><hr><span class="afterhead">Display popup</span>',
        'type'    => 'select',
        'options' => array(
        'onentry' => 'On Entry - visitor enters website',
    ),
    ),
        array(
        'id'      => 'show-popup-after',
        'label'   => 'If "entry popup" option selected, set popup delay in seconds.',
        'type'    => 'number',
        'default' => '5',
    ),
        array(
        'id'      => 'show-popup-when-again',
        'label'   => 'How often will the popup open? For testing purposes, use "all time".',
        'type'    => 'select',
        'options' => array(
        'onesession' => 'Once per session (if the user closes the popup, it will appear on their next visit)',
        'alltime'    => 'All the time (recommended for top/bottom bars only)',
    ),
    ),
        array(
        'id'      => 'select-position',
        'label'   => 'Popup Position (Simple top & bottom bars will not display images.)',
        'type'    => 'select',
        'options' => array(
        'StayInMiddle' => 'Middle (default, with overlay)',
        'FlyInLeft'    => 'FlyIn Left',
    ),
    ),
        array(
        'id'      => 'popup-width',
        'label'   => 'Popup Width (enter number, recommended at least 500)',
        'type'    => 'number',
        'default' => '600',
    ),
        array(
        'id'      => 'popup-animation',
        'label'   => 'Animation',
        'type'    => 'select',
        'options' => array( 'fadeInLeft' ),
    ),
        array(
        'id'      => 'popup-box-color',
        'label'   => '<span class="metaboxfirsthead">Customize your popup style here (optional, not required)</span><hr> <span class="afterhead">Popup Box Background Color</span>',
        'type'    => 'color',
        'default' => '#ffffff',
    ),
        array(
        'id'      => 'title-color',
        'label'   => 'Title Color',
        'type'    => 'color',
        'default' => '#000000',
    ),
        array(
        'id'      => 'content-color',
        'label'   => 'Content Text Color',
        'type'    => 'color',
        'default' => '#999999',
    ),
        array(
        'id'      => 'links-color',
        'label'   => 'Content Links Color',
        'type'    => 'color',
        'default' => '#999999',
    ),
        array(
        'id'      => 'button-bg-color',
        'label'   => 'Button Background Color',
        'type'    => 'color',
        'default' => '#5fba7d',
    ),
        array(
        'id'      => 'button-text-color',
        'label'   => 'Button Text Color',
        'type'    => 'color',
        'default' => '#ffffff',
    ),
        array(
        'id'    => 'button-flat',
        'label' => 'Button Flat',
        'type'  => 'checkbox',
    ),
        array(
        'id'    => 'button-round',
        'label' => 'Button Round',
        'type'  => 'checkbox',
    ),
        array(
        'id'    => 'button-ghost',
        'label' => 'Button Ghost',
        'type'  => 'checkbox',
    ),
        array(
        'id'      => 'close-bg-color',
        'label'   => 'Close Badge Background Color',
        'type'    => 'color',
        'default' => '#333333',
    ),
        array(
        'id'      => 'close-icon-color',
        'label'   => 'Close Badge Text Color',
        'type'    => 'color',
        'default' => '#ffffff',
    ),
        array(
        'id'      => 'overlay-color',
        'label'   => 'Overlay Background Color',
        'type'    => 'color',
        'default' => '#000000',
    ),
        array(
        'id'    => 'overlay-opacity',
        'label' => 'Overlay Bg Opacity (Enter a value between 0.1 to 0.9 or enter 1 to remove transparency completely.)',
        'type'  => 'text',
    )
    ) ;
    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }
    
    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes()
    {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'wow-popup-options',
                __( 'WOW POPUP SETTINGS<br/><br/> Set your options here, then hit the publish / update button.', 'wowpopup' ),
                array( $this, 'add_meta_box_callback' ),
                $screen,
                'advanced',
                'high'
            );
        }
    }
    
    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post )
    {
        wp_nonce_field( 'wow_popup_options_data', 'wow_popup_options_nonce' );
        $this->generate_fields( $post );
    }
    
    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post )
    {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'wow_popup_options_' . $field['id'], true );
            switch ( $field['type'] ) {
                case 'checkbox':
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="checkbox" value="1">',
                        ( $db_value === '1' ? 'checked' : '' ),
                        $field['id'],
                        $field['id']
                    );
                    break;
                case 'select':
                    $input = sprintf( '<select id="%s" name="%s">', $field['id'], $field['id'] );
                    foreach ( $field['options'] as $key => $value ) {
                        $field_value = ( !is_numeric( $key ) ? $key : $value );
                        $input .= sprintf(
                            '<option %s value="%s">%s</option>',
                            ( $db_value === $field_value ? 'selected' : '' ),
                            $field_value,
                            $value
                        );
                    }
                    $input .= '</select>';
                    break;
                case 'color':
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        ( $field['type'] !== 'color' ? 'class="regular-text"' : '' ),
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        ( !empty($db_value) || $db_value === '0' ? $db_value : $field['default'] )
                    );
                    break;
                case 'number':
                    $input = sprintf(
                        '<input id="%s" name="%s" type="%s" value="%s">',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        ( !empty($db_value) || $db_value === '0' ? $db_value : $field['default'] )
                    );
                    break;
                default:
                    $input = sprintf(
                        '<input class="widefat" id="%s" name="%s" type="%s" value="%s">',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= '<p>' . $label . '<br>' . $input . '</p>';
        }
        echo  $output ;
    }
    
    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id )
    {
        if ( !isset( $_POST['wow_popup_options_nonce'] ) ) {
            return $post_id;
        }
        $nonce = $_POST['wow_popup_options_nonce'];
        if ( !wp_verify_nonce( $nonce, 'wow_popup_options_data' ) ) {
            return $post_id;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        foreach ( $this->fields as $field ) {
            
            if ( isset( $_POST[$field['id']] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[$field['id']] = sanitize_email( $_POST[$field['id']] );
                        break;
                    case 'text':
                        $_POST[$field['id']] = sanitize_text_field( $_POST[$field['id']] );
                        break;
                }
                update_post_meta( $post_id, 'wow_popup_options_' . $field['id'], $_POST[$field['id']] );
            } else {
                if ( $field['type'] === 'checkbox' ) {
                    update_post_meta( $post_id, 'wow_popup_options_' . $field['id'], '0' );
                }
            }
        
        }
    }

}
new WowPopUp_Meta_Box();
/**
 * Meta for individual page/posts, where hide option could be checked
 */
class WowPopupHide_Meta_Box
{
    private  $screens = array( 'post', 'page' ) ;
    private  $fields = array( array(
        'id'    => 'hide-wowpopup-on-this-page',
        'label' => 'Hide WowPopup on this Page',
        'type'  => 'checkbox',
    ) ) ;
    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }
    
    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes()
    {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'wowpopup-hide',
                __( 'WowPopup Hide', 'wowpopup' ),
                array( $this, 'add_meta_box_callback' ),
                $screen,
                'side',
                'high'
            );
        }
    }
    
    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post )
    {
        wp_nonce_field( 'wowpopup_hide_data', 'wowpopup_hide_nonce' );
        $this->generate_fields( $post );
    }
    
    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post )
    {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'wowpopup_hide_' . $field['id'], true );
            switch ( $field['type'] ) {
                case 'checkbox':
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="checkbox" value="1">',
                        ( $db_value === '1' ? 'checked' : '' ),
                        $field['id'],
                        $field['id']
                    );
                    break;
                default:
                    $input = sprintf(
                        '<input id="%s" name="%s" type="%s" value="%s">',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= '<p>' . $label . '<br>' . $input . '</p>';
        }
        echo  $output ;
    }
    
    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id )
    {
        if ( !isset( $_POST['wowpopup_hide_nonce'] ) ) {
            return $post_id;
        }
        $nonce = $_POST['wowpopup_hide_nonce'];
        if ( !wp_verify_nonce( $nonce, 'wowpopup_hide_data' ) ) {
            return $post_id;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        foreach ( $this->fields as $field ) {
            
            if ( isset( $_POST[$field['id']] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[$field['id']] = sanitize_email( $_POST[$field['id']] );
                        break;
                    case 'text':
                        $_POST[$field['id']] = sanitize_text_field( $_POST[$field['id']] );
                        break;
                }
                update_post_meta( $post_id, 'wowpopup_hide_' . $field['id'], $_POST[$field['id']] );
            } else {
                if ( $field['type'] === 'checkbox' ) {
                    update_post_meta( $post_id, 'wowpopup_hide_' . $field['id'], '0' );
                }
            }
        
        }
    }

}
new WowPopupHide_Meta_Box();
add_action( 'admin_head', 'wowpopup_custom_fonts' );
function wowpopup_custom_fonts()
{
    echo  '<style>
#wow-popup-options label, #wow-popup-options .afterhead  {color:#333;position:relative; font-weight:400;padding:7px 10px 7px;border-left:2px solid #333;display:block;margin-bottom:-10px; margin-top:15px;}
#wow-popup-options label, #wow-popup-options .afterhead {display:inline-block;width:200px;float:left;margin-right:5px;}
#wow-popup-options .widefat, #wow-popup-options input[type=number], #wow-popup-options select {   position:relative; width: 300px;   border: 1px solid #ddd;   box-shadow: none;}
#wow-popup-options .metaboxfirsthead {font-style:italic;font-size:15px;	background-color: #3e48ab;  padding: 7px 20px; margin: -10px;  display: block; color: #fff;}
#wow-popup-options input:after {display:table;clear:both;float:none;height:1px;content:"";}
#wow-popup-options p, #wow-popup-options label[for="popup-title"], #wow-popup-options label[for="is_home"],  #wow-popup-options label[for="popup-box-color"],	#wow-popup-options label[for="show-popup-entryorexit"], #wow-popup-options label[for="select-premade-style"] {clear:both;float:none;width:97.5%;display:block;    background: #fff;}
#wow-popup-options label[for="popup-title"], #wow-popup-options label[for="is_home"],  #wow-popup-options label[for="popup-box-color"],	#wow-popup-options label[for="show-popup-entryorexit"], #wow-popup-options label[for="select-premade-style"] {margin-top:25px;width:100%;}
#wow-popup-options label , #wow-popup-options .afterhead {background:#f1f1f1;}
#wow-popup-options label[for="select-premade-style"] {margin-top:60px;}
</style>' ;
}