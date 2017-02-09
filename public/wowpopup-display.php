<?php

//======================================================================
// Load PopUp Script
//======================================================================
add_action( 'wp_enqueue_scripts', 'wowpopup_variablejs' );
function wowpopup_variablejs () {
   // Load Js
   add_filter( 'script_loader_tag', function ( $wowpopuptag, $wowpopuphandle ) {
   if ( 'wowpopup-mainjs' !== $wowpopuphandle )
       return $wowpopuptag;
     return str_replace( ' src', ' defer="defer" src', $wowpopuptag );
     }, 10, 2 );
    wp_enqueue_script( 'wowpopup-mainjs', plugin_dir_url( __FILE__ ) . 'js/wowpopup.min.js', array( 'jquery' ), '1.0.0', true );
}

//======================================================================
// Wow Popup Display
//======================================================================
function wowpopup_displaymodal() {
  global $post;
  $popuphideonthispage =  get_post_meta( get_the_ID(), 'wowpopup_hide_hide-wowpopup-on-this-page', true );?>
  <div class="wrapallwowpopup">
  <?php

  $wowargs = array( 'post_type' => 'wow_popup_type', 'posts_per_page'=> 3, 'post_status' => 'publish', 'orderby' => 'date', 'order'   => 'DESC' );
  query_posts( $wowargs );
  while ( have_posts() ) : the_post();

  $popupselectposition = get_post_meta( $post->ID, 'wow_popup_options_select-position', true );
  $popuptitle = get_post_meta( $post->ID, 'wow_popup_options_popup-title', true );
  $popupwidth = get_post_meta( $post->ID, 'wow_popup_options_popup-width', true );
  $popupbuttonurl = get_post_meta( $post->ID, 'wow_popup_options_button-url', true );
  $popupbuttontext = get_post_meta( $post->ID, 'wow_popup_options_button-text', true );
  $popupbuttonghost = get_post_meta( $post->ID, 'wow_popup_options_button-ghost', true );
  $popupbuttonround = get_post_meta( $post->ID, 'wow_popup_options_button-round', true );
  $popupbuttonflat = get_post_meta( $post->ID, 'wow_popup_options_button-flat', true );
  $popupbuttontargetlink = get_post_meta( $post->ID, 'wow_popup_options_select-button-target-link', true );
  $popupanimation = get_post_meta( $post->ID, 'wow_popup_options_popup-animation', true );
  $popupposition = get_post_meta( $post->ID, 'wow_popup_options_select-position', true );
  $popuptextalign = get_post_meta( $post->ID, 'wow_popup_options_select-text-align', true );
  $popupimgalign = get_post_meta( $post->ID, 'wow_popup_options_select-image-align', true );
  $popupshowafter = get_post_meta( $post->ID, 'wow_popup_options_show-popup-after', true );
  $popupshowcookie = get_post_meta( $post->ID, 'wow_popup_options_show-popup-cookie', true );
  $popupshowwhenagain = get_post_meta( $post->ID, 'wow_popup_options_show-popup-when-again', true );
  $popupshowentryorexit = get_post_meta( $post->ID, 'wow_popup_options_show-popup-entryorexit', true );
  $popupshowaftersec = $popupshowafter.'000';
  $popupnofront =  get_post_meta( $post->ID, 'wow_popup_options_is_front_page', true );
  $popupnofrontnohome =  get_post_meta( $post->ID, 'wow_popup_options_is_front_pageandis_home', true );
  $popupnoposts =  get_post_meta( $post->ID, 'wow_popup_options_is_single', true );
  $popupnopages =  get_post_meta( $post->ID, 'wow_popup_options_is_page', true );
  $popupnoarchive =  get_post_meta( $post->ID, 'wow_popup_options_is_archive', true );
  $popupnologgedin =  get_post_meta( $post->ID, 'wow_popup_options_is_user_logged_in', true );
  $popupnosmallerdevices =  get_post_meta( $post->ID, 'wow_popup_options_smaller_devices', true );
  $popuppremadetemplate = get_post_meta( $post->ID, 'wow_popup_options_select-premade-style', true );
  $popupostid = '#wowpopup'.$post->ID;
  $popupthecontent = get_the_content();
  $wow_post_id = $post->ID;

    // Set the params
  	$wowpopupparams = array(
  		'popupshowaftersec' => $popupshowaftersec,
  		'popupostid' => $popupostid,
      'uid' => $wow_post_id,
  		'popupshowcookie' => $popupshowcookie,
      'popupselectposition' => $popupselectposition,
  		'popupshowwhenagain' => $popupshowwhenagain,
  		'popupshowentryorexit' => $popupshowentryorexit
  	);
  $wowpopupparamshandle = 'wowdata_'.$wow_post_id;
  wp_localize_script( 'wowpopup-mainjs', $wowpopupparamshandle, $wowpopupparams );

  if (empty($popuptitle) && empty($popupbuttontext) && empty($popupthecontent)) { echo '<style>.wowpopup-text {padding:0;}</style>';}
  if( ($popupnofront && is_front_page()) || ($popupnoposts && is_single()) || ($popupnopages && is_page()) || ($popupnoarchive && is_archive()) ||
  ($popupnologgedin && is_user_logged_in()) || ($popupnofrontnohome && is_front_page() && is_home())  ) { echo '<style>.wrapallwowpopup{display:none !Important;}</style>'; }
  if ($popupnosmallerdevices) {echo '<style>@media screen and (max-width: 769px) { .wrapallwowpopup{display:none !Important;} } </style>';}
  if(!$popuphideonthispage) { ?>

  <div class="wowgettheid" id="wowpopup<?php the_ID(); ?>" data-wowdata="<?php echo $wowpopupparamshandle; ?>">
  <div class="<?php echo $popuppremadetemplate;?> modelBox keepincenter <?php echo $popupselectposition ;?> animated <?php echo $popupanimation ;?>">
    <div class="insidepopup <?php echo $popupimgalign ;?>">
      <?php
      if(!($popupbuttonurl == null || $popupbuttonurl == '')) { ?>
          <a target="<?php echo $popupbuttontargetlink;?>" href="<?php echo $popupbuttonurl;?>"> <?php
          }
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'full', array( 'class'  => 'topimg' ) );
          }
      if(!($popupbuttonurl == null || $popupbuttonurl == '')) { ?>
          </a> <?php
          } ?>
      <a data-wowdata="<?php echo $wowpopupparamshandle; ?>" href="#" class="wowpopup-closebutton <?php the_ID(); ?>">&times;</a>
      <div class="wowpopup-text text-<?php echo $popuptextalign ;?>">
          <?php if(!($popuptitle == null || $popuptitle == '')) { ?>
            <h2 class="wow-title"><?php echo $popuptitle ;?></h2>
          <?php } ?>
          <?php the_content();?>
          <div class="wowclearfix"></div>
          <?php if(!($popupbuttontext == null || $popupbuttontext == '')) { ?>
          <a href="<?php echo $popupbuttonurl;?>" class="wowpopup-button <?php if ($popupbuttonghost) { echo 'wowbuttonghost';} ?> <?php if ($popupbuttonround) { echo 'wowbuttonround';} ?> <?php if ($popupbuttonflat) { echo 'wowbuttonflat';} ?>" target="<?php echo $popupbuttontargetlink;?>"><?php echo $popupbuttontext;?></a>
          <?php } ?>
      </div>
      <div class="wowclearfix"></div>
    </div>
  </div>
  </div>
  <?php
  }
