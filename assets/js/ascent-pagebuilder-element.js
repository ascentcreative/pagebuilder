// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderElement = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        $(obj).addClass('pb-element-initialised');

        $(this.element).on('click', '.pbe-settings', function(e) {

            console.log($(obj).find('.pb-element-settings .modal')[0]); //.find('.pb-element-settings .modal')[0]);
            
            parent.$('.pagebuilder').trigger('show-modal', [$(obj).find('.pb-element-settings .modal')[0]]);
            e.preventDefault();
            e.stopPropagation();

        });

        
        $(this.element).children('.pb-element-list').sortable({
            handle: '.element-drag'
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


$.widget('ascent.pagebuilderelement', PageBuilderElement);
$.extend($.ascent.PageBuilderElement, {
	
}); 

$(document).ready(function() {
    console.log('init PB Element');
    $('.pb-element').not('.pb-element-initialised').pagebuilderelement();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.pb-element').not('.pb-element-initialised').pagebuilderelement();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
