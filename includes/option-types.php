<?php

if ( ! function_exists( 'ts_display_by_type' ) ) {

  function ts_display_by_type( $args = array() ) {

    /* allow filters to be executed on the array */
    $args = apply_filters( 'ts_display_by_type', $args );

    /* build the function name */
    $function_name_by_type = str_replace( '-', '_', 'ts_type_' . $args['type'] );

    /* call the function & pass in arguments array */
    if ( function_exists( $function_name_by_type ) ) {
      call_user_func( $function_name_by_type, $args );
    } else {
      echo '<p>' . __( 'Sorry, this function does not exist', TS_PTD ) . '</p>';
    }

  }

}

/**
 * Checkbox option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_checkbox' ) ) {

  function ts_type_checkbox( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="checkbox" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( is_array( $choices ) && !empty( $choices ) ) {

      /* build checkbox */
      foreach ( (array) $choices as $key => $choice ) {

        if ( isset( $choice['value'] ) && isset( $choice['label'] ) && isset( $name ) && isset( $id ) && isset( $class ) ) {
          echo '<input type="checkbox" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '" ' . ( isset( $value[$key] ) ? checked( $value[$key], $choice['value'], false ) : '' ) . ' class="' . esc_attr( $class ) . '" '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' />';
          echo '<label class="'.esc_attr( TS_PLUGIN ).'checkbox_title" for="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label>';
        }

      }

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Colorpicker option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_colorpicker' ) ) {

  function ts_type_colorpicker( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="colorpicker" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) && isset( $color ) && isset( $value ) ) {
      /* input */
      echo '<input type="text" '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' data-default-color="'.esc_attr( $color ).'" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" class="'.esc_attr( TS_PLUGIN ).'colorpicker ' . esc_attr( $class ) . '" />';
    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Page Select option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_page_select' ) ) {

  function ts_type_page_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="page-select" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) ) {

      /* build page select */
      echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" class="'.esc_attr( TS_PLUGIN ).'selectbox ' . $class . '">';

      /* query pages array */
      $my_posts = get_posts( array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ) );

      /* has pages */
      if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
        echo '<option value="">' . __( 'Choose One', TS_PTD ) . '</option>';
        foreach ( $my_posts as $my_post ) {
          echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $value, $my_post->ID, false ) . '>' . esc_attr( $my_post->post_title ) . '</option>';
        }
      } else {
        echo '<option value="">' . __( 'No Pages Found', TS_PTD ) . '</option>';
      }

      echo '</select>';

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Post Select option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_post_select' ) ) {

  function ts_type_post_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="post-select" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) ) {

      /* build page select */
      echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" class="'.esc_attr( TS_PLUGIN ).'selectbox ' . $class . '">';

      /* query posts array */
      $my_posts = get_posts( array( 'post_type' => array( 'post' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ) );

      /* has posts */
      if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
        echo '<option value="">' . __( 'Choose One', TS_PTD ) . '</option>';
        foreach ( $my_posts as $my_post ) {
          echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $value, $my_post->ID, false ) . '>' . esc_attr( $my_post->post_title ) . '</option>';
        }
      } else {
        echo '<option value="">' . __( 'No Posts Found', TS_PTD ) . '</option>';
      }

      echo '</select>';

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Radio option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_radio' ) ) {

  function ts_type_radio( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="radio" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) && is_array( $choices ) && !empty( $choices ) ) {

      /* build radio */
      foreach ( (array) $choices as $key => $choice ) {
        if ( isset( $choice['value'] ) && isset( $choice['label'] ) && isset( $name ) && isset( $id ) && isset( $class ) ) {
          echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $value, $choice['value'], false ) . ' class="' . esc_attr( $class ) . '" /><label class="themesama_radio_title" for="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label>';
        }
      }

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Radio Images option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_radio_image' ) ) {

  function ts_type_radio_image( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="radio-image" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) && is_array( $choices ) && !empty( $choices ) ) {

      /* build radio image */
      foreach ( (array) $choices as $key => $choice ) {

        $src = $choice['src'];
        echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="radio" style="display:none;" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $value, $choice['value'], false ) . ' class="'.esc_attr( TS_PLUGIN ).'radio_image" />
            <label class="themesama_radio_title" data-label="'.$choice['label'].'" for="' . esc_attr( $id ) . '-' . esc_attr( $key ) . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $choice['label'] ) .'" title="' . esc_attr( $choice['label'] ) .'" class="' . esc_attr( $class ) . ( $value == $choice['value'] ? ' radio-image-selected' : '' ) . '" /></label>';

      }

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Select option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_select' ) ) {

  function ts_type_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="select" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) ) {

      /* build select */
      echo '<select '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" class="'.esc_attr( TS_PLUGIN ).'selectbox ' . esc_attr( $class ) . '">';

      if ( is_array( $choices ) && !empty( $choices ) ) {

        foreach ( (array) $choices as $choice ) {
          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
          }
        }

      }else {
        echo '<option value="">' . __( 'No Option Found', TS_PTD ) . '</option>';
      }

      echo '</select>';

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Sidebar Select option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.1
 */
