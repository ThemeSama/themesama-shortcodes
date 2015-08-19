<?php

/*---------------------------------------------
    Custom Post Header Shortcode
---------------------------------------------*/
if (!function_exists('get_custom_slupy_post_header')) {

function get_custom_slupy_post_header( $atts = array(), $content = '' ) {
  return do_shortcode($content);
}

}

if( !function_exists('change_slupy_post_thumbnail_size') ) {

function change_slupy_post_thumbnail_size($file_size){

  global $slupy_post_thumbnail_size;

  return !empty($slupy_post_thumbnail_size) ? $slupy_post_thumbnail_size : $file_size;

}

}

/*---------------------------------------------
    Slupy Blog Shortcode
---------------------------------------------*/
if ( !function_exists('get_custom_slupy_blog') ) {

function get_custom_slupy_blog( $atts = array(), $content = '' ) {
  extract(shortcode_atts(array(
    'posts_per_page'  => get_option('posts_per_page'),
    'masonry'         => ts_get_option('blog_masonry'),
    'masonry_columns' => ts_get_option('blog_masonry_max_columns'),
    'pagination'      => ts_get_option('blog_pagination'),
    'meta_position'   => ts_get_option('blog_meta_position'),
    'effect'          => ts_get_option('blog_effect'),
    'ids'             => '',
    'file_size'       => '',
    'exclude'         => '',
    'class'           => ''
  ), $atts ));

  $output = '';

  if( !empty( $file_size ) ) {
    global $slupy_post_thumbnail_size;
    $slupy_post_thumbnail_size = $file_size;
    add_filter('slupy_post_thumbnail_size', 'change_slupy_post_thumbnail_size');
  }
  
  //Paged
  if(get_query_var('page')){
    $paged = intval(get_query_var('page'));
  }else if(get_query_var('paged')){
    $paged = intval(get_query_var('paged'));
  }else{
    $paged = 1;
  }

  global $slupy_blog_meta_position;
  $slupy_blog_meta_position = $meta_position;

  $args = array(
    'post_type'       => 'post',
    'paged'           => $paged,
    'posts_per_page'  => intval($posts_per_page)
  );

  //include and exclude categories
  if( $ids ){
    $args['cat'] = $ids;
  }

  if( $exclude ){
    $exclude = str_replace('-', '', $exclude);
    $all_exclude_cats = explode(',', $exclude);

    foreach ($all_exclude_cats as $key => $value) {
      $all_exclude_cats[$key] = '-'.intval($value);
    }

    $args['cat'] = empty($args['cat']) ? implode(',', $all_exclude_cats) : $args['cat'].','.implode(',', $all_exclude_cats);
  }

  $the_query = new WP_Query($args);

  /*---------------------------------------------
    Masonry Control
  ---------------------------------------------*/
  $articles_classes = '';
  if($masonry == 'on'){
    wp_enqueue_script( 'isotope' );
    wp_enqueue_script( 'imagesLoaded' );
    $articles_classes .= ' masonry-active';
    $articles_classes .= ' col-masonry-'.$masonry_columns;
  }

  $blog_effect = ' data-blogeffect="'.esc_attr( $effect ).'"';

  // The Loop
  if ( $the_query->have_posts() ) {
  
    $output .= '<div class="slupy-articles'.esc_attr( $articles_classes ).'"'.$blog_effect.'>';

    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      ob_start();
      get_template_part( 'post-formats/content', get_post_format() );
      $output .= ob_get_contents();
      ob_end_clean();
    }

    $output .= '</div>';

    //Post pagination.
    ob_start(); 
    slupy_paging_nav($the_query->max_num_pages, $pagination);
    $output .= ob_get_contents();
    ob_end_clean();
  } else {
    // If no content, include the "No posts found" template.
    ob_start(); 
    get_template_part( 'post-formats/content', 'none' );
    $output .= ob_get_contents();
    ob_end_clean();
  }
  /* Restore original Post Data */
  wp_reset_postdata();
  return $output;
}

}

/*---------------------------------------------
  Footer Title Icon
---------------------------------------------*/
if (!function_exists('get_custom_slupy_widget_title')) {

function get_custom_slupy_widget_title( $atts = array(), $content = '' ) {
  extract( shortcode_atts( array(
    'icon'   => '',
    'color'  => '#33ccff'
  ), $atts ) );

  return $icon ? '<span class="widget-title-icon fa fa-'.esc_attr( $icon ).'" style="background-color:'.esc_attr( $color ).';">
    <span class="title-arrow fa fa-caret-right" style="color:'.esc_attr( $color ).';"></span>
  </span>' : '';
}

}

