// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderRow = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        $(obj).addClass('initialised');

        $(this.element).on('click', '.pbr-settings', function() {
            
            parent.$('.pagebuilder').trigger('show-modal', [$(obj).children('.pb-element-settings').children('.modal')]);

        });

    }

}


$.widget('ascent.pagebuilderrow', PageBuilderRow);
$.extend($.ascent.PageBuilderRow, {
	
}); 

$(document).ready(function() {
    console.log('init PBR');
    $('.pb-row').not('.initialised').pagebuilderrow();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.pb-row').not('.initialised').pagebuilderrow();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
