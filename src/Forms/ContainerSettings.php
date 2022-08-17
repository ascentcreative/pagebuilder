<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\CompoundDate;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\ValueWithUnits;

use Illuminate\Support\Arr;

class ContainerSettings extends Form {

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
                            Input::make($name . '[styles][background_color]', 'Background Colour'),
                        ]),
                ]),
            
        ]);

       
        $data = [
            'content' => [
                'rows' =>
                    [
                        'containers' => [
                            $data
                        ]
                    ]
                
            ]
        ];
        
        // dump($data);

        $this->populate($data);
    }

}