if ( ! function_exists( 'ts_type_sidebar_select' ) ) {

  function ts_type_sidebar_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="sidebar-select" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) ) {

      /* build page select */
      echo '<select '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" class="'.esc_attr( TS_PLUGIN ).'selectbox ' . $class . '">';

      /* get the registered sidebars */
      global $wp_registered_sidebars;

      $sidebars = array();
      foreach ( $wp_registered_sidebars as $id_s => $sidebar ) {
        $sidebars[ $id_s ] = $sidebar[ 'name' ];
      }

      /* filters to restrict which sidebars are allowed to be selected, for example we can restrict footer sidebars to be selectable on a blog page */
      $sidebars = apply_filters( 'ot_recognized_sidebars', $sidebars );
      $sidebars = apply_filters( 'ot_recognized_sidebars_' . $id, $sidebars );

      /* has sidebars */
      if ( count( $sidebars ) ) {
        echo '<option value="">' . __( 'Choose Sidebar', TS_PTD ) . '</option>';
        foreach ( $sidebars as $id_s => $sidebar ) {
          echo '<option value="' . esc_attr( $id_s ) . '"' . selected( $value, $id_s, false ) . '>' . esc_attr( $sidebar ) . '</option>';
        }
      } else {
        echo '<option value="">' . __( 'No Sidebars', TS_PTD ) . '</option>';
      }

      echo '</select>';

    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Text option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_text' ) ) {

  function ts_type_text( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="text" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) && isset( $value ) ) {
      /* build text input */
      echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" class="'.esc_attr( TS_PLUGIN ).'inputbox ' . esc_attr( $class ) . '" />';
    }

    echo '</div>';

    echo '</div>';

  }

}


/**
 * Textarea Simple option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_textarea' ) ) {

  function ts_type_textarea( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="textarea" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $id ) && isset( $class ) && isset( $value ) && isset( $rows ) ) {
      /* build textarea simple */
      echo '<textarea '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' class="'.esc_attr( TS_PLUGIN ).'textarea ' . esc_attr( $class ) . '" rows="' . esc_attr( $rows )  . '" name="' . esc_attr( $name ) .'" id="' . esc_attr( $id ) . '">' . esc_textarea( $value ) . '</textarea>';
    }

    echo '</div>';

    echo '</div>';

  }

}

/**
 * Textblock option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_textblock' ) ) {

  function ts_type_textblock( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outerUpload wrapper */
    echo '<div>';

    if ( isset( $description ) ) {
      /* description */
      echo '<div class="description">' . htmlspecialchars_decode( $description ) . '</div>';
    }

    echo '</div>';

  }

}

