// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilder = {
        
    rowCount: 0,
    fieldName: '',

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        this.fieldName = idAry[1];

        console.log(idAry);
        
        var elm = this.element;

        $(elm).addClass('initialised');

        // catch change events relayed from the iFrame:
        $(elm).on('pb-change', function() {
            // self.syncData(); // only on save
            $(this).change();
        });




        $(elm).on('create-element', function(e, context) {
            
            console.log(context);

            // return;

            $('#element-picker').modal();

            $('#element-picker').one('click', 'a', function(e) {

                e.preventDefault();

                let type = $(this).data('element-type');

                $('#element-picker').modal('hide');

                self.buildElement(type, context);

                // $(self.stack).pagebuilderstack('addRow', type);


            });

            // if the user clicks outside the modal, ensure the click handler is removed
            $('#element-picker').on('hidden.bs.modal', function() {
                $('#element-picker').off('click', 'button');
            });


        });

        
        $(elm).on('show-modal', function(e, modal, withDataAndEvents=false) {

            // alert(withDataAndEvents);
            // console.log(modal);
            // console.log(
            //     'remote modal:', 
            //     $(self.element).find('#pb-iframe').contents().find('#' + $(modal).attr('id'))
            // );

            // $(self.element).find('#pb-iframe').contents().find('#' + $(modal).attr('id')).removeClass('fade').modal();

            // $(modal).removeClass('fade').modal();

        

            // return;


            let clone = $(modal).clone(withDataAndEvents); 

            $(clone).find('input:not([type=file]), select, textarea').each(function(idx) {
                console.log(

                    $(this).prop('tagName'),
                    $(this).attr('type'),
                    $(this).val()

                );

            });


            $(clone).find('.initialised').removeClass('initialised');

            // $(clone).on('hidden.bs.modal', function(e) {
            $(clone).on('click', '.btn-ok', function(e) {

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

                $(modal).find('input:not([type=file]), select, textarea').each(function(idx) {
                    console.log(

                        $(this).prop('tagName'),
                        $(this).attr('type'),
                        $(this).val()

                    );

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
                let formdata = new FormData(self.stack.parents('form')[0]);
                $.ajax({
                    url: '/admin/pagebuilder/refreshcss',
                    type: 'post',
                    contentType: false,
                    processData: false,
                    data: formdata
                }).done(function(data) {
                    // console.log(data);
                    console.log(self.stack.parents('html').find('#pb-styles').html(data));
                });


            }).on('hidden.bs.modal', function(e) {

                $(clone).remove(); // not needed in new version...
                // alert('hidden');
                // console.log($(clone).find('.colour'));
                // destroy the colour widget so it can be re-init'ed on next load
                // $(clone).find('.colour').colourfield('destroy');
                
            }).on('shown.bs.modal', function(e) {
                
                // anything we need to do when the modal shows - possibly nothing...

                // some widgets require manual initialisation
            
                // colour widget has display issues if init before modal shows.
                $(clone).find('.colour').colourfield();

            }).modal(); // show the modal

            


        });
        

        // register the event handlers to communicate with the iFrame.
        $(elm).find('#pb-iframe').on('load', function() {

            console.log('iFrame onLoad');

            let stack = $(this).contents().find('.pagebuilderstack');

            $(stack).pagebuilderstack();

            self.stack = stack;

            self.syncData();

            $(this).show();

            $(this).contents().find('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();


            MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

            var observer = new MutationObserver(function(mutations, observer) {
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
            
            start: function(event, ui) {
                $(ui.placeholder).css('height', $(ui.item).outerHeight() + 'px');
            },
            update: function(event, ui) {
                
                // self.updateIndexes();

            }
        });

        // show/hide labels on mouseover
        $(this.element).on('mouseover', '.pb-element', function(e) {
            $(self.element).find('.moused').removeClass('moused'); // hide labels on parents
            $(this).addClass('moused'); // show label on this
            e.stopPropagation(); // stop propagation so parents don't switch back on!
        });

        // hide all labels on mouseout
        $(this.element).on('mouseout', '.pb-element', function(e) {
            $(this).removeClass('moused');
        });




        // capture the click event of the add block button
            // (test for now - adds a new row block. Will need to be coded to ask user what block to add)
        $(this.element).on('click', '#btn-add-row', function(e) {

            let win = $(elm).find('#pb-iframe')[0].contentWindow;

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


        $(this.element).on('click', '#btn-mobile', function(e) {
            e.preventDefault();
            
            $(self.element).toggleClass('mobile');

        });



        // Go fullscreen
        $(this.element).on('click', '#btn-fullscreen', function(e) {

            e.preventDefault();

            $(self.element).addClass('fullscreen').css('top', $(document).scrollTop() + 'px');
            $('body').addClass('no-scroll');

        });

        // exit fullscreen
        $(this.element).on('click', '#btn-docked', function(e) {

            e.preventDefault();

            $(self.element).removeClass('fullscreen').css('top', 'auto');
            $('body').removeClass('no-scroll');

        });



         //capture the submit event of the form to serialise the stack data
         $(this.element).parents('form').on('submit', function() {
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
        }).done(function(data) {
            console.log('ajax init done');

            page = $(data);
            win = $(elm).find('#pb-iframe')[0].contentWindow;
            win.document.open();
            win.document.write(data); //.find('head').html(page.find('head').html());
            win.document.close();
            //$(elm).find('#pb-iframe').contents().find('body').html(page.find('body').html());
        }).fail(function(data, c2, c3) {

            console.log(data);
            page = $(c3);
            win = $(elm).find('#pb-iframe')[0].contentWindow;
            win.document.open();
            win.document.write("<h1>oops</h1>" + data.responseText); //.find('head').html(page.find('head').html());
            win.document.close();

        });

        

    },

    // extract fields from the stack so they can be submitted with the model form:
    syncData: function(){

        // console.log('started datasync');
        // return; 

        let elmSync = $(this.element).find('.pb-sync');

        $(elmSync).html(''); // clear all old data

        $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function() {
            // console.log('sync: ' + $(this).attr('name'));
            // console.log($(this).prop('tagName').toLowerCase());
            if($(this).prop('tagName').toLowerCase() == 'select') {
                $(elmSync).append('<input type="hidden" name="' + $(this).attr('name') + '" value="' + $(this).val() + '">');
            } else {
                $(elmSync).append($(this).clone());
            }
            //
            
        });

    },

    // Performs an Ajax call to return the element HTML and
    // inserts it into the stack, relative to the context
    buildElement: function(type, context) {


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
                path: '',

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        }).done(function(data) {
            console.log('OK', data);
            console.log('context', context);
            if($(context).hasClass('.pb-element')) {
                $(context).after(data);
            }

            if($(context).hasClass('pb-elementlist')) {
                console.log('appending');
                $(context).append(data);
            }

        }).fail(function(data) {
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

}


$.widget('ascent.pagebuilder', PageBuilder);
$.extend($.ascent.PageBuilder, {
	
}); 


$(document).ready(function() {
    console.log('init PB');
    $('.pagebuilder').not('.initialised').pagebuilder();
});


