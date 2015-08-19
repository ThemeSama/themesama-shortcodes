<?php

/*---------------------------------------------
  Control Default Colors
---------------------------------------------*/
if ( !function_exists( 'check_ts_default_colors' ) ) {

  function check_ts_default_colors($get_color = false, $color = 'darkblue' ) {

    global $ts_default_color;

    //Control default colors
    $default_colors = array(
      'darkblue'  => '#31353e',
      'blue'      => '#1ca2f1',
      'green'     => '#82bf06',
      'orange'    => '#fc5513',
      'yellow'    => '#ffbe05',
      'white'     => '#ffffff',
      'default'   => $ts_default_color
    );

    if( $get_color ){
      foreach ( $default_colors as $key => $a_color ) {
        if ( $key == $color ) {
          return $a_color;
          break;
        }
      }
    }

    $val = 'default';
    foreach ( $default_colors as $key => $a_color ) {
      if ( $a_color == $ts_default_color ) {
        $val = $key;
        break;
      }
    }

    return $val;
  }

}

/*---------------------------------------------
  Get & Update Tweets
---------------------------------------------*/
if ( !function_exists( 'ts_gettweets' ) ) {

  function ts_gettweets( $user_name, $count, $exclude_replies, $retweeted, $update_time ) {

    $all_tw = get_option( 'ts_twitter_'.$user_name.$count );

    if ( ( !isset( $all_tw ) ) || ( isset( $all_tw ) && ( time() - $all_tw['time'] > $update_time * 60 ) ) ) {

      require_once TS_PLUGIN_INC .'twitter/index.php';
      global $TS_TWITTER;
      $record_tweets = array();
      $tweets = $TS_TWITTER->get( 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$user_name.'&count='.$count.'&exclude_replies='.$exclude_replies );

      if ( !isset( $tweets->errors ) && is_array( $tweets ) ) {
        foreach ( $tweets as $key => $tweet ) {

          if ( isset( $tweet->retweeted_status ) && $retweeted == 'true' ) {
            $tweet_item = $tweet->retweeted_status;
          }else {
            $tweet_item = $tweet;
          }

          $text = $tweet_item->text;

          if ( isset( $tweet_item->entities->hashtags ) ) {
            foreach ( $tweet_item->entities->hashtags as $value ) {
              $text = str_replace( '#'.$value->text, '<a href="https://twitter.com/search?q=%23'.$value->text.'&src=hash" target="_blank">#'.$value->text.'</a>', $text );
            }
          }
          if ( isset( $tweet_item->entities->user_mentions ) ) {
            foreach ( $tweet_item->entities->user_mentions as $value ) {
              $text = str_replace( '@'.$value->screen_name, '<a href="https://twitter.com/'.$value->screen_name.'" target="_blank">@'.$value->screen_name.'</a>', $text );
            }
          }
          if ( isset( $tweet_item->entities->urls ) ) {
            foreach ( $tweet_item->entities->urls as $value ) {
              $text = str_replace( $value->url, '<a href="'.esc_url( $value->url ).'" target="_blank">'.$value->display_url.'</a>', $text );
            }
          }
          if ( isset( $tweet_item->entities->media ) ) {
            foreach ( $tweet_item->entities->media as $value ) {
              $text = str_replace( $value->url, '<a href="'.esc_url( $value->url ).'" target="_blank">'.$value->display_url.'</a>', $text );
            }
          }

          $record_tweets[$key]['id'] = $tweet_item->id_str;
          $record_tweets[$key]['created_at'] = isset( $tweet_item->created_at ) ? $tweet_item->created_at : '';
          $record_tweets[$key]['profile_image'] = isset( $tweet_item->user->profile_image_url_https ) ? $tweet_item->user->profile_image_url_https : '';
          $record_tweets[$key]['user_name'] = isset( $tweet_item->user->name ) ? $tweet_item->user->name : '';
          $record_tweets[$key]['screen_name'] = isset( $tweet_item->user->screen_name ) ? $tweet_item->user->screen_name : '';
          $record_tweets[$key]['text'] = $text;

        }
        //end foreach

        $all_tw['time'] = time();
        $all_tw['tweets'] = $record_tweets;
        update_option( 'ts_twitter_'.$user_name.$count, $all_tw );

      }

    }

    return isset( $all_tw['tweets'] ) ? $all_tw['tweets'] : __( 'Connect Error' , TS_PTD );

  }

}