/*---------------------------------------------
  Slupy Ajax Contact Form
---------------------------------------------*/
if( !function_exists('get_custom_slupy_contact') ){

function get_custom_slupy_contact( $atts = array(), $content = '' ){
  extract( shortcode_atts( array(
    'name'    => __( 'Name *', SLUPY_TRANSLATE ),
    'email'   => __( 'E-Mail *', SLUPY_TRANSLATE ),
    'subject' => __( 'Subject *', SLUPY_TRANSLATE ),
    'message' => __( 'Message *', SLUPY_TRANSLATE ),
    'button'  => __( 'Send Message', SLUPY_TRANSLATE )
  ), $atts ) );

  return '<div class="slupy-contact-form">
    <form method="post" action="'.esc_url( get_permalink() ).'" class="slupy-contact-form">
      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label>'.$name.'</label>
          <input type="text" name="name" class="slupy-contact-field">
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label>'.$email.'</label>
          <input type="email" name="mail" class="slupy-contact-field">
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label>'.$subject.'</label>
          <input type="text" name="subject" class="slupy-contact-field">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <label>'.$message.'</label>
          <textarea name="message" rows="6" class="slupy-contact-field"></textarea>
          <button class="slupy-button contact-form-submit" type="button"><span>'.$button.'</span></button>
          <span class="contact-form-response"></span>
        </div>
      </div>
    </form>
  </div>';
}

}

/*---------------------------------------------
  Get Slupy Portfolio Items
---------------------------------------------*/
if( !function_exists('get_slupy_portfolio') ){

function get_slupy_portfolio($limit = 5, $p = 1, $ids = '', $exclude = '', $image_size = 'medium', $model = 1){

  $output = '';
  $paged = 1;
  $item_ex_class = '';
  $item_cats = array();
  $tax_query = array();

  //check paged
  if( $p != 1 ){
    $paged = $p;
  }else if(get_query_var('page')){
    $paged = intval(get_query_var('page'));
  }else if(get_query_var('paged')){
    $paged = intval(get_query_var('paged'));
  }

  //include special cats
  if( !empty($ids) ){
    $tax_query[] = array(
      'taxonomy'  => P_SLUG.'_cat',
      'field'     => 'id',
      'terms'     => explode(',', $ids),
      'operator'  => 'IN'
    );
  }

  //exclude special cats
  if( !empty($exclude) ){
    $tax_query[] = array(
      'taxonomy'  => P_SLUG.'_cat',
      'field'     => 'id',
      'terms'     => explode(',', $exclude),
      'operator'  => 'NOT IN'
    );
  }

  //query
  $args = array(
    'post_type'       => P_SLUG,
    'paged'           => $paged,
    'posts_per_page'  => $limit,
    'post__not_in'    => array( get_the_ID() ),
    'tax_query'       => $tax_query
  );

  $the_query = new WP_Query($args);

  // The Loop
  if ( $the_query->have_posts() ) {

    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $item_id = get_the_ID();
      $item_permalink = esc_url( get_permalink() );
      $item_ex_class = ' portfolio-item';
      $item_slug = get_the_terms( $item_id, P_SLUG.'_cat' );
      if( !empty($item_slug) ){
        foreach ($item_slug as $item_key => $item_cat) {
          $item_cats[] = $item_cat->slug;
          $item_ex_class .= ' catergory-'.$item_cat->slug;
        }
      }

      //get post categories
      $all_cat_names = '';
      $post_cats = get_the_terms($item_id, P_SLUG.'_cat');
      if( !empty($post_cats) ){
        foreach ($post_cats as $post_key => $cats) {
          $all_cat_names .= '<a href="#" data-filter=".catergory-'.$cats->slug.'">'.$cats->name.'</a>, ';
        }
      }
      if( $all_cat_names ){
        $all_cat_names = '<span class="portfolio-categories">'.substr($all_cat_names,0,-2).'</span>';
      }

      //get comment link
      $comments_link = '';
      if ( (comments_open() || get_comments_number()) && !post_password_required() ) {
        ob_start();
        comments_popup_link( __( 'Leave a comment', SLUPY_TRANSLATE ), __( '1 Comment', SLUPY_TRANSLATE ), __( '% Comments', SLUPY_TRANSLATE ) );
        $comments_link = ob_get_contents();
        ob_end_clean();
        if( !empty($comments_link) ){
          $comments_link = '<span class="portfolio-comments">'.$comments_link.'</span>';
        }
      }

      //get post date
      $portfolio_date = '<span class="portfolio-date"><a href="'.$item_permalink.'"><time datetime="'.get_the_date('c').'">'.get_the_date().'</time></a></span>';

      //author
      $portfolio_author = '';
      //$portfolio_author = $model == 3 ? '<span class="portfolio-author">'.__('by', SLUPY_TRANSLATE).' <strong>'.get_the_author().'</strong></span>' : '';

      $output .= '<div id="post-'.esc_attr( $item_id ).'" class="'.implode(' ',get_post_class($item_ex_class)).'">';
      $output .= '<a href="'.$item_permalink.'" class="portfolio-url">';
      if ( has_post_thumbnail($item_id) ) {
        $output .= get_the_post_thumbnail($item_id, $image_size, array( 'class' => 'portfolio-image' ));
      }else{
        $output .= '<span class="portfolio-placeholder portfolio-image"></span>';
      }
      $output .= '</a>';
      $output .= '<div class="portfolio-short-details">';
      $output .= '<h3 class="portfolio-heading"><a href="'.$item_permalink.'">'.get_the_title().'</a></h3>';
      $output .= '<div class="portfolio-meta">'.$portfolio_author.$portfolio_date.$comments_link.$all_cat_names.'</div>';
      $output .= '</div>';
      $output .= '</div>';
    }
    
  }

  //help shortcodes max pages number
  $args['showposts'] = -1;
  $the_query->query($args);
  global $slupy_portfolio_max_pages;
  $slupy_portfolio_max_pages = $limit > 0 ? ceil($the_query->post_count / $limit) : 1;

  wp_reset_postdata();
  return $output;

}

}

