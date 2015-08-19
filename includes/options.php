<?php

/*---------------------------------------------
  Columns Layout Options
---------------------------------------------*/
if( !function_exists('columns_layout_options') ) {

function columns_layout_options($args) {

$columns_settings = array(
  array(
    'title'         => __('Columns Layout',TS_PTD),
    'id'            => TS_PLUGIN.'layouts_sc',
    'shortcode'     => '[ts_section{attr}][ts_row]{content}[/ts_row][/ts_section]',
    'options'       => array(
      array(
        'title'     => __('Columns',TS_PTD),
        'name'      => 'columns_layouts',
        'id'        => TS_PLUGIN.'columns_layouts',
        'class'     => '',
        'choices'   => array(
            array('label' => '1','value' => '[ts_column size="12"]{column_1}[/ts_column]','src' => TS_PLUGIN_URL . '/images/1.jpg'),
            array('label' => '2','value' => '[ts_column size="6"]{column_1}[/ts_column][ts_column size="6"]{column_2}[/ts_column]','src' => TS_PLUGIN_URL . '/images/2.jpg'),
            array('label' => '3','value' => '[ts_column size="4"]{column_1}[/ts_column][ts_column size="4"]{column_2}[/ts_column][ts_column size="4"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/3.jpg'),
            array('label' => '4','value' => '[ts_column size="3"]{column_1}[/ts_column][ts_column size="3"]{column_2}[/ts_column][ts_column size="3"]{column_3}[/ts_column][ts_column size="3"]{column_4}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/4.jpg'),
            array('label' => '6','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column][ts_column size="2"]{column_4}[/ts_column][ts_column size="2"]{column_5}[/ts_column][ts_column size="2"]{column_6}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/6.jpg'),
            array('label' => '3','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="8"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/7.jpg'),
            array('label' => '3','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="8"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/8.jpg'),
            array('label' => '3','value' => '[ts_column size="6"]{column_1}[/ts_column][ts_column size="3"]{column_2}[/ts_column][ts_column size="3"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/9.jpg'),
            array('label' => '3','value' => '[ts_column size="3"]{column_1}[/ts_column][ts_column size="6"]{column_2}[/ts_column][ts_column size="3"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/10.jpg'),
            array('label' => '3','value' => '[ts_column size="3"]{column_1}[/ts_column][ts_column size="3"]{column_2}[/ts_column][ts_column size="6"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/11.jpg'),
            array('label' => '3','value' => '[ts_column size="5"]{column_1}[/ts_column][ts_column size="5"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/12.jpg'),
            array('label' => '3','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="5"]{column_2}[/ts_column][ts_column size="5"]{column_3}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/13.jpg'),
            array('label' => '4','value' => '[ts_column size="6"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column][ts_column size="2"]{column_4}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/14.jpg'),
            array('label' => '4','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column][ts_column size="6"]{column_4}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/15.jpg'),
            array('label' => '5','value' => '[ts_column size="4"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column][ts_column size="2"]{column_4}[/ts_column][ts_column size="2"]{column_5}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/16.jpg'),
            array('label' => '5','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="4"]{column_3}[/ts_column][ts_column size="2"]{column_4}[/ts_column][ts_column size="2"]{column_5}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/17.jpg'),
            array('label' => '5','value' => '[ts_column size="2"]{column_1}[/ts_column][ts_column size="2"]{column_2}[/ts_column][ts_column size="2"]{column_3}[/ts_column][ts_column size="2"]{column_4}[/ts_column][ts_column size="4"]{column_5}[/ts_column]','src'  => TS_PLUGIN_URL . '/images/18.jpg')
        ),
        'mode'      => 'content',
        'value'     => '[ts_column size="12"]{column_1}[/ts_column]',
        'type'      => 'radio-image'
      ),
      array(
        'title'     => __('Content',TS_PTD),
        'name'      => 'column_1',
        'id'        => TS_PLUGIN.'spe_content',
        'rows'      => '5',
        'class'     => '',
        'mode'      => 'fake',
        'value'     => '1',
        'type'      => 'textarea'
      )
    )
  ));

  return array_merge($args,$columns_settings);

}

}