/*---------------------------------------------
  Get & Update Instagram
---------------------------------------------*/
if ( !function_exists( 'ts_getinstagram' ) ) {

  function ts_getinstagram( $user_id, $count, $update_time ) {

    $all_photos = get_option( 'ts_instagram_'.$user_id.$count );

    if ( ( !isset( $all_photos ) ) || ( isset( $all_photos ) && ( time() - $all_photos['time'] > $update_time * 60 ) ) ) {

      $photos = json_decode( @file_get_contents( 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent/?access_token=44451048.5685822.4590b287d4294f7fad20552f0806f477&count='.(int)$count ) );
      $record_photos = array();

      if ( isset( $photos ) ) {
        foreach ( $photos->data as $key => $value ) {

          $record_photos[$key]['type'] = $value->type;
          $record_photos[$key]['link'] = $value->link;
          $record_photos[$key]['t_img'] = $value->images->low_resolution->url;

          if ( $value->type == 'video' ) {
            $record_photos[$key]['b_img'] = $value->videos->standard_resolution->url;
          }else {
            $record_photos[$key]['b_img'] = $value->images->standard_resolution->url;
          }

        }
      }

      $all_photos['time'] = time();
      $all_photos['photos'] = $record_photos;
      update_option( 'ts_instagram_'.$user_id.$count, $all_photos );

    }

    return $all_photos['photos'];
  }

}

/*---------------------------------------------
  Get & Update Flickr
---------------------------------------------*/
if ( !function_exists( 'ts_getflickr' ) ) {

  function ts_getflickr( $user_id, $count, $update_time ) {

    $all_photos = get_option( 'ts_flickr_'.$user_id.$count );

    if ( ( !isset( $all_photos ) ) || ( isset( $all_photos ) && ( time() - $all_photos['time'] > $update_time * 60 ) ) ) {

      $feed_Flickr = 'http://api.flickr.com/services/feeds/photos_public.gne?'.( $user_id ? 'id='.$user_id.'&' : '' ).'lang=en-us&format=json&nojsoncallback=1';
      $Flickr = @file_get_contents( $feed_Flickr );
      $flickrResponse = str_replace( "\\'", "'", $Flickr );
      $results = json_decode( $flickrResponse, true );

      $record_photos = array();

      if ( isset( $results['items'] ) ) {
        foreach ( $results['items'] as $key => $value ) {

          if ( $key >= $count ) {
            break;
          }

          $record_photos[$key]['title'] = $value['title'];
          $record_photos[$key]['link'] = $value['link'];
          $record_photos[$key]['img'] = $value['media']['m'];

        }
      }
      $all_photos['time'] = time();
      $all_photos['photos'] = $record_photos;
      update_option( 'ts_flickr_'.$user_id.$count, $all_photos );

    }

    return $all_photos['photos'];
  }

}

/*---------------------------------------------
  Time Ago
---------------------------------------------*/
if ( !function_exists( 'ts_ago' ) ) {

  function ts_ago( $i ) {

    $m = time()-$i;
    $val = __( 'just now', TS_PTD );
    $full_text = array( __( 'years', TS_PTD ), __( 'months', TS_PTD ), __( 'weeks', TS_PTD ), __( 'days', TS_PTD ), __( 'hours', TS_PTD ), __( 'minutes', TS_PTD ), __( 'seconds', TS_PTD ) );
    $small_text = array( __( 'year', TS_PTD ), __( 'month', TS_PTD ), __( 'week', TS_PTD ), __( 'day', TS_PTD ), __( 'hour', TS_PTD ), __( 'minute', TS_PTD ), __( 'second', TS_PTD ) );
    $t = array( 31556926, 2629744, 604800, 86400, 3600, 60, 1 );

    foreach ( $t as $u=>$s ) {
      if ( $s<=$m ) {
        $v=floor( $m/$s );
        $val=$v.' '.( $v==1 ? $small_text[$u] : $full_text[$u] ).' '.__( 'ago', TS_PTD );
        break;
      }
    }

    return $val;
  }

}

/*---------------------------------------------
  Feature Box
---------------------------------------------*/
if ( ! function_exists( 'themesama_featurebox' ) ) {

  function themesama_featurebox( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'id'            => '',
      'file_size'     => '',
      'icon'          => 'star-o',
      'h_size'        => '3',
      'heading'       => '',
      'click_open'    => 'on',
      'autoplay'      => 'on',
      'stop_hover'    => 'off',
      'navigation'    => 'on',
      'fade_effect'   => 'on',
      'touch_drag'    => 'on',
      'duration_time' => '7',
      'url'           => '#',
      'target'        => '',
      'max_width'     => '',
      'class'         => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $url = esc_url( $url );
    $target = $target ? ' target="'.esc_attr( $target ).'"' : '';
    $slider_config = array(
      'id'            => $id,
      'file_size'     => $file_size,
      'autoplay'      => $autoplay,
      'stop_hover'    => $stop_hover,
      'navigation'    => $navigation,
      'fade_effect'   => $fade_effect,
      'touch_drag'    => $touch_drag,
      'duration_time' => $duration_time,
      'pagination'    => 'off',
      'auto_height'   => 'on',
      'fb_slider'     => 'on'
    );

    $attrs = ' class="ts-feature-box'.$class.'"';
    $attrs.= ' data-trigger="'.( $click_open == 'on' ? 'click' : 'mouseenter' ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= '<a href="'.$url.'"'.$target.' class="ts-box-icon fa fa-'.esc_attr( $icon ).'"></a>';
    $val.= '<h'.$h_size.' class="ts-box-title"><a href="'.$url.'"'.$target.'>'.$heading.'</a></h'.$h_size.'>';

    $val.= '<div class="ts-box-details"'.($max_width ? ' style="max-width:'.esc_attr( $max_width ).';"' : '').'>';

    $val.= $id ? '<div class="ts-box-slider">'.themesama_slider( $slider_config ).'</div>' : '';

    $val.= $content ? '<div class="ts-feature-desc"><div class="ts-feature-desc-inner">'.do_shortcode( $content ).'</div></div>' : '';
    $val.= '</div>';

    return $val.'</div>';

  }

}

/*---------------------------------------------
  Team
---------------------------------------------*/
if ( ! function_exists( 'themesama_team' ) ) {

  function themesama_team( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'id'            => '',
      'h_size'        => '3',
      'name'          => '',
      'job'           => '',
      'autoplay'      => 'on',
      'stop_hover'    => 'off',
      'navigation'    => 'on',
      'fade_effect'   => 'on',
      'touch_drag'    => 'on',
      'duration_time' => '7',
      'file_size'     => '',
      'class'         => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $slider_config = array(
      'id'            => $id,
      'autoplay'      => $autoplay,
      'stop_hover'    => $stop_hover,
      'navigation'    => $navigation,
      'fade_effect'   => $fade_effect,
      'touch_drag'    => $touch_drag,
      'duration_time' => $duration_time,
      'file_size'     => $file_size,
      'auto_height'   => 'on',
      'pagination'    => 'off'
    );

    $attrs = ' class="ts-team-member'.$class.'"';

    $val.= '<div'.$attrs.'>';

    $val.= $id ? '<div class="ts-member-slider">'.themesama_slider($slider_config).'</div>' : '';
    $val.= '<h'.$h_size.' class="ts-member-name ts-heading-divider">'.$name.($job ? '<small>'.$job.'</small>' : '').'</h'.$h_size.'>';
    $val.= $content ? '<div class="ts-member-desc">'.do_shortcode( $content ).'</div>' : '';
    
    $val.= '</div>';

    return $val;

  }

}

/*---------------------------------------------
  Our Clients
---------------------------------------------*/
if ( ! function_exists( 'themesama_clients' ) ) {

  function themesama_clients( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'autoplay'          => 'on',
      'stop_hover'        => 'off',
      'pagination'        => 'on',
      'touch_drag'        => 'on',
      'grayscale'         => 'on',
      'classic'           => 'off',
      'duration_time'     => '7',
      'show_max_item'     => '6',
      'show_max_desktop'  => '4',
      'show_max_tablet'   => '2',
      'show_max_mobile'   => '1',
      'class'             => ''
    ), $atts ) );

    $val = '';

    wp_enqueue_style( 'OwlCarousel' );
    wp_enqueue_script( 'OwlCarousel' );

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $grayscale == 'on' ? ' ts-grayscale' : '';
    $class.= $classic == 'on' ? ' ts-clients-classic' : '';

    $attrs = ' class="ts-clients ts-clients-carousel'.$class.'"';
    $attrs.= ' data-autoplay="'.esc_attr( $autoplay ).'"';
    $attrs.= ' data-stophover="'.esc_attr( $stop_hover ).'"';
    $attrs.= ' data-touch="'.esc_attr( $touch_drag ).'"';
    $attrs.= ' data-time="'.esc_attr( $duration_time ).'"';
    $attrs.= ' data-pagination="'.esc_attr( $pagination ).'"';
    $attrs.= ' data-maxitem="'.esc_attr( $show_max_item ).'"';
    $attrs.= ' data-maxdesktop="'.esc_attr( $show_max_desktop ).'"';
    $attrs.= ' data-maxtablet="'.esc_attr( $show_max_tablet ).'"';
    $attrs.= ' data-maxmobile="'.esc_attr( $show_max_mobile ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_client' ) ) {

  function themesama_client( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'src'           => '',
      'url'           => '',
      'target'        => '',
      'color'         => '',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-color-'.($color ? esc_attr( $color ) : 'default');

    $attrs = ' class="ts-client'.$class.'"';
    $attrs.= ' href="'.( $url ? esc_url( $url ) : '#' ).'"';
    $attrs.= $target ? ' target="'.esc_attr( $target ).'"' : '';
    $attrs.= $custom_color ? ' style="background-color: '.esc_attr( $custom_color ).';"' : '';

    $val.= '<a'.$attrs.'><span class="ts-img-effect"></span><img src="'.esc_url( $src ).'" alt="" /></a>';

    return $val;

  }

}


/*---------------------------------------------
  Instagram & Flickr & Photo Stream
---------------------------------------------*/
if ( ! function_exists( 'themesama_photostream' ) ) {

  function themesama_photostream( $atts = array(), $content = '', $tag ) {
    extract( shortcode_atts( array(
      'id'          => '',
      'file_size'   => 'medium',
      'user_id'     => '25025320',
      'count'       => '6',
      'first_big'   => 'on',
      'open_url'    => 'on',
      'update_time' => 50,
      'class'       => ''
    ), $atts ) );

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ( $first_big == 'on' ? ' ts-first-big' : '' );

    $attrs = ' class="ts-photostream'.$class.'"';

    //magnific-popup
    if ( $open_url != 'on' || $id ) {
      wp_enqueue_style( 'magnific-popup' );
      wp_enqueue_script( 'magnific-popup' );
      
      /*if( $tag !== 'ts_photostream' ) {
        wp_enqueue_style( 'mediaelement' );
        wp_enqueue_script( 'mediaelement' );
      }*/
    }

    wp_enqueue_script( 'imagesLoaded' );

    $val = __( 'Please check your shortcode config', TS_PTD );

    if ( $tag == 'ts_instagram' ) {

      $ph = ts_getinstagram( $user_id, $count, $update_time );

      $val = '<div'.$attrs.'>';

      foreach ( $ph as $key => $value ) {

        $ex_class = '';

        if ( $open_url == 'on' ) {
          $p_url = $value['link'];
        }else if ( $value['type'] == 'video' ) {
            $ex_class = 'iframe';
            $p_url = $value['b_img'];
          }else {
          $p_url = $value['b_img'];
        }
        $p_image = $value['t_img'];

        $val.= '<a href="'.esc_url( $p_url ).'"'.( $open_url=='on' ? ' target="_blank"':' class="mfp-'.$ex_class.'" data-gallery="photostream"' ).'><img src="'.esc_url( $p_image ).'" alt=""></a>';
        $val.= ( ( $key+1 ) % 3 === 0 ) ? '<div class="clearfix"></div>' : '';

      }

      $val.='</div>';

    }else if ( $tag == 'ts_photostream' ) {

        if ( $id ) {

          $all_photos = explode( ',', $id );
          $val = '<div'.$attrs.'>';

          foreach ( $all_photos as $key => $value ) {
            $image_ = wp_get_attachment_image_src( intval( $value ), $file_size );
            $image_big = wp_get_attachment_url( intval( $value ) );
            $val.= '<a href="'.esc_url( $image_big ).'" data-gallery="photostream"><img src="'.esc_url( $image_[0] ).'" alt=""></a>';
            $val.= ( ( $key+1 ) % 3 === 0 ) ? '<div class="clearfix"></div>' : '';
          }

          $val.='</div>';

        }

      }else if ( $tag == 'ts_flickr' ) {

        if ( $user_id == '25025320' ) {
          $user_id = '';
        }

        $ph = ts_getflickr( $user_id, $count, $update_time );

        $val = '<div'.$attrs.'>';

        foreach ( $ph as $key => $value ) {

          if ( $open_url == 'on' ) {
            $p_url = $value['link'];
          }else {
            $p_url = str_replace( '_m.', '_b.', $value['img'] );
          }

          $p_image = str_replace( '_m.', '_c.', $value['img'] );

          $val.= '<a href="'.esc_url( $p_url ).'"'.( $open_url=='on' ? ' target="_blank"':' data-gallery="photostream"' ).'><img src="'.esc_url( $p_image ).'" alt=""></a>';
          $val.= ( ( $key+1 ) % 3 === 0 ) ? '<div class="clearfix"></div>' : '';

        }

        $val.='</div>';

      }

    return $val;

  }

}

/*---------------------------------------------
  Twitter
---------------------------------------------*/
if ( ! function_exists( 'themesama_twitter' ) ) {

  function themesama_twitter( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'user_name'     => 'envato',
      'count'         => '2',
      'replies'       => 'on',
      'retweeted'     => 'on',
      'update_time'   => 30,
      'class'         => ''
    ), $atts ) );

    if ( $count == '0' ) {$count = '2';}

    $class = $class ? ' '.esc_attr( $class ) : '';
    $attrs = ' class="ts-twitter'.$class.'"';

    $exclude_replies = $replies == 'on' ? 'false' : 'true';
    $retweeted = $retweeted == 'on' ? 'true' : 'false';

    $val = __( 'Please check your config for twitter shortcode', TS_PTD );
    $tweets = array();

    $tweets = ts_gettweets( $user_name, $count, $exclude_replies, $retweeted, $update_time );

    if ( is_array( $tweets ) ) {

      $val = '<ul'.$attrs.'>';

      foreach ( $tweets as $key => $tweet ) {

        $tweet['profile_image'] = str_replace('_normal', '_200x200', $tweet['profile_image']);

        $val.= '<li>';
        $val.= '<a href="https://twitter.com/'.$tweet['screen_name'].'" class="ts-twitter-avatar" target="_blank"><img src="'.esc_url( $tweet['profile_image'] ).'" alt="" /></a>';
        $val.= '<a href="https://twitter.com/'.$tweet['screen_name'].'" class="ts-twitter-name" target="_blank">'.$tweet['user_name'].' <span>@'.$tweet['screen_name'].'</span></a> ';
        $val.= '<div class="ts-twitter-nav"><a href="https://twitter.com/intent/tweet?in_reply_to='.$tweet['id'].'" title="Reply" target="_blank" class="fa fa-reply"></a> ';
        $val.= '<a href="https://twitter.com/intent/retweet?tweet_id='.$tweet['id'].'" title="Retweet" target="_blank" class="fa fa-retweet"></a> ';
        $val.= '<a href="https://twitter.com/intent/favorite?tweet_id='.$tweet['id'].'" title="Favorite" target="_blank" class="fa fa-star-o"></a>';
        $val.= '<span>'.ts_ago( date( 'U', strtotime( $tweet['created_at'] ) ) ).'</span></div>';
        $val.= '<p class="ts-twitter-text">'.nl2br( $tweet['text'] ).'</p>';
        $val.= '</li>';

      }

      $val.= '</ul>';

    }

    return $val;

  }

}