endwhile; wp_reset_query();
?>
  </div>
<?php
}
add_action( 'wp_footer', 'wowpopup_displaymodal' );

//======================================================================
// Turn hex to rgb
//======================================================================
function wowpopup_hex2rgba($color, $opacity = false) {
 	$default = 'rgb(0,0,0)';
 	if(empty($color))
     return $default;
     if ($color[0] == '#' ) {
     	$color = substr( $color, 1 );
     }
     if (strlen($color) == 6) {
             $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
     } elseif ( strlen( $color ) == 3 ) {
             $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
     } else {
             return $default;
     }
     $rgb =  array_map('hexdec', $hex);
     if($opacity){
     	if(abs($opacity) > 1)
     		$opacity = 1.0;
     	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
     } else {
     	$output = 'rgb('.implode(",",$rgb).')';
     }
     return $output;
 }

//======================================================================
// PopUp Custom Style
//======================================================================
add_action('wp_head', 'wowpopup_custom_styles', 100);
function wowpopup_custom_styles() {
  global $post;
  $wowargs = array( 'post_type' => 'wow_popup_type', 'posts_per_page'=> 3, 'post_status' => 'publish', 'orderby' => 'date', 'order'   => 'DESC' );
  query_posts( $wowargs );
  while ( have_posts() ) : the_post();

      $popupwidth = get_post_meta( $post->ID, 'wow_popup_options_popup-width', true );
      $popupcolor = get_post_meta( $post->ID, 'wow_popup_options_popup-box-color', true );
      $popuptitlecolor = get_post_meta( $post->ID, 'wow_popup_options_title-color', true );
      $popupcontentcolor = get_post_meta( $post->ID, 'wow_popup_options_content-color', true );
      $popuplinkscolor = get_post_meta( $post->ID, 'wow_popup_options_links-color', true );
      $popupclosebgcolor = get_post_meta( $post->ID, 'wow_popup_options_close-bg-color', true );
      if (empty($popupclosebgcolor)) {  $popupclosebgcolor = "#333333"; }
      $popupcloseiconcolor = get_post_meta( $post->ID, 'wow_popup_options_close-icon-color', true );
      if (empty($popupcloseiconcolor)) {  $popupcloseiconcolor = "#ffffff"; }
      $popupbuttonbgcolor = get_post_meta( $post->ID, 'wow_popup_options_button-bg-color', true );
      $popupbuttontextcolor = get_post_meta( $post->ID, 'wow_popup_options_button-text-color', true );
      $popupoverlaycolor = get_post_meta( $post->ID, 'wow_popup_options_overlay-color', true );
      $popupoverlayopacity = get_post_meta( $post->ID, 'wow_popup_options_overlay-opacity', true );
      if (empty($popupoverlayopacity)) {  $popupoverlayopacity = "0.7"; }
      $popupoverlayrgba = wowpopup_hex2rgba($popupoverlaycolor, $popupoverlayopacity);
      $popupostid = '#wowpopup'.$post->ID;
      $popupthecontent = get_the_content();
      $popuppremadetemplate = get_post_meta( $post->ID, 'wow_popup_options_select-premade-style', true );
      ?>


      <style>
      <?php echo $popupostid;?> .modelBox, <?php echo $popupostid;?> .insidepopup.splitlayout, <?php echo $popupostid;?> .insidepopup {  width: <?php echo $popupwidth; ?>px; max-width:100%;}
      <?php echo $popupostid;?> .modelBox.SimpleTopBar, <?php echo $popupostid;?> .SimpleTopBar .insidepopup.splitlayout, <?php echo $popupostid;?> .SimpleTopBar .insidepopup,  <?php echo $popupostid;?> .modelBox.SimpleBottomBar, <?php echo $popupostid;?> .SimpleBottomBar .insidepopup.splitlayout, <?php echo $popupostid;?> .SimpleBottomBar .insidepopup {width:100%;}
      .wowpopup-overlay {background-color:<?php echo $popupoverlayrgba;?>;}
      <?php echo $popupostid;?> a.wowpopup-closebutton { background-color:<?php echo $popupclosebgcolor; ?>; color: <?php echo $popupcloseiconcolor; ?>; }
      <?php echo $popupostid;?> .insidepopup { background-color: <?php echo $popupcolor; ?>;}
      <?php echo $popupostid;?> h2.wow-title { color: <?php echo $popuptitlecolor; ?>;}
      <?php echo $popupostid;?> .wowpopup-text {color:<?php echo $popupcontentcolor; ?>; }
      <?php echo $popupostid;?> .wowpopup-text a {color:<?php echo $popuplinkscolor; ?>; }
      <?php echo $popupostid;?> .wowpopup-text a.wowpopup-button, <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:<?php echo $popupbuttonbgcolor; ?>; color:<?php echo $popupbuttontextcolor; ?>;}
      <?php echo $popupostid;?> .wowpopup-text a.wowpopup-button.wowbuttonghost {	background-color:transparent;	color:<?php echo $popupbuttonbgcolor; ?>; 	border:2px solid; }
      </style>


      <?php if ($popuppremadetemplate == 'general1') { ?>
      <style>
      <?php echo $popupostid;?> .general1 .insidepopup { background-color: #34bfcb;}
      <?php echo $popupostid;?> .general1 h2.wow-title { color: #ffffff;}
      <?php echo $popupostid;?> .general1 .wowpopup-text {color:#ffffff; }
      <?php echo $popupostid;?> .general1 .wowpopup-text a {color:#ffffff; }
      <?php echo $popupostid;?> .general1 .wowpopup-text a.wowpopup-button, <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#8b479c; color:#fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius:3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general2') { ?>
      <style>
      <?php echo $popupostid;?> .general2 .insidepopup { background-color: #0e2a36;}
      <?php echo $popupostid;?> .general2 .wowpopup-text a.wowpopup-button, <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #00b988; color: #fff; border:0;border-bottom:3px solid rgba(0,0,0,0.1); border-radius:3px;}
      <?php echo $popupostid;?> .general2 h2.wow-title { color: #ffffff;}
      <?php echo $popupostid;?> .general2 .wowpopup-text {color:#ffffff; }
      <?php echo $popupostid;?> .general2 .wowpopup-text a {color:#ffffff; }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general3') { ?>
      <style>
      <?php echo $popupostid;?> .general3 .insidepopup { background-color:#2c3e50;}
      <?php echo $popupostid;?> .general3 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #e74c3c; color: #fff; border:0;border-bottom:3px solid rgba(0,0,0,0.1);  border-radius: 3px;}
      <?php echo $popupostid;?> .general3 h2.wow-title { color: #ffffff;}
      <?php echo $popupostid;?> .general3 .wowpopup-text {color:#ffffff; }
      <?php echo $popupostid;?> .general3 .wowpopup-text a {color:#ffffff; }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general4') { ?>
      <style>
      <?php echo $popupostid;?> .general4 .insidepopup { background-color: #1c419c;}
      <?php echo $popupostid;?> .general4 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button { background-color: #68bf22; color: #fff; border:0;border-bottom:3px solid rgba(0,0,0,0.1);  border-radius: 3px;}
      <?php echo $popupostid;?> .general4 h2.wow-title { color: #fff;}
      <?php echo $popupostid;?> .general4 .wowpopup-text {color:#fff; }
      <?php echo $popupostid;?> .general4 .wowpopup-text a {color:#fff; }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general5') { ?>
      <style>
      <?php echo $popupostid;?> .general5 .insidepopup { background-color: #7c62ae;}
      <?php echo $popupostid;?> .general5 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #42bd21;  color: #fff;  border-radius: 3px;}
      <?php echo $popupostid;?> .general5 h2.wow-title { color: #ffffff;}
      <?php echo $popupostid;?> .general5 .wowpopup-text {color:#ffffff; }
      <?php echo $popupostid;?> .general5 .wowpopup-text a {color:#ffffff; }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general6') { ?>
      <style>
      <?php echo $popupostid;?> .general6 .insidepopup { background-color: #e8562a;}
      <?php echo $popupostid;?> .general6 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #c74119; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general6 h2.wow-title,   <?php echo $popupostid;?> .general6 .wowpopup-text,   <?php echo $popupostid;?> .general6 .wowpopup-text a  { color: #ffffff;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general7') { ?>
      <style>
      <?php echo $popupostid;?> .general7 .insidepopup { background-color: #29a7a7;}
      <?php echo $popupostid;?> .general7 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #fde635; color: #111; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general7 h2.wow-title, <?php echo $popupostid;?> .general7 .wowpopup-text, <?php echo $popupostid;?> .general7 .wowpopup-text a { color: #ffffff;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general8') { ?>
      <style>
      <?php echo $popupostid;?> .general8 .insidepopup { background-color: #fff83f;}
      <?php echo $popupostid;?> .general8 h2.wow-title, <?php echo $popupostid;?> .general8 .wowpopup-text, <?php echo $popupostid;?> .general8 .wowpopup-text a { color: #111;}
      <?php echo $popupostid;?> .general8 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #000; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general9') { ?>
      <style>
      <?php echo $popupostid;?> .general9 .insidepopup { background: linear-gradient(90deg, #ff5f6d 0%, #ffc371 100%);}
      <?php echo $popupostid;?> .general9 h2.wow-title, <?php echo $popupostid;?> .general9 .wowpopup-text, <?php echo $popupostid;?> .general9 .wowpopup-text a { color: #111;}
      <?php echo $popupostid;?> .general9 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #000; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general10') { ?>
      <style>
      <?php echo $popupostid;?> .general10 .insidepopup { background: linear-gradient(90deg, #ffe45f 0%, #84f1ec 100%);}
      <?php echo $popupostid;?> .general10 h2.wow-title, <?php echo $popupostid;?> .general10 .wowpopup-text, <?php echo $popupostid;?> .general10 .wowpopup-text a { color: #111;}
      <?php echo $popupostid;?> .general10 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #000; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general11') { ?>
      <style>
      <?php echo $popupostid;?> .general11 .insidepopup {     background: linear-gradient(90deg, #867412 0%, #f3ffbf 100%);}
      <?php echo $popupostid;?> .general11 h2.wow-title, <?php echo $popupostid;?> .general11 .wowpopup-text, <?php echo $popupostid;?> .general11 .wowpopup-text a { color: #111;}
      <?php echo $popupostid;?> .general11 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #000; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general12') { ?>
      <style>
      <?php echo $popupostid;?> .general12 .insidepopup {  background: linear-gradient(90deg, #861278 0%, #ff0081 100%);}
      <?php echo $popupostid;?> .general12 h2.wow-title, <?php echo $popupostid;?> .general12 .wowpopup-text, <?php echo $popupostid;?> .general12 .wowpopup-text a { color: #fff;}
      <?php echo $popupostid;?> .general12 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #000; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general13') { ?>
      <style>
      <?php echo $popupostid;?> .general13 .insidepopup {  background: linear-gradient(343deg, #74d7bf 0, #072460 90%);}
      <?php echo $popupostid;?> .general13 h2.wow-title, <?php echo $popupostid;?> .general13 .wowpopup-text, <?php echo $popupostid;?> .general13 .wowpopup-text a { color: #fff;}
      <?php echo $popupostid;?> .general13 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #730092; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general14') { ?>
      <style>
      <?php echo $popupostid;?> .general14 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general14 .insidepopup {  background-image:url("<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas1.jpg';?>"); background-size:cover;}
      <?php echo $popupostid;?> .general14 h2.wow-title, <?php echo $popupostid;?> .general14 .wowpopup-text, <?php echo $popupostid;?> .general14 .wowpopup-text a { color: #fff;}
      <?php echo $popupostid;?> .general14 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #ec1810; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general14 .wowpopup-text {width:100%;padding: 100px 30px;   background-color: rgba(0,0,0,0.2);}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general15') { ?>
      <style>
      <?php echo $popupostid;?> .general15 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general15 .insidepopup { background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas2.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general15 h2.wow-title, <?php echo $popupostid;?> .general15 .wowpopup-text, <?php echo $popupostid;?> .general15 .wowpopup-text a { color: #fff;}
      <?php echo $popupostid;?> .general15 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color: #65b13d; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general15 .wowpopup-text {width:100%;padding: 100px 30px; text-align:right;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general16') { ?>
      <style>
      <?php echo $popupostid;?> .general16 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general16 .insidepopup {  background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas3.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general16 h2.wow-title, <?php echo $popupostid;?> .general16 .wowpopup-text, <?php echo $popupostid;?> .general16 .wowpopup-text a { color: #fff;    text-shadow: 1px 1px 1px rgba(0,0,0,0.3);}
      <?php echo $popupostid;?> .general16 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#de4d0b; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general16 .wowpopup-text {width:100%;padding: 100px 30px; text-align:right; }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general17') { ?>
      <style>
      <?php echo $popupostid;?> .general17 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general17 .insidepopup {  background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas4.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general17 h2.wow-title, <?php echo $popupostid;?> .general17 .wowpopup-text, <?php echo $popupostid;?> .general17 .wowpopup-text a { color: #fff;    text-shadow: 1px 1px 1px rgba(0,0,0,0.3);}
      <?php echo $popupostid;?> .general17 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#25ce4f; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general17 .wowpopup-text {width:100%; padding: 100px 30px; text-align:right;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general18') { ?>
      <style>
      <?php echo $popupostid;?> .general18 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general18 .insidepopup {  background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas5.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general18 h2.wow-title, <?php echo $popupostid;?> .general18 .wowpopup-text, <?php echo $popupostid;?> .general18 .wowpopup-text a { color: #fff; }
      <?php echo $popupostid;?> .general18 h2.wow-title {font-size:28px;}
      <?php echo $popupostid;?> .general18 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#de4d0b; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general18 .wowpopup-text {width:100%; padding: 130px 30px; text-align:right;}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general19') { ?>
      <style>
      <?php echo $popupostid;?> .general19 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general19 .insidepopup { background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas6.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general19 h2.wow-title, <?php echo $popupostid;?> .general19 .wowpopup-text, <?php echo $popupostid;?> .general19 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general19 h2.wow-title {font-size:28px;}
      <?php echo $popupostid;?> .general19 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#09bdaa; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general19 .wowpopup-text {width:100%; padding: 100px 30px; text-align:center; background-color: rgba(0,0,0,0.4);}
      </style>

      <?php } elseif ($popuppremadetemplate == 'general20') { ?>
      <style>
      <?php echo $popupostid;?> .general20 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general20 .insidepopup {  background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas7.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general20 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general20 h2.wow-title, <?php echo $popupostid;?> .general20 .wowpopup-text, <?php echo $popupostid;?> .general20 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general20 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#09bd25; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general20 .wowpopup-text {width:100%; padding: 100px 30px; background-color: rgba(0,0,0,0.3); }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general21') { ?>
      <style>
      <?php echo $popupostid;?> .general21 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general21 .insidepopup { background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas8.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general21 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general21 h2.wow-title, <?php echo $popupostid;?> .general21 .wowpopup-text, <?php echo $popupostid;?> .general21 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general21 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#59b312; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general21 .wowpopup-text {width:100%; padding: 100px 30px; background-color: rgba(0,0,0,0.3);  }
      </style>

      <?php }  elseif ($popuppremadetemplate == 'general22') { ?>
      <style>
      <?php echo $popupostid;?> .general22 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general22 .insidepopup {  min-height:330px; background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas9.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general22 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general22 h2.wow-title, <?php echo $popupostid;?> .general22 .wowpopup-text, <?php echo $popupostid;?> .general22 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general22 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#1fbdbb; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general22 .wowpopup-text {width:100%; padding: 100px 30px; background-color: rgba(0,0,0,0.3); }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general23') { ?>
      <style>
      <?php echo $popupostid;?> .general23 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general23 .insidepopup { background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas10.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general23 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general23 h2.wow-title, <?php echo $popupostid;?> .general23 .wowpopup-text, <?php echo $popupostid;?> .general23 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general23 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#73bd1f; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general23 .wowpopup-text {width:100%; padding: 100px 30px;  }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general24') { ?>
      <style>
      <?php echo $popupostid;?> .general24 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general24 .insidepopup {background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas11.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general24 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general24 h2.wow-title, <?php echo $popupostid;?> .general24 .wowpopup-text, <?php echo $popupostid;?> .general24 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general24 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#73bd1f; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general24 .wowpopup-text {width:100%; padding: 100px 30px;background-color: rgba(0,0,0,0.2); }
      </style>

      <?php } elseif ($popuppremadetemplate == 'general25') { ?>
      <style>
      <?php echo $popupostid;?> .general25 .insidepopup img.topimg {display:none;}
      <?php echo $popupostid;?> .general25 .insidepopup {  background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'img/xmas12.jpg';?>); background-size:cover; }
      <?php echo $popupostid;?> .general25 h2.wow-title {font-size:26px;}
      <?php echo $popupostid;?> .general25 h2.wow-title, <?php echo $popupostid;?> .general25 .wowpopup-text, <?php echo $popupostid;?> .general25 .wowpopup-text a { color: #fff;text-shadow: 1px 1px 1px rgba(0,0,0,0.3); }
      <?php echo $popupostid;?> .general25 .wowpopup-text a.wowpopup-button,  <?php echo $popupostid;?> .wowpopup-text #mc_embed_signup .button {background-color:#73bd1f; color: #fff; border:0; border-bottom:3px solid rgba(0,0,0,0.1); border-radius: 3px;}
      <?php echo $popupostid;?> .general25 .wowpopup-text {width:100%; padding: 100px 30px;background-color: rgba(0,0,0,0.3);}
      </style>
      <?php } ?>




    <?php
  endwhile; wp_reset_query();
 }