/**
 * Upload option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_upload' ) ) {

  function ts_type_upload( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="upload" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    if ( isset( $name ) && isset( $value ) && isset( $class ) && isset( $id ) ) {

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

      if ( isset( $live ) && $live=='true' ) {

        echo '<div class="'.esc_attr( TS_PLUGIN ).'thumblivepreview"></div>';

      }

      /* input */
      echo '<input '.( isset( $live ) && $live=='true' ? 'style="display:none;"':'' ).' '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" class="'.esc_attr( TS_PLUGIN ).'inputbox ' . esc_attr( $class ) . '" />';

      /* add media button */
      echo '<a href="javascript:void(0);" data-multiple="'.( isset( $multi ) && $multi !='' ? '1':'0' ).'" data-filetype="'.( isset( $filetype ) && $filetype !='' ? $filetype:'image' ).'" data-getid="'.( isset( $live ) && $live=='true' ? 'id':'url' ).'" class="themesama_upload_button button-primary button-large" data-uploadertitle="'.__( 'Choose Image', TS_PTD ).'" data-uploaderbutton="'.__( 'Send Shortcode Manager', TS_PTD ).'" rel="' . $id . '" title="' . __( 'Add Media', TS_PTD ) . '">' . __( 'Upload', TS_PTD ) . '</a>';

      echo '</div>';

    }

    echo '</div>';

  }

}

/**
 * Background option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ts_type_background' ) ) {

  function ts_type_background( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="background" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    if ( isset( $name ) && isset( $value ) && isset( $class ) && isset( $id ) ) {

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner '.esc_attr( TS_PLUGIN ).'backgroundtype">';

      /* input */
      echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" class="'.esc_attr( TS_PLUGIN ).'inputbox ' . esc_attr( $class ) . '" />';

      /* add media button */
      echo '<a href="javascript:void(0);" data-multiple="'.( isset( $multi ) && $multi !='' ? '1':'0' ).'" data-filetype="'.( isset( $filetype ) && $filetype !='' ? $filetype:'image' ).'" data-uploadertitle="'.__( 'Choose Image', TS_PTD ).'" data-uploaderbutton="'.__( 'Send Shortcode Manager', TS_PTD ).'" class="themesama_upload_button button-primary button-large" rel="' . $id . '" title="' . __( 'Add Media', TS_PTD ) . '">' . __( 'Upload', TS_PTD ) . '</a>';

      //Color Picker
      echo '<input type="text" name="bgcolor" value="" class="'.esc_attr( TS_PLUGIN ).'colorpicker" />';

      //BG Options
      echo '<div class="'.esc_attr( TS_PLUGIN ).'select-group" '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depends-on="!'.esc_attr( $dependid ).'"':'' ).'>

            <select name="bgrepeat" class="">
              <option value="">'.__( 'background-repeat', TS_PTD ).'</option>
              <option value="no-repeat">'.__( 'No Repeat', TS_PTD ).'</option>
              <option value="repeat">'.__( 'Repeat All', TS_PTD ).'</option>
              <option value="repeat-x">'.__( 'Repeat Horizontally', TS_PTD ).'</option>
              <option value="repeat-y">'.__( 'Repeat Vertically', TS_PTD ).'</option>
              <option value="inherit">'.__( 'Inherit', TS_PTD ).'</option>
            </select>

            <select name="bgattachment" class="">
              <option value="">'.__( 'background-attachment', TS_PTD ).'</option>
              <option value="fixed">'.__( 'Fixed', TS_PTD ).'</option>
              <option value="scroll">'.__( 'Scroll', TS_PTD ).'</option>
              <option value="inherit">'.__( 'Inherit', TS_PTD ).'</option>
            </select>

            <select name="bgposition" class="">
              <option value="">'.__( 'background-position', TS_PTD ).'</option>
              <option value="left top">'.__( 'Left Top', TS_PTD ).'</option>
              <option value="left center">'.__( 'Left Center', TS_PTD ).'</option>
              <option value="left bottom">'.__( 'Left Bottom', TS_PTD ).'</option>
              <option value="center top">'.__( 'Center Top', TS_PTD ).'</option>
              <option value="center center">'.__( 'Center Center', TS_PTD ).'</option>
              <option value="center bottom">'.__( 'Center Bottom', TS_PTD ).'</option>
              <option value="right top">'.__( 'Right Top', TS_PTD ).'</option>
              <option value="right center">'.__( 'Right Center', TS_PTD ).'</option>
              <option value="right bottom">'.__( 'Right Bottom', TS_PTD ).'</option>
            </select>

          </div>';

      echo '</div>';

    }

    echo '</div>';

  }

}