/*---------------------------------------------
  Social
---------------------------------------------*/
if ( ! function_exists( 'themesama_social' ) ) {

  function themesama_social( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'class' => '',
      'circle' => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $circle == 'on' ? ' circle-icons' : '';

    $attrs = ' class="ts-social'.$class.'"';

    $val.= '<div'.$attrs.'>';

    $val.= do_shortcode( $content );

    $val.= '<span class="ts-social-tooltip"></span></div>';

    return $val;

  }

}

/*---------------------------------------------
  Pricing Table
---------------------------------------------*/
if ( ! function_exists( 'themesama_pricingtable' ) ) {

  function themesama_pricingtable( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'heading_type'  => '4',
      'title'         => '',
      'price_text'    => '',
      'sub_text'      => '',
      'highlight'     => 'on',
      'sup_text'      => '',
      'color'         => 'default',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';

    if ( $custom_color && $color == 'custom' ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>
      .ts-highlight-table.'.$randomID.' .ts-price,
      .ts-pricing-table.'.$randomID.' .ts-table-title{background-color: '.$custom_color.'; }
      .ts-highlight-table.'.$randomID.' .ts-price:after{color: '.$custom_color.';}';

      if( function_exists('colourBrightness') ){
        $custom_style .= '.ts-highlight-table.'.$randomID.' .ts-table-title{background-color: '.colourBrightness($custom_color, -0.85).'}';
      }

      $custom_style .= '</style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-color-'.$color;
    $class.= $highlight == 'on' ? ' ts-highlight-table' : '';
    $class.= ( isset( $randomID ) ? ' '.$randomID : '' );
    $attrs = ' class="ts-pricing-table'.$class.'"';

    $val.= '<div'.$attrs.'>';

    $val.= $custom_style;

    $val.= $title ? '<h'.$heading_type.' class="ts-table-title">'.$title.'</h'.$heading_type.'>':'';
    $val.= $price_text ? '<div class="ts-price">'

      .( $sup_text ? '<sup>'.esc_attr( $sup_text ).'</sup>':'' ).$price_text.( $sub_text ? '<sub>'.esc_attr( $sub_text ).'</sub>':'' ).

      '</div>':'';

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

/*---------------------------------------------
    Sidebar Shortcode
---------------------------------------------*/
if ( ! function_exists( 'themesama_sidebar' ) ) {

  function themesama_sidebar( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'sidebar_id' => ''
    ), $atts ) );

    $val = '';

    ob_start();
    dynamic_sidebar( $sidebar_id );
    $val = ob_get_contents();
    ob_end_clean();

    return $val;
  }

}

/*---------------------------------------------
    Widget Shortcode
---------------------------------------------*/
if ( ! function_exists( 'themesama_widget' ) ) {

  function themesama_widget( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'           => '',
      'widget'          => 'WP_Widget_Search',
      'number'          => '5',
      'sortby'          => 'menu_order',
      'exclude'         => 'null',
      'taxonomy'        => 'post_tag',
      'nav_menu'        => '',
      'cat_options'     => '',
      'archive_options' => '',
      'url'             => 'http://themeforest.net/feeds/new-themeforest-items.atom',
      'items'           => '10',
      'rss_options'     => '',
      'show_date'       => false,
    ), $atts ) );

    $val = '';

    if( defined('IS_SLUPY') ) {

      switch ($widget) {
        case 'WP_Widget_Archives':
          $extra_class = 'widget_archive';
        break;
        case 'WP_Widget_Recent_Posts':
          $extra_class = 'widget_recent_entries';
        break;
        case 'WP_Nav_Menu_Widget':
          $extra_class = 'widget_nav_menu';
        break;
        default:
          $extra_class = strtolower(str_replace('WP_', '', $widget));
        break;
      }

      $args = array(
        'before_widget' => '<aside class="slupy-widget sidebar-widget widget '.$extra_class.'">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>'
      );

    }else {
      $args = array();
    }

    $atts['title'] = $title;

    $atts['show_date'] = $show_date == 'on' ? true : false;

    if( $cat_options ) {
      $options = explode( ',', $cat_options );

      $atts['dropdown'] = in_array( 'dropdown', $options ) ? true : false;
      $atts['count'] = in_array( 'count', $options ) ? true : false;
      $atts['hierarchical'] = in_array( 'hierarchical', $options ) ? true : false;

    }else if( $archive_options ) {
      $options = explode( ',', $archive_options );

      $atts['dropdown'] = in_array( 'dropdown', $options ) ? true : false;
      $atts['count'] = in_array( 'count', $options ) ? true : false;

    }else if( $rss_options ) {
      $options = explode( ',', $rss_options );

      $atts['show_summary'] = in_array( 'show_summary', $options ) ? true : false;
      $atts['show_author'] = in_array( 'show_author', $options ) ? true : false;
      $atts['show_date'] = in_array( 'show_date', $options ) ? true : false;
      
    }

    ob_start();
    the_widget( $widget, $atts, $args );
    $val = ob_get_contents();
    ob_end_clean();

    return $val;
  }

}

/*---------------------------------------------
  Table
---------------------------------------------*/
if ( ! function_exists( 'themesama_table' ) ) {

  function themesama_table( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'color'         => '',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-color-'.($color ? esc_attr( $color ) : 'default');
    $attrs = ' class="ts-table'.$class.'"';
    $attrs.= $custom_color && $color == 'custom' ? ' style="border-color: '.esc_attr( $custom_color ).';"' : '';

    return str_replace('<table>', '<table '.$attrs.'>', do_shortcode( $content ) );

  }

}

/*---------------------------------------------
  Responsive Slider
---------------------------------------------*/
if ( ! function_exists( 'themesama_slider' ) ) {

  function themesama_slider( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'id'            => '',
      'autoplay'      => 'on',
      'stop_hover'    => 'off',
      'navigation'    => 'on',
      'pagination'    => 'on',
      'fade_effect'   => 'on',
      'touch_drag'    => 'on',
      'duration_time' => '7',
      'auto_height'   => 'on',
      'file_size'     => 'medium',
      'fb_slider'     => '',
      'class'         => ''
    ), $atts ) );

    $val = '';
    $multi_img = true;

    wp_enqueue_style( 'OwlCarousel' );
    wp_enqueue_script( 'OwlCarousel' );

    $class = $class ? ' '.esc_attr( $class ) : '';

    //check id one image
    if( $id && strpos($id, ',') === false ) {
      
      $image_ = wp_get_attachment_image_src( intval( $id ), $file_size );
      $val.= '<img src="'.esc_url( $image_[0] ).'" class="fluid-image" alt="">';
      $multi_img = false;

    }else {

      $attrs = ' class="'.($fb_slider ? 'ts-fb-slider' : 'ts-slider').$class.'"';
      $attrs.= ' data-autoplay="'.esc_attr( $autoplay ).'"';
      $attrs.= ' data-stophover="'.esc_attr( $stop_hover ).'"';
      $attrs.= ' data-navigation="'.esc_attr( $navigation ).'"';
      $attrs.= ' data-fade="'.esc_attr( $fade_effect ).'"';
      $attrs.= ' data-touch="'.esc_attr( $touch_drag ).'"';
      $attrs.= ' data-time="'.esc_attr( $duration_time ).'"';
      $attrs.= ' data-pagination="'.esc_attr( $pagination ).'"';
      $attrs.= ' data-autoheight="'.esc_attr( $auto_height ).'"';

      $val.= '<div'.$attrs.'>';

      if ( $id ) {

        $all_photos = explode( ',', $id );
        foreach ( $all_photos as $key => $value ) {
          $image_ = wp_get_attachment_image_src( intval( $value ), $file_size );
          $val.= '<div class="ts-slider-item">
          <img src="'.esc_url( $image_[0] ).'" alt="">
        </div>';
        }

      }else {

        $val.= do_shortcode( $content );

      }

    }

    $val.= $multi_img ? '</div>' : '';
    
    return $val;

  }

}

