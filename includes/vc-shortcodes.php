<?php
/*---------------------------------------------
   Define ThemeSama Shortcode's Attributes
---------------------------------------------*/
if( !function_exists('ts_shortcodes_for_vc') ){

function ts_shortcodes_for_vc($options){

$slupy_color_options = array(
  __( 'Default', TS_PTD )     => '',
  __( 'Dark Blue', TS_PTD )   => 'darkblue',
  __( 'Ocean Blue', TS_PTD )  => 'blue',
  __( 'Green', TS_PTD )       => 'green',
  __( 'Orange', TS_PTD )      => 'orange',
  __( 'Yellow', TS_PTD )      => 'yellow',
  __( 'Custom', TS_PTD )      => 'custom'
);

$slupy_target_options = array(
  ''          => '',
  __( '_blank', TS_PTD )  => '_blank',
  __( '_self', TS_PTD )   => '_self',
  __( '_parent', TS_PTD ) => '_parent',
  __( '_top', TS_PTD )    => '_top',
);

$slupy_heading_options = array(
  __( 'H3', TS_PTD ) => '3',
  __( 'H1', TS_PTD ) => '1',
  __( 'H2', TS_PTD ) => '2',
  __( 'H4', TS_PTD ) => '4',
  __( 'H5', TS_PTD ) => '5',
  __( 'H6', TS_PTD ) => '6'
);

foreach (get_intermediate_image_sizes() as $key => $image_size) {
  $all_image_sizes[$image_size] = $image_size;
}

$tag_taxonomies = array();
foreach ( get_taxonomies() as $taxonomy ) {
  $tax = get_taxonomy( $taxonomy );
  if ( ! $tax->show_tagcloud || empty( $tax->labels->name ) ) {
    continue;
  }
  $tag_taxonomies[$tax->labels->name] = esc_attr( $taxonomy );
}

$custom_menus = array();
$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
if ( is_array( $menus ) ) {
  foreach ( $menus as $single_menu ) {
    $custom_menus[$single_menu->name] = $single_menu->term_id;
  }
}

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);

array_push($options, array(
  //Toggle
  array(
    'name'              => __( 'Toggle', TS_PTD ),
    'base'              => 'ts_toggle',
    'js_view'           => 'TsToggleView',
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'dashicons-sort',
    'description'       => __( 'Add a toggle element', TS_PTD ),
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'holder'        => 'h4',
        'class'         => 'toggle_title',
        'heading'       => __( 'Title', TS_PTD ),
        'param_name'    => 'title',
        'value'         => __( 'Title', TS_PTD ),
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textarea_html',
        'holder'        => 'div',
        'class'         => 'toggle_content',
        'heading'       => __( 'Content', TS_PTD ),
        'param_name'    => 'content',
        'value'         => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', TS_PTD ),
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Trigger', TS_PTD ),
        'param_name'    => 'click_open',
        'value'         => 'on',
        'title_switch'  => __( 'CLICK', TS_PTD ).':'.__( 'HOVER', TS_PTD ),
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Initially open', TS_PTD ),
        'param_name'    => 'activated',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __( 'Choose a defined color or a custom color', TS_PTD ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Custom Color', TS_PTD ),
        'param_name'    => 'custom_color',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Accordion
  array(
    'name'              => __('Accordion',TS_PTD),
    'base'              => 'ts_accordions',
    'js_view'           => 'TsAccordionView',
    'description'       => __('Add a accordion content',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'dashicons-list-view',
    'class'             => '',
    'is_container'      => true,
    'custom_markup'     => '<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">%content%</div><div class="tab_controls"><a class="add_tab" title="'.__( 'Add accordion section', TS_PTD ).'"><span class="vc_icon"></span> <span class="tab-label">'.__( 'Add accordion section', TS_PTD ).'</span></a></div>',
    'default_content'   => '[ts_accordion title="'.__('Section 1', TS_PTD ).'"][/ts_accordion][ts_accordion title="'.__('Section 2', TS_PTD ).'"][/ts_accordion]',
    'params'            => array(
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Collapsible', TS_PTD ),
        'param_name'    => 'collapsible',
        'value'         => 'on',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Trigger', TS_PTD ),
        'param_name'    => 'click_open',
        'value'         => 'on',
        'title_switch'  => __('CLICK',TS_PTD).':'.__('HOVER',TS_PTD),
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __( 'Choose a defined color or a custom color', TS_PTD ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Custom Color', TS_PTD ),
        'param_name'    => 'custom_color',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => false
  ),
  //Accordion item
  array(
    'name'              => __('Accordion Item',TS_PTD),
    'base'              => 'ts_accordion',
    'js_view'           => 'TsAccordionTabView',
    'description'       => '',
    'category'          => __('Content',TS_PTD),
    'is_container'      => true,
    'icon'              => '',
    'class'             => '',
    'content_element'   => false,
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Title',TS_PTD),
        'param_name'    => 'title',
        'value'         => 'Section',
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon'
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Initially open', TS_PTD ),
        'param_name'    => 'activated'
      )
    ),
    'show_settings_on_create'   => false,
    'allowed_container_element' => 'vc_row'
  ),
  //Tabs
  array(
    'name'              => __( 'Tabs', TS_PTD ),
    'base'              => 'ts_tabs',
    'description'       => __( 'Add a tab content', TS_PTD ),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'dashicons-feedback',
    'class'             => '',
    'is_container'      => true,
    'custom_markup'     => '<div class="wpb_tabs_holder wpb_holder vc_container_for_children"><ul class="tabs_controls"></ul>%content%</div>',
    'default_content'   => '[ts_tab title="'.__( 'Tab 1', TS_PTD ).'" tab_id="'.$tab_id_1.'"][/ts_tab][ts_tab title="'.__( 'Tab 2' , TS_PTD ).'" tab_id="'.$tab_id_2.'"][/ts_tab]',
    'js_view'           => 'TsTabsView',
    'params'            => array(
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Tab Buttons Direction', TS_PTD ),
        'param_name'    => 'horizontal_buttons',
        'value'         => 'on',
        'title_switch'  => __( '&rarr;', TS_PTD ).':'.__( '&darr;', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Buttons Position', TS_PTD ),
        'param_name'    => 'left_buttons',
        'value'         => 'on',
        'title_switch'  => __('LEFT',TS_PTD).':'.__('RIGHT',TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Trigger', TS_PTD ),
        'param_name'    => 'click_open',
        'value'         => 'on',
        'title_switch'  => __( 'CLICK', TS_PTD ).':'.__( 'HOVER', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __( 'Choose a defined color or a custom color', TS_PTD ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Custom Color', TS_PTD ),
        'param_name'    => 'custom_color',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => false
  ),
  //Tab
  array(
    'name'              => __( 'Tab', TS_PTD ),
    'base'              => 'ts_tab',
    'description'       => __( 'Add a new tab', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => '',
    'class'             => '',
    'is_container'      => true,
    'js_view'           => 'TsTabView',
    'content_element'   => false,
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Title', TS_PTD ),
        'param_name'    => 'title'
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon'
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Initially open', TS_PTD ),
        'param_name'    => 'active_tab'
      )
    ),
    'show_settings_on_create' => false
  ),
  //Blockquote
  array(
    'name'              => __( 'Blockquote', TS_PTD ),
    'base'              => 'ts_blockquote',
    'description'       => __( 'Add a different style blockquote', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-quote-left',
    'class'             => '',
    'js_view'           => 'TsTextView',
    'wrapper_class'     => 'clearfix',
    'params'            => array(
      array(
        'type'          => 'textarea',
        'holder'        => 'div',
        'heading'       => __( 'Blockquote', TS_PTD ),
        'param_name'    => 'content',
        'value'         => __( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Author', TS_PTD ),
        'param_name'    => 'author_name',
        'value'         => '',
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Job', TS_PTD ),
        'param_name'    => 'author_job',
        'value'         => '',
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Quote Icon', TS_PTD ),
        'param_name'    => 'quote_icon',
        'value'         => 'off',
        'class'         => '',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Line Type', TS_PTD ),
        'param_name'    => 'horizontal_line',
        'value'         => 'off',
        'title_switch'  => __( 'Horizontal', TS_PTD ).':'.__( 'Vertical', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __( 'Choose a defined color or a custom color', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Custom Color', TS_PTD ),
        'param_name'    => 'custom_color',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Infobox
  array(
    'name'              => __( 'Info Box', TS_PTD ),
    'base'              => 'ts_infobox',
    'description'       => __( 'Add a modal info box', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-external-link',
    'class'             => '',
    'js_view'           => 'TsTextView',
    'wrapper_class'     => 'clearfix',
    'params'            => array(
      array(
        'type'          => 'textarea',
        'holder'        => 'div',
        'heading'       => '',
        'param_name'    => 'content',
        'value'         => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>

[ts_button title="Open Modal" url="#change-modal-id" class="mgf-modal"]

<div id="change-modal-id" class="white-popup-block mfp-hide">Modal Content Here</div>', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Line Type', TS_PTD ),
        'param_name'    => 'horizontal_line',
        'value'         => 'off',
        'title_switch'  => __( 'Horizontal', TS_PTD ).':'.__( 'Vertical', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __( 'Choose a defined color or a custom color', TS_PTD ),
        'class'         => '',
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Custom Color', TS_PTD ),
        'param_name'    => 'custom_color',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Alertboxes
  array(
    'name'              => __( 'Alert Boxes', TS_PTD ),
    'base'              => 'ts_alertbox',
    'js_view'           => 'TsAlertBoxView',
    'description'       => __( 'Add a custom alert box', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-check-square-o',
    'class'             => '',
    'wrapper_class'     => 'clearfix',
    'params'            => array(
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Model', TS_PTD ),
        'param_name'    => 'model',
        'value'         => array(
          __( 'Success', TS_PTD ) => 'success',
          __( 'Info', TS_PTD )    => 'info',
          __( 'Notice', TS_PTD )  => 'notice',
          __( 'Error', TS_PTD )   => 'error',
          __( 'Custom', TS_PTD )  => 'custom'
        ),
        'description'   => __( 'Choose your alert box type or add a custom alert box', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'model', 'value' => array( 'custom' ) )
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'BG Color', TS_PTD ),
        'param_name'    => 'bg_color',
        'class'         => '',
        'dependency'    => array( 'element' => 'model', 'value' => array( 'custom' ) )
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __( 'Text', TS_PTD ),
        'holder'        => 'div',
        'param_name'    => 'content',
        'value'         => __('Success',TS_PTD),
        'class'         => 'preview-alertbox'
      )
    )
  ),
  //Responsive Media
  array(
    'name'              => __( 'Responsive Media', TS_PTD ),
    'base'              => 'ts_media',
    'description'       => __( 'Add a responsive image or video', TS_PTD ),
    'category'          => __( 'Media', TS_PTD ),
    'icon'              => 'fa-youtube-play',
    'class'             => '',
    'wrapper_class'     => 'clearfix',
    'params'            => array(
      array(
        'type'          => 'upload_slupy',
        'heading'       => __( 'Image', TS_PTD ),
        'param_name'    => 'image_src',
        'holder'        => 'div',
        'value'         => '',
        'file_type'     => 'image',
        'class'         => '',
        'group'         => __('Image',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'URL', TS_PTD ),
        'param_name'    => 'url',
        'value'         => '',
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Image',TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Target', TS_PTD ),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Image',TS_PTD)
      ),
      array(
        'type'          => 'upload_slupy',
        'heading'       => __( 'Video (.mp4)', TS_PTD ),
        'param_name'    => 'video_mp4',
        'holder'        => 'div',
        'value'         => '',
        'file_type'     => 'video',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'upload_slupy',
        'heading'       => __( 'Video (.webm)', TS_PTD ),
        'param_name'    => 'video_webm',
        'holder'        => 'div',
        'value'         => '',
        'file_type'     => 'video',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'upload_slupy',
        'heading'       => __( 'Video (.ogv)', TS_PTD ),
        'param_name'    => 'video_ogv',
        'holder'        => 'div',
        'value'         => '',
        'file_type'     => 'video',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'upload_slupy',
        'heading'       => __( 'Video Poster', TS_PTD ),
        'param_name'    => 'poster',
        'holder'        => 'div',
        'value'         => '',
        'file_type'     => 'image',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'off',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Muted', TS_PTD ),
        'param_name'    => 'muted',
        'value'         => 'off',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Controls', TS_PTD ),
        'param_name'    => 'controls',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Video',TS_PTD)
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __( 'Paste Iframe Here', TS_PTD ),
        'param_name'    => 'content',
        'value'         => '',
        'class'         => '',
        'group'         => __('Embed',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Feature Box
  array(
    'name'              => __( 'Feature Box', TS_PTD ),
    'base'              => 'ts_featurebox',
    'js_view'           => 'TsFeatureBoxView',
    'description'       => __( 'Add a feature box', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-gift',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'attach_images',
        'heading'       => __( 'Images', TS_PTD ),
        'param_name'    => 'id',
        'value'         => '',
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon',
        'value'         => 'star-o',
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Heading', TS_PTD ),
        'holder'        => 'h3',
        'param_name'    => 'heading',
        'value'         => 'New Feature',
        'class'         => 'featurebox-heading',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __( 'Content', TS_PTD ),
        'param_name'    => 'content',
        'holder'        => 'div',
        'value'         => '',
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Trigger', TS_PTD ),
        'param_name'    => 'click_open',
        'value'         => 'off',
        'title_switch'  => __( 'CLICK', TS_PTD ).':'.__( 'HOVER', TS_PTD ),
        'class'         => '',
        'group'         => __('Extra',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'URL', TS_PTD ),
        'param_name'    => 'url',
        'value'         => '',
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Extra',TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Target', TS_PTD ),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Extra',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Slide Duration Time (second)', TS_PTD ),
        'param_name'    => 'duration_time',
        'group'         => __( 'Slider Config', TS_PTD ),
        'value'         => '5',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Stop on Hover', TS_PTD ),
        'param_name'    => 'stop_hover',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Navigation', TS_PTD ),
        'param_name'    => 'navigation',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Effect', TS_PTD ),
        'param_name'    => 'fade_effect',
        'value'         => 'on',
        'title_switch'  => __( 'FADE', TS_PTD ).':'.__( 'SCROLL', TS_PTD ),
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Touch Drag', TS_PTD ),
        'param_name'    => 'touch_drag',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Image Size',TS_PTD),
        'param_name'    => 'file_size',
        'value'         => $all_image_sizes,
        'class'         => '',
        'group'         => __('Style',TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Heading Size', TS_PTD ),
        'param_name'    => 'h_size',
        'value'         => $slupy_heading_options,
        'class'         => '',
        'group'         => __('Style',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Team Member
  array(
    'name'              => __( 'Team Member', TS_PTD ),
    'base'              => 'ts_team',
    'description'       => __( 'Add a team member', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'dashicons-groups',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'attach_images',
        'heading'       => __( 'Images', TS_PTD ),
        'param_name'    => 'id',
        'value'         => '',
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Name', TS_PTD ),
        'admin_label'   => true,
        'param_name'    => 'name',
        'value'         => 'John Doe',
        'class'         => 'featurebox-heading',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Job', TS_PTD ),
        'admin_label'   => true,
        'param_name'    => 'job',
        'value'         => '',
        'class'         => 'featurebox-heading',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textarea_html',
        'heading'       => __( 'Content', TS_PTD ),
        'param_name'    => 'content',
        'holder'        => 'div',
        'value'         => '',
        'class'         => '',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Slide Duration Time (second)', TS_PTD ),
        'param_name'    => 'duration_time',
        'group'         => __( 'Slider Config', TS_PTD ),
        'value'         => '5',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Stop on Hover', TS_PTD ),
        'param_name'    => 'stop_hover',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Navigation', TS_PTD ),
        'param_name'    => 'navigation',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Effect', TS_PTD ),
        'param_name'    => 'fade_effect',
        'value'         => 'on',
        'title_switch'  => __( 'FADE', TS_PTD ).':'.__( 'SCROLL', TS_PTD ),
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Touch Drag', TS_PTD ),
        'param_name'    => 'touch_drag',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Image Size', TS_PTD),
        'param_name'    => 'file_size',
        'value'         => $all_image_sizes,
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Heading Size', TS_PTD ),
        'param_name'    => 'h_size',
        'value'         => $slupy_heading_options,
        'class'         => '',
        'group'         => __('Style', TS_PTD),
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //List styles
  array(
    'name'              => __( 'List Styles', TS_PTD ),
    'base'              => 'ts_list',
    'js_view'           => 'TsListView',
    'description'       => __( 'Add a <ul> or <ol> list', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'dashicons-editor-ul',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Type', TS_PTD ),
        'param_name'    => 'type',
        'value'         => array( 
          __( 'Circle', TS_PTD )    => 'circle', 
          __( 'Square', TS_PTD )    => 'square', 
          __( 'Roman', TS_PTD )     => 'roman', 
          __( 'Latin', TS_PTD )     => 'latin', 
          __( 'Katakana', TS_PTD )  => 'katakana', 
          __( 'Custom', TS_PTD )    => 'custom' 
        ),
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'type', 'value' => array( 'custom' ) )
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __( 'Content', TS_PTD ),
        'param_name'    => 'content',
        'holder'        => 'div',
        'value'         => '<ul>
 <li>List</li>
 <li>List</li>
 <li>List</li>
</ul>',
        'class'         => 'preview-list'
      )
    )
  ),
  //Button
  array(
    'name'              => __( 'Button', TS_PTD ),
    'base'              => 'ts_button',
    'js_view'           => 'TsButtonView',
    'description'       => __( 'Add a button', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-square-o',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Title', TS_PTD ),
        'holder'        => 'div',
        'param_name'    => 'title',
        'value'         => __( 'Title', TS_PTD ),
        'class'         => 'preview-button'
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'URL', TS_PTD ),
        'param_name'    => 'url',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Target', TS_PTD ),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Size', TS_PTD ),
        'param_name'    => 'size',
        'value'         => array( 
          __( 'Small', TS_PTD )   => 'small', 
          __( 'Medium', TS_PTD )  => 'medium', 
          __( 'Large', TS_PTD )   => 'large', 
          __( 'X-Large', TS_PTD ) => 'xlarge'
        ),
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __( 'Icon', TS_PTD ),
        'param_name'    => 'icon',
        'value'         => '',
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Icon', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Icon Position', TS_PTD ),
        'param_name'    => 'icon_pos',
        'value'         => array( 
          __( 'Left', TS_PTD )  => 'left', 
          __( 'Right', TS_PTD ) => 'right', 
          __( 'Top', TS_PTD )   => 'top', 
          __( 'Bottom', TS_PTD )=> 'bottom'
        ),
        'class'         => '',
        'group'         => __('Icon', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Show Icon with Hover', TS_PTD ),
        'param_name'    => 'hover_effect',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Icon', TS_PTD)
      ),
      array(
        'type'        => 'switch_slupy',
        'heading'     => __('Border Style',TS_PTD),
        'param_name'  => 'border',
        'value'       => 'off',
        'title_switch'=> __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'class'       => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'        => 'switch_slupy',
        'heading'     => __('Title Attribute',TS_PTD),
        'param_name'  => 'title_attr',
        'value'       => 'off',
        'title_switch'=> __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'class'       => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => array(
          __( 'Default', TS_PTD )     => '',
          __( 'Dark Blue', TS_PTD )   => 'darkblue',
          __( 'Ocean Blue', TS_PTD )  => 'blue',
          __( 'Green', TS_PTD )       => 'green',
          __( 'Orange', TS_PTD )      => 'orange',
          __( 'Yellow', TS_PTD )      => 'yellow',
          __( 'White', TS_PTD )       => 'white',
          __( 'Custom', TS_PTD )      => 'custom'
        ),
        'description'   => __( 'Choose a defined color or custom color', TS_PTD ),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'bgcolor',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __( 'Color (Hover)', TS_PTD ),
        'param_name'    => 'bgcolorhover',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Align', TS_PTD ),
        'param_name'    => 'align',
        'value'         => array( '' => '', __( 'Right', TS_PTD ) => 'right', __( 'Center', TS_PTD ) => 'center', __( 'Left', TS_PTD ) => 'left'),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Buttons Set
  array(
    'name'              => __( 'Buttons Set', TS_PTD ),
    'base'              => 'ts_buttonset',
    'js_view'           => 'TsButtonsSetView',
    'description'       => __( 'Add a buttons set', TS_PTD ),
    'category'          => __( 'Content', TS_PTD ),
    'icon'              => 'fa-square',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Title', TS_PTD ),
        'param_name'    => 'title_left',
        'value'         => __( 'Title', TS_PTD ),
        'class'         => '',
        'group'         => __('Left Button', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'URL', TS_PTD ),
        'param_name'    => 'url',
        'value'         => '',
        'class'         => '',
        'group'         => __('Left Button', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Target', TS_PTD ),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Left Button', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Title', TS_PTD ),
        'param_name'    => 'center_text',
        'value'         => __( 'or', TS_PTD ),
        'description'   => __( 'Write a small text for buttons center', TS_PTD ),
        'class'         => '',
        'group'         => __('Center Text', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Title', TS_PTD ),
        'param_name'    => 'title_right',
        'value'         => __( 'Title', TS_PTD ),
        'class'         => '',
        'group'         => __('Right Button', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'URL', TS_PTD ),
        'param_name'    => 'url2',
        'value'         => '',
        'class'         => '',
        'group'         => __('Right Button', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Target', TS_PTD ),
        'param_name'    => 'target2',
        'value'         => $slupy_target_options,
        'description'   => __( '(Optional)', TS_PTD ),
        'class'         => '',
        'group'         => __('Right Button', TS_PTD)
      ),
      array(
        'type'        => 'switch_slupy',
        'heading'     => __('Border Style',TS_PTD),
        'param_name'  => 'border',
        'value'       => 'off',
        'title_switch'=> __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'class'       => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'        => 'switch_slupy',
        'heading'     => __('Title Attributes',TS_PTD),
        'param_name'  => 'title_attr',
        'value'       => 'off',
        'title_switch'=> __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'class'       => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => array(
          __( 'Default', TS_PTD )     => '',
          __( 'Dark Blue', TS_PTD )   => 'darkblue',
          __( 'Ocean Blue', TS_PTD )  => 'blue',
          __( 'Green', TS_PTD )       => 'green',
          __( 'Orange', TS_PTD )      => 'orange',
          __( 'Yellow', TS_PTD )      => 'yellow',
          __( 'White', TS_PTD )       => 'white',
          __( 'Default', TS_PTD )     => ''
        ),
        'description'   => __( 'Choose a defined color', TS_PTD ),
        'class'         => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Align', TS_PTD ),
        'param_name'    => 'align',
        'value'         => array( '' => '', __( 'Right', TS_PTD ) => 'right', __( 'Center', TS_PTD )   => 'center', __( 'Left', TS_PTD )  => 'left'),
        'class'         => '',
        'group'       => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Icon & Heading
  array(
    'name'              => __('Icon & Heading',TS_PTD),
    'base'              => 'ts_icon',
    'js_view'           => 'TsIconView',
    'description'       => __('Add font-awesome icons with heading',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-star-o',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'icon_slupy',
        'heading'       => __('Icon',TS_PTD),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Heading',TS_PTD),
        'param_name'    => 'heading',
        'holder'        => 'h3',
        'value'         => '',
        'class'         => 'icon-heading'
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Heading Small Text',TS_PTD),
        'param_name'    => 'small_text',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('URL',TS_PTD),
        'param_name'    => 'url',
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Target',TS_PTD),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textarea',
        'holder'        => 'div',
        'class'         => '',
        'heading'       => __( 'Content', TS_PTD ),
        'param_name'    => 'content',
        'group'         => __( 'Content', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Heading Size',TS_PTD),
        'param_name'    => 'h_size',
        'value'         => $slupy_heading_options,
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Icon Size',TS_PTD),
        'param_name'    => 'size',
        'value'         => array(
          __( 'Default', TS_PTD )   => 'none',
          __( 'Small', TS_PTD )     => 'small', 
          __( 'Medium', TS_PTD )    => 'medium',
          __( 'Large', TS_PTD )     => 'large', 
          __( 'X-Large', TS_PTD )   => 'xlarge', 
          __( 'XX-Large', TS_PTD )  => 'xxlarge'
        ),
        'description'   => __('If you add a icon without heading you can choose a size',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Table
  array(
    'name'              => __('Table',TS_PTD),
    'base'              => 'ts_table',
    'js_view'           => 'TsTableView',
    'description'       => __('Add a different style table',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-table',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textarea',
        'heading'       => '',
        'param_name'    => 'content',
        'holder'        => 'div',
        'value'         => '<table>
  <tr>
<th class="ts-center ts-min">ID</th>
    <th>Month</th>
    <th>Savings</th>
  </tr>
  <tr>
<td class="ts-center">1</td>
    <td>January</td>
    <td>$100</td>
  </tr>
  <tr>
<td class="ts-center">2</td>
    <td>February</td>
    <td>$120</td>
  </tr>
</table>',
        'class'         => 'preview-table',
        'group'         => __('Table', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Color',TS_PTD),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __('Choose a defined color or a custom color',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Custom Color',TS_PTD),
        'param_name'    => 'custom_color',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Pricing Table
  array(
    'name'              => __('Pricing Table',TS_PTD),
    'base'              => 'ts_pricingtable',
    'description'       => __('Add a pricing table',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-usd',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Heading',TS_PTD),
        'param_name'    => 'title',
        'value'         => 'Heading',
        'admin_label'   => true,
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Price Text',TS_PTD),
        'param_name'    => 'price_text',
        'admin_label'   => true,
        'value'         => '50.99',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Currency',TS_PTD),
        'param_name'    => 'sup_text',
        'value'         => __('$',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Period',TS_PTD),
        'param_name'    => 'sub_text',
        'value'         => __('/ MO',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __('Feature List',TS_PTD),
        'param_name'    => 'content',
        'value'         => '<ul>
<li>...</li>
<li>...</li>
<li>[ts_table_button title="JOIN US" size="large"]</li>
</ul>',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Highlight',TS_PTD),
        'param_name'    => 'highlight',
        'admin_label'   => true,
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Heading Size', TS_PTD ),
        'param_name'    => 'heading_type',
        'value'         => $slupy_heading_options,
        'class'         => '',
        'group'         => __('Style',TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Color',TS_PTD),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __('Choose a defined color or custom color',TS_PTD),
        'admin_label'   => true,
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Custom Color',TS_PTD),
        'param_name'    => 'custom_color',
        'value'         => '',
        'admin_label'   => true,
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Twitter
  array(
    'name'              => __('Twitter',TS_PTD),
    'base'              => 'ts_twitter',
    'description'       => __('Add a twitter feed',TS_PTD),
    'category'          => __('Social',TS_PTD),
    'icon'              => 'fa-twitter',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Twitter User Name',TS_PTD),
        'param_name'    => 'user_name',
        'value'         => __('envato',TS_PTD),
        'admin_label'   => true,
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('How Many Tweets?',TS_PTD),
        'param_name'    => 'count',
        'value'         => '2',
        'admin_label'   => true,
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Replies',TS_PTD),
        'param_name'    => 'replies',
        'value'         => 'on',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Retweeted',TS_PTD),
        'param_name'    => 'retweeted',
        'value'         => 'on',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Update Period (Minutes)',TS_PTD),
        'param_name'    => 'update_time',
        'admin_label'   => true,
        'value'         => '60',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Photo Stream
  array(
    'name'              => __('Photo Stream',TS_PTD),
    'base'              => 'ts_photostream',
    'description'       => __('Add a small gallery with your own images',TS_PTD),
    'category'          => __('Media',TS_PTD),
    'icon'              => 'fa-picture-o',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'attach_images',
        'heading'       => __('Images',TS_PTD),
        'param_name'    => 'id',
        'admin_label'   => true,
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('First Image Big',TS_PTD),
        'param_name'    => 'first_big',
        'value'         => 'on',
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Image Size',TS_PTD),
        'param_name'    => 'file_size',
        'value'         => $all_image_sizes,
        'class'         => '',
        'group'         => __('Style',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Instagram
  array(
    'name'              => __('Instagram',TS_PTD),
    'base'              => 'ts_instagram',
    'description'       => __('Add a Instagram stream',TS_PTD),
    'category'          => __('Social',TS_PTD),
    'icon'              => 'fa-instagram',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('User ID',TS_PTD),
        'param_name'    => 'user_id',
        'admin_label'   => true,
        'value'         => '269801886',
        'description'   => __('Write your User ID - Get <a href="http://jelled.com/instagram/lookup-user-id" target="_blank">here</a>',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Limit',TS_PTD),
        'param_name'    => 'count',
        'admin_label'   => true,
        'value'         => '6',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Update Period (Minutes)',TS_PTD),
        'param_name'    => 'update_time',
        'admin_label'   => true,
        'value'         => '60',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('First Image Big',TS_PTD),
        'param_name'    => 'first_big',
        'value'         => 'on',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Open with',TS_PTD),
        'param_name'    => 'open_url',
        'value'         => 'on',
        'title_switch'  => __('URL',TS_PTD).':'.__('LIGHTBOX',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //flickr
  array(
    'name'              => __('Flickr',TS_PTD),
    'base'              => 'ts_flickr',
    'description'       => __('Add a Flickr stream',TS_PTD),
    'category'          => __('Social',TS_PTD),
    'icon'              => 'fa-flickr',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('User ID',TS_PTD),
        'param_name'    => 'user_id',
        'admin_label'   => true,
        'value'         => '',
        'description'   => __('Write your User ID - Get <a href="http://idgettr.com/" target="_blank">here</a>',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Limit',TS_PTD),
        'param_name'    => 'count',
        'admin_label'   => true,
        'value'         => '6',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Update Period (Minutes)',TS_PTD),
        'param_name'    => 'update_time',
        'admin_label'   => true,
        'value'         => '60',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('First Image Big',TS_PTD),
        'param_name'    => 'first_big',
        'value'         => 'on',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Open with',TS_PTD),
        'param_name'    => 'open_url',
        'value'         => 'on',
        'title_switch'  => __('URL',TS_PTD).':'.__('LIGHTBOX',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //testimonials
  array(
    'name'              => __('Testimonials',TS_PTD),
    'base'              => 'ts_testimonials',
    'as_parent'         => array('only' => 'ts_testimonial'),
    'js_view'           => 'TsColumnView',
    'description'       => __('Add a testimonial slider',TS_PTD),
    'category'          => __('Slider',TS_PTD),
    'icon'              => 'fa-comments-o',
    'class'             => '',
    'content_element'   => true,
    'params'            => array(
      array(
        'type'          => 'dropdown',
        'heading'       => __('Testimonial Model',TS_PTD),
        'admin_label'   => true,
        'param_name'    => 'model',
        'value'         => array(
          __('Standard', TS_PTD)  => 'standard', 
          __('Big Image', TS_PTD) => 'big-testimonial'
        ),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Slide Duration Time (second)', TS_PTD ),
        'param_name'    => 'duration_time',
        'value'         => '5',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Stop on Hover', TS_PTD ),
        'param_name'    => 'stop_hover',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Navigation', TS_PTD ),
        'param_name'    => 'navigation',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Effect', TS_PTD ),
        'param_name'    => 'fade_effect',
        'value'         => 'on',
        'title_switch'  => __( 'FADE', TS_PTD ).':'.__( 'SCROLL', TS_PTD ),
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Touch Drag', TS_PTD ),
        'param_name'    => 'touch_drag',
        'value'         => 'on',
        'group'         => __( 'Slider Config', TS_PTD ),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => false
  ),
  //testimonial
  array(
    'name'              => __('Testimonial',TS_PTD),
    'base'              => 'ts_testimonial',
    'js_view'           => 'TsTextView',
    'description'       => __('A Testimonial Item',TS_PTD),
    'as_child'          => array('only' => 'ts_testimonials'),
    'category'          => __('Slider',TS_PTD),
    'icon'              => '',
    'class'             => '',
    'content_element'   => false,
    'params'            => array(
      array(
        'type'          => 'textarea_html',
        'heading'       => __('Testimonial Content',TS_PTD),
        'param_name'    => 'content',
        'holder'        => 'div',
        'value'         => __('<p>Testimonial content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Name',TS_PTD),
        'param_name'    => 'client_name',
        'value'         => __('John Doe', TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Job',TS_PTD),
        'param_name'    => 'client_job',
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'attach_image',
        'heading'       => __('Image',TS_PTD),
        'param_name'    => 'client_image',
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      )
    )
  ),
  //responsive slider
  array(
    'name'              => __('Responsive Slider',TS_PTD),
    'base'              => 'ts_slider',
    'as_parent'         => array('only' => 'ts_slideritem'),
    'js_view'           => 'TsColumnView',
    'description'       => __('Add a responsive slider',TS_PTD),
    'category'          => __('Slider',TS_PTD),
    'icon'              => 'fa-picture-o',
    'class'             => '',
    'content_element'   => true,
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Slide Duration Time (second)', TS_PTD ),
        'param_name'    => 'duration_time',
        'value'         => '5',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Stop on Hover', TS_PTD ),
        'param_name'    => 'stop_hover',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Navigation', TS_PTD ),
        'param_name'    => 'navigation',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Pagination', TS_PTD ),
        'param_name'    => 'pagination',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Effect', TS_PTD ),
        'param_name'    => 'fade_effect',
        'value'         => 'on',
        'title_switch'  => __( 'FADE', TS_PTD ).':'.__( 'SCROLL', TS_PTD ),
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Touch Drag', TS_PTD ),
        'param_name'    => 'touch_drag',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Auto Height',TS_PTD),
        'param_name'    => 'auto_height',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => false
  ),
  //responsive slider item
  array(
    'name'              => __('Slider Item',TS_PTD),
    'base'              => 'ts_slideritem',
    'as_child'          => array('only' => 'ts_slider'),
    'description'       => __('Add a slide for Responsive Slider',TS_PTD),
    'category'          => __('Slider',TS_PTD),
    'icon'              => '',
    'class'             => '',
    'content_element'   => false,
    'params'            => array(
      array(
        'type'          => 'upload_slupy',
        'heading'       => __('Image',TS_PTD),
        'admin_label'   => true,
        'param_name'    => 'src',
        'value'         => '',
        'file_type'     => 'image',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Title',TS_PTD),
        'param_name'    => 'title',
        'admin_label'   => true,
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __('Description',TS_PTD),
        'param_name'    => 'content',
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Description Vertical Position',TS_PTD),
        'param_name'    => 'v_pos',
        'value'         => array(__('Top', TS_PTD) => 'top', __('Bottom', TS_PTD) => 'bottom'),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Description Horizontal Position',TS_PTD),
        'param_name'    => 'h_pos',
        'value'         => array(__('Left', TS_PTD) => 'left', __('Right', TS_PTD) => 'right', __('Center', TS_PTD) => 'center'),
        'class'         => ''
      )
    )
  ),
  //Progress bar
  array(
    'name'              => __('Progress Bar',TS_PTD),
    'base'              => 'ts_bar',
    'description'       => __('Add a progress bar',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-tasks',
    'class'             => '',
    'content_element'   => true,
    'params'            => array(
      array(
        'type'          => 'icon_slupy',
        'heading'       => __('Icon',TS_PTD),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Title',TS_PTD),
        'admin_label'   => true,
        'param_name'    => 'title',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Percentage (%)',TS_PTD),
        'param_name'    => 'percentage',
        'admin_label'   => true,
        'value'         => '50',
        'description'   => __('Choose 1 between 100',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Percentage Text',TS_PTD),
        'param_name'    => 'percentage_text',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Model',TS_PTD),
        'admin_label'   => true,
        'param_name'    => 'model',
        'value'         => array(
          __('White Label', TS_PTD) => 'white-label',
          __('Standard', TS_PTD)    => 'standard',
          __('Thin', TS_PTD)        => 'thin'
        ),
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Animated',TS_PTD),
        'param_name'    => 'animated',
        'admin_label'   => true,
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Color',TS_PTD),
        'param_name'    => 'color',
        'value'         => $slupy_color_options,
        'description'   => __('Choose a defined color or custom color',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Custom Color',TS_PTD),
        'param_name'    => 'custom_color',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Pie Chart
  array(
    'name'              => __('Pie Chart',TS_PTD),
    'base'              => 'ts_chart',
    'description'       => __('Animated pie chart',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'dashicons-chart-pie',
    'class'             => '',
    'content_element'   => true,
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Title',TS_PTD),
        'param_name'    => 'title',
        'admin_label'   => true,
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Percentage',TS_PTD),
        'param_name'    => 'percentage',
        'admin_label'   => true,
        'value'         => __('50',TS_PTD),
        'description'   => __('Choose -100 between 100',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __('Percentage Icon',TS_PTD),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Percentage Text',TS_PTD),
        'param_name'    => 'percentage_text',
        'value'         => '',
        'description'   => __('If you write a percentage equal value numbers can be animated',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Model',TS_PTD),
        'admin_label'   => true,
        'param_name'    => 'model',
        'value'         => array(__('Standard', TS_PTD) => 'standard', __('Tooltip Text', TS_PTD) => 'tooltip'),
        'class'         => '',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Tooltip Position',TS_PTD),
        'param_name'    => 'tooltip_top',
        'value'         => 'on',
        'title_switch'  => __('TOP',TS_PTD).':'.__('BOTTOM',TS_PTD),
        'class'         => '',
        'dependency'    => array( 'element' => 'model', 'value' => array( 'tooltip' ) ),
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Tooltip Handler',TS_PTD),
        'param_name'    => 'tooltip_hover',
        'value'         => 'on',
        'title_switch'  => __('HOVER',TS_PTD).':'.__('CLICK',TS_PTD),
        'class'         => '',
        'dependency'    => array( 'element' => 'model', 'value' => array( 'tooltip' ) ),
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Animated',TS_PTD),
        'param_name'    => 'animated',
        'value'         => 'on',
        'admin_label'   => true,
        'class'         => '',
        'group'         => __( 'Extra', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Size',TS_PTD),
        'param_name'    => 'size',
        'admin_label'   => true,
        'value'         => array(__('Small', TS_PTD) => '128', __('Medium', TS_PTD) => '196', __('Large', TS_PTD) => '256'),
        'class'         => '',
        'group'         => __( 'Style', TS_PTD )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Color',TS_PTD),
        'param_name'    => 'color',
        'value'         => array(
          __( 'Default', TS_PTD )     => '',
          __( 'Dark Blue', TS_PTD )   => 'darkblue',
          __( 'Ocean Blue', TS_PTD )  => 'blue',
          __( 'Green', TS_PTD )       => 'green',
          __( 'Orange', TS_PTD )      => 'orange',
          __( 'Yellow', TS_PTD )      => 'yellow',
          __( 'White', TS_PTD )       => 'white',
          __( 'Custom', TS_PTD )      => 'custom'
        ),
        'description'   => __('Choose a defined color or custom color',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Track Color',TS_PTD),
        'param_name'    => 'track_color',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Custom Color',TS_PTD),
        'param_name'    => 'custom_color',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //milestone
  array(
    'name'              => __('Milestone',TS_PTD),
    'base'              => 'ts_milestone',
    'description'       => __('Add a milestone element',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-sort-numeric-asc',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Start',TS_PTD),
        'param_name'    => 'start',
        'admin_label'   => true,
        'value'         => '0',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('End',TS_PTD),
        'param_name'    => 'end',
        'admin_label'   => true,
        'value'         => '200',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Duration',TS_PTD),
        'param_name'    => 'duration',
        'admin_label'   => true,
        'value'         => '4',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Subject',TS_PTD),
        'param_name'    => 'subject',
        'admin_label'   => true,
        'value'         => '',
        'class'         => ''
      ),
      array(
        'type'          => 'icon_slupy',
        'heading'       => __('Icon',TS_PTD),
        'param_name'    => 'icon',
        'value'         => '',
        'class'         => '',
        'group'         => __('Icon',TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Icon Position',TS_PTD),
        'param_name'    => 'icon_pos',
        'value'         => array(__('Top', TS_PTD) => 'top', __('Left', TS_PTD) => 'left', __('Right', TS_PTD) => 'right'),
        'class'         => '',
        'group'         => __('Icon',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Numbers Before',TS_PTD),
        'param_name'    => 'before',
        'value'         => '',
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Numbers After',TS_PTD),
        'param_name'    => 'after',
        'value'         => '',
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Decimals',TS_PTD),
        'param_name'    => 'decimals',
        'value'         => '0',
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Number Separator',TS_PTD),
        'param_name'    => 'separator',
        'value'         => 'on',
        'title_switch'  => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'class'         => '',
        'group'         => __('Extra', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Size', TS_PTD ),
        'param_name'    => 'size',
        'value'         => array( 
          __( 'XX-Small', TS_PTD )   => 'xxsmall',
          __( 'X-Small', TS_PTD )   => 'xsmall',
          __( 'Small', TS_PTD )   => 'small',
          __( 'Medium', TS_PTD )  => 'medium',
          __( 'Large', TS_PTD )   => 'large',
          __( 'X-Large', TS_PTD ) => 'xlarge'
        ),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Color', TS_PTD ),
        'param_name'    => 'color',
        'value'         => array(
          __( 'Default', TS_PTD )     => '',
          __( 'Dark Blue', TS_PTD )   => 'darkblue',
          __( 'Ocean Blue', TS_PTD )  => 'blue',
          __( 'Green', TS_PTD )       => 'green',
          __( 'Orange', TS_PTD )      => 'orange',
          __( 'Yellow', TS_PTD )      => 'yellow',
          __( 'White', TS_PTD )       => 'white'
        ),
        'description'   => __( 'Choose a defined color or custom color', TS_PTD ),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Number Color',TS_PTD),
        'param_name'    => 'number_color',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Subject Color',TS_PTD),
        'param_name'    => 'subject_color',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Icon Color',TS_PTD),
        'param_name'    => 'icon_color',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //Countdown
  array(
    'name'              => __('Countdown',TS_PTD),
    'base'              => 'ts_countdown',
    'description'       => __('Add a countdown element',TS_PTD),
    'category'          => __('Content',TS_PTD),
    'icon'              => 'fa-sort-numeric-desc',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Date',TS_PTD),
        'param_name'    => 'date',
        'admin_label'   => true,
        'value'         => 'Jul 11 2016 20:56:10',
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Format',TS_PTD),
        'param_name'    => 'format',
        'value'         => array('yowdhms' => 'yowdhms', 'YDHMS' => 'YDHMS', 'DHMS' => 'DHMS', 'HMS' => 'HMS', __('Custom', TS_PTD) => 'custom'),
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Custom Format',TS_PTD),
        'param_name'    => 'custom_format',
        'value'         => 'YOWDHMS',
        'description'   => __('Use the following characters (in order) to indicate which periods you want to display: <strong>"Y"</strong> for years, <strong>"O"</strong> for months, <strong>"W"</strong> for weeks, <strong>"D"</strong> for days, <strong>"H"</strong> for hours, <strong>"M"</strong> for minutes, <strong>"S"</strong> for seconds. Use upper-case characters for mandatory periods, or the corresponding lower-case characters for optional periods, i.e. only display if non-zero. Once one optional period is shown, all the ones after that are also shown.', TS_PTD),
        'class'         => '',
        'dependency'    => array( 'element' => 'format', 'value' => array( 'custom' ) ),
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Model',TS_PTD),
        'param_name'    => 'model',
        'value'         => array(__('Standard', TS_PTD) => 'standard', __('Circle', TS_PTD) => 'circle', __('Square', TS_PTD) => 'square'),
        'class'         => '',
        'group'         => __('Style',TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    )
  ),
  //our clients
  array(
    'name'              => __('Image Carousel',TS_PTD),
    'base'              => 'ts_clients',
    'as_parent'         => array('only' => 'ts_client'),
    'js_view'           => 'TsColumnView',
    'description'       => __('Add a image carousel',TS_PTD),
    'category'          => __('Slider',TS_PTD),
    'icon'              => 'dashicons-slides',
    'class'             => '',
    'content_element'   => true,
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Slide Duration Time (second)', TS_PTD ),
        'param_name'    => 'duration_time',
        'value'         => '5',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Auto Play', TS_PTD ),
        'param_name'    => 'autoplay',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Stop on Hover', TS_PTD ),
        'param_name'    => 'stop_hover',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Pagination', TS_PTD ),
        'param_name'    => 'pagination',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __( 'Touch Drag', TS_PTD ),
        'param_name'    => 'touch_drag',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Slider Config', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Show Max Items',TS_PTD),
        'param_name'    => 'show_max_item',
        'value'         => '6',
        'class'         => '',
        'group'         => __('Layout Config', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Show Max Items (Desktop)',TS_PTD),
        'param_name'    => 'show_max_desktop',
        'value'         => '4',
        'class'         => '',
        'group'         => __('Layout Config', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Show Max Items (Tablet)',TS_PTD),
        'param_name'    => 'show_max_tablet',
        'value'         => '2',
        'class'         => '',
        'group'         => __('Layout Config', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('Show Max Items (Mobile)',TS_PTD),
        'param_name'    => 'show_max_mobile',
        'value'         => '1',
        'class'         => '',
        'group'         => __('Layout Config', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Image Grayscale',TS_PTD),
        'param_name'    => 'grayscale',
        'value'         => 'on',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Classic Style',TS_PTD),
        'param_name'    => 'classic',
        'value'         => 'off',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => false
  ),
  //responsive slider item
  array(
    'name'              => __('Carousel Item',TS_PTD),
    'base'              => 'ts_client',
    'as_child'          => array('only' => 'ts_clients'),
    'description'       => __('Add a carousel item',TS_PTD),
    'category'          => __('Media',TS_PTD),
    'icon'              => '',
    'class'             => '',
    'content_element'   => false,
    'params'            => array(
      array(
        'type'          => 'upload_slupy',
        'heading'       => __('Image',TS_PTD),
        'param_name'    => 'src',
        'admin_label'   => true,
        'value'         => '',
        'file_type'     => 'image',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __('URL',TS_PTD),
        'param_name'    => 'url',
        'value'         => '',
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Target',TS_PTD),
        'param_name'    => 'target',
        'value'         => $slupy_target_options,
        'description'   => __('(Optional)',TS_PTD),
        'class'         => ''
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Color',TS_PTD),
        'param_name'    => 'color',
        'admin_label'   => true,
        'value'         => $slupy_color_options,
        'description'   => __('Choose a defined color or custom color',TS_PTD),
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'colorpicker',
        'heading'       => __('Custom Color',TS_PTD),
        'param_name'    => 'custom_color',
        'value'         => '',
        'class'         => '',
        'dependency'    => array( 'element' => 'color', 'value' => array( 'custom' ) ),
        'group'         => __('Style', TS_PTD)
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => '',
        'group'         => __('Style', TS_PTD)
      )
    ),
    'show_settings_on_create' => true
  ),
  //Gap
  array(
    'name'              => __( 'Gap', TS_PTD ),
    'base'              => 'ts_gap',
    'description'       => __( 'Use a gap shortcode', TS_PTD ),
    'category'          => __( 'Helper', TS_PTD ),
    'icon'              => 'dashicons-image-flip-vertical',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Size', TS_PTD),
        'param_name'    => 'size',
        'admin_label'   => true,
        'value'         => '30px',
        'class'         => ''
      ),
      array(
        'type'          => 'switch_slupy',
        'heading'       => __('Horizontal Gap',TS_PTD),
        'param_name'    => 'horizontal_gap',
        'value'         => 'off',
        'class'         => ''
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Extra Class', TS_PTD ),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => ''
      )
    )
  ),
  //Clear
  array(
    'name'              => __( 'Clear', TS_PTD ),
    'base'              => 'ts_clear',
    'description'       => __( 'Use a clear shortcode', TS_PTD ),
    'category'          => __( 'Helper', TS_PTD ),
    'icon'              => 'dashicons-editor-removeformatting',
    'class'             => '',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __('Extra Class',TS_PTD),
        'param_name'    => 'class',
        'value'         => '',
        'class'         => ''
      )
    ),
    'show_settings_on_create' => false
  ),
  //sidebar
  array(
    'name'              => __('Sidebar',TS_PTD),
    'base'              => 'ts_sidebar',
    'description'       => __('Place widgetised sidebar',TS_PTD),
    'category'          => __('Structure',TS_PTD),
    'icon'              => 'dashicons-welcome-widgets-menus',
    'class'             => 'wpb_widget_sidebar_widget',
    'params'            => array(
      array(
        'type'          => 'widgetised_sidebars',
        'heading'       => __( 'Sidebar', TS_PTD ),
        'admin_label'   => true,
        'param_name'    => 'sidebar_id'
      )
    )
  ),
  //widgets
  array(
    'name'              => __('Widget',TS_PTD),
    'base'              => 'ts_widget',
    'description'       => __('Add a single WP widget',TS_PTD),
    'category'          => __('Structure',TS_PTD),
    'icon'              => 'dashicons-welcome-widgets-menus',
    'class'             => 'wpb_widget_sidebar_widget',
    'params'            => array(
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Widget title', TS_PTD ),
        'param_name'    => 'title',
        'description'   => __( 'What text use as a widget title. Leave blank to use default widget title.', TS_PTD ),
        'admin_label'   => true,
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __('Widget Type',TS_PTD),
        'param_name'    => 'widget',
        'value'         => array(
          __('Archives', TS_PTD)          => 'WP_Widget_Archives',
          __('Calendar', TS_PTD)          => 'WP_Widget_Calendar',
          __('Categories', TS_PTD)        => 'WP_Widget_Categories',
          __('Meta', TS_PTD)              => 'WP_Widget_Meta',
          __('Pages', TS_PTD)             => 'WP_Widget_Pages',
          __('Recent Comments', TS_PTD)   => 'WP_Widget_Recent_Comments',
          __('Recent Posts', TS_PTD)      => 'WP_Widget_Recent_Posts',
          __('RSS', TS_PTD)               => 'WP_Widget_RSS',
          __('Search', TS_PTD)            => 'WP_Widget_Search',
          __('Tag Cloud', TS_PTD)         => 'WP_Widget_Tag_Cloud',
          __('Custom Menu', TS_PTD)       => 'WP_Nav_Menu_Widget',
        ),
        'class'         => '',
        'admin_label'   => true
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Limit', TS_PTD ),
        'param_name'    => 'number',
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Recent_Comments', 'WP_Widget_Recent_Posts' ) )
      ),
      array(
        'type'        => 'switch_slupy',
        'heading'     => __('Display post date?', TS_PTD ),
        'param_name'  => 'show_date',
        'value'       => 'on',
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Recent_Posts' ) )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Sort by', TS_PTD ),
        'param_name'    => 'sortby',
        'value'         => array(
          __( 'Page title', TS_PTD ) => 'post_title',
          __( 'Page order', TS_PTD ) => 'menu_order',
          __( 'Page ID', TS_PTD )    => 'ID'
        ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Pages' ) )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'Exclude', TS_PTD ),
        'param_name'    => 'exclude',
        'description'   => __( 'Page IDs, separated by commas.', TS_PTD ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Pages' ) )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Taxonomy', TS_PTD ),
        'param_name'    => 'taxonomy',
        'value'         => $tag_taxonomies,
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Tag_Cloud' ) )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Menu', TS_PTD ),
        'param_name'    => 'nav_menu',
        'value'         => $custom_menus,
        'description'   => empty( $custom_menus ) ? __( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', TS_PTD ) : __( 'Select menu', TS_PTD ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Nav_Menu_Widget' ) )
      ),
      array(
        'type'          => 'textarea',
        'heading'       => __( 'Text', TS_PTD ),
        'param_name'    => 'content',
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Text' ) )
      ),
      array(
        'type'          => 'checkbox',
        'heading'       => __( 'Options', TS_PTD ),
        'param_name'    => 'cat_options',
        'value'         => array(
          __( 'Display as dropdown', TS_PTD ) => 'dropdown',
          __( 'Show post counts', TS_PTD )    => 'count',
          __( 'Show hierarchy', TS_PTD )      => 'hierarchical'
        ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Categories' ) )
      ),
      array(
        'type'          => 'checkbox',
        'heading'       => __( 'Options', TS_PTD ),
        'param_name'    => 'archive_options',
        'value'         => array(
          __( 'Display as dropdown', TS_PTD ) => 'dropdown',
          __( 'Show post counts', TS_PTD )    => 'count'
        ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_Archives' ) )
      ),
      array(
        'type'          => 'textfield',
        'heading'       => __( 'RSS feed URL', TS_PTD ),
        'param_name'    => 'url',
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_RSS' ) )
      ),
      array(
        'type'          => 'dropdown',
        'heading'       => __( 'Items', TS_PTD ),
        'param_name'    => 'items',
        'value'         => array( __( '10 - Default', TS_PTD ) => '', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ),
        'description'   => __( 'How many items would you like to display?', TS_PTD ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_RSS' ) )
      ),
      array(
        'type'          => 'checkbox',
        'heading'       => __( 'Options', TS_PTD ),
        'param_name'    => 'rss_options',
        'value'         => array(
          __( 'Display item content?', TS_PTD )             => 'show_summary',
          __( 'Display item author if available?', TS_PTD ) => 'show_author',
          __( 'Display item date?', TS_PTD )                => 'show_date'
        ),
        'dependency'    => array( 'element' => 'widget', 'value' => array( 'WP_Widget_RSS' ) )
      )
    )
  ),
));

return $options;

}

}

add_filter( 'vc_maps_for_slupy', 'ts_shortcodes_for_vc', 11 );

/*---------------------------------------------
    Customize Shortcode Editor
---------------------------------------------*/
class disable_vc_backend_title extends WPBakeryShortCode{
  public function outputTitle($title) {
      return '';
  }
}

class WPBakeryShortCode_TS_TESTIMONIALS extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_TS_TESTIMONIAL extends disable_vc_backend_title{}

class WPBakeryShortCode_TS_SLIDER extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_TS_SLIDERITEM extends WPBakeryShortCode {}

class WPBakeryShortCode_TS_BARS extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_TS_BAR extends WPBakeryShortCode {}

class WPBakeryShortCode_TS_CHARTS extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_TS_CHAR extends WPBakeryShortCode {}

class WPBakeryShortCode_TS_CLIENTS extends WPBakeryShortCodesContainer {}
class WPBakeryShortCode_TS_CLIENT extends WPBakeryShortCode {}

require_once vc_path_dir('SHORTCODES_DIR', 'vc-tabs.php');
require_once vc_path_dir('SHORTCODES_DIR', 'vc-tab.php');
require_once vc_path_dir('SHORTCODES_DIR', 'vc-accordion.php');
require_once vc_path_dir('SHORTCODES_DIR', 'vc-accordion-tab.php');

class WPBakeryShortCode_TS_ACCORDIONS extends WPBakeryShortCode_VC_Accordion {}
class WPBakeryShortCode_TS_ACCORDION extends WPBakeryShortCode_VC_Accordion_tab{}

class WPBakeryShortCode_TS_TABS extends WPBakeryShortCode_VC_Tabs {}
class WPBakeryShortCode_TS_TAB extends WPBakeryShortCode_VC_Tab{}


class WPBakeryShortCode_TS_TOGGLE extends disable_vc_backend_title{}
class WPBakeryShortCode_TS_BLOCKQUOTE extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_BUTTON extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_ALERTBOX extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_FEATUREBOX extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_BUTTONSET extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_ICON extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_TABLE extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_LIST extends disable_vc_backend_title {}
class WPBakeryShortCode_TS_INFOBOX extends disable_vc_backend_title {}