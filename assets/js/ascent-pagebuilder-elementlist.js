// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderElementList = {
        
    rowCount: 0,
    listObserver: null,

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        $(obj).addClass('pb-elementlist-initialised');  


        MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

        this.listObserver = new MutationObserver(function(mutations, observer) {
            console.log('change detected');
            self.elementsChanged();
        });

        // define what element should be observed by the observer
        // and what types of mutations trigger the callback
        this.listObserver.observe(this.element[0], {
            subtree: false,
            childList: true
        });
    

        // $(this.element).on('elements-changed', function() {
            // self.elementsChanged();
        // })

        self.elementsChanged();


        $(this.element).sortable({
            connectWith: '.pb-elementlist-' + $(this.element).data('listtype'),
            handle: '.element-drag',
            forcePlaceholderSize: true,
            forceHelperSize: true,
            receive: function(event, ui) {

                // let path = ''; //'content';
                // let parents = $(this).parents(".pb-element");
                // parents.each(function(idx) {
                //     let elm = parents[idx];
                //     path = "[" + $(elm).data('unid') + "][e]" + path;
                // });
                // path = 'content' + path;

                // console.log('new path:', path);

                // let fields = ui.item.find('INPUT, SELECT, TEXTAREA');
                
                // fields.each(function(idx) {
                //     let fld = fields[idx];
                //     // console.log(fld);

                //     console.log('old name: ', $(fld).attr('name'));

                //     let split = $(fld).attr('name').split(ui.item.data('unid'));
                //     split[0] = path + '[';
                //     $(fld).attr('name', split.join(ui.item.data('unid')));

                //     console.log('new name: ', $(fld).attr('name'));
                // });

                console.log('recv', ui.item );

                // console.log('[data-unid="' + $(ui.item).attr('data-unid') + '"]');

                console.log($('#element-' + $(ui.item).attr('data-unid'))); //.css('background', 'blue'); //.pagebuilderelement('updatePath');

                console.log(ui.item.trigger('path-changed'));

                self.elementsChanged();

                // alert("sortabel stop");
                // console.log($(ui.item).parents('.pagebuilderstack'));
                // $(ui.item).parents('.pagebuilderstack').pagebuilderstack('reindexFields');
            },
            out: function() {
                self.elementsChanged();
            }
        });


        console.log('ElementList INIT');
       

        // $(this.element).on()

    },

    elementsChanged: function() {
        console.log($(this.element).find('.pb-element').length);
        if($(this.element).find('.pb-element').length == 0) {
            $(this.element).addClass('empty');
        } else {
            $(this.element).removeClass('empty');
        }
    }

}


$.widget('ascent.pagebuilderelementlist', PageBuilderElementList);
$.extend($.ascent.PageBuilderElementList, {
	
}); 


$(document).ready(function() {
    console.log('init PB Elementlist');
    $('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
});



MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

var observer = new MutationObserver(function(mutations, observer) {
    // fired when a mutation occurs
    // console.log(mutations, observer);
    // ...
    $('.pb-elementlist').not('.pb-elementlist-initialised').pagebuilderelementlist();
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
// observer.observe($('#pb-iframe').contents(), {
  subtree: true,
  childList: true
  //...
});