if ( ! function_exists( 'themesama_slideritem' ) ) {

  function themesama_slideritem( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'   => '',
      'src'     => '',
      'v_pos'   => 'bottom',
      'h_pos'   => 'left',
      'url'     => '',
      'target'  => '',
      'class'   => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';

    $attrs = ' class="ts-slider-item'.$class.'"';

    $val.= '<div'.$attrs.'>';
    
    $val.= $url ? '<a href="'.esc_url( $url ).'"'.( $target ? ' target="'.esc_attr( $target ).'"':'' ).'>' : '';
    $val.= '<img src="'.esc_url( $src ).'" alt="" />';
    $val.= $url ? '</a>':'';

    $val.= ( $title || $content ) ? '<div class="ts-slider-desc ts-'.esc_attr( $v_pos ).' ts-'.esc_attr( $h_pos ).'">'.( $title ? '<h4 class="ts-slider-heading">'.$title.'</h4>':'' ).( $content ? '<div class="clearfix"></div><div class="ts-slider-content">'.$content.'</div>' : '' ).'</div>' : '';

    $val.= '</div>';

    return $val;

  }

}

/*---------------------------------------------
  Testimonials
---------------------------------------------*/
if ( ! function_exists( 'themesama_testimonials' ) ) {

  function themesama_testimonials( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'autoplay'      => 'on',
      'stop_hover'    => 'on',
      'navigation'    => 'on',
      'fade_effect'   => 'on',
      'touch_drag'    => 'on',
      'duration_time' => '7',
      'model'         => 'standard',
      'class'         => ''
    ), $atts ) );

    $val = '';

    wp_enqueue_style( 'OwlCarousel' );
    wp_enqueue_script( 'OwlCarousel' );

    global $ts_testimonial_model;
    $ts_testimonial_model = $model;

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-'.esc_attr( $model );
    $class.= $navigation != 'on' ? ' ts-without-nav' : '';

    $attrs = ' class="ts-testimonials'.$class.'"';
    $attrs.= ' data-autoplay="'.esc_attr( $autoplay ).'"';
    $attrs.= ' data-stophover="'.esc_attr( $stop_hover ).'"';
    $attrs.= ' data-navigation="'.esc_attr( $navigation ).'"';
    $attrs.= ' data-pagination="'.esc_attr( $navigation ).'"';
    $attrs.= ' data-fade="'.esc_attr( $fade_effect ).'"';
    $attrs.= ' data-touch="'.esc_attr( $touch_drag ).'"';
    $attrs.= ' data-time="'.esc_attr( $duration_time ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_testimonial' ) ) {

  function themesama_testimonial( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'client_name'   => '',
      'client_job'    => '',
      'client_image'  => '',
      'class'         => ''
    ), $atts ) );

    global $ts_testimonial_model;

    $image_ = $client_image ? wp_get_attachment_image_src( intval( $client_image ) ): '';

    $client_image = isset( $image_[0] ) ? '<img src="'.esc_url( $image_[0] ).'" alt="" />' : '';

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';

    $attrs = ' class="ts-testimonial'.$class.'"';

    $val.= '<div'.$attrs.'>';
    //big image
    $val.= ( $client_image && $ts_testimonial_model != 'standard' ) ? '<div class="ts-testimonial-img">'.$client_image.'</div>':'';
    $val.= '<div class="ts-testimonial-desc'.( $client_name ? ' ts-with-author' : '' ).( ( $client_image && $ts_testimonial_model != 'standard' ) ? ' ts-with-image' : '' ).'"><div class="ts-desc">'.do_shortcode( $content ).'</div>';
    $val.= '<div class="clearfix"></div>';
    $val.= ( $client_image  && $ts_testimonial_model == 'standard' ) ? '<div class="ts-testimonial-small-img">'.$client_image.'</div>':'';
    $val.= ( $client_name ? '<div class="ts-author">'.esc_attr( $client_name ).( $client_job ? ', <small>'.$client_job.'</small>':'' ).'</div>':'' );
    $val.= '</div></div>';

    return $val;

  }

}

