// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderBlock = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        $(obj).addClass('initialised');

        $(this.element).on('click', '.pbb-settings', function(e) {
            
            parent.$('.pagebuilder').trigger('show-modal', [$(obj).children('.pb-element-settings').children('.modal')]);
            e.preventDefault();

        });

        $(this.element).on('click', '.pbb-delete', function(e) {

            if(confirm('Delete this block?', 'This action cannot be undone')) {

                $(self.element).html('');

                $(self.element).parents('form').submit();

            // $(self.element).css('grid-template-columns', 'repeat(auto-fill, minmax(300px, 1fr) minmax(300px, 1fr))');


            }
            
            e.preventDefault();

        });

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


    }

}


$.widget('ascent.pagebuilderblock', PageBuilderBlock);
$.extend($.ascent.PageBuilderBlock, {
	
}); 

$(document).ready(function() {
    console.log('init PB Container');
    $('.pb-block').not('.initialised').pagebuilderblock();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.pb-block').not('.initialised').pagebuilderblock();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
