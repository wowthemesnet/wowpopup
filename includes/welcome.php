<?php 
add_action('admin_menu', 'wowpopup_menus');
function wowpopup_menus() {	
    add_submenu_page( 'edit.php?post_type=wow_popup_type', __('WowPopup Guide', ''), __('How to', ''), 'manage_options', 'wowpopup_options', 'wowpopup_options');
}

function wowpopup_options() {    
    $wowpopup_prourl = 'https://www.wowthemes.net/preview/index.php?plugin=wowpopup'; 
    ?>
    <style>
    .welcome-panel-column, .welcome-panel-column {
        width: 48% !Important;
        padding: 0 2% 0 0;
        margin: 0 0 1em 0;
    }
    .welcome {
        border: 1px solid #e5e5e5;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        background: #fff;
        text-align:center;
        padding:20px;
        max-width:1000px; 
        margin-top:80px;
    }
    </style>
        
    <div class="wrap">
    
        <h2>Wow Popup</h2>        
        <h2>How to add a popup</h2>
        <ul><li>1. Navigate to Dashboard -> WowPopup -> Create new popup</li>
        <li>2. Add title, content, set featured image, customize, then publish. <li>
        </ul>
        Visit your website to see it in action!

        <h3>Tips</h3>
        <ul>
        <li>- when testing your popup, it is  recommended to work with <em>show all the time</em> option enabled, otherwise you may not be able to preview it several times.</li>
        <li>- do <strong>not</strong> select <em>hide when user is logged in</em> option while testing because you will most likely be logged in and you will not be able to test your popup. </li>

        <h3>How to temporarily disable a popup</h3>
        You do not want to remove/delete your popup anytime you don't need it anymore. You might need it later. Set the popup as draft, just like you would do with any regular post.

        <h3>Questions?</h3>
        <p>We're <a target="_blank" href="https://www.wowthemes.net/support/">here</a> to help you!</p>
        <p>If you enjoy our plugin, please, support us by purchasing a license. The premium version is extended with some really great features!

        <div class="welcome">
            <div style="display: flex;  justify-content: space-between;align-items: center;">
            <h1 style="font-family: fantasy;font-size:32px;margin-bottom:20px;">WowPopup Pro</h1>
                <a target="_blank" style="border-radius:3px;margin-top:-10px;display:inline-block;background:#7341d8;font-family:Helvetica; font-size:15px;color:#fff;padding:15px 20px;text-decoration:none; font-weight:400;" href="<?php echo $wowpopup_prourl;?>">&rarr; View Demo</a>
            </div>
            <a style="display:block;" target="_blank" href="<?php echo $wowpopup_prourl;?>">
            <?php echo '<img style="max-width:100%;" src="' . plugins_url( 'public/img/wow-popup-plugin-wordpress.png', dirname(__FILE__) ) . '" > ';?>
            </a>
        </div>

    </div>	
<?php }


