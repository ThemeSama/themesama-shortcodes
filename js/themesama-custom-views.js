jQuery(document).ready(function($) {
'use strict';

var Shortcodes = vc.shortcodes;

function get_ts_color(c){
  var output = '';
  $.each( ts_colors, function(i, val){
    if( i === c ){
      output = val;
    }
  });
  return output;
}

/*---------------------------------------------
    Visual Composer Element Custom Views
---------------------------------------------*/

/*---------------------------------------------
    Toggle
---------------------------------------------*/
window.TsToggleView = vc.shortcode_view.extend({
  events:function () {
    return _.extend({'click .toggle_title':'toggle'
    }, window.TsToggleView.__super__.events);
  },
  toggle:function (e) {
    e.preventDefault();
    $(e.currentTarget).toggleClass('toggle_title_active');
    $('.toggle_content', this.$el).toggle();
  },
  changeShortcodeParams:function (model) {
    var params = model.get('params');

    //show changes
    window.TsToggleView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_toggle') ){
        this.$el.addClass('wpb_vc_toggle');
    }
    //check toggle
    if (_.isObject(params) && _.isString(params.open) && params.open === 'true') {
        $('.toggle_title', this.$el).addClass('toggle_title_active').next().show();
    }
    //check icon
    if(_.isObject(params) && _.isString(params.icon) && params.open !== ''){
      $('.toggle_title',this.$el).prepend('<i class="toggle_icon fa fa-'+params.icon+'"></i> ');
    }
  }
});

/*---------------------------------------------
  Nested Shortcodes
---------------------------------------------*/
window.TsColumnView = vc.shortcode_view.extend({
  events:{
      'click > .controls .column_delete':'deleteShortcode',
      'click > .controls .column_add':'addShortCodeElement',
      'click > .controls .column_edit':'editElement',
      'click > .controls .column_clone':'clone',
      'click > .wpb_element_wrapper > .empty_container':'addToEmpty'
  },
  initialize:function (options) {
      window.TsColumnView.__super__.initialize.call(this, options);
      _.bindAll(this, 'setDropable', 'dropButton');
  },
  ready:function (e) {
      window.TsColumnView.__super__.ready.call(this, e);
      this.setDropable();
      return this;
  },
  render:function () {
      window.TsColumnView.__super__.render.call(this);
      this.$el.attr('data-width', this.model.get('params').width);
      this.setEmpty();
      return this;
  },
  addShortCodeElement: function (e){
      e.preventDefault();
      var current_shortcode_name = $('[data-model-id="'+this.model.id+'"]').data('element_type');
      var create_shortcode_name = '';
      //control element type
      switch(current_shortcode_name){
        case 'ts_testimonials': create_shortcode_name = 'ts_testimonial'; break;
        case 'ts_slider': create_shortcode_name = 'ts_slideritem'; break;
        case 'ts_bars': create_shortcode_name = 'ts_bar'; break;
        case 'ts_charts': create_shortcode_name = 'ts_chart'; break;
        case 'ts_clients': create_shortcode_name = 'ts_client'; break;
      }
      if(create_shortcode_name != ''){
        var new_element = vc.shortcodes.create({shortcode:create_shortcode_name, params:vc.getDefaults(create_shortcode_name), parent_id:this.model.id});
        $('[data-model-id="'+new_element.id+'"] a.vc_control-btn-edit').trigger('click');
      }
  },
  addToEmpty:function (e) {
      e.preventDefault();
      if ($(e.target).hasClass('empty_container')) this.addShortCodeElement(e);
  },
  setDropable:function () {
      this.$content.droppable({
          greedy:true,
          accept:(this.model.get('shortcode') == 'vc_column_inner' ? '.dropable_el' : ".dropable_el,.dropable_row"),
          hoverClass:"wpb_ui-state-active",
          drop:this.dropButton
      });
      return this;
  },
  dropButton:function (event, ui) {
      if (ui.draggable.is('#wpb-add-new-element')) {
          new vc.element_block_view({model:{position_to_add:'end'}}).show(this);
      } else if (ui.draggable.is('#wpb-add-new-row')) {
          this.createRow();
      }
  },
  setEmpty:function () {
      this.$el.addClass('empty_column');
      this.$content.addClass('empty_container');
  },
  unsetEmpty:function () {
      this.$el.removeClass('empty_column');
      this.$content.removeClass('empty_container');
  },
  checkIsEmpty:function () {
      if (Shortcodes.where({parent_id:this.model.id}).length) {
          this.unsetEmpty();
      } else {
          this.setEmpty();
      }
      if (this.model.get('parent_id')) {
          var row_view = vc.app.views[this.model.get('parent_id')];
          if (row_view.model.get('shortcode').match(/^vc\_row/)) {
              row_view.sizeRows();
          }
      }
      window.TsColumnView.__super__.checkIsEmpty.call(this);
  },
  /**
   * Create row
   */
  createRow:function () {
      var row = Shortcodes.create({shortcode:'vc_row_inner', parent_id:this.model.id});
      Shortcodes.create({shortcode:'vc_column_inner', params:{width:'1/1'}, parent_id:row.id });
      return row;
  }
});

/*---------------------------------------------
    Text
---------------------------------------------*/
window.TsTextView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');

    //show changes
    window.TsTextView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }

    //check quote icon for blockquote
    if( _.isObject(params) && _.isString(params.quote_icon) && params.quote_icon === 'on' ){
      $('.wpb_vc_param_value',this.$el).prepend('<i class="quote_icon fa fa-quote-left"></i>');
    }
    //check author & job for blockquote
    if( _.isObject(params) && _.isString(params.author_name) && params.author_name !== '' ){
      $('.wpb_vc_param_value',this.$el).append( '<div class="author-name">'+params.author_name+(_.isString(params.author_job) && params.author_job !== '' ? ', '+params.author_job : '')+'</div>' );
    }
    //check author & job for testimonial
    if( _.isObject(params) && _.isString(params.client_name) && params.client_name !== '' ){
      $('.wpb_vc_param_value',this.$el).append( '<div class="author-name">'+params.client_name+(_.isString(params.client_job) && params.client_job !== '' ? ', '+params.client_job : '')+'</div>' );
    }
  }
});

