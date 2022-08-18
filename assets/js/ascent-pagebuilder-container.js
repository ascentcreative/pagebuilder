// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderContainer = {
        
    rowCount: 0,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        $(obj).addClass('initialised');

        $(this.element).on('click', '.pbc-settings', function() {
            
            parent.$('.pagebuilder').trigger('show-modal', [$(obj).children('.pb-element-settings').children('.modal')]);

        });

    }

}


$.widget('ascent.pagebuildercontainer', PageBuilderContainer);
$.extend($.ascent.PageBuilderContainer, {
	
}); 

$(document).ready(function() {
    console.log('init PB Container');
    $('.pb-container').not('.initialised').pagebuildercontainer();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.pb-container').not('.initialised').pagebuildercontainer();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