/*---------------------------------------------
  Pie Charts
---------------------------------------------*/
if ( ! function_exists( 'themesama_charts' ) ) {

  function themesama_charts( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'model'         => 'standard',
      'animated'      => 'on',
      'size'          => '210',
      'tooltip_top'   => 'on',
      'tooltip_hover' => 'on',
      'class'         => ''
    ), $atts ) );

    wp_enqueue_script( 'jquery-effects-core' );
    wp_enqueue_script( 'waypoints' );
    wp_enqueue_script( 'easyPieChart' );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-charts-'.esc_attr( $model );
    $class.= $model == 'tooltip' ? ' ts-tooltip-'.($tooltip_top == 'on' ? 'top' : 'bottom') : '';

    switch ( intval( $size ) ) {

    case intval( $size ) <= 160 :
      $ex_size = 'small';
      break;
    case intval( $size )<= 210 :
      $ex_size = 'medium';
      break;
    default:
      $ex_size = 'large';
      break;
    }

    $class.= ' ts-charts-'.$ex_size;

    $attrs = ' class="ts-charts'.$class.'"';
    $attrs.= ' data-animated="'.esc_attr( $animated ).'"';
    $attrs.= ' data-size="'.esc_attr( $size ).'"';
    $attrs.= ' data-trigger="'.( $tooltip_hover == 'off' ? 'click' : 'mouseenter' ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_chart' ) ) {

  function themesama_chart( $atts = array() ) {
    global $ts_default_color;
    extract( shortcode_atts( array(
      'model'           => '',
      'animated'        => '',
      'size'            => '210',
      'tooltip_top'     => 'on',
      'tooltip_hover'   => 'on',
      'icon'            => '',
      'title'           => '',
      'percentage'      => '',
      'percentage_text' => '',
      'color'           => 'default',
      'custom_color'    => '',
      'track_color'     => '#dcdde0',
      'class'           => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';
    $pie_color = $custom_color ? $custom_color : check_ts_default_colors(true, $color);

    //check single pie
    if( $model && $animated ) {
      return themesama_charts( $atts, '[ts_chart track_color="'.$track_color.'" icon="'.$icon.'" title="'.$title.'" percentage="'.$percentage.'" percentage_text="'.$percentage_text.'" color="'.$color.'" custom_color="'.$custom_color.'" class="'.$class.'"]' );
    } //single pie
    
    //check icon
    $percentage_text = $icon ? '<i class="fa fa-'.$icon.'"></i> '.$percentage_text : $percentage_text;

    if ( $custom_color ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>
    .'.$randomID.' .ts-skill-title span{background-color: '.( $custom_color ? $custom_color : $color ).';}
    .'.$randomID.' .ts-skill-title span:after{color:'.( $custom_color ? $custom_color : $color ).';}
  </style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-custom';
    $class.= !$title ? ' ts-without-skill' : '';
    $class.= isset( $randomID ) ? ' '.$randomID : '';

    $attrs = ' class="ts-chart'.esc_attr( $class ).'"';
    $attrs.= ' data-percent="'.esc_attr( $percentage ).'"';
    $attrs.= ' data-barcolor="'.esc_attr( $pie_color ).'"';
    $attrs.= ' data-trackcolor="'.esc_attr( $track_color ).'"';

    $val.= '<span'.$attrs.'>';

    $val.= $custom_style;

    $val.= '<span class="ts-percentage-title'.( $title ? ' ts-chart-with-title' : '' ).'">'.str_replace( $percentage, '<span class="ts-chart-percent">'.$percentage.'</span>' , $percentage_text ).'</span>';
    $val.= $title ? '<span class="ts-skill-title"><span>'.$title.'</span></span>' : '';

    $val.='</span>';

    return $val;

  }

}

/*---------------------------------------------
  Progress Bars
---------------------------------------------*/
if ( ! function_exists( 'themesama_bars' ) ) {

  function themesama_bars( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'model'    => 'standard',
      'animated' => 'on',
      'class'    => ''
    ), $atts ) );

    wp_enqueue_script( 'jquery-effects-core' );
    wp_enqueue_script( 'waypoints' );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-bar-'.esc_attr( $model );

    $attrs = ' class="ts-bars'.$class.'"';
    $attrs.= ' data-animated="'.esc_attr( $animated ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_bar' ) ) {

  function themesama_bar( $atts = array() ) {
    extract( shortcode_atts( array(
      'model'           => '',
      'animated'        => '',
      'title'           => '',
      'icon'            => '',
      'percentage'      => '',
      'percentage_text' => '',
      'color'           => '',
      'custom_color'    => '',
      'class'           => ''
    ), $atts ) );

    $val = '';

    //Single  bar
    if( $model && $animated ){
      return themesama_bars( array('model' => $model, 'animated' => $animated), '[ts_bar title="'.$title.'" icon="'.$icon.'" percentage="'.$percentage.'" percentage_text="'.$percentage_text.'" color="'.$color.'" custom_color="'.$custom_color.'" model="'.$model.'" class="'.$class.'"]' );
    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-default';

    $attrs = ' class="ts-bar'.esc_attr( $class ).'"';
    $attrs.= ' data-percentage="'.esc_attr( $percentage ).'"';

    $val.= '<div'.$attrs.'>';
    $val.= '<div class="ts-bar-title"><div>';

    $val.= $icon ? '<span class="ts-bar-icon fa fa-'.esc_attr( $icon ).'"></span>' : '';
    $val.= esc_attr( $title ).($model == 'thin' && $percentage_text ? '<small class="pull-right">'.$percentage_text.'</small>' : '').'</div>';

    $val.='</div>';
    $val.='<div class="ts-bar-percentage"><span class="ts-bar-color"'.($custom_color ? ' style="background-color:'.esc_attr( $custom_color ).'";' : '').'>'.( ( $percentage_text ) ? '<span class="ts-bar-percentage-title">'.esc_attr( $percentage_text ).'</span>': '' ).'</span></div>';
    $val.='</div>';

    return $val;

  }

}

if ( ! function_exists( 'themesama_milestone' ) ) {

  function themesama_milestone( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'start'         => '0',
      'end'           => '',
      'before'        => '',
      'after'         => '',
      'duration'      => '4',
      'subject'       => '',
      'icon'          => '',
      'icon_pos'      => 'left',
      'separator'     => 'on',
      'decimals'      => '0',
      'color'         => 'default',
      'number_color'  => '',
      'subject_color' => '',
      'icon_color'    => '',
      'size'          => 'medium',
      'class'         => ''
    ), $atts ) );

    $val = '';

    wp_enqueue_script( 'waypoints' );
    wp_enqueue_script( 'countUp' );

    //icon
    $icon = $icon ? '<span class="ts-milestone-icon ts-milestone-icon-'.esc_attr( $icon_pos ).' fa fa-'.esc_attr( $icon ).'"'.($icon_color ? ' style="color:'.esc_attr( $icon_color ).'"' : '').'></span>' : '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= empty( $icon )  || ($icon && $icon_pos == 'top') ? ' text-center' : '';
    $class.= $icon && $icon_pos == 'right' ? ' text-right' : '';
    $class.= empty( $icon ) ? ' ts-milestone-without-icon' : '';
    $class.= ' ts-milestone-'.$size;
    $class.= ' ts-color-'.$color;

    $attrs = ' class="ts-milestone'.$class.'"';

    $val.= '<div'.$attrs.'>';
    $val.= $icon ? $icon : '';

    $val.= '<div class="ts-milestone-text"'.($number_color ? ' style="color:'.esc_attr( $number_color ).'"' : '').'>';
    $val.= $before ? '<span class="ts-milestone-before">'.$before.'</span>' : '';
    $val.= '<span class="ts-milestone-number" data-separator="'.esc_attr( $separator ).'" data-duration="'.esc_attr( $duration ).'" data-decimals="'.esc_attr( $decimals ).'" data-start="'.esc_attr($start).'" data-end="'.esc_attr($end).'">'.$start.'</span>';
    $val.= $after ? '<span class="ts-milestone-after">'.$after.'</span>' : '';
    $val.= '</div>';

    $val.= $subject ? '<div class="ts-milestone-subject"'.($subject_color ? ' style="color:'.esc_attr( $subject_color ).'"' : '').'>'.$subject.'</div>' : '';

    $val.= '</div>';

    return $val;

  }

}

if ( ! function_exists( 'themesama_countdown' ) ) {

  function themesama_countdown( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'date'          => '',
      'format'        => '',
      'custom_format' => '',
      'timezone'      => '',
      'labels'        => '',
      'labels1'       => '',
      'digits'        => '',
      'model'         => 'standard',
      'class'         => ''
    ), $atts ) );

    $val = '';

    wp_enqueue_script( 'countDown' );

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-countdown-'.$model;

    $attrs = ' class="ts-countdown'.esc_attr( $class ).'"';
    $attrs.= ' data-date="'.esc_attr( $date ).'"';
    $attrs.= $timezone ? ' data-timezone="'.esc_attr( $timezone ).'"' : '';
    $attrs.= $labels ? ' data-labels="'.esc_attr( $labels ).'"' : '';
    $attrs.= $labels1 ? ' data-labels1="'.esc_attr( $labels1 ).'"' : '';
    $attrs.= $digits ? ' data-digits="'.esc_attr( $digits ).'"' : '';
    $attrs.= ' data-format="'.($format != 'custom' ? esc_attr( $format ) : esc_attr( $custom_format )).'"';

    $val.= '<div'.$attrs.'></div>';

    return $val;

  }

}

/*---------------------------------------------
  Button
---------------------------------------------*/
if ( ! function_exists( 'themesama_button' ) ) {

  function themesama_button( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'         => '',
      'size'          => 'medium',
      'color'         => '',
      'url'           => '#',
      'target'        => '',
      'icon'          => '',
      'border'        => 'off',
      'title_attr'    => 'off',
      'icon_pos'      => '',
      'hover_effect'  => 'off',
      'textcolor'     => '',
      'textcolorhover'=> '',
      'bgcolor'       => '',
      'bgcolorhover'  => '',
      'align'         => '',
      'class'         => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';

    if ( $color == 'custom' ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>';
      $custom_style.= $border != 'on' ? '.ts-button.'.$randomID.'{background-color: '.$bgcolor.';}' : '';
      $custom_style.= $border != 'on' ? '.ts-button.'.$randomID.':hover{background-color: '.$bgcolorhover.';}' : '';
      $custom_style.= $textcolor ? '.ts-button.'.$randomID.' .ts-button-title{color:'.$textcolor.';}' : '';
      $custom_style.= $textcolorhover ? '.ts-button.'.$randomID.':hover .ts-button-title{color:'.$textcolorhover.';}' : '';
    
      if( $border == 'on' ){
        $custom_style.= '.ts-border-button.ts-button.'.$randomID.'{border-color: '.$bgcolor.';}';
        $custom_style.= '.ts-border-button.ts-button.'.$randomID.',
                .ts-border-button.ts-button.'.$randomID.' .ts-button-title,
                .ts-border-button.ts-button.'.$randomID.' .ts-button-icon{color: '.$bgcolor.';}';

        $custom_style.= '.ts-border-button.ts-button.'.$randomID.':hover{border-color: '.$bgcolorhover.';background-color: '.$bgcolorhover.';}';
        $custom_style.= '.ts-border-button.ts-button.'.$randomID.':hover,
                .ts-border-button.ts-button.'.$randomID.':hover .ts-button-title,
                .ts-border-button.ts-button.'.$randomID.':hover .ts-button-icon{color: #fff;}';
      }

    $custom_style.= '</style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= isset( $randomID ) ? ' '.$randomID : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-'.check_ts_default_colors();
    $class.= ' ts-button-'.$size;
    $class.= $icon_pos && $icon ? ' ts-icon-'.$icon_pos : '';
    $class.= $align && $align != 'center' ? ' ts-align-'.$align : '';
    $class.= $hover_effect == 'on' && $icon ? ' ts-button-effect' : '';
    $class.= $border == 'on' ? ' ts-border-button' : '';

    $attrs = ' class="ts-button'.esc_attr( $class ).'"';
    $attrs.= ' href="'.esc_url( $url ).'"';
    $attrs.= $target ? ' target="'.esc_attr( $target ).'"':'';
    $attrs.= $title_attr == 'on' ? ' title="'.esc_attr( $title ).'"' : '';

    $val.= $align == 'center' ? '<div class="text-center">' : '';

    $val.= '<a'.$attrs.'>';

    $val.= $custom_style ? $custom_style : '';

    $icon = $icon ? '<span class="ts-button-icon"><span class="ts-btn-icon fa fa-'.$icon.'"></span></span>' : '';

    $val.= $icon && ($icon_pos == 'top' || $icon_pos == 'left') ? $icon : '';
    $val.= '<span class="ts-button-title">'.$title.'</span>';
    $val.= $icon && ($icon_pos == 'bottom' || $icon_pos == 'right') ? $icon : '';

    $val.= '</a>';

    $val.= $align == 'center' ? '</div>' : '';

    return $val;

  }

}

/*---------------------------------------------
  Buttons Set
---------------------------------------------*/
if ( ! function_exists( 'themesama_buttonset' ) ) {

  function themesama_buttonset( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title_left'  => '',
      'title_right' => '',
      'title_attr'  => 'off',
      'color'       => '',
      'url'         => '#',
      'target'      => '',
      'url2'        => '#',
      'target2'     => '',
      'align'       => '',
      'center_text' => 'or',
      'border'      => 'off',
      'class'       => ''
    ), $atts ) );

    $val = '';

    if( strpos( $center_text, 'fa-' ) !== false ) {
      $center_text = '<i class="fa '.$center_text.'"></i>';
    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $border == 'on' ? ' ts-border-button' : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-'.check_ts_default_colors();
    $class.= $align && $align != 'center' ? ' ts-align-'.$align : '';

    $attrs = ' class="ts-buttons'.esc_attr( $class ).'"';

    $val.= $align == 'center' ? '<div class="text-center">' : '';

    $val.= '<span'.$attrs.'>';

    $attrs = ' href="'.esc_url( $url ).'"';
    $attrs.= $target ? ' target="'.esc_attr( $target ).'"':'';
    $attrs.= $title_attr == 'on' ? ' title="'.esc_attr( $title_left ).'"' : '';

    $val.= '<a'.$attrs.' class="ts-button-left ts-buttons-btn">'.$title_left.'</a>';

    $val.= '<span class="ts-button-center">'.$center_text.'</span>';

    $attrs = ' href="'.esc_url( $url2 ).'"';
    $attrs.= $target2 ? ' target="'.esc_attr( $target2 ).'"':'';
    $attrs.= $title_attr == 'on' ? ' title="'.esc_attr( $title_right ).'"' : '';

    $val.= '<a'.$attrs.' class="ts-button-right ts-buttons-btn">'.$title_right.'</a>';

    $val.= '</span>';

    $val.= $align == 'center' ? '</div>' : '';

    return $val;

  }

}

