// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderStack = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var elm = this.element;

        $(elm).addClass('initialised');

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

        // $(this.element).on('mousemove', '.pb-element', function(e) {
        //     console.log(this);
        //     // e.stopPropagation();
        // });

        // hide all labels on mouseout
        $(this.element).on('mouseout', '.pb-element', function(e) {
            $(this).removeClass('moused');
        });

        $(this.element).on('change', function(e) {
            console.log('change - pbs', this, e);
            // alert('changd');
            $(this.element).change();
        });

    },

    addRow: function() {

        var elm = this.element;

        let type = 'type';
        let field  = 'content';
        let idx = $(elm).find('.pb-row').length; 

        $.ajax({
            type: 'post',
            url: '/admin/pagebuilder/makerow/' + type + '/' + field + '/' + idx, 
            headers: {
                'Accept' : "application/json"
            }
        }).done(function(data) {

            $(elm).find('.pb-rows').append(data);
            $(elm).trigger('change');
            // self.updateIndexes();      
        });

    }

}


$.widget('ascent.pagebuilderstack', PageBuilderStack);
$.extend($.ascent.PageBuilderStack, {
	
}); 

// $(document).ready(function() {
//     console.log('init PB');
//     $('.pagebuilderstack').not('.initialised').pagebuilderstack();
// });