/*---------------------------------------------
  Get Slupy Portfolio Cats
---------------------------------------------*/
if( !function_exists('get_slupy_portfolio_cats') ){

function get_slupy_portfolio_cats($ids = '', $exclude = '', $pos = 'right', $all_works = ''){

  $output = '';
  $all_cats = '';
  $all_select_options = '';
  $all_works = empty( $all_works ) ? __( 'All Works', SLUPY_TRANSLATE ) : $all_works;
  $args = array(
    'exclude'   => $exclude ? explode(',', $exclude) : array(),
    'include'   => $ids ? explode(',', $ids) : array()
  );

  $terms = get_terms(P_SLUG.'_cat', $args);

  if ( count($terms) > 0 ){
    foreach ( $terms as $term ) {
      $all_cats .= '<li><a href="#" data-filter=".catergory-'.$term->slug.'">'.$term->name.'</a></li>';
      $all_select_options .= '<option data-filter=".catergory-'.$term->slug.'">'.$term->name.'</option>';
    }
  }
  
  $output .= '<div class="portfolio-filter-menu filter-pos-'.esc_attr( $pos ).'">
    <ul class="hidden-xs">
      <li><a href="#" data-filter="*" class="activated-filter">'.esc_html( $all_works ).'</a></li>
      '.$all_cats.'
    </ul>
    <div class="select-wrapper hidden-lg hidden-md hidden-sm">
      <select>
        <option data-filter="*">'.esc_html( $all_works ).'</option>
        '.$all_select_options.'
      </select>
    </div>
  </div>';

  return $output;

}

}

/*---------------------------------------------
  Get Slupy Portfolio Shortcode Output
---------------------------------------------*/
if( !function_exists('get_slupy_portfolio_output') ){

function get_slupy_portfolio_output($atts = array()){
  extract(shortcode_atts(array(
    'posts_per_page'  => get_option('posts_per_page'),
    'page'            => '1',
    'padding'         => ts_get_option('portfolio_padding'),
    'masonry'         => ts_get_option('portfolio_masonry'),
    'fit_grid'        => ts_get_option('portfolio_fit_grid'),
    'model'           => ts_get_option('portfolio_model') ? ts_get_option('portfolio_model') : '1',
    'max_columns'     => ts_get_option('portfolio_max_columns') ? ts_get_option('portfolio_max_columns') : '4',
    'filterable'      => ts_get_option('portfolio_filter'),
    'filterable_pos'  => 'right',
    'pagination'      => ts_get_option('portfolio_pagination') ? ts_get_option('portfolio_pagination') : 'loadmore',
    'image_size'      => ts_get_option('portfolio_image_size') ? ts_get_option('portfolio_image_size') : 'medium',
    'ids'             => '',
    'exclude'         => '',
    'filter_text'     => ''
  ), $atts ));

  $output = '';

  wp_enqueue_script( 'isotope' );
  wp_enqueue_script( 'imagesLoaded' );

  $ex_class  = 'portfolio-items';
  $ex_class .= ' portfolio-model-'.$model;
  $ex_class .= ' col-masonry-'.$max_columns;
  $ex_class .= $masonry !== 'on' ? ' portfolio-list-fitrows' : ' portfolio-list-masonry';
  $ex_class .= $masonry !== 'on' && $model !== '3' && $fit_grid === 'on' ? ' fit-portfolio-grid' : '';
  $ex_class .= $padding === 'on' && $model !== '3' ? ' with-padding' : '';

  $output .= $filterable === 'on' ? get_slupy_portfolio_cats($ids, $exclude, $filterable_pos, $filter_text) : '';

  $output .= '<div class="'.esc_attr( $ex_class ).'" data-layoutmode="'.($masonry !== 'on' || $model === '3' ? 'fitRows' : 'masonry').'">';

  $output .= get_slupy_portfolio($posts_per_page, $page, $ids, $exclude, $image_size, intval($model));

  $output .= '</div>';

  //get slupy pagination
  if( function_exists('slupy_paging_nav') ){

    global $slupy_portfolio_max_pages;

    ob_start();
    slupy_paging_nav($slupy_portfolio_max_pages,$pagination,'.portfolio-items');
    $output .= ob_get_contents();
    ob_end_clean();

  }

  return $output;

}

}

