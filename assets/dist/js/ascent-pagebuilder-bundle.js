// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var PageBuilder = {
  rowCount: 0,
  fieldName: '',
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    this.fieldName = idAry[1];
    console.log(idAry);
    var elm = this.element;
    $(elm).addClass('initialised');

    // catch change events relayed from the iFrame:
    $(elm).on('pb-change', function () {
      // self.syncData(); // only on save
      $(this).change();
    });
    $(elm).on('create-element', function (e, context) {
      console.log(context);

      // return;

      $('#element-picker').modal();
      $('#element-picker').one('click', 'a', function (e) {
        e.preventDefault();
        var type = $(this).data('element-type');
        $('#element-picker').modal('hide');
        self.buildElement(type, context);

        // $(self.stack).pagebuilderstack('addRow', type);
      });

      // if the user clicks outside the modal, ensure the click handler is removed
      $('#element-picker').on('hidden.bs.modal', function () {
        $('#element-picker').off('click', 'button');
      });
    });
    $(elm).on('show-modal', function (e, modal) {
      var withDataAndEvents = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
      // alert(withDataAndEvents);
      // console.log(modal);
      // console.log(
      //     'remote modal:', 
      //     $(self.element).find('#pb-iframe').contents().find('#' + $(modal).attr('id'))
      // );

      // $(self.element).find('#pb-iframe').contents().find('#' + $(modal).attr('id')).removeClass('fade').modal();

      // $(modal).removeClass('fade').modal();

      // return;

      var clone = $(modal).clone(withDataAndEvents);
      $(clone).find('input:not([type=file]), select, textarea').each(function (idx) {
        console.log($(this).prop('tagName'), $(this).attr('type'), $(this).val());
      });
      $(clone).find('.initialised').removeClass('initialised');

      // $(clone).on('hidden.bs.modal', function(e) {
      $(clone).on('click', '.btn-ok', function (e) {
        e.preventDefault();

        // This should be done on clicking OK, not on closing the modal (which may be a cancel event)
        // $(clone).modal('hide');

        // let reclone = $(clone).clone(withDataAndEvents);

        // write the data back to the iFrame
        // I think we need to loop through all the fields in the modal...
        $(modal).replaceWith(clone);

        // console.log("*** CLOSING - GETING DATA ***");

        // $(clone).find('input:not([type=file]), select, textarea').each(function(idx) {
        //     console.log(

        //         $(this).prop('tagName'),
        //         $(this).attr('type'),
        //         $(this).val()

        //     );

        //     let target = $(modal).find('[name="' + $(this).attr('name') + '"]');

        //     if($(target).prop('tagName').toLowerCase() == 'select') {
        //         $(target).val($(this).val());
        //         // $(target).find('option[value=' + $(this).val()).
        //     } else {
        //         $(target).val($(this).val());
        //     }
        //     // need to handle checkboxes etc
        // });

        $(clone).modal('hide');

        // console.log("*** TARGET VALUES CROSSCHECK ***");

        $(modal).find('input:not([type=file]), select, textarea').each(function (idx) {
          console.log($(this).prop('tagName'), $(this).attr('type'), $(this).val());
        });
        return;

        // $(modal).find('.modal-body').html($(clone).find('.modal-body').html());
        // $(modal).replaceWith(clone);

        // sync the data fields.
        // self.syncData(); // only on save

        // OLD - refresh the UI
        // self.stack.parents('form').submit();

        // instead of submit and reload, let's see if we can fire off the data to simply 
        // recreate the CSS. Hopefully a smoother UI experience...
        var formdata = new FormData(self.stack.parents('form')[0]);
        $.ajax({
          url: '/admin/pagebuilder/refreshcss',
          type: 'post',
          contentType: false,
          processData: false,
          data: formdata
        }).done(function (data) {
          // console.log(data);
          console.log(self.stack.parents('html').find('#pb-styles').html(data));
        });
      }).on('hidden.bs.modal', function (e) {
        $(clone).remove(); // not needed in new version...
        // alert('hidden');
        // console.log($(clone).find('.colour'));
        // destroy the colour widget so it can be re-init'ed on next load
        // $(clone).find('.colour').colourfield('destroy');
      }).on('shown.bs.modal', function (e) {
        // anything we need to do when the modal shows - possibly nothing...

        // some widgets require manual initialisation

        // colour widget has display issues if init before modal shows.
        $(clone).find('.colour').colourfield();
      }).modal(); // show the modal
    });

    // register the event handlers to communicate with the iFrame.
    $(elm).find('#pb-iframe').on('load', function () {
      console.log('iFrame onLoad');
      var stack = $(this).contents().find('.pagebuilderstack');
      $(stack).pagebuilderstack();
      self.stack = stack;
      self.syncData();
      $(this).show();
      $(this).contents().find('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
      MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
      var observer = new MutationObserver(function (mutations, observer) {
        // fired when a mutation occurs
        // console.log(mutations, observer);
        // ...
        // alert('mutated');
        // console.log('mutate');
        $('.pb-elementllist').not('.pb-elementlist-initialised').pagebuilderelementlist();
      });

      // define what element should be observed by the observer
      // and what types of mutations trigger the callback
      observer.observe($(this).contents()[0], {
        subtree: true,
        childList: true
        //...
      });

      // consol
      // console.log($(this).contents()[0]);

      // Can't do this... if a block has a 'vh' measurement, the body will height will immediately be wrong!
      // (would need some pre-processing to convert a vh to a fixed px measurement in admin preview)
      // for now, just live with it...
      // $(this).css('height', this.contentWindow.document.body.scrollHeight + 'px');
    });

    // make the stack sortable (drag & drop)
    $(this.element).find('.pb-rows').sortable({
      axis: 'y',
      handle: '.row-drag',
      start: function start(event, ui) {
        $(ui.placeholder).css('height', $(ui.item).outerHeight() + 'px');
      },
      update: function update(event, ui) {

        // self.updateIndexes();
      }
    });

    // show/hide labels on mouseover
    $(this.element).on('mouseover', '.pb-element', function (e) {
      $(self.element).find('.moused').removeClass('moused'); // hide labels on parents
      $(this).addClass('moused'); // show label on this
      e.stopPropagation(); // stop propagation so parents don't switch back on!
    });

    // hide all labels on mouseout
    $(this.element).on('mouseout', '.pb-element', function (e) {
      $(this).removeClass('moused');
    });

    // capture the click event of the add block button
    // (test for now - adds a new row block. Will need to be coded to ask user what block to add)
    $(this.element).on('click', '#btn-add-row', function (e) {
      var win = $(elm).find('#pb-iframe')[0].contentWindow;
      self.buildElement('section', win.$('.pb-stack').find('.pb-elementlist').first());
      e.preventDefault();

      // $('#block-picker').modal();

      // var field = $(this).attr('data-block-field'); //'content';
      // var idx = $(self.element).find('.row-edit').length;

      // $('#block-picker').one('click', 'a', function(e) {

      //     e.preventDefault();

      //     var type = $(this).data('block-type');

      //     $('#block-picker').modal('hide');

      //     // $.get('/admin/stack/make-row/' + type + '/' + field + '/' + idx, function(data) {
      //     //     // $(self.element).find('.stack-output').before(data);
      //     //     $(self.element).find('.stack-rows').append(data);
      //     //     self.updateIndexes();                
      //     // });

      //     $(self.stack).pagebuilderstack('addRow', type);

      // });

      // // if the user clicks outside the modal, ensure the click handler is removed
      // $('#block-picker').on('hidden.bs.modal', function() {
      //     $('#block-picker').off('click', 'button');
      // });
    });

    $(this.element).on('click', '#btn-mobile', function (e) {
      e.preventDefault();
      $(self.element).toggleClass('mobile');
    });

    // Go fullscreen
    $(this.element).on('click', '#btn-fullscreen', function (e) {
      e.preventDefault();
      $(self.element).addClass('fullscreen').css('top', $(document).scrollTop() + 'px');
      $('body').addClass('no-scroll');
    });

    // exit fullscreen
    $(this.element).on('click', '#btn-docked', function (e) {
      e.preventDefault();
      $(self.element).removeClass('fullscreen').css('top', 'auto');
      $('body').removeClass('no-scroll');
    });

    //capture the submit event of the form to serialise the stack data
    $(this.element).parents('form').on('submit', function () {
      console.log('saving - final data sync');
      self.syncData();
      // return false;
    });

    // now, we need to create a dummy form with the data to initialise the iframe:

    // $(elm).find('#pb-iframe').contents().find('form').submit();
    // $('body').append('<form id="pb-init-form" target="pb-frame" method="post" action="/admin/pagebuilder/iframe"><input name="xyz"></form>');

    // console.log( $('#pb-init-form'));
    // console.log($('#pb-init-form').submit());
    console.log('firing ajax init');
    $.ajax({
      url: '/admin/pagebuilder/iframe',
      method: 'post',
      data: {
        payload: $('#pb-init').val()
      }
    }).done(function (data) {
      console.log('ajax init done');
      page = $(data);
      win = $(elm).find('#pb-iframe')[0].contentWindow;
      win.document.open();
      win.document.write(data); //.find('head').html(page.find('head').html());
      win.document.close();
      //$(elm).find('#pb-iframe').contents().find('body').html(page.find('body').html());
    }).fail(function (data, c2, c3) {
      console.log(data);
      page = $(c3);
      win = $(elm).find('#pb-iframe')[0].contentWindow;
      win.document.open();
      win.document.write("<h1>oops</h1>" + data.responseText); //.find('head').html(page.find('head').html());
      win.document.close();
    });
  },
  // extract fields from the stack so they can be submitted with the model form:
  syncData: function syncData() {
    // console.log('started datasync');
    // return; 

    var elmSync = $(this.element).find('.pb-sync');
    $(elmSync).html(''); // clear all old data

    $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function () {
      // console.log('sync: ' + $(this).attr('name'));
      // console.log($(this).prop('tagName').toLowerCase());
      if ($(this).prop('tagName').toLowerCase() == 'select') {
        $(elmSync).append('<input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '">');
      } else {
        $(elmSync).append($(this).clone());
      }
      //
    });
  },

  // Performs an Ajax call to return the element HTML and
  // inserts it into the stack, relative to the context
  buildElement: function buildElement(type, context) {
    $.ajax({
      url: '/admin/pagebuilder/makeelement',
      type: 'post',
      // cache: false,
      // contentType: false,
      // processData: false,
      data: {
        // need to populate this:
        // fieldname: 'content[rows][' + row_unid + '][containers][' + container_unid + ']',
        // row: row_unid,
        // container: container_unid,
        // template: $(this).data('block-type')
        // type: 'htmltag',
        type: type,
        path: ''
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (data) {
      console.log('OK', data);
      console.log('context', context);
      if ($(context).hasClass('.pb-element')) {
        $(context).after(data);
      }
      if ($(context).hasClass('pb-elementlist')) {
        console.log('appending');
        $(context).append(data);
      }
    }).fail(function (data) {
      console.log("fail:", data);
    });
  }

  // new version - builds the heirarchy of the fields so we don't have to worry about them in the builder UI
  // rather tha just getting a list of all INPUT elements, we need to traverse the DOM using known classes
  //  - get each element, add unid to the path, copythe fields in the element etc

  // NOT NEEDED - rather, heirarchy updated as needed by stack.
  // NewSyncData: function() {

  //     let elmSync = $(this.element).find('.pb-sync');

  //     $(elmSync).html(''); // clear all old data

  //     let syncFields = this.syncTraverse($(this.stack).children('.pb-stack')[0], 'content'); //this.fieldName);

  //     // console.log('syncFields', syncFields);

  //     syncFields.forEach(function(fld) {
  //         // console.log('fld', fld);
  //         if($(fld).prop('tagName').toLowerCase() == 'select') {
  //             $(elmSync).append('<input type="hidden" name="' + $(fld).attr('name') + '" value="' + $(fld).val() + '">');
  //         } else {
  //             $(elmSync).append($(fld));
  //         }
  //     });

  //     // $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function() {
  //     //     // console.log('sync: ' + $(this).attr('name'));
  //     //     // console.log($(this).prop('tagName').toLowerCase());
  //     //     if($(this).prop('tagName').toLowerCase() == 'select') {
  //     //         $(elmSync).append('<input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '">');
  //     //     } else {
  //     //         $(elmSync).append($(this).clone());
  //     //     }
  //     //     //

  //     // });

  // },

  // syncTraverse: function(elm, path) {

  //     console.log('path', path);

  //     let self = this;

  //     console.log(elm);

  //     let unid = $(elm).data('unid');
  //     console.log('unid', unid);

  //     let fields = $(elm).find('INPUT[name^="' + unid + '"], SELECT[name^="' + unid + '"], TEXTAREA[name^="' + unid + '"]');
  //     console.log('fields: ', fields);

  //     let syncFields = [];
  //     fields.each(function(idx) { 
  //         let fld = $(fields[idx]).clone();

  //         console.log('old name', fld.attr('name'));
  //         console.log('new name', fld.attr('name').replace(unid, path + '[' + unid + ']'));

  //         fld.attr('name', fld.attr('name').replace(unid, path + '[' + unid + ']'));
  //         syncFields.push(fld);

  //     });

  //     let children = $($(elm).find('.pb-elementlist')[0]).children('.pb-element'); 
  //     children.each(function(idx) {
  //         child = children[idx];
  //         // let unid = $(child).data('unid');
  //         // console.log(unid + ": " + $(child).find('INPUT[name=' + unid + '\\[t\\]]').val());
  //         // let fields = 
  //         syncFields = syncFields.concat(self.syncTraverse(child, path + '[' + unid + '][e]'));
  //     });

  //     return syncFields;

  // }
};

$.widget('ascent.pagebuilder', PageBuilder);
$.extend($.ascent.PageBuilder, {});
$(document).ready(function () {
  console.log('init PB');
  $('.pagebuilder').not('.initialised').pagebuilder();
});

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var ButtonElement = {
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    this.unid = obj.data('unid');
    console.log('init Button Element');
    $(obj).addClass('button-element-initialised');
    $(this.element).find('.button-edit').on('keyup', function () {
      console.log($(this).html());
      $(self.element).find("textarea").val($(this).html());
    });
  }
};
$.widget('ascent.buttonelement', ButtonElement);
$.extend($.ascent.ButtonElement, {});
$(document).ready(function () {
  console.log('init PB Button Element');
  $('.pb-button').not('.button-element-initialised').buttonelement();
});
MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
var observer = new MutationObserver(function (mutations, observer) {
  // fired when a mutation occurs
  // console.log(mutations, observer);
  // ...
  $('.pb-button').not('.button-element-initialised').buttonelement();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var PageBuilderElement = {
  rowCount: 0,
  unid: '',
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    this.unid = obj.data('unid');
    $(obj).addClass('pb-element-initialised');
    $(this.element).on('click', function (e) {
      self.select();
      e.stopPropagation();
    });
    $(this.element).on('click', '.pbe-selparent', function (e) {
      console.log($($(self.element).parents('.pb-element')[0]).pagebuilderelement('select'));
      e.preventDefault();
      e.stopPropagation();
    });
    $(this.element).on('click', '.pbe-settings', function (e) {
      console.log($(obj).find('.pb-element-settings .modal')[0]); //.find('.pb-element-settings .modal')[0]);

      // $(obj).find('.pb-element-settings .modal').first().modal('show');

      parent.$('.pagebuilder').trigger('show-modal', [$(obj).find('.pb-element-settings .modal')[0]]);
      e.preventDefault();
      e.stopPropagation();
    });
    $(this.element).parents('.pb-elementlist').first().trigger('elements-changed');
    $(this.element).on('callback-test', function (e) {
      alert('cqllback event');
    });
    $(this.element).on('path-changed', function (e) {
      self.updatePath();
      e.stopPropagation();
    });
    $(this.element).on('click', '#pbe-addchild-' + this.unid, function (e) {
      // alert('ok - ' + self.unid);

      // console.log(parent);

      e.preventDefault();
      parent.$('.pagebuilder').trigger('create-element', [$(self.element).find('.pb-elementlist').first()]);
      console.log('list = ', $(self.element).find('.pb-elementlist').first());
      return;

      // TODO - wrap this in a call to the element picker
      // we send an ajax request to render a new block of the relevant type
      $.ajax({
        url: '/admin/pagebuilder/makeelement',
        type: 'post',
        // cache: false,
        // contentType: false,
        // processData: false,
        data: {
          // need to populate this:
          // fieldname: 'content[rows][' + row_unid + '][containers][' + container_unid + ']',
          // row: row_unid,
          // container: container_unid,
          // template: $(this).data('block-type')
          // type: 'htmltag',
          type: 'image',
          path: ''
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).done(function (data) {
        // console.log('block', block);
        console.log('data', data);

        // and then insert the returned HTML in place of the empty block.
        var elmlist = $(self.element).find('.pb-elementlist').first();
        var element = $(data);
        elmlist.append(element);
        console.log('New Element added to DOM');
      }).fail(function (data) {
        alert('error creating block');
        console.log('error creating block', data);
      });
      e.preventDefault();
    });
    $(this.element).on('click', '#pbe-delete-' + this.unid, function (e) {
      if (confirm("Delete this?")) {
        $(self.element).remove();
      }
      $(this.element).parents('.pb-elementlist').first().trigger('elements-changed');
      e.preventDefault();
    });
    if ($(this.element).find('.pb-element-type').attr('name').startsWith('new')) {
      console.log('unpathed new element detected', self.element);
      self.updatePath();

      // scroll new element into view if needed
      // needs to be done on a timeout to get correct height of added element, apparently.
      window.setTimeout(function () {
        // console.log('element top: ', self.element.offset().top);
        // console.log('scroll posiution: ', window.parent.$('#pb-iframe')[0].scrollTop);
        // console.log('frame height: ', window.parent.$('#pb-iframe').height());
        if (self.element.offset().top > window.parent.$('#pb-iframe')[0].scrollTop + window.parent.$('#pb-iframe').height()) {
          window.parent.$('#pb-iframe')[0].contentWindow.scrollTo({
            top: self.element.offset().top + self.element.height(),
            left: 0,
            behavior: 'smooth'
          });
        }
      }, 1);
      self.select();
    }

    // $('.pb-block').resizable({
    //     handles: 'e',
    //     placeholder: 'ui-state-highlight',
    //     create: function( event, ui ) {
    //         // Prefers an another cursor with two arrows
    //         console.log('RS Create');
    //         $(".ui-resizable-handle").css("cursor","ew-resize");
    //     }, 
    //     start: function(event, ui) {
    //         console.log(ui, event);
    //         console.log(this);

    //         $(this).resizable("option", "grid", [100, 100])
    //         // $(ui).css('background', 'blue');
    //     }
    // });

    var elmlist = $(this.element).find('.pb-elementlist').first();
    if (elmlist.length > 0) {
      $(this.element).addClass('has-elementlist');
    }
    // console.log($(this.element).attr('class'), elmlist);
  },

  select: function select() {
    // console.log($(this.element).pagebuilderelement('instance'));
    $('.pb-element.selected').removeClass('selected');
    $(this.element).toggleClass('selected');
  },
  callback: function callback() {
    alert('callback');
  },
  updatePath: function updatePath() {
    var elmlist = $(this.element).parents('.pb-elementlist').first();
    var element = this.element;
    var path = ''; //'content';
    // let parents = $(elmlist).parents(".pb-element");

    var parents = $(this.element).parents(".pb-element, .pb-column");
    parents.each(function (idx) {
      var elm = parents[idx];
      if ($(elm).hasClass('pb-element')) {
        segment = "[" + $(elm).data('unid') + "][e]";
      } else {
        // list index (aka column)
        segment = "[" + $(elm).data('unid') + "]";
      }
      path = segment + path;
    });
    path = 'content' + path;
    var fields = $(element).find('INPUT, SELECT, TEXTAREA');
    var unid = $(element).data('unid');
    fields.each(function (idx) {
      var fld = fields[idx];
      // console.log(fld);

      if ($(fld).attr('name')) {
        console.log('old name: ', $(fld).attr('name'));
        var split = $(fld).attr('name').split($(element).data('unid'));
        console.log(split);
        split[0] = path + '[';
        $(fld).attr('name', split.join($(element).data('unid')));
        console.log('new name: ', $(fld).attr('name'));
      }
    });
  }
};
$.widget('ascent.pagebuilderelement', PageBuilderElement);
$.extend($.ascent.PageBuilderElement, {});
$(document).ready(function () {
  console.log('init PB Element');
  $('.pb-element').not('.pb-element-initialised').pagebuilderelement();
});
MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
var observer = new MutationObserver(function (mutations, observer) {
  // fired when a mutation occurs
  // console.log(mutations, observer);
  // ...
  $('.pb-element').not('.pb-element-initialised').pagebuilderelement();

  // $('.pb-element').pagebuilderelement('updatePath');
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var PageBuilderElementList = {
  rowCount: 0,
  listObserver: null,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    $(obj).addClass('pb-elementlist-initialised');
    MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
    this.listObserver = new MutationObserver(function (mutations, observer) {
      console.log('change detected');
      self.elementsChanged();
    });

    // define what element should be observed by the observer
    // and what types of mutations trigger the callback
    this.listObserver.observe(this.element[0], {
      subtree: false,
      childList: true
    });

    // $(this.element).on('elements-changed', function() {
    // self.elementsChanged();
    // })

    self.elementsChanged();
    $(this.element).sortable({
      connectWith: '.pb-elementlist-' + $(this.element).data('listtype'),
      handle: '.element-drag',
      forcePlaceholderSize: true,
      forceHelperSize: true,
      receive: function receive(event, ui) {
        // let path = ''; //'content';
        // let parents = $(this).parents(".pb-element");
        // parents.each(function(idx) {
        //     let elm = parents[idx];
        //     path = "[" + $(elm).data('unid') + "][e]" + path;
        // });
        // path = 'content' + path;

        // console.log('new path:', path);

        // let fields = ui.item.find('INPUT, SELECT, TEXTAREA');

        // fields.each(function(idx) {
        //     let fld = fields[idx];
        //     // console.log(fld);

        //     console.log('old name: ', $(fld).attr('name'));

        //     let split = $(fld).attr('name').split(ui.item.data('unid'));
        //     split[0] = path + '[';
        //     $(fld).attr('name', split.join(ui.item.data('unid')));

        //     console.log('new name: ', $(fld).attr('name'));
        // });

        console.log('recv', ui.item);

        // console.log('[data-unid="' + $(ui.item).attr('data-unid') + '"]');

        console.log($('#element-' + $(ui.item).attr('data-unid'))); //.css('background', 'blue'); //.pagebuilderelement('updatePath');

        console.log(ui.item.trigger('path-changed'));
        self.elementsChanged();

        // alert("sortabel stop");
        // console.log($(ui.item).parents('.pagebuilderstack'));
        // $(ui.item).parents('.pagebuilderstack').pagebuilderstack('reindexFields');
      },

      out: function out() {
        self.elementsChanged();
      }
    });
    console.log('ElementList INIT');

    // $(this.element).on()
  },

  elementsChanged: function elementsChanged() {
    console.log($(this.element).find('.pb-element').length);
    if ($(this.element).find('.pb-element').length == 0) {
      $(this.element).addClass('empty');
    } else {
      $(this.element).removeClass('empty');
    }
  }
};
$.widget('ascent.pagebuilderelementlist', PageBuilderElementList);
$.extend($.ascent.PageBuilderElementList, {});
$(document).ready(function () {
  console.log('init PB Elementlist');
  $('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
});
MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
var observer = new MutationObserver(function (mutations, observer) {
  // fired when a mutation occurs
  // console.log(mutations, observer);
  // ...
  $('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  // observer.observe($('#pb-iframe').contents(), {
  subtree: true,
  childList: true
  //...
});

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var ImageElement = {
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    this.unid = obj.data('unid');
    console.log('init Image Element');
    $(obj).addClass('image-element-initialised');
    if ($(this.element).find('img.preview').length == 0) {
      $(this.element).addClass('empty');
    }
    $(this.element).on('dblclick', function () {
      console.log(self.element);
      $(self.element).find('.fileupload').fileupload('start');
    });
    // 

    $(this.element).on('upload-start', function (e) {
      var holder = $(self.element).find('.image-element-image');
      $(holder).css('opacity', 0.5);
    });
    $(this.element).on('upload-complete', function (e) {
      console.log(e);
      var holder = $(self.element).find('.image-element-image');
      var img = $(self.element).find('img.image-element');
      if (img.length == 0) {
        img = $('<IMG src="" class="preview image-element">');
        $(self.element).append(img);
        $(self.element).removeClass('empty');
      }
      console.log('hldr', holder);
      console.log('img', img);
      $(img).attr('src', '/image/max/' + e.filedata['hashed_filename']);
      $(img).one('load', function () {
        $(holder).css('opacity', 1);
      });
    });
  }
};
$.widget('ascent.imageelement', ImageElement);
$.extend($.ascent.ImageElement, {});
$(document).ready(function () {
  console.log('init PB Image Element');
  $('.pb-image').not('.image-element-initialised').imageelement();
});
MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
var observer = new MutationObserver(function (mutations, observer) {
  // fired when a mutation occurs
  // console.log(mutations, observer);
  // ...
  $('.pb-image').not('.image-element-initialised').imageelement();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var PageBuilderStack = {
  rowCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var elm = this.element;
    $(elm).addClass('initialised');

    // make the stack sortable (drag & drop)
    // $(this.element).find('.pb-rows').sortable({
    //     axis: 'y',
    //     handle: '.row-drag',

    //     start: function(event, ui) {
    //         $(ui.placeholder).css('height', $(ui.item).outerHeight() + 'px');
    //     },
    //     update: function(event, ui) {

    //         // self.updateIndexes();

    //     }
    // });

    // show/hide labels on mouseover
    $(this.element).on('mouseover', '.pb-element', function (e) {
      $(self.element).find('.moused').removeClass('moused'); // hide labels on parents
      $(this).addClass('moused'); // show label on this
      e.stopPropagation(); // stop propagation so parents don't switch back on!
    });

    // $(this.element).on('mousemove', '.pb-element', function(e) {
    //     console.log(this);
    //     // e.stopPropagation();
    // });

    // hide all labels on mouseout
    $(this.element).on('mouseout', '.pb-element', function (e) {
      $(this).removeClass('moused');
    });
    $(this.element).on('change', function (e) {
      console.log('change - pbs', this, e);
      // alert('changd');
      $(this.element).change();
    });

    // $(this.element).on('show.bs.modal', function(e) {
    //     alert('incoming Modal!')
    // });

    $(this.element).on('click', '.pb-block-empty', function () {
      self.addBlock(this);
    });
    $(this.element).on('fieldorderdirty', function () {
      self.reindexFields();
    });
    console.log('Stack INIT');

    // alert('stack init');

    // $(document).trigger('fieldorderdirty');
  },

  addRow: function addRow(block) {
    // alert(block);

    var elm = this.element;

    // let type = 'type';
    var field = 'content';
    var idx = $(elm).find('.pb-row').length;
    $.ajax({
      type: 'post',
      url: '/admin/pagebuilder/makerow/' + block + '/' + field + '/' + idx,
      headers: {
        'Accept': "application/json"
      }
    }).done(function (data) {
      $(elm).find('.pb-rows').append(data);
      $(elm).trigger('change');
      // self.updateIndexes();      
    });
  },

  addBlock: function addBlock(block) {
    // block is the DOM element for the target block.
    // need to resolve this into the Row, Container and Block indexes.
    // or do we? can we not just replace the block HTML?
    // - only thing is retaining the hierarchy of field indexes...

    var row_unid = $(block).parents('.pb-row').find('.pb-row-unid').val();
    var container_unid = $(block).parents('.pb-container').find('.pb-container-unid').val();
    parent.$('.pagebuilder').find('#block-picker').one('click', 'a', function () {
      // when a user clicks a block type

      // 1) close the modal - it's not needed
      parent.$('.pagebuilder').find('#block-picker').modal('hide');

      // we send an ajax request to render a new block of the relevant type
      $.ajax({
        url: '/admin/pagebuilder/makeblock',
        method: 'post',
        data: {
          // need to populate this:
          fieldname: 'content[rows][' + row_unid + '][containers][' + container_unid + ']',
          row: row_unid,
          container: container_unid,
          // idx: 0,
          template: $(this).data('block-type')
        }
      }).done(function (data) {
        console.log('block', block);
        console.log('data', data);

        // and then insert the returned HTML in place of the empty block.
        $(block).replaceWith($(data));
      }).fail(function (data) {
        alert('error creating block');
        console.log('error creating block', data);
      });
    });

    // display the modal now we've set up the handlers
    parent.$('.pagebuilder').find('#block-picker').modal();
    console.log(block);
  }

  // reindexFields: function() {
  //     console.log('fwefewfwef');
  //     // alert('reiindex');

  //     this.reindexTraverse($(this.element).children('.pb-stack'), 'content');

  // },

  // reindexTraverse: function(elm, path) {

  //     console.log('elm:', elm);

  //     let unid = $(elm).data('unid');
  //     console.log('unid', unid);

  //     let fields = $(elm).find('INPUT[name^="' + unid + '"], SELECT[name^="' + unid + '"], TEXTAREA[name^="' + unid + '"]');
  //     console.log(fields);

  // }
};

$.widget('ascent.pagebuilderstack', PageBuilderStack);
$.extend($.ascent.PageBuilderStack, {});

// $(document).ready(function() {
//     console.log('init PB');
//     $('.pagebuilderstack').not('.initialised').pagebuilderstack();
// });

// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var PageBuilder = {
  rowCount: 0,
  fieldName: '',
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    this.fieldName = idAry[1];
    console.log(idAry);
    var elm = this.element;
    $(elm).addClass('initialised');

    // catch change events relayed from the iFrame:
    $(elm).on('pb-change', function () {
      // self.syncData(); // only on save
      $(this).change();
    });
    $(elm).on('create-element', function (e, context) {
      console.log(context);

      // return;

      $('#element-picker').modal();
      $('#element-picker').one('click', 'a', function (e) {
        e.preventDefault();
        var type = $(this).data('element-type');
        $('#element-picker').modal('hide');
        self.buildElement(type, context);

        // $(self.stack).pagebuilderstack('addRow', type);
      });

      // if the user clicks outside the modal, ensure the click handler is removed
      $('#element-picker').on('hidden.bs.modal', function () {
        $('#element-picker').off('click', 'button');
      });
    });
    $(elm).on('show-modal', function (e, modal) {
      var withDataAndEvents = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
      // alert(withDataAndEvents);

      var clone = $(modal).clone(withDataAndEvents);
      $(clone).find('.initialised').removeClass('initialised');

      // $(clone).on('hidden.bs.modal', function(e) {
      $(clone).on('click', '.btn-ok', function (e) {
        e.preventDefault();

        // This should be done on clicking OK, not on closing the modal (which may be a cancel event)
        $(clone).modal('hide');

        // write the data back to the iFrame
        $(modal).replaceWith(clone);

        // sync the data fields.
        // self.syncData(); // only on save

        // refresh the UI
        self.stack.parents('form').submit();

        // submit via ajax - stops the page jumping to the top / retains scroll position.
        // let fd = new FormData(self.stack.parents('form')[0]);

        // console.log(fd.values());
        // keys = fd.keys();
        // item = keys.next();
        // while(!item.done) {
        //     console.log(item.value, fd.get(item.value));
        //     item = keys.next();
        //     // key = fd.values().next();
        // }

        // alert('here');
        // $.ajax({
        //     url: '/admin/pagebuilder/iframe',
        //     method: 'post',
        //     data: fd,
        //     contentType: false,
        //     processData: false,
        //     // headers: {
        //     //     'Accept' : "application/json"
        //     // },
        // }).done(function(data) {
        //     console.log('done');

        //     page = $(data);
        //     win = $(elm).find('#pb-iframe')[0].contentWindow;
        //     win.document.open();
        //     win.document.write(data); //.find('head').html(page.find('head').html());
        //     win.document.close();
        //     // console.log(data);
        //     // $(elm).find('#pb-iframe').contents().find('body').html(page.find('body').html());
        // })
      }).on('hidden.bs.modal', function (e) {
        $(clone).remove();
      }).on('shown.bs.modal', function (e) {
        // anything we need to do when the modal shows - possibly nothing...

        // some widgets require manual initialisation

        // colour widget has display issues if init before modal shows.
        $(clone).find('.colour').colourfield();
      }).modal(); // show the modal
    });

    // register the event handlers to communicate with the iFrame.
    $(elm).find('#pb-iframe').on('load', function () {
      console.log('iFrame onLoad');
      var stack = $(this).contents().find('.pagebuilderstack');
      $(stack).pagebuilderstack();
      self.stack = stack;
      self.syncData();
      $(this).show();
      $(this).contents().find('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
      MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
      var observer = new MutationObserver(function (mutations, observer) {
        // fired when a mutation occurs
        // console.log(mutations, observer);
        // ...
        // alert('mutated');
        // console.log('mutate');
        $('.pb-elementllist').not('.pb-elementlist-initialised').pagebuilderelementlist();
      });

      // define what element should be observed by the observer
      // and what types of mutations trigger the callback
      observer.observe($(this).contents()[0], {
        subtree: true,
        childList: true
        //...
      });

      // consol
      // console.log($(this).contents()[0]);

      // Can't do this... if a block has a 'vh' measurement, the body will height will immediately be wrong!
      // (would need some pre-processing to convert a vh to a fixed px measurement in admin preview)
      // for now, just live with it...
      // $(this).css('height', this.contentWindow.document.body.scrollHeight + 'px');
    });

    // make the stack sortable (drag & drop)
    $(this.element).find('.pb-rows').sortable({
      axis: 'y',
      handle: '.row-drag',
      start: function start(event, ui) {
        $(ui.placeholder).css('height', $(ui.item).outerHeight() + 'px');
      },
      update: function update(event, ui) {

        // self.updateIndexes();
      }
    });

    // show/hide labels on mouseover
    $(this.element).on('mouseover', '.pb-element', function (e) {
      $(self.element).find('.moused').removeClass('moused'); // hide labels on parents
      $(this).addClass('moused'); // show label on this
      e.stopPropagation(); // stop propagation so parents don't switch back on!
    });

    // hide all labels on mouseout
    $(this.element).on('mouseout', '.pb-element', function (e) {
      $(this).removeClass('moused');
    });

    // capture the click event of the add block button
    // (test for now - adds a new row block. Will need to be coded to ask user what block to add)
    $(this.element).on('click', '#btn-add-row', function (e) {
      var win = $(elm).find('#pb-iframe')[0].contentWindow;
      self.buildElement('section', win.$('.pb-stack').find('.pb-elementlist').first());
      e.preventDefault();

      // $('#block-picker').modal();

      // var field = $(this).attr('data-block-field'); //'content';
      // var idx = $(self.element).find('.row-edit').length;

      // $('#block-picker').one('click', 'a', function(e) {

      //     e.preventDefault();

      //     var type = $(this).data('block-type');

      //     $('#block-picker').modal('hide');

      //     // $.get('/admin/stack/make-row/' + type + '/' + field + '/' + idx, function(data) {
      //     //     // $(self.element).find('.stack-output').before(data);
      //     //     $(self.element).find('.stack-rows').append(data);
      //     //     self.updateIndexes();                
      //     // });

      //     $(self.stack).pagebuilderstack('addRow', type);

      // });

      // // if the user clicks outside the modal, ensure the click handler is removed
      // $('#block-picker').on('hidden.bs.modal', function() {
      //     $('#block-picker').off('click', 'button');
      // });
    });

    $(this.element).on('click', '#btn-mobile', function (e) {
      e.preventDefault();
      $(self.element).toggleClass('mobile');
    });

    // Go fullscreen
    $(this.element).on('click', '#btn-fullscreen', function (e) {
      e.preventDefault();
      $(self.element).addClass('fullscreen').css('top', $(document).scrollTop() + 'px');
      $('body').addClass('no-scroll');
    });

    // exit fullscreen
    $(this.element).on('click', '#btn-docked', function (e) {
      e.preventDefault();
      $(self.element).removeClass('fullscreen').css('top', 'auto');
      $('body').removeClass('no-scroll');
    });

    //capture the submit event of the form to serialise the stack data
    $(this.element).parents('form').on('submit', function () {
      console.log('saving - final data sync');
      self.syncData();
      // return false;
    });

    // now, we need to create a dummy form with the data to initialise the iframe:

    // $(elm).find('#pb-iframe').contents().find('form').submit();
    // $('body').append('<form id="pb-init-form" target="pb-frame" method="post" action="/admin/pagebuilder/iframe"><input name="xyz"></form>');

    // console.log( $('#pb-init-form'));
    // console.log($('#pb-init-form').submit());
    console.log('firing ajax init');
    $.ajax({
      url: '/admin/pagebuilder/iframe',
      method: 'post',
      data: {
        payload: $('#pb-init').val()
      }
    }).done(function (data) {
      console.log('ajax init done');
      page = $(data);
      win = $(elm).find('#pb-iframe')[0].contentWindow;
      win.document.open();
      win.document.write(data); //.find('head').html(page.find('head').html());
      win.document.close();
      //$(elm).find('#pb-iframe').contents().find('body').html(page.find('body').html());
    }).fail(function (data, c2, c3) {
      console.log(data);
      page = $(c3);
      win = $(elm).find('#pb-iframe')[0].contentWindow;
      win.document.open();
      win.document.write("<h1>oops</h1>" + data.responseText); //.find('head').html(page.find('head').html());
      win.document.close();
    });
  },
  // extract fields from the stack so they can be submitted with the model form:
  syncData: function syncData() {
    // console.log('started datasync');
    // return; 

    var elmSync = $(this.element).find('.pb-sync');
    $(elmSync).html(''); // clear all old data

    $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function () {
      // console.log('sync: ' + $(this).attr('name'));
      // console.log($(this).prop('tagName').toLowerCase());
      if ($(this).prop('tagName').toLowerCase() == 'select') {
        $(elmSync).append('<input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '">');
      } else {
        $(elmSync).append($(this).clone());
      }
      //
    });
  },

  // Performs an Ajax call to return the element HTML and
  // inserts it into the stack, relative to the context
  buildElement: function buildElement(type, context) {
    $.ajax({
      url: '/admin/pagebuilder/makeelement',
      type: 'post',
      // cache: false,
      // contentType: false,
      // processData: false,
      data: {
        // need to populate this:
        // fieldname: 'content[rows][' + row_unid + '][containers][' + container_unid + ']',
        // row: row_unid,
        // container: container_unid,
        // template: $(this).data('block-type')
        // type: 'htmltag',
        type: type,
        path: ''
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (data) {
      console.log('OK', data);
      console.log('context', context);
      var elm = $(data);
      if ($(context).hasClass('.pb-element')) {
        $(context).after(elm);
      }
      if ($(context).hasClass('pb-elementlist')) {
        $(context).append(elm);
      }
    }).fail(function (data) {
      console.log("fail:", data);
    });
  }

  // new version - builds the heirarchy of the fields so we don't have to worry about them in the builder UI
  // rather tha just getting a list of all INPUT elements, we need to traverse the DOM using known classes
  //  - get each element, add unid to the path, copythe fields in the element etc

  // NOT NEEDED - rather, heirarchy updated as needed by stack.
  // NewSyncData: function() {

  //     let elmSync = $(this.element).find('.pb-sync');

  //     $(elmSync).html(''); // clear all old data

  //     let syncFields = this.syncTraverse($(this.stack).children('.pb-stack')[0], 'content'); //this.fieldName);

  //     // console.log('syncFields', syncFields);

  //     syncFields.forEach(function(fld) {
  //         // console.log('fld', fld);
  //         if($(fld).prop('tagName').toLowerCase() == 'select') {
  //             $(elmSync).append('<input type="hidden" name="' + $(fld).attr('name') + '" value="' + $(fld).val() + '">');
  //         } else {
  //             $(elmSync).append($(fld));
  //         }
  //     });

  //     // $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function() {
  //     //     // console.log('sync: ' + $(this).attr('name'));
  //     //     // console.log($(this).prop('tagName').toLowerCase());
  //     //     if($(this).prop('tagName').toLowerCase() == 'select') {
  //     //         $(elmSync).append('<input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '">');
  //     //     } else {
  //     //         $(elmSync).append($(this).clone());
  //     //     }
  //     //     //

  //     // });

  // },

  // syncTraverse: function(elm, path) {

  //     console.log('path', path);

  //     let self = this;

  //     console.log(elm);

  //     let unid = $(elm).data('unid');
  //     console.log('unid', unid);

  //     let fields = $(elm).find('INPUT[name^="' + unid + '"], SELECT[name^="' + unid + '"], TEXTAREA[name^="' + unid + '"]');
  //     console.log('fields: ', fields);

  //     let syncFields = [];
  //     fields.each(function(idx) { 
  //         let fld = $(fields[idx]).clone();

  //         console.log('old name', fld.attr('name'));
  //         console.log('new name', fld.attr('name').replace(unid, path + '[' + unid + ']'));

  //         fld.attr('name', fld.attr('name').replace(unid, path + '[' + unid + ']'));
  //         syncFields.push(fld);

  //     });

  //     let children = $($(elm).find('.pb-elementlist')[0]).children('.pb-element'); 
  //     children.each(function(idx) {
  //         child = children[idx];
  //         // let unid = $(child).data('unid');
  //         // console.log(unid + ": " + $(child).find('INPUT[name=' + unid + '\\[t\\]]').val());
  //         // let fields = 
  //         syncFields = syncFields.concat(self.syncTraverse(child, path + '[' + unid + '][e]'));
  //     });

  //     return syncFields;

  // }
};

$.widget('ascent.pagebuilder', PageBuilder);
$.extend($.ascent.PageBuilder, {});
$(document).ready(function () {
  console.log('init PB');
  $('.pagebuilder').not('.initialised').pagebuilder();
});