/*---------------------------------------------
    Table
---------------------------------------------*/
window.TsTableView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');
    var item_color = get_ts_color('default');

    //show changes
    window.TsTableView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
      this.$el.addClass('wpb_vc_column_text');
    }
    //get color
    if (_.isObject(params) && _.isString(params.color) && params.color !== '') {
      item_color = get_ts_color(params.color);
      if( params.color === 'custom' && _.isString(params.custom_color) && params.custom_color !== '' ){
        item_color = params.custom_color;
      }
    }
    //set color
    $('.preview-table',this.$el).css('border-color',item_color);
  }
});


/*---------------------------------------------
    Button
---------------------------------------------*/
window.TsButtonView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');
    var item_color = get_ts_color('default');
    var ex_class = '';
    var ex_style = '';
    var ex_icon = '';
    var ex_title = '';

    //show changes
    window.TsButtonView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
      this.$el.addClass('wpb_vc_column_text');
    }
    //get color
    if (_.isObject(params) && _.isString(params.color) && params.color !== '') {
      item_color = get_ts_color(params.color);
      //for text color
      if( params.color === 'white' ){
        ex_class += ' color-white';
      }
      if( params.color === 'custom' && _.isString(params.bgcolor) && params.bgcolor !== '' ){
        item_color = params.bgcolor;
      }
    }

    ex_class += ' size-'+params.size;
    ex_style = ' style="background-color:'+item_color+'"';
    //check button icon
    if( _.isObject(params) && _.isString(params.icon) && params.icon !== '' ){
      ex_icon = '<span class="button_icon"><i class="fa fa-'+params.icon+'"></i></span>';
      ex_class += ' icon-'+params.icon_pos;
    }
    if( _.isObject(params) && _.isString(params.title) && params.title !== '' ){
      ex_title = '<span class="button_title">'+params.title+'</span>';
    }
    //set
    $('.preview-button',this.$el).html('<a class="'+ex_class+'"'+ex_style+'>'+ex_icon+ex_title+'</a>');
  }
});

