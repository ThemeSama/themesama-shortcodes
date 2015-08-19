<?php
/*
Plugin Name: ThemeSama Shortcodes
Plugin URI: http://www.themesama.com/
Description: A shortcode generator for WordPress Themes.
Version: 1.0.5
Author: ThemeSama
Author URI: http://www.themesama.com
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if( !class_exists('TS_Shortcodes') ) {

class TS_Shortcodes {

    function __construct(){

    //Define Names & Directories
    defined('TS_PLUGIN')      ||  define('TS_PLUGIN', 'themesama_');
    defined('TS_TAG')         ||  define('TS_TAG', 'ts_');
    defined('TS_PTD')         ||  define('TS_PTD', 'themesama-shortcodes');
    defined('TS_PLUGIN_DIR')  ||  define('TS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
    defined('TS_PLUGIN_INC')  ||  define('TS_PLUGIN_INC', TS_PLUGIN_DIR.'includes/' );
    defined('TS_PLUGIN_URL')  ||  define('TS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    defined('TS_PLUGIN_VER')  ||  define('TS_PLUGIN_VER', '1.0.5');

    if( is_admin() ){

      //Shortcode Manager Options
      require_once( TS_PLUGIN_INC .'options.php' );
      //Option Types
      require_once( TS_PLUGIN_INC.'option-types.php');

    }
    
    //All Shortcodes
    require_once( TS_PLUGIN_INC .'shortcodes.php' );

    //widgets
    require_once( TS_PLUGIN_INC .'widgets.php' );

    //Visual Composer
    if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
      require_once( TS_PLUGIN_INC .'vc-shortcodes.php' );
    }

    //Actions
    add_action('wp_enqueue_scripts', array(&$this, TS_PLUGIN.'site_scripts'));

    add_action('init', array(&$this, 'slupy_init'));
    add_action('admin_init', array(&$this, TS_PLUGIN.'shortcode_manager'));
    add_action('admin_enqueue_scripts', array(&$this, TS_PLUGIN.'admin_scripts'));
    add_action('wp_ajax_ts_load_content', array(&$this,'themesama_load_content_callback'));
    add_action('media_buttons_context', array(&$this, 'themesama_shortcode_button'));
    add_action('admin_footer', array(&$this, TS_PLUGIN.'admin_footer') );
    add_action('plugins_loaded', array(&$this, TS_PLUGIN.'load_textdomain') );

    //Default Shortcode Manager Options
    $this->themesama_options_array = array();

  }

  function slupy_init() {
    if( defined('IS_SLUPY') ){
      require_once( TS_PLUGIN_INC .'slupy-shortcodes.php' );
    }
  }

  function themesama_shortcode_manager(){
    $this->themesama_options_array = apply_filters( 'themesama_shortcode_manager_options', $this->themesama_options_array ); 
  }

  /*---------------------------------------------
    Load Content for Shortcodes
  ---------------------------------------------*/
  function themesama_load_content_callback() {

    global $wpdb; // this is how you get access to the database

    $ts_content = isset($_POST['ts_content']) ? intval( $_POST['ts_content'] ) : -1;

    if( $ts_content != -1 && isset($this->themesama_options_array[$ts_content]["options"]) ){

    foreach ($this->themesama_options_array[$ts_content]["options"] as $key => $value) {

      echo '<div class="'.esc_attr( TS_PLUGIN ).'a_configelement"'.( isset($value['shortcode']) ? ' data-shortcode="'.esc_attr( $value['shortcode'] ).'"':'' ).( isset($value['depends']) ? ' data-depends-on="'.esc_attr( $value['depends'] ).'"':'' ).'>';

      if( !empty($value['title']) ){
        echo '<h3 class="'.esc_attr( TS_PLUGIN ).'option_heading">'.$value['title'].'</h3>';
        if( !empty($value['desc']) ){
          echo '<i class="fa fa-question-circle '.TS_PLUGIN.'help_icon" data-title="'.esc_attr( $value['desc'] ).'"></i>';
        }
      }

      ts_display_by_type($value);

      echo '</div>';

      if( isset($value['addbutton']) && $value['addbutton']!= false ){
        echo '<a href="#" class="'.esc_attr( TS_PLUGIN ).'addrowbutton button" title="'.esc_attr( $value['addbutton'] ).'">
          <span class="themesama_plus_icon"></span> '.$value['addbutton'].'
        </a>';
      }

    }

    }else{

      _e('Detail options not available for this shortcode, just click & insert', TS_PTD);

    }

    die(); // this is required to return a proper result

  }
  
  /*---------------------------------------------
    Load Theme Styles & Scripts
  ---------------------------------------------*/
  function themesama_site_scripts(){

    //Register Shortcode Scripts
    wp_deregister_script('waypoints');
    wp_register_script('waypoints', TS_PLUGIN_URL .'js/components/waypoints.min.js', array('jquery'), '2.0.3', true );
    wp_register_script('easyPieChart', TS_PLUGIN_URL .'js/components/jquery.easypiechart.min.js', array('jquery'), '2.1.3', true );
    wp_register_script('countUp', TS_PLUGIN_URL .'js/components/countUp.min.js', array(), '1.1.1', true );
    wp_register_script('countDown', TS_PLUGIN_URL .'js/components/jquery.countdown.min.js', array(), '2.0.1', true );

    //Shortcodes Styles
    wp_enqueue_style( TS_PLUGIN.'shortcodes', TS_PLUGIN_URL . 'css/shortcodes.css', array(), TS_PLUGIN_VER );
    
    wp_enqueue_script('waypoints');

    //Control Slupy Theme
    if( !defined('IS_SLUPY') ){
      //Columns layout
      //wp_enqueue_style('columns-layout', TS_PLUGIN_URL . 'css/columns-layout.css' );
      //Enqueue Font Awasome Icons
      wp_enqueue_style('font-awasome', TS_PLUGIN_URL . 'css/font-awesome.min.css', array(), '4.1.0', 'all');
      //magnific-popup
      wp_enqueue_style( 'magnific-popup', TS_PLUGIN_URL . 'css/magnific.css', array(), '0.9.9' );
      wp_enqueue_script( 'magnific-popup', TS_PLUGIN_URL .'js/components/jquery.magnific-popup.min.js', array( 'jquery' ), '0.9.9' );
      //images loaded
      wp_register_script( 'imagesLoaded', TS_PLUGIN_URL.'js/components/imagesloaded.min.js', array(), '3.1.4', true );
      //OwlCarousel
      wp_register_style('OwlCarousel', TS_PLUGIN_URL . 'css/owl.carousel.css' );
      wp_register_script('OwlCarousel', TS_PLUGIN_URL .'js/components/owl.carousel.min.js', array('jquery'), '1.31', true );
      //FitVids
      wp_register_script('fitvids', TS_PLUGIN_URL . 'js/components/jquery.fitvids.js', array('jquery'), '1.0.3', true );
      //
      wp_enqueue_script( TS_PLUGIN.'shortcodessite', TS_PLUGIN_URL . 'js/scripts.js', array('jquery'), TS_PLUGIN_VER, true);
      
      $default_color = '#31353e';
    }else{
      $default_color = (ts_get_option('slupy_skins')=="custom") ? ts_get_option('slupy_accentcolor') : ts_get_option('slupy_skins');
    }

    if( defined('IS_SLUPY') ){
      $used_font = ts_get_option('headings_font');
      if( isset($used_font['font-family']) && strlen($used_font['font-family']) > 0 ){
        $font_family = $used_font['font-family'];
      }else{
        $font_family = 'Arial';
      }
    }else{
      $font_family = 'Arial';
    }

    global $ts_default_color;
    $ts_default_color = $default_color;
    $custom_css = '
.ts-photostream a,
.ts-white-bg .ts-buttons.ts-color-white.ts-border-button a:hover,
.ts-pricing-table .ts-table-title,
.ts-clients a.ts-color-default,
.ts-color-white.ts-button:hover,
.ts-color-white.ts-buttons .ts-buttons-btn:hover,
.ts-color-white.ts-buttons:hover .ts-button-center,
.ts-color-default .ts-current-tab a,
.ts-color-default .ts-tab-nav a:hover,
.ts-color-default .ts-buttons-btn,
.ts-color-default .ts-skill-title span,
.ts-color-default.ts-dropcap,
.ts-color-default.ts-highlight,
.ts-color-default.ts-button,
.ts-color-default.ts-button.ts-border-button:hover,
.ts-color-default.ts-pricing-table .ts-table-title,
.ts-color-default.ts-highlight-table .ts-price,
.ts-color-default .ts-bar-color{background-color: '.$default_color.'; } ';

if( function_exists('colourBrightness') ){
  $hover_color = colourBrightness($default_color, -0.85);
  $custom_css .= '
.ts-color-default .ts-button-center,
.ts-color-default .ts-buttons-btn:hover,
.ts-color-default.ts-highlight-table .ts-table-title,
.ts-color-default.ts-button:hover{background-color: '.$hover_color.';}';

  $custom_css .= '.ts-color-default .ts-button-left{border-color: '.$hover_color.';}';
  
}

$custom_css .= '
.ts-color-white.ts-border-button:hover,
.ts-color-white.ts-border-button:hover .ts-button-title,
.ts-color-white.ts-border-button:hover .ts-button-icon,
.ts-twitter-nav a:hover,
.ts-feature-box:hover .ts-box-icon,
.ts-feature-box:hover .ts-box-title a,
.ts-color-default.ts-border-button .ts-button-right,
.ts-color-default.ts-border-button .ts-button-left,
.ts-color-default.ts-border-button,
.ts-color-default.ts-border-button .ts-button-title,
.ts-color-default.ts-border-button .ts-button-icon,
.ts-color-default .ts-skill-title span:after,
.ts-color-default .ts-current-tab a:after,
.ts-color-default .ts-active-accordion .ts-accordion-button:after,
.ts-color-default.ts-highlight-table .ts-price:after,
.ts-color-default.ts-dropcap-transparent,
.ts-color-default.ts-blockquote:after{color: '.$default_color.';}

.ts-table,
.ts-color-white.ts-border-button:hover,
.ts-color-white.ts-buttons:hover .ts-button-left,
.ts-color-default.ts-border-button,
.ts-color-default .ts-tab-nav li:hover,
.ts-color-default .ts-current-tab,
.ts-color-default .ts-active-accordion .ts-accordion-button,
.ts-color-default.ts-blockquote{border-color: '.$default_color.'; }';

$custom_css .='.ts-pricing-table .ts-price,
.ts-table th,
.ts-charts,
.ts-buttons a,
.ts-button,
.ts-dropcap,
.ts-author{
  font-family: "'.$font_family.'", sans-serif;
}';
    $custom_css = str_replace("\n", "", $custom_css);
    wp_add_inline_style( TS_PLUGIN.'shortcodes', $custom_css );
    
  }

  /*---------------------------------------------
    Load Admin Styles & Scripts
  ---------------------------------------------*/
  function themesama_admin_scripts(){

    //for wp.media modal window
    wp_enqueue_media();
    //for shortcode manager & color picker
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style( TS_PLUGIN.'shortcodesadmin', TS_PLUGIN_URL . 'css/admin.css' );
    //Enqueue Font Awasome Icons
    if( !defined('IS_SLUPY') ){
      wp_enqueue_style('font-awasome', TS_PLUGIN_URL . 'css/font-awesome.min.css', array(), '4.1.0', 'all');
    }
    wp_enqueue_style('css-tipsy', TS_PLUGIN_URL . 'css/tipsy.css', array(), '1.0', 'all');

    wp_enqueue_script( TS_PLUGIN.'shortcodesjs', TS_PLUGIN_URL . 'js/shortcodes.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script( 'jquery-form-dependencies', TS_PLUGIN_URL . 'js/jquery.form-dependencies.js', array('jquery'), '2.0', true);
    wp_enqueue_script( 'zeroclipboard', TS_PLUGIN_URL . 'js/ZeroClipboard.min.js', array(), '1.0.0', true);
    wp_enqueue_script('jquery-tipsy', TS_PLUGIN_URL . 'js/jquery.tipsy.js', array('jquery'), '1.0.0a', true);
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('wp-color-picker');

    //Visual Composer
    if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
      
      if( defined('IS_SLUPY') ){
        $default_color = (ts_get_option('slupy_skins')=="custom") ? ts_get_option('slupy_accentcolor') : ts_get_option('slupy_skins');
      }else{
        $default_color = '#31353e';
      }

      $all_colors = array(
        'default'   => $default_color,
        'darkblue'  => '#31353e',
        'blue'      => '#1ca2f1',
        'green'     => '#82bf06',
        'orange'    => '#fc5513',
        'yellow'    => '#ffbe05',
        'white'     => '#f0f0f0'
      );

      wp_enqueue_script( TS_PLUGIN.'custom-views', TS_PLUGIN_URL . 'js/themesama-custom-views.js', array('wpb_js_composer_js_custom_views'), '1.0.0', true);
      wp_localize_script( TS_PLUGIN.'custom-views', 'ts_colors', $all_colors );
    }

  }


  /*---------------------------------------------
    Add Shortcode Button
  ---------------------------------------------*/
  function themesama_shortcode_button($context){

    $context.= '<a href="#" class="'.esc_attr( TS_PLUGIN ).'shortcode-button button" title="'.__("Add Shortcode", TS_PTD).'">
      <span class="'.esc_attr( TS_PLUGIN ).'plus_icon"></span> '.__("Add Shortcode", TS_PTD).'
    </a>';
    
    return $context;

  }

  
  /*---------------------------------------------
    Create Modal and Shortcode Manager
  ---------------------------------------------*/
  function themesama_admin_footer(){

    echo '<div class="'.esc_attr( TS_PLUGIN ).'shortcode_content">
      <div class="media-modal">
      <a class="media-modal-close" href="#" title="Close"><span class="media-modal-icon"></span></a>
      <div class="media-modal-content">
        <div class="media-frame hide-menu hide-router">
          <div class="media-frame-title"><h1>'.__('Shortcodes', TS_PTD).'</h1></div>
          <div class="media-frame-content">
            <div class="media-frame-content-margin" id="'.TS_PLUGIN.'shortcodetab">';

    /*---------------------------------------------
      Begin: Call Options & Tabs
    ---------------------------------------------*/

    $themesama_all_tabs = '';
    
    foreach ($this->themesama_options_array as $key => $value) {
      
      $themesama_all_tabs.= '<li><a href="#tab_'.$value["id"].'" data-idkey="'.$key.'" data-shortcode="'.( isset($value["shortcode"]) ? $value["shortcode"] : '' ).'">'.$value["title"].'</a></li>';

      echo '<div class="tabs_shortcode_list" id="tab_'.esc_attr( $value["id"] ).'"></div>';

    }

    echo '<ul class="'.esc_attr( TS_PLUGIN ).'shortcode-list">'.$themesama_all_tabs.'</ul>';

    /*---------------------------------------------
      End: Call Options & Tabs
    ---------------------------------------------*/

    echo '</div></div>
          <div class="media-frame-toolbar">
            <div class="media-toolbar">
            <div class="media-toolbar-primary">
              <div class="'.esc_attr( TS_PLUGIN ).'copyclipboard_info">'.__('Shortcode Copied!',TS_PTD).'</div>
              <a href="#" class="'.esc_attr( TS_PLUGIN ).'copyclipboard button media-button  button-large" data-moviepath="'.esc_url( TS_PLUGIN_URL ).'">'.__('Copy Clipboard', TS_PTD).'</a>
              <a href="#" class="'.esc_attr( TS_PLUGIN ).'addshortcode_button button media-button button-primary button-large">'.__('Add Shortcode', TS_PTD).'</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="media-modal-backdrop"></div>
    </div>';

  }

  /**
   * Load plugin textdomain.
   *
   * @since 1.0.4
   */
  function themesama_load_textdomain() {
    load_plugin_textdomain( TS_PTD, false, TS_PLUGIN_DIR . '/languages' );
  }

}

//Call Shortcode Class
$ts_shortcodes = new TS_Shortcodes();

}

?>