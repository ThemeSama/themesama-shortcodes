<?php
/*
 * Themesama Shortcode Widget
 *
 * @since 1.0
 * @author @theme_sama
*/
class TS_ShortcodeWidget extends WP_Widget {

  
  /*
   * Construct
   *
   * @since 1.0.5
  */
  function __construct() {
      
    parent::__construct( 'TS_ShortcodeWidget', __('Themesama Shortcodes',TS_PTD),
      array(
        'classname' => 'ts_shortcode',
        'description' => __('Add shortcodes on a widget!',TS_PTD)
      )
    );
  }
  
  function form($instance) {

    $instance = wp_parse_args( (array) $instance, array(
      'title'             => '', 
      'shortcode_content' => '', 
      'nomargin'          => 'false')
    );

    $title = $instance['title'];
    $nomargin = esc_attr($instance['nomargin']);
    $shortcode_content = $instance['shortcode_content'];

?>
<p>
  <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:',TS_PTD); ?></label>
  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
  <label for="<?php echo esc_attr( $this->get_field_id('shortcode_content') ); ?>"><?php _e('Shortcode:',TS_PTD); ?></label>
</p>
<p>
  <a title="Add Shortcode" class="themesama_shortcode-button button" href="#" data-inputid="<?php echo esc_attr( $this->get_field_id('shortcode_content') ); ?>">
    <span class="themesama_plus_icon"></span> <?php _e('Add Shortcode',TS_PTD); ?>
  </a>
</p>
  <textarea name="<?php echo esc_attr( $this->get_field_name('shortcode_content') ); ?>" id="<?php echo esc_attr( $this->get_field_id('shortcode_content') ); ?>" cols="20" rows="16" class="widefat"><?php echo esc_textarea( $shortcode_content ); ?></textarea>
</p>
<p>
  <label for="<?php echo esc_attr( $this->get_field_id('nomargin') ); ?>"><?php _e('No Margin:',TS_PTD); ?></label>
  <select name="<?php echo esc_attr( $this->get_field_name('nomargin') ); ?>">
    <option value="true" <?php if($nomargin == "true"){echo "selected";}?>><?php _e('On',TS_PTD); ?></option>
    <option value="false" <?php if($nomargin == "false"){echo "selected";}?>><?php _e('Off',TS_PTD); ?></option>
  </select>
</p>
<?php
  }
  
  function update($new_instance, $old_instance) {
    $instance=$old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['nomargin'] = strip_tags($new_instance['nomargin']);
    $instance['shortcode_content']=$new_instance['shortcode_content'];
    
    return $instance;
  }
  
  function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    
    if ( empty($title) ) $title = false;
    
    $shortcode_content = $instance['shortcode_content'];
    $nomargin = $instance['nomargin'];
    
    echo $args["before_widget"].'<div class="ts_widget_shortcode">';
    
    if( $title ) echo $args["before_title"].$title.$args["after_title"];

    echo '<div class="ts_shortcode_content ts-white-bg'.($nomargin == 'true' ? ' ts_nowidget_margin':'').(empty( $title ) ? ' ts_without_widget_title':'').'">'.do_shortcode($shortcode_content).'</div></div>'.$args['after_widget'];
  }
  
}
  
function ts_load_widgets() {
    register_widget('TS_ShortcodeWidget');
}

add_action( 'widgets_init', 'ts_load_widgets' );

?>