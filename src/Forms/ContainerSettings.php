<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Checkbox;
use AscentCreative\Forms\Fields\FileUpload;
use AscentCreative\Forms\Fields\Options;
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

                    Tab::make('tab_size', 'Size')
                        ->children([

                            ValueWithUnits::make($name . '[styles][max_width]', 'Width', ['px', '%'])
                                ->description('The width of the screen to use for the content. Leave blank for the default centralised portion, or enter values in % or px. <br/>
                                <strong>Examples:<br/></strong>
                                <code>100%</code> will use the full screen width.<br/>
                                <code>500px</code> will use the central 500px of the screen (or shrink if narrower)'),

                        ]),

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

                            HTML::make('<div class="border p-2"><strong>Image:</strong>', '</div>')
                                ->children([
                                    FileUpload::make($name . '[styles][background_image]', 'Image'),
                                    Options::make($name . '[styles][background_size]', 'Size')
                                        ->options([
                                            'contain' => "Show the whole image",
                                            'cover' => "Fill the background"
                                        ]),
                                    Checkbox::make($name . '[styles][background_repeat]', 'Repeat')
                                       ->checkedValue('repeat')->uncheckedValue('no-repeat'),

                          
                            ]),
                            
                            Input::make($name . '[styles][background_color]', 'Background Colour'),
                        ]),
                ]),
            
        ]);

        

        $dot = collect(Arr::dot(json_decode(json_encode($data), true)))
                    ->mapWithKeys(function($item, $key) use ($name) {
                        return [dotname($name) . '.' . $key => $item];
                    })->toArray();


        $data = Arr::undot($dot);

        $this->populate($data, $name);
    }

}