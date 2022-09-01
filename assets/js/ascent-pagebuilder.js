// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilder = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var elm = this.element;

        $(elm).addClass('initialised');

        // catch change events relayed from the iFrame:
        $(elm).on('pb-change', function() {
            // self.syncData(); // only on save
            $(this).change();
        });

        
        $(elm).on('show-modal', function(e, modal, withDataAndEvents=false) {

            // alert(withDataAndEvents);

            let clone = $(modal).clone(withDataAndEvents); 

            $(clone).find('.initialised').removeClass('initialised');

            // $(clone).on('hidden.bs.modal', function(e) {
            $(clone).on('click', '.btn-ok', function(e) {

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

            }).on('hidden.bs.modal', function(e) {

                $(clone).remove();
                
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

            e.preventDefault();

            $('#block-picker').modal();


            var field = $(this).attr('data-block-field'); //'content';
            var idx = $(self.element).find('.row-edit').length;

            $('#block-picker').one('click', 'a', function(e) {

                e.preventDefault();

                var type = $(this).data('block-type');
            
                $('#block-picker').modal('hide');

                // $.get('/admin/stack/make-row/' + type + '/' + field + '/' + idx, function(data) {
                //     // $(self.element).find('.stack-output').before(data);
                //     $(self.element).find('.stack-rows').append(data);
                //     self.updateIndexes();                
                // });

                $(self.stack).pagebuilderstack('addRow', type);


            });

            // if the user clicks outside the modal, ensure the click handler is removed
            $('#block-picker').on('hidden.bs.modal', function() {
                $('#block-picker').off('click', 'button');
            });

      
        });


        $(this.element).on('click', '#btn-mobile', function(e) {
            e.preventDefault();
            
            $(self.element).toggleClass('mobile');

        });



        // Go fullscreen
        $(this.element).on('click', '#btn-fullscreen', function(e) {

            e.preventDefault();

            $(self.element).addClass('fullscreen');

        });

        // exit fullscreen
        $(this.element).on('click', '#btn-docked', function(e) {

            e.preventDefault();

            $(self.element).removeClass('fullscreen');

        });



         //capture the submit event of the form to serialise the stack data
         $(this.element).parents('form').on('submit', function() {
            console.log('saving - final data sync');
            self.syncData();

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

        console.log('started datasync');

        let elmSync = $(this.element).find('.pb-sync');

        $(elmSync).html(''); // clear all old data

        $(this.stack).find('INPUT, SELECT, TEXTAREA').each(function() {
            // console.log('sync: ' + $(this).attr('name'));
            $(elmSync).append($(this).clone());
        });

    }

}


$.widget('ascent.pagebuilder', PageBuilder);
$.extend($.ascent.PageBuilder, {
	
}); 


$(document).ready(function() {
    console.log('init PB');
    $('.pagebuilder').not('.initialised').pagebuilder();
});