/*---------------------------------------------
  Other Shortcodes Options
---------------------------------------------*/
if( !function_exists('themesama_options_values') ) {

function themesama_options_values($args){

  $ts_shortcode_colors = array(
    array(
      'label' => __('Default',TS_PTD),
      'value' => ''
    ),
    array(
      'label' => __('Dark Blue',TS_PTD),
      'value' => 'darkblue'
    ),
    array(
      'label' => __('Ocean Blue',TS_PTD),
      'value' => 'blue'
    ),
    array(
      'label' => __('Green',TS_PTD),
      'value' => 'green'
    ),
    array(
      'label' => __('Orange',TS_PTD),
      'value' => 'orange'
    ),
    array(
      'label' => __('Yellow',TS_PTD),
      'value' => 'yellow'
    ),
    array(
      'label' => __('Custom',TS_PTD),
      'value' => 'custom'
    )
  );

  $ts_shortcode_colors3 = array(
    array(
      'label' => __('Default',TS_PTD),
      'value' => ''
    ),
    array(
      'label' => __('Dark Blue',TS_PTD),
      'value' => 'darkblue'
    ),
    array(
      'label' => __('Ocean Blue',TS_PTD),
      'value' => 'blue'
    ),
    array(
      'label' => __('Green',TS_PTD),
      'value' => 'green'
    ),
    array(
      'label' => __('Orange',TS_PTD),
      'value' => 'orange'
    ),
    array(
      'label' => __('Yellow',TS_PTD),
      'value' => 'yellow'
    ),
    array(
      'label' => __('White',TS_PTD),
      'value' => 'white'
    ),
    array(
      'label' => __('Custom',TS_PTD),
      'value' => 'custom'
    )
  );

  $ts_shortcode_colors_2 = $ts_shortcode_colors;
  array_pop($ts_shortcode_colors_2);

  $ts_shortcode_target = array(
    array(
      'label' => '',
      'value' => ''
    ),
    array(
      'label' => '_blank',
      'value' => '_blank'
    ),
    array(
      'label' => '_self',
      'value' => '_self'
    ),
    array(
      'label' => '_parent',
      'value' => '_parent'
    ),
    array(
      'label' => '_top',
      'value' => '_top'
    )
  );
  
$themesama_settings = array(
  array(
    'title'         => __('Button',TS_PTD),
    'id'            => TS_PLUGIN.'button_sc',
    'shortcode'     => '[ts_button{attr}]{content}[/ts_button]',
    'options'       => array(
      array(
        'title'     => __('Title',TS_PTD),
        'name'      => 'title',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('URL',TS_PTD),
        'name'      => 'url',
        'id'        => '',
        'dependid'  => 'button_sc_url',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Target',TS_PTD),
        'name'      => 'target',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_target,
        'value'     => '',
        'type'      => 'select',
        'depends'   => '!button_sc_url'
      ),
      array(
        'title'     => __('Size',TS_PTD),
        'name'      => 'size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Small',TS_PTD),
            'value' => 'small'
          ),
          array(
            'label' => __('Medium',TS_PTD),
            'value' => 'medium'
          ),
          array(
            'label' => __('Large',TS_PTD),
            'value' => 'large'
          ),
          array(
            'label' => __('X-Large',TS_PTD),
            'value' => 'xlarge'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'controls',
        'id'        => '',
        'dependid'  => 'button_sc_icon',
        'class'     => '',
        'value'     => 'off',
        'mode'      => 'fake',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Choose a Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => 'hide',
        'type'      => 'iconbox',
        'depends'   => 'button_sc_icon:on'
      ),
      array(
        'title'     => __('Icon Position',TS_PTD),
        'name'      => 'icon_pos',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Left',TS_PTD),
            'value' => 'left'
          ),
          array(
            'label' => __('Right',TS_PTD),
            'value' => 'right'
          ),
          array(
            'label' => __('Top',TS_PTD),
            'value' => 'top'
          ),
          array(
            'label' => __('Bottom',TS_PTD),
            'value' => 'bottom'
          )
          
        ),
        'value'     => '',
        'type'      => 'select',
        'depends'   => 'button_sc_icon:on'
      ),
      array(
        'title'     => __('Show Icon with Hover',TS_PTD),
        'name'      => 'hover_effect',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'button_sc_icon:on'
      ),
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'button_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'bgcolor',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'button_sc_color:custom'
      ),
      array(
        'title'     => __('Color (Hover)',TS_PTD),
        'name'      => 'bgcolorhover',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'button_sc_color:custom'
      ),
      array(
        'title'     => __('Align',TS_PTD),
        'name'      => 'align',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => '',
            'value' => ''
          ),
          array(
            'label' => __('Right',TS_PTD),
            'value' => 'right'
          ),
          array(
            'label' => __('Center',TS_PTD),
            'value' => 'center'
          ),
          array(
            'label' => __('Left',TS_PTD),
            'value' => 'left'
          )
          
        ),
        'value'     => '',
        'type'      => 'select'
      )
    )

  ),
  array(
    'title'         => __('Buttons Set',TS_PTD),
    'id'            => TS_PLUGIN.'buttons_sc',
    'shortcode'     => '[ts_buttonset{attr}]',
    'options'       => array(
      array(
        'title'     => __('Title - Left Button',TS_PTD),
        'name'      => 'title_left',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('URL - Left Button',TS_PTD),
        'name'      => 'url',
        'id'        => '',
        'dependid'  => 'buttons_sc_url',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Target - Left Button',TS_PTD),
        'name'      => 'target',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_target,
        'value'     => '',
        'type'      => 'select',
        'depends'   => '!buttons_sc_url'
      ),
      array(
        'title'     => __('Title - Right Button',TS_PTD),
        'name'      => 'title_right',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('URL - Right Button',TS_PTD),
        'name'      => 'url2',
        'id'        => '',
        'dependid'  => 'buttons_sc_url2',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Target - Right Button',TS_PTD),
        'name'      => 'target2',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_target,
        'value'     => '',
        'type'      => 'select',
        'depends'   => '!buttons_sc_url2'
      ),
      array(
        'title'     => __('Title - Button Center',TS_PTD),
        'name'      => 'center_text',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_colors_2,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Align',TS_PTD),
        'name'      => 'align',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => '',
            'value' => ''
          ),
          array(
            'label' => __('Right',TS_PTD),
            'value' => 'right'
          ),
          array(
            'label' => __('Center',TS_PTD),
            'value' => 'center'
          ),
          array(
            'label' => __('Left',TS_PTD),
            'value' => 'left'
          )
          
        ),
        'value'     => '',
        'type'      => 'select'
      )
    )
  ),
  array(
    'title'         => __('Blockquote & InfoBox',TS_PTD),
    'id'            => TS_PLUGIN.'blockquote_sc',
    'shortcode'     => '[ts_blockquote{attr}]{content}[/ts_blockquote]',
    'options'       => array(
      array(
        'title'     => __('Quote Icon',TS_PTD),
        'name'      => 'quote_icon',
        'id'        => '',
        'class'     => '',
        'value'     => 'off',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Line Type',TS_PTD),
        'name'      => 'horizontal_line',
        'id'        => '',
        'class'     => 'big_switch',
        'value'     => 'off',
        'text'      => __('Horizontal',TS_PTD).':'.__('Vertical',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Color Options',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'blockquote_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Custom Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'blockquote_sc_color:custom'
      ),
      array(
        'title' => __('Author',TS_PTD),
        'name'  => 'author_name',
        'id'    => '',
        'class' => '',
        'value' => '',
        'type'  => 'text'
      ),
      array(
        'title' => __('Job',TS_PTD),
        'name'  => 'author_job',
        'id'    => '',
        'class' => '',
        'value' => '',
        'type'  => 'text'
      ),
      array(
        'title' => __('Content',TS_PTD),
        'name'  => 'content',
        'id'    => '',
        'rows'  => '5',
        'class' => '',
        'mode'  => 'content',
        'value' => '',
        'type'  => 'textarea'
      )
    )
  ),
  array(
    'title'         => __('Highlight',TS_PTD),
    'id'            => TS_PLUGIN.'highlight_sc',
    'shortcode'     => '[ts_highlight{attr}]{content}[/ts_highlight]',
    'options'       => array(
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'highlight_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Text Color',TS_PTD),
        'name'      => 'custom_textcolor',
        'id'        => '',
        'class'     => '',
        'color'     => '#ffffff',
        'value'     => '#ffffff',
        'type'      => 'colorpicker',
        'depends'   => 'highlight_sc_color:custom'
      ),
      array(
        'title'     => __('BG Color',TS_PTD),
        'name'      => 'custom_bgcolor',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'highlight_sc_color:custom'
      ),
      array(
        'title'     => __('Text',TS_PTD),
        'name'      => '',
        'id'        => '',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '',
        'type'      => 'text'
      )
    )
  ),
  array(
    'title'         => __('List Styles',TS_PTD),
    'id'            => TS_PLUGIN.'liststyle_sc',
    'shortcode'     => '[ts_list{attr}]{content}[/ts_list]',
    'options'       => array(
      array(
        'title'     => __('Type',TS_PTD),
        'name'      => 'type',
        'id'        => '',
        'dependid'  => 'liststyle_sc_type',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Circle',TS_PTD),
            'value' => 'circle'
          ),
          array(
            'label' => __('Square',TS_PTD),
            'value' => 'square'
          ),
          array(
            'label' => __('Roman',TS_PTD),
            'value' => 'roman'
          ),
          array(
            'label' => __('Latin',TS_PTD),
            'value' => 'latin'
          ),
          array(
            'label' => __('Katakana',TS_PTD),
            'value' => 'katakana'
          ),
          array(
            'label' => __('Custom',TS_PTD),
            'value' => 'custom'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => 'hide',
        'type'      => 'iconbox',
        'depends'   => 'liststyle_sc_type:custom'
      ),
      array(
        'title'     => __('Content',TS_PTD),
        'name'      => 'content',
        'id'        => '',
        'rows'      => '12',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '<ul>
 <li>List</li>
 <li>List</li>
 <li>List</li>
</ul>',
        'type'      => 'textarea'
      )
    )
  ),
  array(
    'title'         => __('Feature Box',TS_PTD),
    'id'            => TS_PLUGIN.'featurebox_sc',
    'shortcode'     => '[ts_featurebox{attr}]{content}[/ts_featurebox]',
    'options'       => array(
      array(
        'title'     => __('Images',TS_PTD),
        'name'      => 'id',
        'dependid'  => 'featurebox_sc_id',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'live'      => 'true',
        'multi'     => 'true',
        'type'      => 'upload'
      ),
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => 'hide',
        'type'      => 'iconbox'
      ),
      array(
        'title'     => __('Heading Size',TS_PTD),
        'name'      => 'h_size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => 'H1',
            'value' => '1'
          ),
          array(
            'label' => 'H2',
            'value' => '2'
          ),
          array(
            'label' => 'H3',
            'value' => '3'
          ),
          array(
            'label' => 'H4',
            'value' => '4'
          ),
          array(
            'label' => 'H5',
            'value' => '5'
          ),
          array(
            'label' => 'H6',
            'value' => '6'
          )
        ),
        'value'     => '3',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Heading',TS_PTD),
        'name'      => 'heading',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Content',TS_PTD),
        'name'      => 'content',
        'id'        => '',
        'rows'      => '5',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '',
        'type'      => 'textarea'
      ),
      array(
        'title'     => __('Open With',TS_PTD),
        'name'      => 'click_open',
        'dependid'  => 'featurebox_sc_click_open',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Click',TS_PTD).':'.__('Hover',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('URL',TS_PTD),
        'name'      => 'url',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text',
        'depends'   => 'featurebox_sc_click_open:off'
      ),
      array(
        'title'     => __('Target',TS_PTD),
        'name'      => 'target',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_target,
        'value'     => '',
        'type'      => 'select',
        'depends'   => 'featurebox_sc_click_open:off'
      ),
      array(
        'title'       => __('Slider Config',TS_PTD),
        'description' => __('If you use a few images for a Feature Box, you can edit slider config.',TS_PTD),
        'type'        => 'textblock',
        'depends'     => '!featurebox_sc_id'
      ),
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!featurebox_sc_id'
      ),
      array(
        'title'     => __('Stop on Hover',TS_PTD),
        'name'      => 'stop_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!featurebox_sc_id'
      ),
      array(
        'title'     => __('Navigation',TS_PTD),
        'name'      => 'navigation',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!featurebox_sc_id'
      ),
      array(
        'title'     => __('Effect',TS_PTD),
        'name'      => 'fade_effect',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('FADE',TS_PTD).':'.__('SCROLL',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!featurebox_sc_id'
      ),
      array(
        'title'     => __('Touch Drag',TS_PTD),
        'name'      => 'touch_drag',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!featurebox_sc_id'
      ),
      array(
        'title'         => __('Slide Duration Time (second)',TS_PTD),
        'name'          => 'duration_time',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,30,1',
        'type'          => 'numeric-slider',
        'depends'       => '!featurebox_sc_id'
      )
    )
  ),
  array(
    'title'         => __('Team Member',TS_PTD),
    'id'            => TS_PLUGIN.'team_sc',
    'shortcode'     => '[ts_team{attr}]{content}[/ts_team]',
    'options'       => array(
      array(
        'title'     => __('Images',TS_PTD),
        'name'      => 'id',
        'dependid'  => 'teammember_sc_id',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'live'      => 'true',
        'multi'     => 'true',
        'type'      => 'upload'
      ),
      array(
        'title'     => __('Heading Size',TS_PTD),
        'name'      => 'h_size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => 'H1',
            'value' => '1'
          ),
          array(
            'label' => 'H2',
            'value' => '2'
          ),
          array(
            'label' => 'H3',
            'value' => '3'
          ),
          array(
            'label' => 'H4',
            'value' => '4'
          ),
          array(
            'label' => 'H5',
            'value' => '5'
          ),
          array(
            'label' => 'H6',
            'value' => '6'
          )
        ),
        'value'     => '3',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Name',TS_PTD),
        'name'      => 'name',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Job',TS_PTD),
        'name'      => 'job',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Content',TS_PTD),
        'name'      => 'content',
        'id'        => '',
        'rows'      => '5',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '',
        'type'      => 'textarea'
      ),
      array(
        'title'       => __('Slider Config',TS_PTD),
        'description' => __('If you use a few images for a team member, you can edit slider config.',TS_PTD),
        'type'        => 'textblock',
        'depends'     => '!teammember_sc_id'
      ),
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!teammember_sc_id'
      ),
      array(
        'title'     => __('Stop on Hover',TS_PTD),
        'name'      => 'stop_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!teammember_sc_id'
      ),
      array(
        'title'     => __('Navigation',TS_PTD),
        'name'      => 'navigation',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!teammember_sc_id'
      ),
      array(
        'title'     => __('Effect',TS_PTD),
        'name'      => 'fade_effect',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('FADE',TS_PTD).':'.__('SCROLL',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!teammember_sc_id'
      ),
      array(
        'title'     => __('Touch Drag',TS_PTD),
        'name'      => 'touch_drag',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => '!teammember_sc_id'
      ),
      array(
        'title'         => __('Slide Duration Time (second)',TS_PTD),
        'name'          => 'duration_time',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,30,1',
        'type'          => 'numeric-slider',
        'depends'       => '!teammember_sc_id'
      )
    )
  ),
  array(
    'title'         => __('Icon & Heading',TS_PTD),
    'id'            => TS_PLUGIN.'icon_sc',
    'shortcode'     => '[ts_icon{attr}]',
    'options'       => array(
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => '',
        'type'      => 'iconbox'
      ),
      array(
        'title'     => __('Size',TS_PTD),
        'name'      => 'size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Small',TS_PTD),
            'value' => 'small'
          ),
          array(
            'label' => __('Medium',TS_PTD),
            'value' => 'medium'
          ),
          array(
            'label' => __('Large',TS_PTD),
            'value' => 'large'
          ),
          array(
            'label' => __('X-Large',TS_PTD),
            'value' => 'xlarge'
          ),
          array(
            'label' => __('XX-Large',TS_PTD),
            'value' => 'xxlarge'
          )
        ),
        'value'     => '',
        'type'      => 'select',
        'depends'   => 'icon_sc_heading'
      ),
      array(
        'title'     => __('Heading Size',TS_PTD),
        'name'      => 'h_size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => 'H1',
            'value' => '1'
          ),
          array(
            'label' => 'H2',
            'value' => '2'
          ),
          array(
            'label' => 'H3',
            'value' => '3'
          ),
          array(
            'label' => 'H4',
            'value' => '4'
          ),
          array(
            'label' => 'H5',
            'value' => '5'
          ),
          array(
            'label' => 'H6',
            'value' => '6'
          )
        ),
        'value'     => '3',
        'type'      => 'select',
        'depends'   => '!icon_sc_heading'
      ),
      array(
        'title'     => __('Heading',TS_PTD),
        'name'      => 'heading',
        'id'        => '',
        'dependid'  => 'icon_sc_heading',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      )
    )
  ),
  array(
    'title'         => __('Dropcap & Iconbox',TS_PTD),
    'id'            => TS_PLUGIN.'dropcap_sc',
    'shortcode'     => '[ts_dropcap{attr}]',
    'options'       => array(
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => 'hide',
        'type'      => 'iconbox'
      ),
      array(
        'title'     => __('Text',TS_PTD),
        'name'      => 'text',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Model',TS_PTD),
        'name'      => 'bg',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Square BG',TS_PTD),
            'value' => 'square'
          ),
          array(
            'label' => __('Circle BG',TS_PTD),
            'value' => 'circle'
          ),
          array(
            'label' => __('Transoarent BG',TS_PTD),
            'value' => 'transparent'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Color Options',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'blockquote_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors3,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Custom Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'blockquote_sc_color:custom'
      ),
      array(
        'title'     => __('Dropcap Position',TS_PTD),
        'name'      => 'left_dropcap',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Left',TS_PTD).':'.__('Right',TS_PTD),
        'type'      => 'switch'
      )
    )
  ),
  array(
    'title'         => __('Tabs',TS_PTD),
    'id'            => TS_PLUGIN.'tabs_sc',
    'shortcode'     => '[ts_tabs{attr}]{content}[/ts_tabs]',
    'options'       => array(
      array(
        'title'     => __('Tab Buttons',TS_PTD),
        'name'      => 'horizontal_buttons',
        'id'        => '',
        'class'     => 'big_switch',
        'value'     => 'on',
        'text'      => __('Horizontal',TS_PTD).':'.__('Vertical',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Buttons Position',TS_PTD),
        'name'      => 'left_buttons',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Left',TS_PTD).':'.__('Right',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Open With',TS_PTD),
        'name'      => 'click_open',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Click',TS_PTD).':'.__('Hover',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Color Options',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'tabs_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Custom Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'tabs_sc_color:custom'
      ),
      array(
        'title'         => __('Tab Section',TS_PTD),
        'shortcode'     => '[ts_tab{attr}]{content}[/ts_tab]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title' => __('Icon',TS_PTD),
            'name'  => 'icon',
            'id'    => '',
            'class' => '',
            'value' => '',
            'toggle'=> 'hide',
            'type'  => 'iconbox'
          ),
          array(
            'title' => __('Title',TS_PTD),
            'name'  => 'title',
            'id'    => '',
            'class' => '',
            'value' => '',
            'type'  => 'text'
          ),
          array(
            'title' => __('Content',TS_PTD),
            'name'  => 'content',
            'id'    => '',
            'rows'  => '5',
            'class' => '',
            'mode'  => 'content',
            'value' => '',
            'type'  => 'textarea'
          )
        ),
        'type'      => 'group-content'
      )
    )
  ),
  array(
    'title'         => __('Accordion & Toggle',TS_PTD),
    'id'          => TS_PLUGIN.'accordions_sc',
    'shortcode'       => '[ts_accordions{attr}]{content}[/ts_accordions]',
    'options'       => array(
      array(
        'title'     => __('Collapsible',TS_PTD),
        'name'      => 'collapsible',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Open With',TS_PTD),
        'name'      => 'click_open',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Click',TS_PTD).':'.__('Hover',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Color Options',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'accordions_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Custom Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'accordions_sc_color:custom'
      ),
      array(
        'title'         => __('Accordion Section',TS_PTD),
        'shortcode'     => '[ts_accordion{attr}]{content}[/ts_accordion]',
        'addbutton'     => __('Add New Section',TS_PTD),
        'removebutton'  => __('Remove This Section',TS_PTD),
        'options'       => array(
          array(
            'title' => __('Icon',TS_PTD),
            'name'  => 'icon',
            'id'    => '',
            'class' => '',
            'value' => '',
            'toggle'=> 'hide',
            'type'  => 'iconbox'
          ),
          array(
            'title' => __('Title',TS_PTD),
            'name'  => 'title',
            'id'    => '',
            'class' => '',
            'value' => '',
            'type'  => 'text'
          ),
          array(
            'title' => __('Content',TS_PTD),
            'name'  => 'content',
            'id'    => '',
            'rows'  => '5',
            'class' => '',
            'mode'  => 'content',
            'value' => '',
            'type'  => 'textarea'
          ),
          array(
            'title' => __('Activated',TS_PTD),
            'name'  => 'activated',
            'id'    => '',
            'class' => '',
            'value' => 'off',
            'text'  => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'  => 'switch'
          )
        ),
        'type'      => 'group-content'
      )
    )
  ),
  array(
    'title'         => __('Alert Boxes',TS_PTD),
    'id'            => TS_PLUGIN.'alertboxes_sc',
    'shortcode'     => '[ts_alertbox{attr}]{content}[/ts_alertbox]',
    'options'       => array(
      array(
        'title'     => __('Model',TS_PTD),
        'name'      => 'model',
        'id'        => '',
        'class'     => '',
        'dependid'  => 'alertboxes_sc_model',
        'choices'   => array(
          array(
            'label' => __('Success',TS_PTD),
            'value' => 'success'
          ),
          array(
            'label' => __('Info',TS_PTD),
            'value' => 'info'
          ),
          array(
            'label' => __('Notice',TS_PTD),
            'value' => 'notice'
          ),
          array(
            'label' => __('Error',TS_PTD),
            'value' => 'error'
          ),
          array(
            'label' => __('Custom',TS_PTD),
            'value' => 'custom'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Icon',TS_PTD),
        'name'      => 'icon',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'toggle'    => 'hide',
        'type'      => 'iconbox',
        'depends'   => 'alertboxes_sc_model:custom'
      ),
      array(
        'title'     => __('BG Color',TS_PTD),
        'name'      => 'bg_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#dd3333',
        'value'     => '#dd3333',
        'type'      => 'colorpicker',
        'depends'   => 'alertboxes_sc_model:custom'
      ),
      array(
        'title'     => __('Content',TS_PTD),
        'name'      => 'content',
        'id'        => '',
        'rows'      => '5',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '',
        'type'      => 'textarea'
      )
    )
  ),
  array(
    'title'         => __('Responsive Slider',TS_PTD),
    'id'            => TS_PLUGIN.'slider_sc',
    'shortcode'     => '[ts_slider{attr}]{content}[/ts_slider]',
    'options'       => array(
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'dependid'  => 'slider_sc_autoplay',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Stop on Hover',TS_PTD),
        'name'      => 'stop_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'slider_sc_autoplay:on'
      ),
      array(
        'title'     => __('Navigation',TS_PTD),
        'name'      => 'navigation',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Pagination',TS_PTD),
        'name'      => 'pagination',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Effect',TS_PTD),
        'name'      => 'fade_effect',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('FADE',TS_PTD).':'.__('SCROLL',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Touch Drag',TS_PTD),
        'name'      => 'touch_drag',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Auto Height',TS_PTD),
        'name'      => 'auto_height',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'         => __('Slide Duration Time (second)',TS_PTD),
        'name'          => 'duration_time',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,30,1',
        'type'          => 'numeric-slider',
        'depends'       => 'slider_sc_autoplay:on'
      ),
      array(
        'title'         => __('Slider Item',TS_PTD),
        'shortcode'     => '[ts_slideritem{attr}]{content}[/ts_slideritem]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title' => __('Image',TS_PTD),
            'name'  => 'src',
            'id'    => '',
            'class' => '',
            'value' => '',
            'live'  => '',
            'type'  => 'upload'
          ),
          array(
            'title' => __('Title',TS_PTD),
            'name'  => 'title',
            'id'    => '',
            'class' => '',
            'value' => '',
            'type'  => 'text'
          ),
          array(
            'title' => __('Description',TS_PTD),
            'name'  => 'content',
            'id'    => '',
            'rows'  => '5',
            'class' => '',
            'mode'  => 'content',
            'value' => '',
            'type'  => 'textarea'
          ),
          array(
            'title'     => __('Description Vertical Position',TS_PTD),
            'name'      => 'v_pos',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label' => __('Top',TS_PTD),
                'value' => 'top'
              ),
              array(
                'label' => __('Bottom',TS_PTD),
                'value' => 'bottom'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Description Horizontal Position',TS_PTD),
            'name'      => 'h_pos',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label' => __('Left',TS_PTD),
                'value' => 'left'
              ),
              array(
                'label' => __('Right',TS_PTD),
                'value' => 'right'
              ),
              array(
                'label' => __('Center',TS_PTD),
                'value' => 'center'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
        ),
        'type'          => 'group-content'
      )
    )
  ),
  array(
    'title'         => __('Testimonials',TS_PTD),
    'id'            => TS_PLUGIN.'testimonials_sc',
    'shortcode'     => '[ts_testimonials{attr}]{content}[/ts_testimonials]',
    'options'       => array(
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Stop on Hover',TS_PTD),
        'name'      => 'stop_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Navigation',TS_PTD),
        'name'      => 'navigation',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Effect',TS_PTD),
        'name'      => 'fade_effect',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('FADE',TS_PTD).':'.__('SCROLL',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Touch Drag',TS_PTD),
        'name'      => 'touch_drag',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'         => __('Slide Duration Time (second)',TS_PTD),
        'name'          => 'duration_time',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,30,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'     => __('Model',TS_PTD),
        'name'      => 'model',
        'id'        => '',
        'dependid'  => 'accordions_sc_color',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Big Image',TS_PTD),
            'value' => 'big-testimonial'
          ),
          array(
            'label' => __('Standard',TS_PTD),
            'value' => 'standard'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'         => __('Testimonial',TS_PTD),
        'shortcode'     => '[ts_testimonial{attr}]{content}[/ts_testimonial]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title' => __('Name',TS_PTD),
            'name'  => 'client_name',
            'id'    => '',
            'class' => '',
            'value' => '',
            'type'  => 'text'
          ),
          array(
            'title' => __('Job',TS_PTD),
            'name'  => 'client_job',
            'id'    => '',
            'class' => '',
            'value' => '',
            'type'  => 'text'
          ),
          array(
            'title' => __('Image',TS_PTD),
            'name'  => 'client_image',
            'id'    => '',
            'class' => '',
            'value' => '',
            'live'  => 'true',
            'type'  => 'upload'
          ),
          array(
            'title' => __('Testimonial Content',TS_PTD),
            'name'  => 'content',
            'id'    => '',
            'rows'  => '5',
            'class' => '',
            'mode'  => 'content',
            'value' => '',
            'type'  => 'textarea'
          )
        ),
        'type'      => 'group-content'
      )
    )
  ),
  array(
    'title'         => __('Responsive Media',TS_PTD),
    'id'            => TS_PLUGIN.'rsvideo_sc',
    'shortcode'     => '[ts_media{attr}]{content}[/ts_media]',
    'options'       => array(
      array(
        'title'     => __('Media Type',TS_PTD),
        'name'      => 'mediatype',
        'id'        => '',
        'dependid'  => 'rsvideo_sc_mediatype',
        'class'     => '',
        'mode'      => 'fake',
        'value'     => 'on',
        'text'      => __('Video',TS_PTD).':'.__('Image',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Your Image',TS_PTD),
        'name'      => 'image_src',
        'id'        => '',
        'dependid'  => 'rsvideo_sc_image_src',
        'class'     => '',
        'value'     => '',
        'type'      => 'upload',
        'depends'   => 'rsvideo_sc_mediatype:off'
      ),
      array(
        'title'     => __('URL',TS_PTD),
        'name'      => 'url',
        'id'        => '',
        'dependid'  => 'rsvideo_sc_url',
        'class'     => '',
        'value'     => '',
        'type'      => 'text',
        'depends'   => 'rsvideo_sc_mediatype:off + !rsvideo_sc_image_src'
      ),
      array(
        'title'     => __('Target',TS_PTD),
        'name'      => 'target',
        'id'        => '',
        'class'     => '',
        'choices'   => $ts_shortcode_target,
        'value'     => '',
        'type'      => 'select',
        'depends'   => 'rsvideo_sc_mediatype:off + !rsvideo_sc_url'
      ),
      array(
        'title'     => __('Embed Type',TS_PTD),
        'name'      => 'embedtype',
        'id'        => '',
        'dependid'  => 'rsvideo_sc_embedtype',
        'class'     => '',
        'mode'      => 'fake',
        'value'     => 'on',
        'text'      => __('url',TS_PTD).':'.__('iframe',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'rsvideo_sc_mediatype:on'
      ),
      array(
        'title'     => __('Your Own Video (.mp4)',TS_PTD),
        'name'      => 'video_mp4',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'filetype'  => 'video',
        'type'      => 'upload',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Type (.webm)',TS_PTD),
        'name'      => 'video_webm',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'filetype'  => 'video',
        'type'      => 'upload',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Type (.ogv)',TS_PTD),
        'name'      => 'video_ogv',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'filetype'  => 'video',
        'type'      => 'upload',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'class'     => '',
        'value'     => 'off',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Muted',TS_PTD),
        'name'      => 'muted',
        'id'        => '',
        'class'     => '',
        'value'     => 'off',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Loop',TS_PTD),
        'name'      => 'loop',
        'id'        => '',
        'class'     => '',
        'value'     => 'off',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => 'Controls',
        'name'      => 'controls',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Poster',TS_PTD),
        'name'      => 'poster',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'upload',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:on'
      ),
      array(
        'title'     => __('Iframe Embed Code',TS_PTD),
        'name'      => 'content',
        'id'        => '',
        'rows'      => '5',
        'class'     => '',
        'mode'      => 'content',
        'value'     => '',
        'type'      => 'textarea',
        'depends'   => 'rsvideo_sc_mediatype:on + rsvideo_sc_embedtype:off'
      )
    )
  ),
  array(
    'title'         => __('Progress Bars',TS_PTD),
    'id'            => TS_PLUGIN.'bars_sc',
    'shortcode'     => '[ts_bars{attr}]{content}[/ts_bars]',
    'options'       => array(
      array(
        'title'     => __('Model',TS_PTD),
        'name'      => 'model',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('White Label',TS_PTD),
            'value' => 'white-label'
          ),
          array(
            'label' => __('Standard',TS_PTD),
            'value' => 'standard'
          ),
          array(
            'label' => __('Thin',TS_PTD),
            'value' => 'thin'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Animated',TS_PTD),
        'name'      => 'animated',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'         => __('Bars',TS_PTD),
        'shortcode'     => '[ts_bar{attr}]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title'     => __('Title',TS_PTD),
            'name'      => 'title',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'         => __('Percentage (%)',TS_PTD),
            'name'          => 'percentage',
            'id'            => '',
            'class'         => '',
            'value'         => '50',
            'min_max_step'  => '0,100,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('Percentage Text',TS_PTD),
            'name'      => 'percentage_text',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('Icon',TS_PTD),
            'name'      => 'icon',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'toggle'    => 'hide',
            'type'      => 'iconbox'
          ),
          array(
            'title'     => __('Color',TS_PTD),
            'name'      => 'color',
            'id'        => '',
            'class'     => '',
            'choices'   => $ts_shortcode_colors_2,
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Custom Color',TS_PTD),
            'name'      => 'custom_color',
            'id'        => '',
            'class'     => '',
            'color'     => '',
            'value'     => '',
            'type'      => 'colorpicker'
          )
        ),
        'type'      => 'group-content'
      )
    )

  ),
  array(
    'title'         => __('Pie Chart',TS_PTD),
    'id'            => TS_PLUGIN.'chart_sc',
    'shortcode'     => '[ts_charts{attr}]{content}[/ts_charts]',
    'options'       => array(
      array(
        'title'     => __('Model',TS_PTD),
        'name'      => 'model',
        'id'        => '',
        'dependid'  => 'chart_sc_model',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Standard',TS_PTD),
            'value' => 'standard'
          ),
          array(
            'label' => __('Tooltip Label',TS_PTD),
            'value' => 'tooltip'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Tooltip Position',TS_PTD),
        'name'      => 'tooltip_top',
        'id'        => '',
        'class'     => 'medium_switch',
        'value'     => 'on',
        'text'      => __('Top',TS_PTD).':'.__('Bottom',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'chart_sc_model:tooltip'
      ),
      array(
        'title'     => __('Tooltip Method',TS_PTD),
        'name'      => 'tooltip_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('Hover',TS_PTD).':'.__('Click',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'chart_sc_model:tooltip'
      ),
      array(
        'title'     => __('Size',TS_PTD),
        'name'      => 'size',
        'id'        => '',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Small',TS_PTD),
            'value' => '128'
          ),
          array(
            'label' => __('Medium',TS_PTD),
            'value' => '196'
          ),
          array(
            'label' => __('Large',TS_PTD),
            'value' => '256'
          )
        ),
        'value'     => '128',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Animated',TS_PTD),
        'name'      => 'animated',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'       => __('Charts',TS_PTD),
        'shortcode'   => '[ts_chart{attr}]',
        'addbutton'   => __('Add New',TS_PTD),
        'removebutton'=> __('Remove This',TS_PTD),
        'options'     => array(
          array(
            'title'     => __('Title',TS_PTD),
            'name'      => 'title',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'         => __('Percentage (%)',TS_PTD),
            'name'          => 'percentage',
            'id'            => '',
            'class'         => '',
            'value'         => '50',
            'min_max_step'  => '-100,100,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('Percentage Text',TS_PTD),
            'name'      => 'percentage_text',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('Color',TS_PTD),
            'name'      => 'color',
            'id'        => '',
            'class'     => '',
            'choices'   => $ts_shortcode_colors_2,
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Custom Color',TS_PTD),
            'name'      => 'custom_color',
            'id'        => '',
            'class'     => '',
            'color'     => '',
            'value'     => '',
            'type'      => 'colorpicker'
          )
        ),
        'type'          => 'group-content'
      )
    )

  ),
  array(
    'title'         => __('Social Icons',TS_PTD),
    'id'            => TS_PLUGIN.'social_sc',
    'shortcode'     => '[ts_social]{content}[/ts_social]',
    'options'       => array(
      array(
        'title'         => __('Social Icon',TS_PTD),
        'shortcode'     => '[ts_icon{attr}]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title'     => __('Icon',TS_PTD),
            'name'      => 'icon',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'toggle'    => 'hide',
            'social'    => 'true',
            'type'      => 'iconbox'
          ),
          array(
            'title'     => __('Tooltip Title',TS_PTD),
            'name'      => 'title',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('URL',TS_PTD),
            'name'      => 'url',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('Target',TS_PTD),
            'name'      => 'target',
            'id'        => '',
            'class'     => '',
            'choices'   => $ts_shortcode_target,
            'value'     => '',
            'type'      => 'select'
          )
        ),
        'type'          => 'group-content'
      )
    )
  ),
  array(
    'title'         => __('Table',TS_PTD),
    'id'            => TS_PLUGIN.'table_sc',
    'shortcode'     => '[ts_table{attr}]{content}[/ts_table]',
    'options'       => array(
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'table_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#ffffff',
        'value'     => '#ffffff',
        'type'      => 'colorpicker',
        'depends'   => 'table_sc_color:custom'
      ),
      array(
        'title'     => __('Your Table',TS_PTD),
        'name'      => '',
        'id'        => '',
        'class'     => '',
        'rows'      => '22',
        'mode'      => 'content',
        'value'     => '<table>
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
        'type'      => 'textarea'
      )
    )

  ),
  array(
    'title'         => __('Pricing Table',TS_PTD),
    'id'            => TS_PLUGIN.'pricingtable_sc',
    'shortcode'     => '[ts_pricingtable{attr}]{content}[/ts_pricingtable]',
    'options'       => array(
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'color',
        'id'        => '',
        'dependid'  => 'ptable_sc_color',
        'class'     => '',
        'choices'   => $ts_shortcode_colors,
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'     => __('Color',TS_PTD),
        'name'      => 'custom_color',
        'id'        => '',
        'class'     => '',
        'color'     => '#33ccff',
        'value'     => '#33ccff',
        'type'      => 'colorpicker',
        'depends'   => 'ptable_sc_color:custom'
      ),
      array(
        'title'     => __('Highlight',TS_PTD),
        'name'      => 'highlight',
        'id'        => '',
        'class'     => '',
        'value'     => 'off',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Heading',TS_PTD),
        'name'      => 'title',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Price Text',TS_PTD),
        'name'      => 'price_text',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Currency',TS_PTD),
        'name'      => 'sup_text',
        'id'        => '',
        'class'     => '',
        'value'     => '$',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Period',TS_PTD),
        'name'      => 'sub_text',
        'id'        => '',
        'class'     => '',
        'value'     => '/ MO',
        'type'      => 'text'
      ),
      array(
        'title'     => __('Feature List',TS_PTD),
        'name'      => '',
        'id'        => '',
        'class'     => '',
        'rows'      => '12',
        'mode'      => 'content',
        'value'     => '<ul>
<li>...</li>
<li>...</li>
<li>[ts_button title="JOIN US" size="large" color="darkblue"][/ts_button]</li>
</ul>',
        'type'      => 'textarea'
      )
    )

  ),
  array(
    'title'         => __('Twitter',TS_PTD),
    'id'            => TS_PLUGIN.'twitter_sc',
    'shortcode'     => '[ts_twitter{attr}]',
    'options'       => array(
      array(
        'title'     => __('Twitter User Name',TS_PTD),
        'name'      => 'user_name',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      ),
      array(
        'title'         => __('How Many Tweets?',TS_PTD),
        'name'          => 'count',
        'id'            => '',
        'class'         => '',
        'value'         => '2',
        'min_max_step'  => '1,15,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'     => __('Replies',TS_PTD),
        'name'      => 'replies',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Retweeted',TS_PTD),
        'name'      => 'retweeted',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      )
    )

  ),
  array(
    'title'         => __('Photo Stream',TS_PTD),
    'id'            => TS_PLUGIN.'photostream_sc',
    'shortcode'     => '{content}',
    'options'       => array(
      array(
        'title'     => __('Type',TS_PTD),
        'name'      => 'type',
        'id'        => '',
        'mode'      => 'fake',
        'dependid'  => 'photostream_sc_type',
        'class'     => '',
        'choices'   => array(
          array(
            'label' => __('Gallery',TS_PTD),
            'value' => 'gallery'
          ),
          array(
            'label' => __('Instagram',TS_PTD),
            'value' => 'instagram'
          ),
          array(
            'label' => __('Flickr',TS_PTD),
            'value' => 'flickr'
          )
        ),
        'value'     => '',
        'type'      => 'select'
      ),
      array(
        'title'         => __('Gallery',TS_PTD),
        'shortcode'     => '[ts_photostream{attr}]',
        'addbutton'     => false,
        'removebutton'  => '',
        'options'       => array(
          array(
            'title'     => __('Images',TS_PTD),
            'name'      => 'id',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'live'      => 'true',
            'multi'     => 'true',
            'type'      => 'upload'
          ),
          array(
            'title'     => __('First image bigger than others',TS_PTD),
            'name'      => 'first_big',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          )
        ),
        'type'      => 'group-content',
        'depends'   => 'photostream_sc_type:gallery'
      ),
      array(
        'title'         => __('Instagram',TS_PTD),
        'shortcode'     => '[ts_instagram{attr}]',
        'addbutton'     => false,
        'removebutton'  => '',
        'options'       => array(
          array(
            'title'     => __('User ID',TS_PTD),
            'name'      => 'user_id',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'         => __('How Many Items?',TS_PTD),
            'name'          => 'count',
            'id'            => '',
            'class'         => '',
            'value'         => '6',
            'min_max_step'  => '1,20,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('First image bigger than others',TS_PTD),
            'name'      => 'first_big',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Open with',TS_PTD),
            'name'      => 'open_url',
            'id'        => '',
            'class'     => 'big_switch',
            'value'     => 'on',
            'text'      => __('URL',TS_PTD).':'.__('LIGHTBOX',TS_PTD),
            'type'      => 'switch'
          )
        ),
        'type'          => 'group-content',
        'depends'       => 'photostream_sc_type:instagram'
      ),
      array(
        'title'         => __('Flickr',TS_PTD),
        'shortcode'     => '[ts_flickr{attr}]',
        'addbutton'     => false,
        'removebutton'  => '',
        'options'       => array(
          array(
            'title'     => __('User ID',TS_PTD),
            'name'      => 'user_id',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'         => __('How Many Items?',TS_PTD),
            'name'          => 'count',
            'id'            => '',
            'class'         => '',
            'value'         => '6',
            'min_max_step'  => '1,20,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('First image bigger than others',TS_PTD),
            'name'      => 'first_big',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Open with',TS_PTD),
            'name'      => 'open_url',
            'id'        => '',
            'class'     => 'big_switch',
            'value'     => 'on',
            'text'      => __('URL',TS_PTD).':'.__('LIGHTBOX',TS_PTD),
            'type'      => 'switch'
          )
        ),
        'type'          => 'group-content',
        'depends'       => 'photostream_sc_type:flickr'
      )

    )

  ),
  array(
    'title'         => __('Our Clients',TS_PTD),
    'id'            => TS_PLUGIN.'ourclients_sc',
    'shortcode'     => '[ts_clients{attr}]{content}[/ts_clients]',
    'options'       => array(
      array(
        'title'     => __('Auto Play',TS_PTD),
        'name'      => 'autoplay',
        'id'        => '',
        'dependid'  => 'ourclients_sc_autoplay',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Stop on Hover',TS_PTD),
        'name'      => 'stop_hover',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch',
        'depends'   => 'ourclients_sc_autoplay:on'
      ),
      array(
        'title'     => __('Pagination',TS_PTD),
        'name'      => 'pagination',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Touch Drag',TS_PTD),
        'name'      => 'touch_drag',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'     => __('Grayscale Effect',TS_PTD),
        'name'      => 'grayscale',
        'id'        => '',
        'class'     => '',
        'value'     => 'on',
        'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
        'type'      => 'switch'
      ),
      array(
        'title'         => __('Slide Duration Time (second)',TS_PTD),
        'name'          => 'duration_time',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,30,1',
        'type'          => 'numeric-slider',
        'depends'       => 'ourclients_sc_autoplay:on'
      ),
      array(
        'title'         => __('Show Max Items (Wide)',TS_PTD),
        'name'          => 'show_max_item',
        'id'            => '',
        'class'         => '',
        'value'         => '6',
        'min_max_step'  => '4,10,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'         => __('Show Max Items (Desktop)',TS_PTD),
        'name'          => 'show_max_desktop',
        'id'            => '',
        'class'         => '',
        'value'         => '4',
        'min_max_step'  => '2,10,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'         => __('Show Max Items (Tablet)',TS_PTD),
        'name'          => 'show_max_tablet',
        'id'            => '',
        'class'         => '',
        'value'         => '2',
        'min_max_step'  => '1,10,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'         => __('Show Max Items (Mobile)',TS_PTD),
        'name'          => 'show_max_mobile',
        'id'            => '',
        'class'         => '',
        'value'         => '1',
        'min_max_step'  => '1,10,1',
        'type'          => 'numeric-slider'
      ),
      array(
        'title'         => __('A Client',TS_PTD),
        'shortcode'     => '[ts_client{attr}]{content}[/ts_client]',
        'addbutton'     => __('Add New',TS_PTD),
        'removebutton'  => __('Remove This',TS_PTD),
        'options'       => array(
          array(
            'title'     => __('Image',TS_PTD),
            'name'      => 'src',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'live'      => '',
            'type'      => 'upload'
          ),
          array(
            'title'     => __('URL',TS_PTD),
            'name'      => 'url',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('Target',TS_PTD),
            'name'      => 'target',
            'id'        => '',
            'class'     => '',
            'choices'   => $ts_shortcode_target,
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Color',TS_PTD),
            'name'      => 'color',
            'id'        => '',
            'class'     => '',
            'choices'   => $ts_shortcode_colors_2,
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Color',TS_PTD),
            'name'      => 'custom_color',
            'id'        => '',
            'class'     => '',
            'color'     => '',
            'value'     => '',
            'type'      => 'colorpicker'
          )
        ),
        'type'          => 'group-content'
      )
    )
  ),
  array(
    'title'             => __('Gap',TS_PTD),
    'id'                => TS_PLUGIN.'gap_sc',
    'shortcode'         => '[ts_gap{attr}]',
    'options'       => array(
      array(
        'title'     => __('Size',TS_PTD),
        'name'      => 'size',
        'id'        => '',
        'class'     => '',
        'value'     => '',
        'type'      => 'text'
      )
    )
  ),
  array(
    'title'             => __('Line',TS_PTD),
    'id'                => TS_PLUGIN.'line_sc',
    'shortcode'         => '[ts_line]'
  ),
  array(
    'title'             => __('Clear',TS_PTD),
    'id'                => TS_PLUGIN.'clear_sc',
    'shortcode'         => '[ts_clear]'
  )
);

  return array_merge($args,$themesama_settings);

}

}

