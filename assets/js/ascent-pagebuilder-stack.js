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

        $(this.element).on('show.bs.modal', function(e) {
            alert('incoming Modal!')
        });

        $(this.element).on('click', '.pb-block-empty', function() {
            self.addBlock(this);
        });

        
    },

    addRow: function(block) {

        // alert(block);

        var elm = this.element;

        // let type = 'type';
        let field  = 'content';
        let idx = $(elm).find('.pb-row').length; 

        $.ajax({
            type: 'post',
            url: '/admin/pagebuilder/makerow/' + block + '/' + field + '/' + idx, 
            headers: {
                'Accept' : "application/json"
            }
        }).done(function(data) {

            $(elm).find('.pb-rows').append(data);
            $(elm).trigger('change');
            // self.updateIndexes();      
        });

    },

    addBlock: function(block) {

        // block is the DOM element for the target block.
        // need to resolve this into the Row, Container and Block indexes.
        // or do we? can we not just replace the block HTML?
        // - only thing is retaining the hierarchy of field indexes...

        let row_unid = $(block).parents('.pb-row').find('.pb-row-unid').val();
        let container_unid = $(block).parents('.pb-container').find('.pb-container-unid').val();

        
        
        parent.$('.pagebuilder').find('#block-picker').one('click', 'a', function() {

            
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

            }).done(function(data) {

                console.log('block', block);
                console.log('data', data);
                
                // and then insert the returned HTML in place of the empty block.
                $(block).replaceWith($(data));


            }).fail(function(data) {
                alert('error creating block');
                console.log('error creating block', data);
            });

          
            
        });

        // display the modal now we've set up the handlers
        parent.$('.pagebuilder').find('#block-picker').modal();



        console.log(block);

    }

}


$.widget('ascent.pagebuilderstack', PageBuilderStack);
$.extend($.ascent.PageBuilderStack, {

	
}); 

// $(document).ready(function() {
//     console.log('init PB');
//     $('.pagebuilderstack').not('.initialised').pagebuilderstack();
// });