/*---------------------------------------------
    Buttons Set
---------------------------------------------*/
window.TsButtonsSetView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');
    var item_color = get_ts_color('default');
    var ex_output = '';
    var ex_class = '';
    var ex_style = '';

    //show changes
    window.TsButtonsSetView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }
    
    //get color
    if (_.isObject(params) && _.isString(params.color) && params.color !== '') {
      item_color = get_ts_color(params.color);
      //for text color
      if( params.color === 'white' ){
        ex_class += ' color-white';
      }
      if( params.color === 'custom' && _.isString(params.bgcolor) && params.bgcolor !== '' ){
        item_color = params.bgcolor;
      }
    }
    ex_style = ' style="background-color:'+item_color+'"';

    //check default values
    if( _.isObject(params) ){
      if( _.isString(params.title_left) && params.title_left !== '' ){
        ex_output += '<span class="buttons-left-title">'+params.title_left+'</span>';
      }
      if( _.isString(params.center_text) && params.center_text !== '' ){
        ex_output += '<span class="buttons-center-text">'+params.center_text+'</span>';
      }
      if( _.isString(params.title_right) && params.title_right !== '' ){
        ex_output += '<span class="buttons-right-title">'+params.title_right+'</span>';
      }
    }
    //set default values
    $('.wpb_element_wrapper',this.$el).html('<span class="preview-buttons'+ex_class+'"'+ex_style+'>'+ex_output+'</span>');
  }
});

/*---------------------------------------------
    List
---------------------------------------------*/
window.TsListView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');
    var list_type = '';

    //show changes
    window.TsListView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }
    //check list type
    if( _.isObject(params) && _.isString(params.type) && params.type !== '' ){
      switch (params.type) {
        case 'roman':
          list_type = 'upper-roman';
        break;
        case 'latin':
          list_type = 'upper-latin';
        break;
        case 'custom':
          list_type = 'none';
          if( _.isString(params.icon) && params.icon !== '' ){
            $('.preview-list ul li', this.$el).prepend('<i class="list_icon fa fa-'+params.icon+'"></i>');
          }
        break;
        default:
          list_type = params.type;
      }
    }
    //set list type
    $('.preview-list ul', this.$el).css('list-style-type',list_type);
  }
});

/*---------------------------------------------
    Feature Box
---------------------------------------------*/
window.TsFeatureBoxView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');

    //show changes
    window.TsFeatureBoxView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }

    //check icon
    if( _.isObject(params) && _.isString(params.icon) && params.icon !== '' ){
      $('.featurebox-heading',this.$el).prepend('<i class="featurebox_icon fa fa-'+params.icon+'"></i>');
    }
  }
});

/*---------------------------------------------
    Icon
---------------------------------------------*/
window.TsIconView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');

    //show changes
    window.TsIconView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }

    //check icon
    if( _.isObject(params) && _.isString(params.icon) && params.icon !== '' ){
      $('.icon-heading',this.$el).prepend('<i class="preview-ts-icon fa fa-'+params.icon+'"></i>');
    }

    if( _.isObject(params) && _.isString(params.small_text) && params.small_text !== '' ){
      $('.icon-heading',this.$el).append( ' / <small>'+params.small_text+'</small>' );
    }
  }
});

/*---------------------------------------------
    Alertbox
---------------------------------------------*/
window.TsAlertBoxView = vc.shortcode_view.extend({
  changeShortcodeParams:function (model) {
    var params = model.get('params');
    var alert_icon = '';
    var item_color = '';
    var bg_color = '';

    //show changes
    window.TsAlertBoxView.__super__.changeShortcodeParams.call(this, model);
    //
    if( !this.$el.hasClass('wpb_vc_column_text') ){
        this.$el.addClass('wpb_vc_column_text');
    }

    //check alertbox model
    if( _.isObject(params) && _.isString(params.model) && params.model !== '' ){
      switch (params.model) {
        case 'success':
          alert_icon = 'check';
          item_color = get_ts_color('green');
        break;
        case 'info':
          alert_icon = 'info';
          item_color = get_ts_color('blue');
        break;
        case 'notice':
          alert_icon = 'exclamation';
          item_color = get_ts_color('yellow');
        break;
        case 'error':
          alert_icon = 'ban';
          item_color = get_ts_color('orange');
        break;
        case 'custom':
          if( _.isString(params.icon) && params.icon !== '' ){
            alert_icon = params.icon;
          }
          if( _.isString(params.bg_color) && params.bg_color !== '' ){
            item_color = params.bg_color;
          }
        break;
      }
      //check icon
      if( alert_icon != '' ){
        bg_color = ' style="background-color:'+item_color+';"';
        alert_icon = '<i class="alertbox_icon fa fa-'+alert_icon+'"'+bg_color+'></i>';
      }
      //set
      $('.preview-alertbox',this.$el).prepend(alert_icon);
    }
  }
});

