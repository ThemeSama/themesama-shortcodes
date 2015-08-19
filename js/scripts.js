;(function($, window, document, undefined) {
  'use strict';

  var $window = $(window);
  var $document = $(document);

  var windowHeight = $window.height();

  $window.resize(function () {
    windowHeight = $window.height();
  });

  $.exists = function(selector) {
    return ($(selector).length > 0);
  };

  /*---------------------------------------------
    FitVids
  ---------------------------------------------*/
  $.fn.slupyFitVids = function() {

    return this.each(function() {

      var _this = $(this);

      _this.fitVids({
        customSelector: "iframe[src*='blip.tv'],iframe[src*='dailymotion.com'],iframe[src*='funnyordie.com'],iframe[src*='viddler.com'],iframe[src*='rd.io'],iframe[src*='hulu.com']"
      });

    });

  };

  /*---------------------------------------------
    WP Responsive Video
  ---------------------------------------------*/
  $.fn.slupyWPVideo = function() {

    return this.each(function() {

      var _this           = $(this),
          _content        = _this.find('.mejs-container'),
          _video          = _this.find('video.wp-video-shortcode'),
          _video_width    = _video.attr('width'),
          _video_height   = _video.attr('height'),
          _percentage     = _video_height / _video_width;

          _video.css({'width' : '100%', 'height' : '100%'});

      $window.resize(function(){
          _this.css({'width' : '100%', 'height' : (_this.width() * _percentage) + 'px', 'opacity' : '1'});
      }).resize();

    });

  };

  /*---------------------------------------------
    OWL Slider
  ---------------------------------------------*/
  $.fn.slupyOwlSlider = function() {

    return this.each(function() {

      var _this = $(this);

      _this.owlCarousel({
        navigation      : _this.data('navigation') === 'on' ? true : false,
        autoPlay        : _this.data('autoplay') === 'on' ? parseInt(_this.data('time'))*1000 : false,
        stopOnHover     : _this.data('stophover') === 'on' ? true : false,
        touchDrag       : _this.data('touch') === 'on' ? true : false,
        mouseDrag       : _this.data('touch') === 'on' ? true : false,
        transitionStyle : _this.data('fade') === 'on' ? 'fade' : false,
        pagination      : _this.data('pagination') === 'on' ? true : false,
        autoHeight      : _this.data('autoheight') !== 'on' ? false : true,
        navigationText  : false,
        singleItem      : true,
        afterAction     : function(){
          if( _this.next().is('.thumbnails') ){
            _this.next().find('a')
              .removeClass('active-thumbnail').eq(this.owl.currentItem)
              .addClass('active-thumbnail');
          }
        }
      });

    });

  };

  /*---------------------------------------------
    OWL Carousel
  ---------------------------------------------*/
  $.fn.slupyOwlCarousel = function() {

    return this.each(function() {

      var _this = $(this);

      _this.owlCarousel({
        items: parseInt(_this.data('maxitem')) || 6,
        itemsDesktop : _this.data('maxdesktop') !== '' ? [1199,parseInt(_this.data('maxdesktop'))] : [1199,4],
        itemsDesktopSmall : _this.data('maxdesktop') !== '' ? [980,parseInt(_this.data('maxdesktop'))] : [980,4],
        itemsTablet: _this.data('maxtablet') !== '' ? [768,parseInt(_this.data('maxtablet'))] : [768,2],
        itemsTabletSmall: false,
        itemsMobile : _this.data('maxmobile') !== '' ? [479,parseInt(_this.data('maxmobile'))] : [479,1],
        autoPlay: _this.data('autoplay') === 'on' ? parseInt(_this.data('time'))*1000 : false,
        stopOnHover: _this.data('stophover') === 'on' ? true : false,
        touchDrag: _this.data('touch') === 'on' ? true : false,
        mouseDrag: _this.data('touch') === 'on' ? true : false,
        pagination: _this.data('pagination') === 'on' ? true : false,
        navigationText: false,
        autoHeight : false
      });

    });

  };

  /*---------------------------------------------
    Feature Box
  ---------------------------------------------*/
  $.fn.tsFeatureBox = function() {

    return this.each(function() {

      var _this = $(this),
          _content = _this.find('.ts-box-details'),
          _trigger = _this.data('trigger'),
          _desc = _this.find('.ts-feature-desc'),
          _slider_content = _this.find('.ts-box-slider'),
          _owl_slider = _this.find('.ts-slider'),
          _autoplay = _owl_slider.data('autoplay'),
          _time = parseInt(_owl_slider.data('time')),
          _height = _this.outerHeight(),
          _padding = _this.find('.ts-box-icon').outerHeight() / 2;

      $(_this).on(_trigger, function(e) {
        e.preventDefault();

        _this.addClass('show-feature-box');

        _height = _this.outerHeight();

        _slider_content.css('padding-bottom',_height - _padding);
        if( _content.html() != '' ) {
          _content.fadeIn('fast');
        }

        $window.resize();

        _owl_slider.trigger('owl.play',_autoplay === 'on' ? _time * 1000 : false);
      }).on('mouseleave',function(){
        _owl_slider.trigger('owl.stop');
        _content.hide();
        _this.removeClass('show-feature-box');
      });
      
    });

  };

  /*---------------------------------------------
    Social Tooltip
  ---------------------------------------------*/
  $.fn.tsSocial = function() {

    return this.each(function() {

      var _this = $(this),
          _tooltip = _this.parent().find('.ts-social-tooltip'),
          _title = _this.data('title');

      _this.mouseover(function(){
        _tooltip.text(_title).stop().animate({opacity:1},300);
      }).mouseleave(function(){
        _tooltip.stop().animate({opacity:0},300);
      });
      
    });

  };

  /*---------------------------------------------
    Pie Charts
  ---------------------------------------------*/
  $.fn.tsPieChart = function() {

    return this.each(function() {

      var _this = $(this),
          _color = _this.data('barcolor'),
          _content = _this.parent(),
          _tooltip = _content.hasClass('ts-charts-tooltip') ? true : false,
          _title = _this.find('.ts-skill-title'),
          _animation = _content.data('animated') === 'on' ? 1000 : false,
          _size = _content.data('size'),
          _trigger = _content.data('trigger');

      function init_ts_pie() {
        _this.easyPieChart({
          barColor : _color,
          trackColor: '#dcdde0',
          lineCap: 'square',
          lineWidth: 10,
          animate: _animation,
          size: _size,
          scaleColor: false,
          onStep: function(from, to, percent) {
              _this.find('.ts-chart-percent').text(Math.round(percent));
          }
        }).css("opacity","1");

        if( _tooltip ){
          _this.on(_trigger, function(){
            _title.stop().fadeToggle();
          }).on("mouseleave", function(){
            _title.fadeOut();
          });
        }
      }

      if( _animation ) {
        _this.waypoint(function() {
          init_ts_pie();
        },{offset: '95%'});

      }else {
        init_ts_pie();
      }
      
    });

  };

  /*---------------------------------------------
    Progress Bars
  ---------------------------------------------*/
  $.fn.tsProgressBars = function() {

    return this.each(function() {

      var _this = $(this),
          _percentage = _this.data('percentage')+'%',
          _speed = _this.data('percentage') * 20,
          _bar = _this.find('.ts-bar-color'),
          _animation = _this.parent().data('animated') === 'on' ? true : false;

      if( _animation ){
        _this.waypoint(function() {
          _bar.animate({width: _percentage},_speed,'easeOutQuint');
        },{offset: '95%'});
      }else{
        _bar.css('width',_percentage);
      }
      
    });

  };

  /*---------------------------------------------
    Milestone
  ---------------------------------------------*/
  $.fn.tsMilestone = function() {

    return this.each(function() {

      var _this     = $(this),
          _options  = {
            useEasing : true, 
            useGrouping : true, 
            separator : _this.data('separator') == 'on' ? ',' : '',
            decimal : '.'
          },
          _duration = _this.data('duration') || 3.5,
          _decimals = _this.data('decimals') || 0,
          _start    = _this.data('start'),
          _end      = _this.data('end'),
          _control  = true;

      _this.waypoint(function() {
        if( _control ) {
          _control = false;
          var numAnim = new countUp(this, _start, _end, _decimals , _duration, _options);
          numAnim.start();
        }
        
      },{offset: '95%'});
      
    });

  };

  /*---------------------------------------------
    Tabs
  ---------------------------------------------*/
  $.fn.tsTabs = function() {

    return this.each(function() {

      var _this = $(this),
          _trigger = _this.data('trigger'),
          _buttons = _this.find('.ts-tab-nav li'),
          _content = _this.find('.ts-tab-content'),
          _active_tab = _this.find('.ts-tab-nav .ts-current-tab').index();

      if( _active_tab == -1 ){
        _active_tab = 0;
        _buttons.first().addClass('ts-current-tab');
        _content.first().show();
      }else{
        _content.eq(_active_tab).show();
      }

      _buttons.on(_trigger, function(e) {
        e.preventDefault();

        var _btn = $(this);

        if( _active_tab != _btn.index() ){

          _active_tab = _btn.index();
          _buttons.removeClass('ts-current-tab');
          _btn.addClass('ts-current-tab');
          _content.hide().eq(_active_tab).fadeIn();

        }

      }).on('click', 'a', function(e) {
        e.preventDefault();
      });
      
    });

  };

  /*---------------------------------------------
    Accordions
  ---------------------------------------------*/
  $.fn.tsAccordions = function() {

    return this.each(function() {

      var _this = $(this),
          _buttons = _this.find('.ts-accordion-button'),
          _collapsible = _this.data('collapsible'),
          _active_tab = _this.find('.ts-active-accordion .ts-accordion-content'),
          _activated = _this.find('.ts-active-accordion').first().index(),
          _contents = _this.find('.ts-accordion-content'),
          _trigger = _this.data('trigger');

      _active_tab.show();

      _buttons.on(_trigger, function(e){
        e.preventDefault();

        var _btn = $(this),
            _accordion = _btn.parents('.ts-accordion'),
            _content = _btn.parent().find('.ts-accordion-content');

        if( _accordion.hasClass('ts-active-accordion') && _collapsible === 'on'  ){
                
          _content.slideToggle(400);
          _accordion.removeClass('ts-active-accordion');

        }else if( !_accordion.hasClass('ts-active-accordion') ){

          _contents.slideUp(400).parents('.ts-accordion').removeClass('ts-active-accordion');
          _accordion.addClass('ts-active-accordion');
          _content.slideToggle();

        }

      });

    });

  };

  /*---------------------------------------------
    Photo Stream
  ---------------------------------------------*/
  $.fn.tsPhotoStream = function() {

    return this.each(function() {

      var _this = $(this),
          _images = _this.find('img');

      _this.magnificPopup({
        delegate: 'a[data-gallery="photostream"]',
        gallery: {
          enabled: true
        },
        type: 'image'
      });

      _images.each(function() {

        var _image = $(this);

        _image.imagesLoaded(function() {

          var _width = _image.width(),
              _height = _image.height();

          if( _width < _height ){
            _image.css({width: '101%',height:'auto'});
          }

          _image.parent().css('opacity','1');

        });

      });
      
    });

  };

  /*---------------------------------------------
    Media Player
  ---------------------------------------------*/
  $.fn.tsMediaPlayer = function() {

    return this.each(function() {

      var _this = $(this).find('video');
      _this.mediaelementplayer();
      
    });

  };

  /*---------------------------------------------
    Buttons
  ---------------------------------------------*/
  $.fn.tsButtons = function() {

    return this.each(function() {

      var _this     = $(this),
          _left_w   = _this.find('.ts-button-left').outerWidth(),
          _right_w  = _this.find('.ts-button-right').outerWidth();

      if( _right_w > _left_w ) {
        _left_w = _right_w;
      }

      _this.css('width', (_left_w * 2) + 'px' ).addClass('ts-buttons-init');
      
    });

  };

  /*---------------------------------------------
    Call Plugins
  ---------------------------------------------*/
  $(document).ready(function(){
    
    $('.ts-clients-carousel').slupyOwlCarousel();
    $('.ts-slider, .ts-testimonials').slupyOwlSlider();
    $('.fit-entry-media, .ts-fitvids').slupyFitVids();
    $('.wp-video, .ts-video').slupyWPVideo();

    $('.ts-feature-box').tsFeatureBox();
    $('.ts-social a[data-title]').tsSocial();
    $('.ts-chart').tsPieChart();
    $('.ts-bar').tsProgressBars();
    $('.ts-tabs').tsTabs();
    $('.ts-accordions').tsAccordions();
    $('.ts-photostream').tsPhotoStream();
    $('.ts-video').tsMediaPlayer();
    $('.ts-buttons').tsButtons();
    $('.ts-milestone-number').tsMilestone();

    $('.single .format-image-media').magnificPopup({type: 'image'});
    $('.mgf-modal').magnificPopup({type: 'inline'});
    $('.gallery-lightbox .gallery-item a, .gallery-lightbox .owl-item a').magnificPopup({
      type: 'image',
      gallery: {
        enabled: true
      }
    });

    /*---------------------------------------------
        AlertBoxes Close Button
    ---------------------------------------------*/
    $('body').on('click', '.ts-alertbox-close',function(){

      var _this = $(this).parent();

      _this.slideUp('normal',function(){
        _this.remove();
      });
    });

  });

}(jQuery, window, document));