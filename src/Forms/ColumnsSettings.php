<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Fields\Checkbox;
use AscentCreative\Forms\Fields\FileUpload;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\CompoundDate;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\ValueWithUnits;

use Illuminate\Support\Arr;

class ColumnsSettings extends Form {

    public function __construct($name, $data) {

        $this->children([
            
            Tabs::make('tabs', 'tabs')
                ->styled(false)
                ->children([

                    Tab::make('tab_layout', 'Layout')
                        ->children([
                            ValueWithUnits::make($name . '[i][gap]', 'Gap', ['px', 'rem']),
                        ]),

                    Tab::make('tab_spacing', 'Spacing')
                        ->children([
                            HTML::make('<div class="border p-2"><strong>Padding:</strong>', '</div>')
                                ->children([
                                    HTML::make('<div class="flex">', '</div>')
                                        ->children([
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[s][padding_top]', 'Top', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[s][padding_bottom]', 'Bottom', ['px', '%', 'em']),
                                                ]),
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[s][padding_left]', 'Left', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[s][padding_right]', 'Right', ['px', '%', 'em']),
                                                ])
                                        ])
                                   
                            ]),
                            HTML::make('<div class="border p-2 mt-2"><strong>Margin:</strong>', '</div>')
                                ->children([
                                    HTML::make('<div class="flex">', '</div>')
                                        ->children([
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[s][margin_top]', 'Top', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[s][margin_bottom]', 'Bottom', ['px', '%', 'em']),
                                                ]),
                                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                                ->children([
                                                    ValueWithUnits::make($name . '[s][margin_left]', 'Left', ['px', '%', 'em']),
                                                    ValueWithUnits::make($name . '[s][margin_right]', 'Right', ['px', '%', 'em']),
                                                ])
                                        ])
                                   
                                ])

                           
                        ]),
                    
                        Tab::make('tab_bg', 'Background')
                            ->children([
                                Subforms\Background::make($name)
                            ]),
                ]),
            
        ]);

        
        if($data) {
        $dot = collect(Arr::dot(json_decode(json_encode($data), true)))
                    ->mapWithKeys(function($item, $key) use ($name) {
                        return [dotname($name) . '.' . $key => $item];
                    })->toArray();


        $data = Arr::undot($dot);

                } else {
                    $data = [];
                }

        $this->populate($data, $name);
    }

}