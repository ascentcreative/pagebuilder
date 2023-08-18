// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var ButtonElement = {
        
  
    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        this.unid = obj.data('unid');

        console.log('init Button Element');

        $(obj).addClass('button-element-initialised');
        
     
        $(this.element).find('.button-edit').on('keyup', function() {
            console.log($(this).html());
            $(self.element).find("textarea").val($(this).html());
        });

    }

}


$.widget('ascent.buttonelement', ButtonElement);
$.extend($.ascent.ButtonElement, {
	
}); 

$(document).ready(function() {
    console.log('init PB Button Element');
    $('.pb-button').not('.button-element-initialised').buttonelement();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
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
