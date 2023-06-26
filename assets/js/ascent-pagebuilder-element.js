// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

var PageBuilderElement = {
        
    rowCount: 0,
    unid: '',

    _init: function () {

        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;

        this.unid = obj.data('unid');

        $(obj).addClass('pb-element-initialised');

        $(this.element).on('click', function(e) {
            self.select();
            e.stopPropagation();
        }); 

        $(this.element).on('click', '.pbe-selparent', function(e) {
            console.log($($(self.element).parents('.pb-element')[0]).pagebuilderelement('select'));
            e.preventDefault();
            e.stopPropagation();
        });

        $(this.element).on('click', '.pbe-settings', function(e) {

            console.log($(obj).find('.pb-element-settings .modal')[0]); //.find('.pb-element-settings .modal')[0]);
            
            parent.$('.pagebuilder').trigger('show-modal', [$(obj).find('.pb-element-settings .modal')[0]]);
            e.preventDefault();
            e.stopPropagation();

        });

        $(this.element).on('callback-test', function(e) {
            alert('cqllback event');
        });

        $(this.element).on('path-changed', function(e) {
            self.updatePath();
            e.stopPropagation();
        });

        $(this.element).on('click', '#pbe-addchild-' + this.unid, function (e) {
            // alert('ok - ' + self.unid);

            // console.log(parent);

           

            e.preventDefault();

            parent.$('.pagebuilder').trigger('create-element', [$(self.element).find('.pb-elementlist')]);

            return;


            // TODO - wrap this in a call to the element picker
            // we send an ajax request to render a new block of the relevant type
            $.ajax({
                url: '/admin/pagebuilder/makeelement',
                type: 'post',
                // cache: false,
                // contentType: false,
                // processData: false,
                data: {
                    // need to populate this:
                    // fieldname: 'content[rows][' + row_unid + '][containers][' + container_unid + ']',
                    // row: row_unid,
                    // container: container_unid,
                    // template: $(this).data('block-type')
                    // type: 'htmltag',
                    type: 'image',
                    path: '',

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            }).done(function(data) {

                // console.log('block', block);
                console.log('data', data);
                
                // and then insert the returned HTML in place of the empty block.
                let elmlist = $(self.element).find('.pb-elementlist').first();
                let element = $(data);
                elmlist.append(element);

                console.log('New Element added to DOM');

               

            }).fail(function(data) {
                alert('error creating block');
                console.log('error creating block', data);
            });

            e.preventDefault();
    
        });

        $(this.element).on('click', '#pbe-delete-' + this.unid, function (e) {
            if(confirm("Delete this?")) {
                $(self.element).remove();
            }
            e.preventDefault();
        });


        if($(this.element).find('.pb-element-type').attr('name').startsWith('new')) {
            console.log('unpathed new element detected');
            self.updatePath();
        }
        
        
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


    },

    select: function() {
        console.log($(this.element).pagebuilderelement('instance'));
        $('.pb-element.selected').removeClass('selected');
        $(this.element).toggleClass('selected');
    },

    callback: function() {
        alert('callback');
    },

    updatePath: function() {

        console.log('update path');

        let elmlist = $(this.element).parents('.pb-elementlist').first();

        let element = this.element;
                
        let path = ''; //'content';
        // let parents = $(elmlist).parents(".pb-element");
        
        let parents = $(this.element).parents(".pb-element, .pb-column");

        console.log(parents);

        parents.each(function(idx) {
            let elm = parents[idx];
            if($(elm).hasClass('pb-element')) {
                segment = "[" + $(elm).data('unid') + "][e]";
            } else {
                // list index (aka column)
                segment = "[" + $(elm).data('unid') + "]";
            }
            path = segment + path;
        });
        path = 'content' + path;

        console.log('path: ', path);

        let fields = $(element).find('INPUT, SELECT, TEXTAREA');

        let unid = $(element).data('unid');

        console.log($(element).data());

        console.log('unid = ', unid);
        
        fields.each(function(idx) {
            let fld = fields[idx];
            // console.log(fld);

            console.log('old name: ', $(fld).attr('name'));

            let split = $(fld).attr('name').split($(element).data('unid'));
            console.log(split);
            split[0] = path + '[';
            $(fld).attr('name', split.join($(element).data('unid')));

            console.log('new name: ', $(fld).attr('name'));
        });


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

    // $('.pb-element').pagebuilderelement('updatePath');
});

// define what element should be observed by the observer
// and what types of mutations trigger the callback
observer.observe(document, {
  subtree: true,
  childList: true
  //...
});