if( !function_exists('rev_plugin_options_for_ts') ) {

  function rev_plugin_options_for_ts($args) {

    global $wpdb;
    $sql_q = $wpdb->get_results('SELECT id, title, alias FROM '.$wpdb->prefix.'revslider_sliders ORDER BY id ASC');
    $revsliders = array();

    if ($sql_q) {
      foreach ( $sql_q as $slider ) {
        $revsliders[] = array('label' => $slider->title, 'value' => $slider->alias);
      }
    }

    $plugin_settings = array(
      array(
        'title'         => __('Revolution Slider',TS_PTD),
        'id'            => 'rev_slider',
        'shortcode'     => '[rev_slider{attr}]',
        'options'       => array(
          array(
            'title'     => __('Choose a slider',TS_PTD),
            'name'      => 'alias',
            'id'        => '',
            'class'     => '',
            'choices'   => $revsliders,
            'value'     => '',
            'type'      => 'select'
          ),
        )
      )
    );
    
    return array_merge($args,$plugin_settings);
  }

}

if( !function_exists('cf7_plugin_options_for_ts') ) {

  function cf7_plugin_options_for_ts($args) {

    global $wpdb;
    $sql_q = $wpdb->get_results('SELECT ID, post_title FROM '.$wpdb->posts.' WHERE post_type = "wpcf7_contact_form"');
    $c_forms = array();

    if ($sql_q) {
      foreach ( $sql_q as $c_form ) {
        $c_forms[] = array('label' => $c_form->post_title, 'value' => $c_form->ID);
      }
    }

    $plugin_settings = array(
      array(
        'title'         => __('Contact Form 7',TS_PTD),
        'id'            => 'contact_form_7',
        'shortcode'     => '[contact-form-7{attr}]',
        'options'       => array(
          array(
            'title'     => __('Title',TS_PTD),
            'name'      => 'title',
            'id'        => '',
            'class'     => '',
            'value'     => '',
            'type'      => 'text'
          ),
          array(
            'title'     => __('Choose a contact form',TS_PTD),
            'name'      => 'id',
            'id'        => '',
            'class'     => '',
            'choices'   => $c_forms,
            'value'     => '',
            'type'      => 'select'
          )
        )
      )
    );
    
    return array_merge($args,$plugin_settings);
  }

}