/*---------------------------------------------
    Accordion
---------------------------------------------*/
window.TsAccordionView = vc.shortcode_view.extend({
  adding_new_tab:false,
  events:{
      'click .add_tab':'addTab',
      'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete':'deleteShortcode',
      'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit':'editElement',
      'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone':'clone'
  },
  render:function () {
      window.TsAccordionView.__super__.render.call(this);
      this.$content.sortable({
          axis:"y",
          handle:"h3",
          stop:function (event, ui) {
              // IE doesn't register the blur when sorting
              // so trigger focusout handlers to remove .ui-state-focus
              ui.item.prev().triggerHandler("focusout");
              $(this).find('> .wpb_sortable').each(function () {
                  var shortcode = $(this).data('model');
                  shortcode.save({'order':$(this).index()}); // Optimize
              });
          }
      });
      return this;
  },
  changeShortcodeParams:function (model) {
      window.TsAccordionView.__super__.changeShortcodeParams.call(this, model);
      var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
      if (this.$content.hasClass('ui-accordion')) {
          this.$content.accordion("option", "collapsible", collapsible);
      }
  },
  changedContent:function (view) {
      if( !this.$el.hasClass('wpb_vc_accordion') ){
          this.$el.addClass('wpb_vc_accordion');
      }

      if (this.$content.hasClass('ui-accordion')) this.$content.accordion('destroy');
      var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
      this.$content.accordion({
          header:"h3",
          navigation:false,
          autoHeight:true,
          heightStyle: "content",
          collapsible:collapsible,
          active:this.adding_new_tab === false && view.model.get('cloned') !== true ? 0 : view.$el.index()
      });
      this.adding_new_tab = false;
  },
  addTab:function (e) {
      this.adding_new_tab = true;
      e.preventDefault();
      vc.shortcodes.create({shortcode:'ts_accordion', params:{title:window.i18nLocale.section}, parent_id:this.model.id});
  },
  _loadDefaults:function () {
      window.TsAccordionView.__super__._loadDefaults.call(this);
  }
});

window.TsAccordionTabView = window.VcColumnView.extend({
  events:{
      'click > .vc_controls .column_delete,.wpb_vc_accordion_tab > .vc_controls .vc_control-btn-delete':'deleteShortcode',
      'click > .vc_controls .column_add,.wpb_vc_accordion_tab >  .vc_controls .vc_control-btn-prepend':'addElement',
      'click > .vc_controls .column_edit,.wpb_vc_accordion_tab >  .vc_controls .vc_control-btn-edit':'editElement',
      'click > .vc_controls .column_clone,.wpb_vc_accordion_tab > .vc_controls .vc_control-btn-clone':'clone',
      'click > [data-element_type] > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
  },
  setContent:function () {
      this.$content = this.$el.find('> [data-element_type] > .wpb_element_wrapper > .vc_container_for_children');
  },
  changeShortcodeParams:function (model) {
      var params = model.get('params');
      window.TsAccordionTabView.__super__.changeShortcodeParams.call(this, model);
      if (_.isObject(params) && _.isString(params.title)) {
          this.$el.find('> h3 .tab-label').text(params.title);
      }

      $('.wpb_ts_accordion',this.$el).addClass('wpb_vc_accordion_tab');

      //check icon
      if( _.isObject(params) && _.isString(params.icon) && params.icon !== '' ){
        $('.tab-label',this.$el).prepend('<i class="toggle_icon fa fa-'+params.icon+'"></i> ');
      }
  },
  setEmpty:function () {
      $('> [data-element_type]', this.$el).addClass('vc_empty-column');
      this.$content.addClass('vc_empty-container');
  },
  unsetEmpty:function () {
      $('> [data-element_type]', this.$el).removeClass('vc_empty-column');
      this.$content.removeClass('vc_empty-container');
  }
});

