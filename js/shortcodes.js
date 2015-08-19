jQuery(document).ready(function($) {
'use strict';

  var ts_shortcodetab = $('#themesama_shortcodetab'),
      ts_clone_elements = new Array(),
      ts_input_id = '';

  /*---------------------------------------------
    Shortcode Manager Show & Hide
  ---------------------------------------------*/
  $('body').on('click','.themesama_shortcode-button',function(){

    ts_input_id = $(this).data('inputid');

    if( ts_input_id == undefined ){
      ts_input_id = '';
    }

    $('.themesama_shortcode_content').show();
    $('.themesama_shortcode-list li.ui-tabs-active a').trigger('click');
    return false;

  });

  $('.themesama_shortcode_content .media-modal-close,.themesama_shortcode_content .media-modal-backdrop').click(function(){
    $('.themesama_shortcode_content').hide();
    return false;
  });

  $(document).keyup(function(e) {

    if (e.keyCode == 27) { $('.themesama_shortcode_content').hide(); }   // esc

  });

  /*---------------------------------------------
    jQUery UI Tabs
  ---------------------------------------------*/
  ts_shortcodetab.tabs().find('.ui-tabs-anchor').click(function() {
    $('.media-frame-content').animate({scrollTop : 0},500);
  });

  /*---------------------------------------------
    Custom Uploader for Upload Option Type
  ---------------------------------------------*/
  var custom_uploader;
  var themesama_upload_button;
 
  $( ts_shortcodetab ).on('click', '.themesama_upload_button', function(e) {
 
    e.preventDefault();

    themesama_upload_button = $(this);
 
    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
      title: themesama_upload_button.data('uploadertitle'),
      button: {
        text: themesama_upload_button.data('uploaderbutton')
      },
      library:{
        type: themesama_upload_button.data('filetype')
      },
      multiple: (themesama_upload_button.data('multiple') == '1') ? true:false
    });
 
    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {

      var selection = custom_uploader.state().get('selection');
      selection.map( function( attachment ) {
 
        attachment = attachment.toJSON();

        if(themesama_upload_button.data('getid')==='id'){

          themesama_upload_button.prev('input').val(attachment.id).change();
          if((themesama_upload_button.data('multiple') == '0')){
            themesama_upload_button.prev().prev().html('');
          }
          var media_thumbnail = ( attachment.sizes.thumbnail !== undefined ) ? attachment.sizes.thumbnail.url : attachment.url;
          themesama_upload_button.prev().prev().append('<a data-id="'+attachment.id+'" href="'+attachment.url+'" target="_blank"><img src="'+media_thumbnail+'" alt="'+attachment.title+'" /><i class="fa fa-times-circle"></i></a>');
          get_new_images_id(themesama_upload_button.prev().prev());
        }else{
          themesama_upload_button.prev('input').val(attachment.url).change();
        }
     
      });
      
    });
 
    //Open the uploader dialog
    custom_uploader.open();
 
  });

  /*---------------------------------------------
    On-Off Switch
  ---------------------------------------------*/
  $( ts_shortcodetab ).on('click', '.themesama_onoffswitch', function(){
    $(this).toggleClass('active');
    if( $(this).next().val().toString() != $(this).data('off').toString() ){
      $(this).next().val($(this).data('off')).change();
    }else{
      $(this).next().val($(this).data('on')).change();
    }
  });

  /*---------------------------------------------
    Toggle for Icons
  ---------------------------------------------*/
  $( ts_shortcodetab ).on('click', '.themesama_toggle_icons', function(){
    $(this).toggleClass('active').next().slideToggle();
  }).on('change', '.themesama_checkbox_image',function(){
    if(this.checked){
      $(this).parent().siblings().find('.themesama_checkbox_image:checked').attr('checked',false);
    }
  });

  $(ts_shortcodetab).on('change', 'input[name="themesama_filter_input"]', function() {
    var filter = $(this).val();
    if (filter) {
      $(this).parent().find(".themesama_iconbox_label").hide();
      $(this).parent().find('.themesama_iconbox_label input[value*="' + filter + '"]').parent().show();
    } else {
      $(this).parent().find(".themesama_iconbox_label").show();
    }
    return false;
  }).on('keyup', 'input[name="themesama_filter_input"]', function() {
    $(this).change();
  }).on('click', 'input[name="themesama_filter_input"]', function() {
    $(this).val('').change();
  });

  /*---------------------------------------------
    Add Shortcode
  ---------------------------------------------*/
  function ts_get_shortcode_values(_this){

    var cache_attr ='';
    var cache_val = '';
    var return_val = '';

    //mode
    switch (_this.data("type")){

      case "checkbox":
      case "icon":

        cache_attr = $('input[type="checkbox"]',_this).attr("name");
        $('input[type="checkbox"]:checked',_this).each(function(){
          cache_val+= $(this).val()+',';
        });
        cache_val = cache_val.substr(0,cache_val.length-1);

      break;

      case "page-select":
      case "post-select":
      case "sidebar-select":
      case "select":

        cache_attr = $('select',_this).attr("name");
        cache_val = $('select option:selected',_this).val();

      break;

      case "radio-image":
      case "radio":

        cache_attr = $('input[type="radio"]',_this).attr("name");
        cache_val = $('input[type="radio"]:checked',_this).val();

      break;

      case "textarea":

        cache_attr = $('textarea',_this).attr("name");
        cache_val = $('textarea',_this).val().toString();

      break;

      case "switch":
      case "text":
      case "ts_icon":
      case "background":
      case "colorpicker":
      case "upload":
      case "numericslider":

        cache_attr = $('input[type="text"]',_this).attr("name");
        cache_val = $('input[type="text"]',_this).val().toString();

      break;

    }

    if( cache_val!= '' && cache_val!= undefined ){

      return_val = cache_attr + '::' + cache_val;

    }

    return return_val;

  }

  function ts_get_shortcode(){

    var themesama_at = '';
    var inserted_shortcode = '';
    var inserted_shortcode_ex = '';

    var inserted_content = '';
    var inserted_attr = '';
    var inserted_content_ex = '';
    var inserted_attr_ex = '';

    //Activated Tab
    themesama_at = $('.themesama_shortcode-list > li.ui-tabs-active > a').attr('href');
    inserted_shortcode = $('.themesama_shortcode-list > li.ui-tabs-active > a').data('shortcode');

    $(themesama_at+' > .themesama_a_configelement').each(function(){

    if( !($(this).hasClass('hidden')) ){

      if( $(this).data('shortcode')!= undefined ){
        
        inserted_shortcode_ex = $(this).data('shortcode');

        $('.themesama_a_configelement',this).each(function(){

          var ts_get_values = new Array();
          ts_get_values = ts_get_shortcode_values( $('.themesama_format_setting',this) ).split('::');
          if(ts_get_values[1]!=undefined && $('.themesama_format_setting',this).data("mode") === "content"){
            inserted_content_ex+=ts_get_values[1];
          }else if(ts_get_values[0]!=undefined && ts_get_values[1]!=undefined && $('.themesama_format_setting',this).data("mode") === "attr"){
            inserted_attr_ex+=' '+ts_get_values[0]+'="'+ts_get_values[1]+'"';
          }

        });

        inserted_shortcode_ex = inserted_shortcode_ex.replace('{content}',inserted_content_ex);
        inserted_shortcode_ex = inserted_shortcode_ex.replace('{attr}',inserted_attr_ex);

        inserted_content_ex = '';
        inserted_attr_ex = '';

        inserted_content+=inserted_shortcode_ex;

      }else{

        var ts_get_values = new Array();
        ts_get_values = ts_get_shortcode_values( $('.themesama_format_setting',this) ).split('::');
        if(ts_get_values[1]!=undefined && $('.themesama_format_setting',this).data("mode") === "content"){
          inserted_content+=ts_get_values[1];
        }else if(ts_get_values[0]!=undefined && ts_get_values[1]!=undefined && $('.themesama_format_setting',this).data("mode") === "attr"){
          inserted_attr+=' '+ts_get_values[0]+'="'+ts_get_values[1]+'"';
        }

      }

      //background type for attr
      if( $('.themesama_format_setting',this).data("type") == "background" ){

        if( $('input[name="bgcolor"]',this).val() != "" ){
          inserted_attr+=' bg_color="'+$('input[name="bgcolor"]',this).val()+'"';
        }

        if( $('input[name="bg"]',this).val() != "" ){

          if( $('select[name="bgrepeat"] option:selected',this).val() != "" ){
            inserted_attr+=' bg_repeat="'+$('select[name="bgrepeat"] option:selected',this).val()+'"';
          }
          if( $('select[name="bgattachment"] option:selected',this).val() != "" ){
            inserted_attr+=' bg_attachment="'+$('select[name="bgattachment"] option:selected',this).val()+'"';
          }
          if( $('select[name="bgposition"] option:selected',this).val() != "" ){
            inserted_attr+=' bg_position="'+$('select[name="bgposition"] option:selected',this).val()+'"';
          }

        }

      }

    }

    });

    inserted_shortcode = inserted_shortcode.replace('{content}',inserted_content);
    inserted_shortcode = inserted_shortcode.replace('{attr}',inserted_attr);

    inserted_content = '';
    inserted_attr = '';

    //replace content
    for( var i = 0; i<=6; i++ ){

      inserted_shortcode = inserted_shortcode.replace('{column_'+i+'}',$('textarea[name="column_'+i+'"]').val());

    }
    //inserted_shortcode = inserted_shortcode.replace(/\]\[([a-z])/g,']\n[$1').replace(/\]\[([a-z])/g,']\n[$1');

    return inserted_shortcode;

  }

  $('body').on('click', '.themesama_addshortcode_button', function(){

    if(ts_input_id==''){
      window.send_to_editor( ts_get_shortcode() );
    }else{
      $('#'+ts_input_id).val( $('#'+ts_input_id).val()+ts_get_shortcode() );
    }
    $('.themesama_shortcode_content').hide();
    return false;

  });

  if($(".themesama_copyclipboard").length>0){
    var clipboard_button = new ZeroClipboard($(".themesama_copyclipboard"), { moviePath: $(".themesama_copyclipboard").data('moviepath')+'js/ZeroClipboard.swf' });
    clipboard_button.on( 'dataRequested', function (client, args) {

      $('.themesama_copyclipboard_info').fadeIn(200).delay(700).fadeOut();
      client.setText( ts_get_shortcode() );
      
    });
  }

  /*---------------------------------------------
    Column Contents
  ---------------------------------------------*/
  $( ts_shortcodetab ).on('click', 'label[for^="themesama_columns_layouts"]', function(){

    if( $('textarea[name="column_2"]').length == 0 ){

      for (var i = 6; i > 1; i--) {
      
        $('#themesama_spe_content').after('<textarea class="themesama_textarea " rows="5" name="column_'+i+'">'+i+'</textarea>');
      
      };

    }
    $('textarea[name^="column_"]').hide();
    for (var i = 1; i <= $(this).data("label"); i++) {

      $('textarea[name="column_'+i+'"]').css('width', (97/$(this).data("label"))+'%' ).show();
    
    };

  });

  /*---------------------------------------------
    Add & Remove Row
  ---------------------------------------------*/
  $( ts_shortcodetab ).on('click', '.themesama_addrowbutton', function(){

    var active_tab = parseFloat($('.themesama_shortcode-list .ui-tabs-active a').data('idkey'));
    $(ts_clone_elements[active_tab]).clone().insertBefore($(this));
    $(this).prev('.themesama_a_configelement').find('.themesama_removerowbutton').removeClass('hidden');
    //reflesh
    get_reflesh_content($(this).prev('.themesama_a_configelement'));
    return false;

  }).on('click', '.themesama_removerowbutton', function(){

    $(this).parents('.themesama_a_configelement').remove();
    return false;

  });

  /*---------------------------------------------
    Update Multiple Selected Images ID
  ---------------------------------------------*/
  function get_new_images_id(_this){

    var all_images_id = '';
    $('a[data-id]',_this).each(function(){
      all_images_id+= $(this).data('id')+',';
    });
    all_images_id = all_images_id.substr(0,all_images_id.length-1);
    $(_this).next().val(all_images_id);

  }

  /*---------------------------------------------
    Remove Live Preview Thumb
  ---------------------------------------------*/
  $( ts_shortcodetab ).on('click', '.themesama_thumblivepreview a i', function(){

    $(this).parent().removeAttr('data-id');
    get_new_images_id($(this).parents('.themesama_thumblivepreview'));
    $(this).parent().remove();
    return false;

  });

  function get_reflesh_content(ts_content){

    /*---------------------------------------------
      Form Dependencies
    ---------------------------------------------*/
    $(ts_content).FormDependencies({
      inactiveClass : 'hidden',
      clearValues   : true
    });

    /*---------------------------------------------
      WP Color Picker
    ---------------------------------------------*/
    $('.themesama_colorpicker', ts_content).wpColorPicker();

    /*---------------------------------------------
      Sortable Rows
    ---------------------------------------------*/
    $('.themesama_thumblivepreview',ts_content).sortable({
      items: "a",
      update: function() {
        get_new_images_id( $(this) );
      }
    });

    /*---------------------------------------------
      Help Icon
    ---------------------------------------------*/
    $('.themesama_help_icon').tipsy({title:'data-title', gravity: 'e' });

    /*---------------------------------------------
      Numeric Slider
    ---------------------------------------------*/
    $('.themesama_numeric_slider', ts_content).each(function(){

      $(this).slider({
        animate: true,
        range: "min",
        value: $(this).prev('input').attr('value'),
        min: $(this).prev('input').data('min'),
        max: $(this).prev('input').data('max'),
        step: $(this).prev('input').data('step'),
        slide: function( event, ui ) {
        $(this).prev('input').val(ui.value);
        $(this).next('span').html(ui.value);
        }
      });

    });

  }

  /*---------------------------------------------
    Ajax Load Form Elements & Actions
  ---------------------------------------------*/
  $('.themesama_shortcode-list li a').click(function(){

    var ts_content = $(this).attr('href');
    var ts_id = parseFloat($(this).data('idkey'));


    if( $(ts_content).is(':empty') ){

      var data = {
        action: 'ts_load_content',
        ts_content: $(this).data('idkey')
      };
      console.time('load-time');
      $.post(ajaxurl, data, function(response) {
        console.timeEnd('load-time');
        $(ts_content).html(response);
        ts_clone_elements[ts_id] = $('.themesama_a_configelement[data-shortcode]',ts_content).clone();
        //reflesh actions
        get_reflesh_content(ts_content,response);
      });

    }

  });
});