/*---------------------------------------------
  Icon
---------------------------------------------*/
if ( ! function_exists( 'themesama_icon' ) ) {

  function themesama_icon( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'     => '',
      'icon'      => '',
      'size'      => 'medium',
      'h_size'    => '3',
      'heading'   => '',
      'small_text'=> '',
      'url'       => '',
      'target'    => '',
      'class'     => ''
    ), $atts ) );

    $val = '';
    $c_text = '';

    $size = esc_attr( $size );
    $icon = esc_attr( $icon );
    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $small_text ? ' ts-heading-divider' : '';

    $attrs = $class ? ' class="'.$class.'"' : '';
    $attrs.= $title ? ' data-title="'.esc_attr( $title ).'"':'';
    $attrs.= $url ? ' href="'.esc_url( $url ).'"':'';
    $attrs.= $target ? ' target="'.esc_attr( $target ).'"':'';

    $o_icon = $icon;
    $icon = $icon ? '<span class="fa fa-'.$icon.' ts-size-'.$size.' ts-heading-icon"></span>' : '';

    if ( $url && $heading ) {
      $c_text = '<a'.$attrs.'>'.$icon.$heading.'</a>';

    }else if ( $heading ) {
      $c_text = $icon.$heading;

    }else if ( $url && $icon ) {
      $c_text = '<a'.$attrs.'><span class="fa fa-'.$o_icon.' fa-fw ts-size-'.$size.'"></span></a>';

    }else if( $icon ) {
      $c_text = '<span class="fa fa-'.$o_icon.' fa-fw ts-size-'.$size.'"></span>';

    }

    if ( $heading ) {
      $c_text .= $small_text ? '<small>'.$small_text.'</small>' : '';
      $val = '<h'.$h_size.( $class ? ' class="'.$class.'"' : '' ).'>'.$c_text.'</h'.$h_size.'>';

    }else {
      $val = $c_text;
    }

    $val .= $content ? '<div class="ts-iconbox-content'.($icon ? ' ts-content-padding-'.$size : '' ).'">'.do_shortcode($content).'</div>' : '';

    return $val;

  }

}

/*---------------------------------------------
  List Style
---------------------------------------------*/
if ( ! function_exists( 'themesama_list' ) ) {

  function themesama_list( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'icon'  => '',
      'type'  => 'circle',
      'class' => ''
    ), $atts ) );

    $val = '';

    if ( $type == 'custom' && $icon ) {
      $content_ = str_replace( '<ul', '<ul class="fa-ul" ', do_shortcode( $content ) );
      $content_ = str_replace( '<li>', '<li><i class="fa-li fa fa-'.esc_attr( $icon ).'"></i>', $content_ );
    }else {
      $content_ = do_shortcode( $content );
    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-list-'.esc_attr( $type );

    $attrs = ' class="ts-list'.$class.'"';

    $val.= '<div'.$attrs.'>';
    $val.= $content_;
    $val.= '</div>';

    return $val;

  }

}

/*---------------------------------------------
  Highlight
---------------------------------------------*/
if ( ! function_exists( 'themesama_highlight' ) ) {

  function themesama_highlight( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'color'             => '',
      'custom_bgcolor'    => '',
      'custom_textcolor'  => '',
      'class'             => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-default';

    $attrs = ' class="ts-highlight'.esc_attr( $class ).'"';

    $val.= '<span'.$attrs.( $custom_textcolor && $custom_bgcolor ? ' style="color: '.esc_attr( $custom_textcolor ).'; background-color: '.esc_attr( $custom_bgcolor ).';"' : '' ).'>';

    $val.= do_shortcode( $content );

    $val.= '</span>';
    return $val;

  }

}

/*---------------------------------------------
  AlertBoxes
---------------------------------------------*/
if ( ! function_exists( 'themesama_alertbox' ) ) {

  function themesama_alertbox( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'model'       => 'info',
      'icon'        => 'info-circle',
      'bg_color'    => '',
      'class'       => ''
    ), $atts ) );

    $val = '';

    switch ( $model ) {
      case 'success':
        $alert_icon = 'fa-check';
        break;
      case 'info':
        $alert_icon = 'fa-info';
        break;
      case 'notice':
        $alert_icon = 'fa-exclamation';
        break;
      case 'error':
        $alert_icon = 'fa-ban';
        break;
      case 'custom':
        $alert_icon = 'fa-'.$icon;
        break;
    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= ' ts-'.( $model ).'-alertbox';

    $attrs = ' class="ts-alertbox'.esc_attr( $class ).'"';

    $val.= '<div'.$attrs.'>';

    $val.= '<div class="ts-alert-icon"'.($bg_color && $model == 'custom' ? ' style="background-color:'.esc_attr( $bg_color ).'; color:'.esc_attr( $bg_color ).';"' : '').'><span class="ts-icon fa '.esc_attr( $alert_icon ).'"></span></div>';
    $val.= '<div class="ts-alert-content">'.do_shortcode( $content ).'</div>';

    $val.= '<span class="ts-alertbox-close fa fa-times"></span></div>';
    return $val;

  }

}