/**
 * On-Off Switch option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 */
if ( ! function_exists( 'ts_type_switch' ) ) {

  function ts_type_switch( $args = array() ) {

    extract( $args );

    if ( isset( $text ) ) {
      $std_values = explode( ":", $text );
    }else {
      $std_values[0] = "ON";
      $std_values[1] = "OFF";
    }

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="switch" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    if ( isset( $name ) && isset( $value ) && isset( $class ) && isset( $id ) ) {


      echo '<div data-on="on" data-off="off" class="' . esc_attr( $class ) .' '.esc_attr( TS_PLUGIN ).'onoffswitch '.( ( isset( $value ) ) && $value == "on" ? 'active':'' ).'">' . '<div class="'.esc_attr( TS_PLUGIN ).'onoffswitch-inner">
                <div class="'.esc_attr( TS_PLUGIN ).'onoffswitch-active"><div class="'.esc_attr( TS_PLUGIN ).'onoffswitch-switch">'.$std_values[0].'</div></div>
                <div class="'.esc_attr( TS_PLUGIN ).'onoffswitch-inactive"><div class="'.esc_attr( TS_PLUGIN ).'onoffswitch-switch">'.$std_values[1].'</div></div>
            </div>' . '</div>';

      /* build text input */
      echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' style="display:none;" type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" />';

      echo '</div>';

    }

    echo '</div>';
  }

}

/**
 * IconBox option type.
 *
 *
 * @param array   An array of arguments.
 * @return    string
 */
