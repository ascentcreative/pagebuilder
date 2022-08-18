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
            self.syncData();
            $(this).change();
        });

        
        $(elm).on('show-modal', function(e, modal) {

            let clone = $(modal).clone(); 

            $(clone).find('.initialised').removeClass('initialised');
        
            // $(clone).on('hidden.bs.modal', function(e) {
            $(clone).on('click', '.btn-ok', function(e) {

                // This should be done on clicking OK, not on closing the modal (which may be a cancel event)
                $(clone).modal('hide');

                // write the data back to the iFrame
                $(modal).replaceWith(clone);

                // sync the data fields.
                self.syncData();

                // refresh the UI
                self.stack.parents('form').submit();

            }).on('hidden.bs.modal', function(e) {

                $(clone).remove();
                
            }).on('shown.bs.modal', function(e) {
                
                // anything we need to do when the modal shows - possibly nothing...

            }).modal(); // show the modal


        });
        


        // register the event handlers to communicate with the iFrame.
        $(elm).find('#pb-iframe').on('load', function() {

            let stack = $(this).contents().find('.pagebuilderstack');

            $(stack).pagebuilderstack();

            self.stack = stack;

            self.syncData();

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


        // Add row button:
        $(this.element).on('click', '#btn-add-row', function(e) {

            // ** Currently we're just hard coding a specific content block template **
            // Need to reinstate the block type selection that we have in the stack editor eventually.

            e.preventDefault();

            $(self.stack).pagebuilderstack('addRow');

        });

        

    },

    // extract fields from the stack so they can be submitted with the model form:
    syncData: function(){

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