/*---------------------------------------------
  Dropcap & Iconbox
---------------------------------------------*/
if ( ! function_exists( 'themesama_dropcap' ) ) {

  function themesama_dropcap( $atts = array() ) {
    extract( shortcode_atts( array(
      'bg'            => 'transparent',
      'text'          => '',
      'icon'          => '',
      'left_dropcap'  => 'on',
      'color'         => '',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $val = '';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-default';
    $class.= $left_dropcap == 'on' ? ' left-dropcap' : ' right-dropcap';
    $class.= ( strlen( $text ) > 1 || ( $text && $icon ) ) ? ' ts-dropcap-transparent' : ' ts-dropcap-'.$bg;

    $attrs = ' class="ts-dropcap'.$class.'"';
    if ( $custom_color && $color == 'custom' ) {
      $attrs .= ' style="'.(( strlen( $text ) > 1 || ( $text && $icon ) || $bg == 'transparent' ) ? 'color:' : 'background-color:').esc_attr( $custom_color ).';"';
    }

    $val.= '<span'.$attrs.'>';

    $val.= $icon ? '<span class="fa fa-'.esc_attr( $icon ).' fa-fw"></span>' : '';
    $val.= $text ? $text : '';

    $val.= '</span>';
    return $val;

  }

}

/*---------------------------------------------
  Blockquote & Info Box
---------------------------------------------*/
if ( ! function_exists( 'themesama_blockquote' ) ) {

  function themesama_blockquote( $atts = array(), $content = '', $tag ) {
    extract( shortcode_atts( array(
      'quote_icon'      => 'off',
      'info_box'        => 'off',
      'horizontal_line' => 'off',
      'color'           => '',
      'custom_color'    => '',
      'author_name'     => '',
      'author_job'      => '',
      'class'           => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';

    if( $tag == 'ts_infobox' ){
      $info_box = 'on';
    }

    if ( $custom_color && $color == 'custom' ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>
      .'.$randomID.'.ts-blockquote:after{color: '.$custom_color.';}
      .'.$randomID.'.ts-blockquote.ts-horizontal-line{border-bottom-color: '.$custom_color.'; }
      .'.$randomID.'.ts-blockquote.ts-vertical-line{border-left-color: '.$custom_color.'; }
    </style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-default';
    $class.= $quote_icon == 'on' ? ' ts-quote-icon' : '';
    $class.= $horizontal_line == 'on' ? ' ts-horizontal-line' : ' ts-vertical-line';
    $class.= $author_name ? ' ts-with-author' : '';
    $class.= $info_box == 'on' ? ' ts-info-box' : '';
    $class.= isset( $randomID ) ? ' '.$randomID : '';

    $attrs = ' class="ts-blockquote'.esc_attr( $class ).'"';

    $val.= $info_box == 'on' ? '<div'.$attrs.'>' : '<blockquote'.$attrs.'>';

    $val.= $custom_style;

    $val.= $quote_icon == 'on' ? '<i class="quote-icon fa fa-quote-left"></i>' : '';
    $val.= do_shortcode( $content );
    $val.= $author_name ? '<div class="ts-author">'.$author_name.( $author_job ? ', <small>'.$author_job.'</small>' : '' ).'</div>' : '';

    $val.= $info_box == 'on' ? '</div>' : '</blockquote>';
    return $val;

  }

}

/*---------------------------------------------
  Accordion & Toggle
---------------------------------------------*/
if ( ! function_exists( 'themesama_accordions' ) ) {

  function themesama_accordions( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'collapsible'   => 'on',
      'click_open'    => 'on',
      'color'         => '',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';

    if ( $custom_color && $color == 'custom' ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>
      .'.$randomID.' .ts-active-accordion .ts-accordion-button:after{color: '.$custom_color.';}
      .'.$randomID.' .ts-active-accordion .ts-accordion-button{border-color: '.$custom_color.'; }
      </style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $color ? ' ts-color-'.esc_attr( $color ) : ' ts-color-default';
    $class.= isset( $randomID ) ? ' '.$randomID:'';

    $attrs = ' class="ts-accordions'.$class.'"';
    $attrs.= ' data-trigger="'.( $click_open == 'on' ? 'click' : 'mouseenter' ).'"';
    $attrs.= ' data-collapsible="'.( $collapsible == 'on' ? 'on' : 'off' ).'"';

    
    $val.= '<div'.$attrs.'>';

    $val.= $custom_style;

    $val.= do_shortcode( $content );

    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_accordion' ) ) {

  function themesama_accordion( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'     => 'Title',
      'icon'      => '',
      'activated' => 'off',
      'class'     => ''
    ), $atts ) );

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $activated == 'on' ? ' ts-active-accordion' : '';

    $attrs = ' class="ts-accordion'.$class.'"';

    $val = '<div'.$attrs.'>';
    $val.= '<h4 class="ts-accordion-button">';

    $val.= $icon ? '<span class="ts-accordion-icon fa fa-'.esc_attr( $icon ).'"></span>' : '';
    $val.= $title ? '<span class="ts-accordion-title">'.esc_attr( $title ).'</span>' : '';
    $val.='</h4><div class="ts-accordion-content"'.($activated == 'on' ? ' style="display:block;"' : '' ).'>'.do_shortcode( $content ).'</div></div>';

    return $val;

  }

}

if ( !function_exists( 'themesama_toggle' ) ) {

  function themesama_toggle( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'         => 'Toggle',
      'activated'     => 'off',
      'icon'          => '',
      'click_open'    => 'on',
      'color'         => '',
      'custom_color'  => '',
      'class'         => ''
    ), $atts ) );

    $class .= ' ts-toggle';

    $accordion_config = array(
      'click_open'    => $click_open,
      'color'         => $color,
      'custom_color'  => $custom_color,
      'class'         => $class
    );

    $toggle_config = array(
      'title'         => $title,
      'icon'          => $icon,
      'activated'     => $activated
    );

    $toggle = themesama_accordion( $toggle_config, $content );
    $toggle = themesama_accordions( $accordion_config, $toggle );

    return $toggle;
  }

}


/*---------------------------------------------
  Tabs
---------------------------------------------*/
if ( ! function_exists( 'themesama_tabs' ) ) {

  function themesama_tabs( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'horizontal_buttons'  => 'on',
      'left_buttons'        => 'on',
      'click_open'          => 'on',
      'color'               => '',
      'custom_color'        => '',
      'class'               => ''
    ), $atts ) );

    $val = '';
    $custom_style = '';

    if ( $custom_color && $color == 'custom' ) {

      $randomID = 'ts-custom-'.rand();

      $custom_style = '<style type="text/css" scoped>
      .'.$randomID.' .ts-current-tab a,
      .'.$randomID.' .ts-tab-nav a:hover{background-color: '.$custom_color.'; }
      .'.$randomID.' .ts-current-tab a:after{color: '.$custom_color.';}
      .'.$randomID.' .ts-tab-nav li:hover,
      .'.$randomID.' .ts-current-tab{border-color:'.$custom_color.';}
      </style>';

    }

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $horizontal_buttons == 'on' ? ' ts-horizontal-tab' : ' ts-vertical-tab';
    $class.= $left_buttons == 'on' ? ' ts-left-nav' : ' ts-right-nav';
    $class.= $color ? ' ts-color-'.$color : ' ts-color-default';
    $class.= isset( $randomID ) ? ' '.$randomID:'';

    $attrs = ' class="ts-tabs'.esc_attr( $class ).'"';
    $attrs.= ' data-trigger="'.( $click_open == 'on' ? 'click' : 'mouseenter' ).'"';

    global $ts_tab_buttons;
    $ts_tab_buttons = '';

    $tab_content = do_shortcode( $content );

    $val.= '<div'.$attrs.'>';

    $val.= $custom_style;

    $val.= '<ul class="ts-tab-nav">'.$ts_tab_buttons.'</ul>';
    $val.= '<div class="ts-tab-contents">'.$tab_content.'</div>';
    $val.= '</div>';
    return $val;

  }

}

if ( ! function_exists( 'themesama_tab' ) ) {

  function themesama_tab( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'title'       => '',
      'icon'        => '',
      'active_tab'  => '',
      'class'       => ''
    ), $atts ) );

    global $ts_tab_buttons;

    $class .= $active_tab ? 'ts-current-tab' : '';

    $ts_tab_buttons.= '<li'.( $class ? ' class="'.$class.'"' : '' ).'>';
    $ts_tab_buttons.= '<a href="#" title="'.esc_attr( $title ).'">';
    $ts_tab_buttons.= $icon ? '<span class="ts-tab-icon fa fa-'.esc_attr( $icon ).'"></span>' : '';
    $ts_tab_buttons.= $title ? '<span class="ts-tab-title">'.esc_attr( $title ).'</span>' : '';
    $ts_tab_buttons.= '</a></li>';

    $val='<div class="ts-tab-content"'.($active_tab ? ' style="display:block;"' : '' ).'>'.do_shortcode( $content ).'</div>';

    return $val;

  }

}

/*---------------------------------------------
  Media - Responsive Video & Image
---------------------------------------------*/
if ( ! function_exists( 'themesama_media' ) ) {

  function themesama_media( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'image_src'   => '',
      'video_mp4'   => '',
      'video_webm'  => '',
      'video_ogv'   => '',
      'muted'       => 'off',
      'poster'      => '',
      'loop'        => 'off',
      'autoplay'    => 'off',
      'controls'    => 'on',
      'url'         => '',
      'target'      => '',
      'class'       => ''
    ), $atts ) );

    $val = '';
    $class = $class ? ' '.esc_attr( $class ) : '';
    $class = $controls != 'on' ? esc_attr( $class ).' ts-hide-controls' : esc_attr( $class );

    if ( $video_mp4 || $video_webm || $video_ogv ) {

      wp_enqueue_style( 'mediaelement' );
      wp_enqueue_script( 'mediaelement' );

      $attr = '';
      $attr.= ( $controls == 'on' ? ' controls="controls"':'' );
      $attr.= ( $muted == 'on' ? ' muted="muted"':'' );
      $attr.= ( $autoplay == 'on' ? ' autoplay="autoplay"':'' );
      $attr.= ( $loop == 'on' ? ' loop="loop"':'' );
      $attr.= ( $poster ? ' poster="'.esc_url( $poster ).'"':'' );
      $attr.= '  preload="none"';
      $val =  '<div style="width:1920px; height: 1080px; opacity: 0;" class="ts-video'.$class.'">';
      $val.=  '<video'.$attr.'>';

      $val.=  ( strpos( $video_mp4, 'youtu' ) !== false ) ? '<source type="video/youtube" src="'.esc_url( $video_mp4 ).'">' : '';
      $val.=  ( $video_mp4 && strpos( $video_mp4, 'youtu' ) === false ) ? '<source type="video/mp4" src="'.esc_url( $video_mp4 ).'">' : '';
      $val.=  ( $video_webm ) ? '<source type="video/webm" src="'.esc_url( $video_webm ).'">' : '';
      $val.=  ( $video_ogv ) ? '<source type="video/ogg" src="'.esc_url( $video_ogv ).'">' : '';

      $val.=  '</video></div>';

      if ( version_compare( get_bloginfo( 'version' ), '3.9', '>' ) && function_exists('wp_video_shortcode') ) {
        $video_shortcode_settings = array(
          'mp4'       => esc_url( $video_mp4 ),
          'ogv'       => esc_url( $video_ogv ),
          'webm'      => esc_url( $video_webm ),
          'poster'    => esc_url( $poster ),
          'width'     => '1280',
          'height'    => '720'
        );

        if( $autoplay == 'on' ) {
          $video_shortcode_settings['autoplay'] = 'on';
        }

        $val = wp_video_shortcode( $video_shortcode_settings );

      }

    }else if ( isset( $content ) && $content ) {

        wp_enqueue_script( 'fitvids' );
        $val = '<div class="ts-fitvids'.$class.'">'.$content.'</div>';

      }else if ( $image_src ) {

        $img_ = '<img src="'.esc_url( $image_src ).'" class="fluid-image'.$class.'" alt="" />';
        $val = ( $url ) ? '<a href="'.esc_url( $url ).'"'.( ( $target ) ? ' target="'.esc_attr( $target ).'"':'' ).'>'.$img_.'</a>' : $img_;

      }else {

      $val = __( 'Please Insert a URL for Video', TS_PTD );

    }

    return do_shortcode( $val );
  }

}