if ( ! function_exists( 'ts_type_iconbox' ) ) {

  function ts_type_iconbox( $args = array() ) {
    /* turns arguments array into variables */
    extract( $args );

    if( !class_exists('TS_FRAMEWORK_ICON_FIELD') ){

    //FontAwasome Icons
    $FontAwasomeIcons=array( 'adjust', 'anchor', 'archive', 'arrows', 'arrows-h', 'arrows-v', 'asterisk', 'ban', 'bar-chart-o', 'barcode', 'bars', 'beer', 'bell', 'bell-o', 'bolt', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'bug', 'building-o', 'bullhorn', 'bullseye', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'certificate', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'circle', 'circle-o', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'credit-card', 'crop', 'crosshairs', 'cutlery', 'dashboard', 'desktop', 'dot-circle-o', 'download', 'edit', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-o', 'eraser', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'female', 'fighter-jet', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'frown-o', 'gamepad', 'gavel', 'gear', 'gears', 'gift', 'glass', 'globe', 'group', 'hdd-o', 'headphones', 'heart', 'heart-o', 'home', 'inbox', 'info', 'info-circle', 'key', 'keyboard-o', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'lightbulb-o', 'location-arrow', 'lock', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'music', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'picture-o', 'plane', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'random', 'refresh', 'reply', 'reply-all', 'retweet', 'road', 'rocket', 'rss', 'rss-square', 'search', 'search-minus', 'search-plus', 'share', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'spinner', 'square', 'square-o', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'subscript', 'suitcase', 'sun-o', 'superscript', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'terminal', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'trophy', 'truck', 'umbrella', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'user', 'users', 'video-camera', 'volume-down', 'volume-off', 'volume-up', 'warning', 'wheelchair', 'wrench', 'check-square', 'check-square-o', 'circle', 'circle-o', 'dot-circle-o', 'minus-square', 'minus-square-o', 'plus-square', 'plus-square-o', 'square', 'square-o', 'bitcoin', 'btc', 'cny', 'dollar', 'eur', 'euro', 'gbp', 'inr', 'jpy', 'krw', 'money', 'rmb', 'rouble', 'rub', 'ruble', 'rupee', 'try', 'turkish-lira', 'usd', 'won', 'yen', 'align-center', 'align-justify', 'align-left', 'align-right', 'bold', 'chain', 'chain-broken', 'clipboard', 'columns', 'copy', 'cut', 'dedent', 'eraser', 'file', 'file-o', 'file-text', 'file-text-o', 'files-o', 'floppy-o', 'font', 'indent', 'italic', 'link', 'list', 'list-alt', 'list-ol', 'list-ul', 'outdent', 'paperclip', 'paste', 'repeat', 'rotate-left', 'rotate-right', 'save', 'scissors', 'strikethrough', 'table', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'underline', 'undo', 'unlink', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'arrows-alt', 'backward', 'compress', 'eject', 'expand', 'fast-backward', 'fast-forward', 'forward', 'pause', 'play', 'play-circle', 'play-circle-o', 'step-backward', 'step-forward', 'stop', 'youtube-play', 'adn', 'android', 'apple', 'bitbucket', 'bitbucket-square', 'bitcoin', 'btc', 'css3', 'dribbble', 'dropbox', 'facebook', 'facebook-square', 'flickr', 'foursquare', 'github', 'github-alt', 'github-square', 'gittip', 'google-plus', 'google-plus-square', 'html5', 'instagram', 'linkedin', 'linkedin-square', 'linux', 'maxcdn', 'pagelines', 'pinterest', 'pinterest-square', 'renren', 'skype', 'stack-exchange', 'stack-overflow', 'trello', 'tumblr', 'tumblr-square', 'twitter', 'twitter-square', 'vimeo-square', 'vk', 'weibo', 'windows', 'xing', 'xing-square', 'youtube', 'youtube-play', 'youtube-square', 'ambulance', 'h-square', 'hospital-o', 'medkit', 'plus-square', 'stethoscope', 'user-md', 'wheelchair' );

    if ( isset( $social ) ) {
      $FontAwasomeIcons=array( 'facebook', 'twitter', 'adn', 'android', 'apple', 'bitbucket', 'css3', 'dribbble', 'dropbox', 'flickr', 'foursquare', 'github', 'gittip', 'google-plus', 'html5', 'instagram', 'linkedin', 'linux', 'maxcdn', 'pinterest', 'skype', 'tumblr', 'vimeo-square', 'vk', 'weibo', 'windows', 'xing', 'youtube-play', 'envelope', 'rss' );
    }

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="icon" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

    if ( isset( $toggle ) && isset( $name ) && isset( $value ) && isset( $class ) && isset( $id ) ) {

      echo '<div class="'.esc_attr( TS_PLUGIN ).'toggle_icons '.( ( isset( $toggle ) && ( $toggle == 'hide' ) ) ? 'active': '' ).'">
          <div>'.__( 'Hide Icons', TS_PTD ).' <i class="fa fa-angle-up"></i></div>
          <div>'.__( 'Show Icons', TS_PTD ).' <i class="fa fa-angle-down"></i></div>
        </div>';
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner '.esc_attr( TS_PLUGIN ).'iconbox_content " '.( ( isset( $toggle ) && ( $toggle == 'hide' ) ) ? 'style="display:none;"': '' ).'>';
      echo '<input type="text" name="'.esc_attr( TS_PLUGIN ).'filter_input" class="'.esc_attr( TS_PLUGIN ).'filter_input" value="'.__( 'Type & Filter', TS_PTD ).'" />';
      /* build radio image */
      foreach (  $FontAwasomeIcons as $key ) {

        echo '<label class="'.esc_attr( TS_PLUGIN ).'iconbox_label">
              <input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="checkbox" style="display:none;" name="' . esc_attr( $name ) . '" value="' . esc_attr( $key ) . '"' . checked( $value, $key, false ) . ' class="'.esc_attr( TS_PLUGIN ).'checkbox_image" />
              <i class="fa fa-'.$key.'"></i>
            </label>';


      }

      echo '</div>';

    }

    echo '</div>';

    }else{
      echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting ts_content_icon" data-type="ts_icon" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';
      echo '<div class="format-setting-inner '.esc_attr( TS_PLUGIN ).'iconbox_content">';
      $field_ts_icon = new TS_FRAMEWORK_ICON_FIELD;
      $args = array(
        'title'       => '',
        'desc'        => '',
        'type'        => '',
        'depends'     => '',
        'field_name'  => $name,
        'field_value' => '',
        'class'       => TS_PLUGIN.'checkbox_image'
      );
      echo $field_ts_icon->output($args);
      echo '</div></div>';
    }
  }

}

/**
 * Group Content
 *
 *
 * @param array   An array of arguments.
 * @return    string
 */
if ( ! function_exists( 'ts_type_group_content' ) ) {

  function ts_type_group_content( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* format setting outer wrapper */
    echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting '.esc_attr( TS_PLUGIN ).'a_groupcontent" data-type="groupcontent">';

    foreach ( $options as $key => $value ) {

      echo '<div class="'.esc_attr( TS_PLUGIN ).'a_configelement" '.( isset( $value['depends'] ) ? 'data-depends-on="'.esc_attr( $value['depends'] ).'"':'' ).'>';

      if ( isset( $value['title'] ) ) {
        echo '<h3 class="'.esc_attr( TS_PLUGIN ).'option_heading">'.$value['title'].'</h3>';
      }

      ts_display_by_type( $value );

      echo '</div>';

    }

    if ( isset( $removebutton ) ) {
      echo '<a href="#" class="'.esc_attr( TS_PLUGIN ).'removerowbutton button hidden" title="'.esc_attr( $removebutton ).'">
          <span class="themesama_minus_icon"></span> '.$removebutton.'
        </a>';
    }

    echo '</div>';
  }

}

/**
 * Numeric Slider option type.
 *
 * @param array   An array of arguments.
 * @return    string
 */
if ( ! function_exists( 'ts_type_numeric_slider' ) ) {

  function ts_type_numeric_slider( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    if ( isset( $min_max_step ) ) {

      $_options = explode( ',', $min_max_step );
      $min = isset( $_options[0] ) ? $_options[0] : 0;
      $max = isset( $_options[1] ) ? $_options[1] : 100;
      $step = isset( $_options[2] ) ? $_options[2] : 1;

      /* format setting outer wrapper */
      echo '<div class="'.esc_attr( TS_PLUGIN ).'format_setting" data-type="numericslider" data-mode="'.( isset( $mode ) ? esc_attr( $mode ) : 'attr' ).'">';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

      if ( isset( $name ) && isset( $value ) && isset( $class ) && isset( $id ) ) {

        echo '<input '.( ( isset( $dependid ) && $dependid!='' ) ? ' data-depend-id="'.esc_attr( $dependid ).'"':'' ).' type="text" class="hidden" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" data-min="' . esc_attr( $min ) . '" data-max="' . esc_attr( $max ) . '" data-step="' . esc_attr( $step ) . '">';
        echo '<div class="'.esc_attr( TS_PLUGIN ).'numeric_slider '.esc_attr( $class ).'"></div><span class="'.esc_attr( TS_PLUGIN ).'numeric_slider_title">'.esc_attr( $value ).'</span>';

      }

      echo '</div>';

      echo '</div>';

    }

  }

}

?>