if( !function_exists('slupy_shortcode_options_for_ts') ) {

  function slupy_shortcode_options_for_ts($args) {

    foreach (get_intermediate_image_sizes() as $key => $image_size) {
      $all_image_size[] = array('label' => $image_size, 'value' => $image_size);
    }

    $slupy_settings = array(
      array(
        'title'         => __('Portfolio',TS_PTD),
        'id'            => 'slupy_portfolio',
        'shortcode'     => '[slupy_portfolio{attr}]',
        'options'       => array(
          array(
            'title'     => __('Thumbnail Model',TS_PTD),
            'name'      => 'model',
            'id'        => '',
            'dependid'  => 'portfolio_model',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('Model 1',TS_PTD),
                'value'     => '1'
              ),
              array(
                'label'     => __('Model 2',TS_PTD),
                'value'     => '2'
              ),
              array(
                'label'     => __('Model 3',TS_PTD),
                'value'     => '3'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('List Type',TS_PTD),
            'name'      => 'masonry',
            'id'        => '',
            'dependid'  => 'portfolio_masonry',
            'depends'   => 'portfolio_model:1|2',
            'class'     => 'big_switch',
            'value'     => 'on',
            'text'      => __('MASONRY',TS_PTD).':'.__('GRID',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Fit Grid Height?',TS_PTD),
            'name'      => 'fit_grid',
            'id'        => '',
            'depends'   => 'portfolio_model:1|2 + portfolio_masonry:off',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Loop Items Padding?',TS_PTD),
            'name'      => 'padding',
            'id'        => '',
            'depends'   => 'portfolio_model:1|2',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Filterable',TS_PTD),
            'name'      => 'filterable',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Portfolio Max Columns',TS_PTD),
            'name'      => 'max_columns',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label' => '2',
                'value' => '2'
              ),
              array(
                'label' => '3',
                'value' => '3'
              ),
              array(
                'label' => '4',
                'value' => '4'
              ),
              array(
                'label' => '5',
                'value' => '5'
              )
            ),
            'value'     => '3',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Pagination Style',TS_PTD),
            'name'      => 'pagination',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('Load More',TS_PTD),
                'value'     => 'loadmore'
              ),
              array(
                'label'     => __('Older & Newer Button',TS_PTD),
                'value'     => 'oldernewer'
              ),
              array(
                'label'     => __('Page Numbers',TS_PTD),
                'value'     => 'pagenumbers'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'         => __('Portfolio Per Page',TS_PTD),
            'name'          => 'posts_per_page',
            'id'            => '',
            'class'         => '',
            'value'         => '10',
            'min_max_step'  => '2,30,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('Image Size',TS_PTD),
            'name'      => 'image_size',
            'id'        => '',
            'class'     => '',
            'choices'   => $all_image_size,
            'value'     => '',
            'type'      => 'select'
          )
        )
      ),
      array(
        'title'         => __('Latest Projects',TS_PTD),
        'id'            => 'slupy_cportfolio',
        'shortcode'     => '[slupy_cportfolio{attr}]',
        'options'       => array(
          array(
            'title'     => __('Thumbnail Model',TS_PTD),
            'name'      => 'model',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('Model 1',TS_PTD),
                'value'     => '1'
              ),
              array(
                'label'     => __('Model 2',TS_PTD),
                'value'     => '2'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'         => __('Limit',TS_PTD),
            'name'          => 'limit',
            'id'            => '',
            'class'         => '',
            'value'         => '8',
            'min_max_step'  => '4,12,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('Image Size',TS_PTD),
            'name'      => 'image_size',
            'id'        => '',
            'class'     => '',
            'choices'   => $all_image_size,
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Auto Play',TS_PTD),
            'name'      => 'autoplay',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Stop on Hover',TS_PTD),
            'name'      => 'stop_hover',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch',
          ),
          array(
            'title'     => __('Pagination',TS_PTD),
            'name'      => 'pagination',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Touch Drag',TS_PTD),
            'name'      => 'touch_drag',
            'id'        => '',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'         => __('Slide Duration Time (second)',TS_PTD),
            'name'          => 'duration_time',
            'id'            => '',
            'class'         => '',
            'value'         => '4',
            'min_max_step'  => '2,30,1',
            'type'          => 'numeric-slider',
            'depends'       => 'ourclients_sc_autoplay:on'
          ),
          array(
            'title'         => __('Show Max Items (Wide)',TS_PTD),
            'name'          => 'show_max_item',
            'id'            => '',
            'class'         => '',
            'value'         => '4',
            'min_max_step'  => '2,10,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'         => __('Show Max Items (Desktop)',TS_PTD),
            'name'          => 'show_max_desktop',
            'id'            => '',
            'class'         => '',
            'value'         => '3',
            'min_max_step'  => '2,10,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'         => __('Show Max Items (Tablet)',TS_PTD),
            'name'          => 'show_max_tablet',
            'id'            => '',
            'class'         => '',
            'value'         => '2',
            'min_max_step'  => '1,10,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'         => __('Show Max Items (Mobile)',TS_PTD),
            'name'          => 'show_max_mobile',
            'id'            => '',
            'class'         => '',
            'value'         => '1',
            'min_max_step'  => '1,10,1',
            'type'          => 'numeric-slider'
          )
        )
      ),
      array(
        'title'         => __('Blog',TS_PTD),
        'id'            => 'slupy_blog',
        'shortcode'     => '[slupy_blog{attr}]',
        'options'       => array(
          array(
            'title'     => __('Masonry Style',TS_PTD),
            'name'      => 'masonry',
            'id'        => '',
            'dependid'  => 'masonry_style',
            'class'     => '',
            'value'     => 'on',
            'text'      => __('ON',TS_PTD).':'.__('OFF',TS_PTD),
            'type'      => 'switch'
          ),
          array(
            'title'     => __('Masonry Max Columns',TS_PTD),
            'name'      => 'masonry_columns',
            'id'        => '',
            'depends'   => 'masonry_style:on',
            'class'     => '',
            'choices'   => array(
              array(
                'label' => '2',
                'value' => '2'
              ),
              array(
                'label' => '3',
                'value' => '3'
              ),
              array(
                'label' => '4',
                'value' => '4'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Masonry Effect',TS_PTD),
            'name'      => 'effect',
            'id'        => '',
            'depends'   => 'masonry_style:on',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('fade',TS_PTD),
                'value'     => 'fadeIn'
              ),
              array(
                'label'     => __('fadeInDown',TS_PTD),
                'value'     => 'fadeInDown'
              ),
              array(
                'label'     => __('fadeInUp',TS_PTD),
                'value'     => 'fadeInUp'
              ),
              array(
                'label'     => __('bounceIn',TS_PTD),
                'value'     => 'bounceIn'
              ),
              array(
                'label'     => __('flipInX',TS_PTD),
                'value'     => 'flipInX'
              ),
              array(
                'label'     => __('flipInY',TS_PTD),
                'value'     => 'flipInY'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'         => __('Posts Per Page',TS_PTD),
            'name'          => 'posts_per_page',
            'id'            => '',
            'class'         => '',
            'value'         => '10',
            'min_max_step'  => '2,30,1',
            'type'          => 'numeric-slider'
          ),
          array(
            'title'     => __('Pagination Style',TS_PTD),
            'name'      => 'pagination',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('Load More',TS_PTD),
                'value'     => 'loadmore'
              ),
              array(
                'label'     => __('Older & Newer Button',TS_PTD),
                'value'     => 'oldernewer'
              ),
              array(
                'label'     => __('Page Numbers',TS_PTD),
                'value'     => 'pagenumbers'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
          array(
            'title'     => __('Meta Position',TS_PTD),
            'name'      => 'meta_position',
            'id'        => '',
            'class'     => '',
            'choices'   => array(
              array(
                'label'     => __('Content After',TS_PTD),
                'value'     => 'content-after'
              ),
              array(
                'label'     => __('Media After',TS_PTD),
                'value'     => 'media-after'
              ),
              array(
                'label'     => __('Heading After',TS_PTD),
                'value'     => 'heading-after'
              ),
              array(
                'label'     => __('Together with Read More Button',TS_PTD),
                'value'     => 'read-more'
              )
            ),
            'value'     => '',
            'type'      => 'select'
          ),
        )
      )
    );
    return array_merge($args,$slupy_settings);
  }

}


/*---------------------------------------------
  Filters
---------------------------------------------*/
add_filter('themesama_shortcode_manager_options', 'columns_layout_options', 10);
add_filter('themesama_shortcode_manager_options', 'themesama_options_values', 13);
add_filter('themesama_shortcode_manager_options', 'slupy_shortcode_options_for_ts', 14);

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if( is_plugin_active('revslider/revslider.php') ){
  add_filter('themesama_shortcode_manager_options', 'rev_plugin_options_for_ts', 13);
}

if( is_plugin_active('contact-form-7/wp-contact-form-7.php') ){
  add_filter('themesama_shortcode_manager_options', 'cf7_plugin_options_for_ts', 14);
}

?>