/*---------------------------------------------
  User Cart
---------------------------------------------*/
if ( ! function_exists( 'themesama_usercart' ) ) {

  function themesama_usercart( $atts = array(), $content = '' ) {
    extract( shortcode_atts( array(
      'banner_img'    => '',
      'user_img'      => '',
      'title'         => '',
      'social_icons'  => '',
      'social_links'  => '',
      'social_colors' => '',
      'class'         => ''
    ), $atts ) );

    $val = '';
    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $banner_img ? ' ts-cart-with-banner' : '';
    
    $attrs = ' class="ts-usercart'.$class.'"';

    $val.= '<div'.$attrs.'>';

    $val.= $banner_img ? '<img src="'.esc_url( $banner_img ).'" class="ts-banner-img" alt="">' : '';
    
    $val.= '<div class="ts-cart-header">';
    $val.= $user_img ? '<img src="'.esc_url( $user_img ).'" class="ts-user-img alignleft" alt="">' : '';
    $val.= $title ? '<h3 class="ts-usercart-heading">'.$title.'</h3>' : '';
    $val.= '</div>';

    $val.= $content ? '<div class="ts-usercart-content">'.do_shortcode($content).'</div>' : '';

    if( $social_icons && $social_colors && $social_links ) {

      $user_social_content = '';
      $social_icons_array = explode(',', $social_icons);
      $social_links_array = explode(',', $social_links);
      $social_colors_array = explode(',', $social_colors);

      $social_count = count($social_icons_array);

      foreach ($social_icons_array as $icon_key => $new_icon) {
        $a_attr = ' href="'.(!empty($social_links_array[$icon_key]) ? esc_url( $social_links_array[$icon_key] ) : '#').'"';
        $a_attr.= !empty($social_colors_array[$icon_key]) ? ' style="background-color:'.esc_attr( $social_colors_array[$icon_key] ).'"' : '';
        $a_attr.= 'class="ts-social-icon fa fa-'.esc_attr( $new_icon ).'"';

        $user_social_content .= '<a'.$a_attr.'></a>';
      }

      $val.= '<div class="ts-usercart-social ts-social-col-'.$social_count.'">'.$user_social_content.'</div>';
    }

    $val.= '</div>';

    return $val;
  }

}


/*---------------------------------------------
  Section
---------------------------------------------*/
if ( ! function_exists( 'themesama_section' ) ) {

  function themesama_section( $atts = array(), $content = '' ) {
    return '<div class="row"><div class="container">'.do_shortcode( $content ).'</div></div>';
  }

}

/*---------------------------------------------
  Row
---------------------------------------------*/
if ( ! function_exists( 'themesama_row' ) ) {

  function themesama_row( $atts = array(), $content = '' ) {
    return '<div class="row">'.do_shortcode( $content ).'</div>';
  }

}

/*---------------------------------------------
  Columns
---------------------------------------------*/
if ( ! function_exists( 'themesama_columns' ) ) {

  function themesama_columns( $atts, $content = '' ) {
    extract( shortcode_atts( array(
      'size'  => '12',
      'class' => ''
    ), $atts ) );

    $class .= $class ? $class.' col-sm-'.intval($size) : 'col-sm-'.intval($size);

    return '<div class="'.esc_attr( $class ).'">'.do_shortcode( $content ).'</div>';
  }

}

/*---------------------------------------------
  Gap
---------------------------------------------*/
if ( ! function_exists( 'themesama_gap' ) ) {

  function themesama_gap( $atts, $content = '' ) {
    extract( shortcode_atts( array(
      'size'  => '30px',
      'horizontal_gap' => 'off',
      'class' => ''
    ), $atts ) );

    $gap_size = '';
    $gap_tag = 'div';
    $gap_pos = 'top';

    $class = $class ? ' '.esc_attr( $class ) : '';
    $class.= $horizontal_gap == 'off' ? ' ts-gap-clear' : '';

    if( $horizontal_gap != 'on' ) {
      if( $size == '20px' || $size == '30px' || $size == '40px' || $size == '60px' || $size == '120px' ){
        $gap_size = str_replace('px', '', $size);
      }
    }else {
      $gap_tag = 'span';
      $gap_pos = 'right';
    }

    return '<'.$gap_tag.' class="ts-gap'.($gap_size ? '-'.$gap_size : '' ).$class.'" '.(!$gap_size ? 'style="margin-'.$gap_pos.':'.esc_attr( $size ).';"' : '').'></'.$gap_tag.'>';
  }

}

/*---------------------------------------------
  Line
---------------------------------------------*/
if ( ! function_exists( 'themesama_line' ) ) {

  function themesama_line() {
    return '<hr>';
  }

}

/*---------------------------------------------
  Clear
---------------------------------------------*/
if ( ! function_exists( 'themesama_clear' ) ) {

  function themesama_clear() {
    return '<div class="clearfix"></div>';
  }

}

/*---------------------------------------------
  Shortcodes
---------------------------------------------*/
add_shortcode( TS_TAG.'featurebox', TS_PLUGIN.'featurebox' );
add_shortcode( TS_TAG.'team', TS_PLUGIN.'team' );
add_shortcode( TS_TAG.'clients', TS_PLUGIN.'clients' );
add_shortcode( TS_TAG.'client', TS_PLUGIN.'client' );
add_shortcode( TS_TAG.'instagram', TS_PLUGIN.'photostream' );
add_shortcode( TS_TAG.'flickr', TS_PLUGIN.'photostream' );
add_shortcode( TS_TAG.'photostream', TS_PLUGIN.'photostream' );
add_shortcode( TS_TAG.'twitter', TS_PLUGIN.'twitter' );
add_shortcode( TS_TAG.'social', TS_PLUGIN.'social' );
add_shortcode( TS_TAG.'pricingtable', TS_PLUGIN.'pricingtable' );
add_shortcode( TS_TAG.'sidebar', TS_PLUGIN.'sidebar' );
add_shortcode( TS_TAG.'table', TS_PLUGIN.'table' );
add_shortcode( TS_TAG.'slider', TS_PLUGIN.'slider' );
add_shortcode( TS_TAG.'widget', TS_PLUGIN.'widget' );
add_shortcode( TS_TAG.'slideritem', TS_PLUGIN.'slideritem' );
add_shortcode( TS_TAG.'testimonials', TS_PLUGIN.'testimonials' );
add_shortcode( TS_TAG.'testimonial', TS_PLUGIN.'testimonial' );
add_shortcode( TS_TAG.'charts', TS_PLUGIN.'charts' );
add_shortcode( TS_TAG.'chart', TS_PLUGIN.'chart' );
add_shortcode( TS_TAG.'bars', TS_PLUGIN.'bars' );
add_shortcode( TS_TAG.'bar', TS_PLUGIN.'bar' );
add_shortcode( TS_TAG.'milestone', TS_PLUGIN.'milestone' );
add_shortcode( TS_TAG.'countdown', TS_PLUGIN.'countdown' );
add_shortcode( TS_TAG.'button', TS_PLUGIN.'button' );
add_shortcode( TS_TAG.'table_button', TS_PLUGIN.'button' );
add_shortcode( TS_TAG.'buttonset', TS_PLUGIN.'buttonset' );
add_shortcode( TS_TAG.'icon', TS_PLUGIN.'icon' );
add_shortcode( TS_TAG.'list', TS_PLUGIN.'list' );
add_shortcode( TS_TAG.'highlight', TS_PLUGIN.'highlight' );
add_shortcode( TS_TAG.'alertbox', TS_PLUGIN.'alertbox' );
add_shortcode( TS_TAG.'dropcap', TS_PLUGIN.'dropcap' );
add_shortcode( TS_TAG.'blockquote', TS_PLUGIN.'blockquote' );
add_shortcode( TS_TAG.'infobox', TS_PLUGIN.'blockquote' );
add_shortcode( TS_TAG.'accordions', TS_PLUGIN.'accordions' );
add_shortcode( TS_TAG.'accordion', TS_PLUGIN.'accordion' );
add_shortcode( TS_TAG.'toggle', TS_PLUGIN.'toggle' );
add_shortcode( TS_TAG.'tabs', TS_PLUGIN.'tabs' );
add_shortcode( TS_TAG.'tab', TS_PLUGIN.'tab' );
add_shortcode( TS_TAG.'media', TS_PLUGIN.'media' );
add_shortcode( TS_TAG.'usercart', TS_PLUGIN.'usercart' );
add_shortcode( TS_TAG.'section', TS_PLUGIN.'section' );
add_shortcode( TS_TAG.'row', TS_PLUGIN.'row' );
add_shortcode( TS_TAG.'row_inner', TS_PLUGIN.'row' );
add_shortcode( TS_TAG.'column', TS_PLUGIN.'columns' );
add_shortcode( TS_TAG.'column_inner', TS_PLUGIN.'columns' );
add_shortcode( TS_TAG.'gap', TS_PLUGIN.'gap' );
add_shortcode( TS_TAG.'line', TS_PLUGIN.'line' );
add_shortcode( TS_TAG.'clear', TS_PLUGIN.'clear' );