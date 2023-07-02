<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Fields\Checkbox;
// use AscentCreative\Forms\Fields\FileUpload;
use AscentCreative\Files\Fields\FileUpload;
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

                            Options::make($name . '[options][container_layout]', "Layout")
                                // ->options([
                                //     'single'=>'Single Column',
                                //     '-2'=>'Two Columns (even)',
                                //     'cols-40-60'=>'Two Columns (40/60 split)',
                                //     'cols-3'=>'Three Columns'
                                // ]),
                                ->options(
                                    collect(config('pagebuilder.container_layouts'))->mapWithKeys(function($item, $key) {
                                        return [ $key => $item['title'] ];
                                    })->toArray()
                                )->includeNullItem(false),

                            ValueWithUnits::make($name . '[s][max_width]', 'Width', ['px', '%'])
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

                            HTML::make('<div class="border p-2 mb-2"><strong>Image:</strong>', '</div>')
                                ->children([
                                    FileUpload::make($name . '[s][background_image]', 'Image'),
                                    Options::make($name . '[s][background_size]', 'Size')
                                        ->options([
                                            'contain' => "Show the whole image",
                                            'cover' => "Fill the background"
                                        ]),
                                    Checkbox::make($name . '[s][background_repeat]', 'Repeat')
                                       ->checkedValue('repeat')->uncheckedValue('no-repeat'),

                          
                            ]),
                            
                            HTML::make('<div class="border p-2"><strong>Colour:</strong>', '</div>')
                                ->children([
                                    Colour::make($name . '[s][background_color]', 'Colour')
                                        ->manualInit(true)
                                        ->description('This colour will be behind any image specified above.'),
                                ]),
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