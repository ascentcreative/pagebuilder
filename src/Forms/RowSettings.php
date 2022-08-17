<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\FileUpload;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\CompoundDate;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\ValueWithUnits;

use Illuminate\Support\Arr;

class RowSettings extends Form {

    public function __construct($name, $data) {

        $this->children([
            
            Tabs::make('tabs', 'tabs')
                ->styled(false)
                ->children([
                    Tab::make('tab_spacing', 'Spacing')
                        ->children([
                            HTML::make('<div class="border p-2"><strong>Padding:</strong>', '</div>')
                                ->children([
                                    HTML::make('<div class="flex">', '</div>')
                                        ->children([
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[styles][padding_top]', 'Top', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[styles][padding_bottom]', 'Bottom', ['px', '%', 'em']),
                                                ]),
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[styles][padding_left]', 'Left', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[styles][padding_right]', 'Right', ['px', '%', 'em']),
                                                ])
                                        ])
                                   
                            ]),
                            HTML::make('<div class="border p-2 mt-2"><strong>Margin:</strong>', '</div>')
                                ->children([
                                    HTML::make('<div class="flex">', '</div>')
                                        ->children([
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[styles][margin_top]', 'Top', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[styles][margin_bottom]', 'Bottom', ['px', '%', 'em']),
                                                ]),
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[styles][margin_left]', 'Left', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[styles][margin_right]', 'Right', ['px', '%', 'em']),
                                                ])
                                        ])
                                   
                                ])

                           
                        ]),
                    Tab::make('tab_bg', 'Background')
                        ->children([
                            FileUpload::make($name . '[styles][background_image]', 'Image'),
                            Options::make($name . '[styles][background_size]', 'Size')
                                ->options([
                                    'contain' => "Show the whole image",
                                    'cover' => "Fill the background"
                                ]),
                            Input::make($name . '[styles][background_repeat]', 'Repeat', 'hidden')
                                ->value('norepeat')->wrapper('none'),
                            Input::make($name . '[styles][background_color]', 'Background Colour'),
                        ]),
                ]),
            
        ]);

       
        $data = [
            'content' => [
                'rows' =>
                    [
                        $data
                    ]
                
            ]
        ];
        
        // dump($data);

        $this->populate($data);
    }

}