/*---------------------------------------------
  Get Slupy Carousel Portfolio Shortcode Output
---------------------------------------------*/
if( !function_exists('get_slupy_cportfolio_output') ){

function get_slupy_cportfolio_output($atts = array()){
  extract(shortcode_atts(array(
    'limit'           => ts_get_option('portfolio_latest_works_limit') ? ts_get_option('portfolio_latest_works_limit') : '8',
    'page'            => '1',
    'image_size'      => ts_get_option('portfolio_cimage_size') ? ts_get_option('portfolio_cimage_size') : 'medium',
    'ids'             => '',
    'model'           => '2',
    'exclude'         => '',
    'autoplay'        => 'on',
    'stop_hover'      => 'on',
    'pagination'      => 'on',
    'touch_drag'      => 'on',
    'duration_time'   => '5',
    'show_max_item'   => '4',
    'show_max_desktop'=> '3',
    'show_max_tablet' => '2',
    'show_max_mobile' => '1',
  ), $atts ));

  wp_enqueue_style('OwlCarousel');
  wp_enqueue_script('OwlCarousel');

  $class = 'portfolio-carousel portfolio-model-'.$model;

  $attrs = ' class="'.esc_attr( $class ).'"';
  $attrs.= ' data-autoplay="'.esc_attr( $autoplay ).'"';
  $attrs.= ' data-stophover="'.esc_attr( $stop_hover ).'"';
  $attrs.= ' data-touch="'.esc_attr( $touch_drag ).'"';
  $attrs.= ' data-time="'.esc_attr( $duration_time ).'"';
  $attrs.= ' data-pagination="'.esc_attr( $pagination ).'"';
  $attrs.= ' data-maxitem="'.esc_attr( $show_max_item ).'"';
  $attrs.= ' data-maxdesktop="'.esc_attr( $show_max_desktop ).'"';
  $attrs.= ' data-maxtablet="'.esc_attr( $show_max_tablet ).'"';
  $attrs.= ' data-maxmobile="'.esc_attr( $show_max_mobile ).'"';

  $output = '<div'.$attrs.'>';
  $output .= get_slupy_portfolio($limit, $page, $ids, $exclude, $image_size);
  $output .= '</div>';

  return $output;
}

}

/*---------------------------------------------
  Slupy Add to Cart Shortcode
---------------------------------------------*/
if( !function_exists('woo_add_to_cart_shortcode') ) {

function woo_add_to_cart_shortcode( $atts ) {

  if ( empty( $atts ) ) return '';

  extract( shortcode_atts( array(
    'title'      => '',
    'url'        => '',
    'target'     => '',
    'tooltip'    => '',
    'id'         => '',
    'sku'        => '',
    'style'      => 'border:4px solid #ccc; padding: 12px;',
    'show_price' => 'true'
  ), $atts ) );

  if( !empty( $url ) && !empty( $title ) ) {
    $title = '<a href="'.esc_url( $url ).'"'.( !empty( $target ) ? ' target="'.esc_attr( $target ).'"' : '' ).'>'.esc_html( $title ).'</a>';
  }

  $output = $title ? '<div class="ts-add-to-cart'.($tooltip ? ' ts-cart-tooltip ts-cart-tooltip-'.esc_attr( $tooltip ) : '').'"><div class="add-to-cart-title"><h4>'.$title.'</h4></div>' : '';
  
  if( class_exists('WC_Shortcodes') ) {
    $output .= WC_Shortcodes::product_add_to_cart($atts);
  }

  $output .= $title ? '</div>' : '';

  return $output;
}

}

/*---------------------------------------------
  Add Shortcode
---------------------------------------------*/
add_shortcode( 'slupy_portfolio', 'get_slupy_portfolio_output' );
add_shortcode( 'slupy_cportfolio', 'get_slupy_cportfolio_output' );
add_shortcode( 'slupy_post_header', 'get_custom_slupy_post_header' );
add_shortcode( 'slupy_blog', 'get_custom_slupy_blog' );
add_shortcode( 'slupy_contact', 'get_custom_slupy_contact' );
add_shortcode( 'slupy_icon', 'get_custom_slupy_widget_title' );
add_shortcode( 'ts_add_to_cart', 'woo_add_to_cart_shortcode' );