/*---------------------------------------------
    Tabs
---------------------------------------------*/
window.TsTabsView = vc.shortcode_view.extend({
  new_tab_adding:false,
  events:{
      'click .add_tab':'addTab',
      'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
      'click > .vc_controls .vc_control-btn-edit':'editElement',
      'click > .vc_controls .vc_control-btn-clone':'clone'
  },
  initialize:function (params) {
      window.TsTabsView.__super__.initialize.call(this, params);
      _.bindAll(this, 'stopSorting');
  },
  render:function () {
      window.TsTabsView.__super__.render.call(this);
      this.$tabs = this.$el.find('.wpb_tabs_holder');
      this.createAddTabButton();
      return this;
  },
  ready:function (e) {
      window.TsTabsView.__super__.ready.call(this, e);
  },
  createAddTabButton:function () {
      var new_tab_button_id = (+new Date() + '-' + Math.floor(Math.random() * 11));
      this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>');
      this.$add_button = $('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>').appendTo(this.$tabs.find(".tabs_controls"));
  },
  addTab:function (e) {
      e.preventDefault();
      this.new_tab_adding = true;
      var tab_title = window.i18nLocale.tab,
          tabs_count = this.$tabs.find('[data-element_type=ts_tab]').length,
          tab_id = (+new Date() + '-' + tabs_count + '-' + Math.floor(Math.random() * 11));
      vc.shortcodes.create({shortcode:'ts_tab', params:{title:tab_title, tab_id:tab_id}, parent_id:this.model.id});
      return false;
  },
  stopSorting:function (event, ui) {
      var shortcode;
      this.$tabs.find('ul.tabs_controls li:not(.add_tab_block)').each(function (index) {
          var href = $(this).find('a').attr('href').replace("#", "");
          // $('#' + href).appendTo(this.$tabs);
          shortcode = vc.shortcodes.get($('[id=' + $(this).attr('aria-controls') + ']').data('model-id'));
          vc.storage.lock();
          shortcode.save({'order':$(this).index()}); // Optimize
      });
      shortcode.save();
  },
  changedContent:function (view) {
      var params = view.model.get('params');
      if (!this.$tabs.hasClass('ui-tabs')) {
          this.$tabs.tabs({
              select:function (event, ui) {
                  if ($(ui.tab).hasClass('add_tab')) {
                      return false;
                  }
                  return true;
              }
          });
          this.$tabs.find(".ui-tabs-nav").prependTo(this.$tabs);
          this.$tabs.find(".ui-tabs-nav").sortable({
              axis:(this.$tabs.closest('[data-element_type]').data('element_type') == 'vc_tour' ? 'y' : 'x'),
              update:this.stopSorting,
              items:"> li:not(.add_tab_block)"
          });
      }
      if (view.model.get('cloned') === true) {
          var cloned_from = view.model.get('cloned_from'),
              $after_tab = $('[href=#tab-' + cloned_from.params.tab_id + ']', this.$content).parent(),
              $new_tab = $("<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>").insertAfter($after_tab);
          this.$tabs.tabs('refresh');
          this.$tabs.tabs("option", 'active', $new_tab.index());
      } else {
          $("<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>")
              .insertBefore(this.$add_button);
          this.$tabs.tabs('refresh');
          this.$tabs.tabs("option", "active", this.new_tab_adding ? $('.ui-tabs-nav li', this.$content).length - 2 : 0);

      }
      this.new_tab_adding = false;
  },
  cloneModel:function (model, parent_id, save_order) {
      var shortcodes_to_resort = [],
          new_order = _.isBoolean(save_order) && save_order === true ? model.get('order') : parseFloat(model.get('order')) + vc.clone_index,
          model_clone,
          new_params = _.extend({}, model.get('params'));
      if (model.get('shortcode') === 'ts_tab') _.extend(new_params, {tab_id:+new Date() + '-' + this.$tabs.find('[data-element-type=ts_tab]').length + '-' + Math.floor(Math.random() * 11)});
      model_clone = Shortcodes.create({shortcode:model.get('shortcode'), id:vc_guid(), parent_id:parent_id, order:new_order, cloned:(model.get('shortcode') === 'ts_tab' ? false : true), cloned_from:model.toJSON(), params:new_params});
      _.each(Shortcodes.where({parent_id:model.id}), function (shortcode) {
          this.cloneModel(shortcode, model_clone.get('id'), true);
      }, this);
      return model_clone;
  },
  changeShortcodeParams:function (model) {
    this.$el.addClass('wpb_vc_tabs');
  }
});

