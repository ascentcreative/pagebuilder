<?php

return [

    // paths to search for TypeDescriptor classes
    'discovery_paths' => [
        app_path() . '/../vendor/ascentcreative/pagebuilder/src/BlockDescriptors',
        app_path() . '/../vendor/ascentcreative/cms/src/PageBuilder/BlockDescriptors',
        app_path() . '/../vendor/ascentcreative/blog/src/PageBuilder/BlockDescriptors',
        app_path() . '/../vendor/ascentcreative/store/src/PageBuilder/BlockDescriptors',
        // app_path() . '/../vendor/ascentcreative/donate/src/PageBuilder/BlockDescriptors',
        app_path() .'/PageBuilder/BlockDescriptors',
    ],

    // paths to search for Edit and Show blades for the blocks. Searched in this order.
    'blade_paths' => [
        'pagebuilder',
        'pagebuilder::blocks',
        'cms::pagebuilder',
        'blog::pagebuilder',
        'store::pagebuilder',
        // 'donate::pagebuilder',
    ],

     // TypeDescriptor classes to ignore
     'disabled_types' => [
        
    ],

    'defaults' => [
        'row' => [
            'styles' => [
                'padding_left' => '20px',
                'padding_right' => '20px',
                'padding_top' => '20px',
                'padding_bottom' => '20px',
                'align_items' => 'center',
            ]
        ]
    ],


    'container_layouts' => [

        'single' => [
            'title'=>'Single Block',
            'thumbnail'=>'', // for later use on a blockselect field... one step at a time
            'columns'=>1,
            'grid-template-columns'=>[
                'lg'=>'1fr',
                'md'=>'1fr',
                'sm'=>'1fr',
            ]
        ],
        
        'double' => [
            'title'=>'Two Columns (even)',
            'thumbnail'=>'', // for later use on a blockselect field... one step at a time
            'columns'=>2,
            'grid-template-columns'=>[
                'lg'=>'1fr 1fr',
                'md'=>'1fr',
                'sm'=>'1fr',
            ]
        ],

        'double-weighted-left' => [
            'title'=>'Two Columns (60/40)',
            'thumbnail'=>'', // for later use on a blockselect field... one step at a time
            'columns'=>2,
            'grid-template-columns'=>[
                'lg'=>'6fr 4fr',
                'md'=>'1fr',
                'sm'=>'1fr',
            ]
        ],

        'double-weighted-right' => [
            'title'=>'Two Columns (40/60)',
            'thumbnail'=>'', // for later use on a blockselect field... one step at a time
            'columns'=>2,
            'grid-template-columns'=>[
                'lg'=>'4fr 6fr',
                'md'=>'1fr',
                'sm'=>'1fr',
            ]
        ],

        'triple' => [
            'title'=>'Three Columns',
            'thumbnail'=>'', // for later use on a blockselect field... one step at a time
            'columns'=>3,
            'grid-template-columns'=>[
                'lg'=>'1fr 1fr 1fr',
                'md'=>'1fr',
                'sm'=>'1fr',
            ]
        ],

     
    ]
    
];
