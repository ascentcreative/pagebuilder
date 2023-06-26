// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var ImageElement = {
        
  
    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        this.unid = obj.data('unid');

        console.log('init Image Element');

        $(obj).addClass('image-element-initialised');
        
        if($(this.element).find('img.preview').length == 0) {
            $(this.element).addClass('empty');
        }

        $(this.element).on('dblclick', '.image-element-image', function() {
            $(self.element).find('.fileupload').fileupload('start');
        });
        // 

        $(this.element).on('upload-start', function(e) {
            let holder = $(self.element).find('.image-element-image');
            $(holder).css('opacity', 0.5);
        });

        $(this.element).on('upload-complete', function(e) {

            console.log(e);
            
            let holder = $(self.element).find('.image-element-image');
            let img = $(holder).find('img');

            if(img.length == 0) {
                img = $('<IMG src="" class="preview">');
                $(holder).append(img);
                $(self.element).removeClass('empty');
            }

            console.log('hldr', holder);
            console.log('img', img);

            $(img).attr('src', '/image/max/' + e.filedata['hashed_filename']);
            
            $(img).one('load', function() {
                $(holder).css('opacity', 1);
            });

        });

     

    }

}


$.widget('ascent.imageelement', ImageElement);
$.extend($.ascent.ImageElement, {
	
}); 

$(document).ready(function() {
    console.log('init PB Image Element');
    $('.image-element').not('.image-element-initialised').imageelement();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.image-element').not('.image-element-initialised').imageelement();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