window.TsTabView = window.VcColumnView.extend({
  events:{
    'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
    'click > .vc_controls .vc_control-btn-prepend':'addElement',
    'click > .vc_controls .vc_control-btn-edit':'editElement',
    'click > .vc_controls .vc_control-btn-clone':'clone',
    'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
  },
  render:function () {
      var params = this.model.get('params');
      window.TsTabView.__super__.render.call(this);
      if(!params.tab_id) {
        params.tab_id = (+new Date() + '-' + Math.floor(Math.random() * 11));
        this.model.save('params', params);
      }
      this.id = 'tab-' + params.tab_id;
      this.$el.attr('id', this.id);
      return this;
  },
  ready:function (e) {
      window.TsTabView.__super__.ready.call(this, e);
      this.$tabs = this.$el.closest('.wpb_tabs_holder');
      var params = this.model.get('params');
      return this;
  },
  changeShortcodeParams:function (model) {
      var params = model.get('params');
      var custom_icon = '';
      if( params.icon != '' && params.icon != undefined ){
        custom_icon = '<i class="toggle_icon fa fa-'+params.icon+'"></i> ';
      }
      window.TsTabView.__super__.changeShortcodeParams.call(this, model);
      if (_.isObject(params) && _.isString(params.title) && _.isString(params.tab_id)) {
          $('.ui-tabs-nav [href=#tab-' + params.tab_id + ']').html(custom_icon+params.title);
      }
      $('.wpb_ts_tab').addClass('wpb_vc_tab');
  },
  deleteShortcode:function (e) {
      _.isObject(e) && e.preventDefault();
      var answer = confirm(window.i18nLocale.press_ok_to_delete_section),
          parent_id = this.model.get('parent_id');
      if (answer !== true) return false;
      this.model.destroy();
      if(!vc.shortcodes.where({parent_id: parent_id}).length) {
        vc.shortcodes.get(parent_id).destroy();
        return false;
      }
      var params = this.model.get('params'),
          current_tab_index = $('[href=#tab-' + params.tab_id + ']', this.$tabs).parent().index();
      $('[href=#tab-' + params.tab_id + ']').parent().remove();
      var tab_length = this.$tabs.find('.ui-tabs-nav li:not(.add_tab_block)').length;
      if(tab_length > 0) {
          this.$tabs.tabs('refresh');
      }
      if (current_tab_index < tab_length) {
          this.$tabs.tabs("option", "active", current_tab_index);
      } else if (tab_length > 0) {
          this.$tabs.tabs("option", "active", tab_length - 1);
      }

  },
  cloneModel:function (model, parent_id, save_order) {
      var shortcodes_to_resort = [],
          new_order = _.isBoolean(save_order) && save_order === true ? model.get('order') : parseFloat(model.get('order')) + vc.clone_index,
          new_params = _.extend({}, model.get('params'));
      if (model.get('shortcode') === 'ts_tab') _.extend(new_params, {tab_id:+new Date() + '-' + this.$tabs.find('[data-element_type=ts_tab]').length + '-' + Math.floor(Math.random() * 11)});
      var model_clone = Shortcodes.create({shortcode:model.get('shortcode'), parent_id:parent_id, order:new_order, cloned:true, cloned_from:model.toJSON(), params:new_params});
      _.each(Shortcodes.where({parent_id:model.id}), function (shortcode) {
          this.cloneModel(shortcode, model_clone.id, true);
      }, this);
      return model_clone;
  }
});

});