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
                            HTML::make('<div class="border p-2"><strong>Image:</strong>', '</div>')
                                ->children([
                                    FileUpload::make($name . '[styles][background_image]', 'Image'),
                                    Options::make($name . '[styles][background_size]', 'Size')
                                        ->options([
                                            'contain' => "Show the whole image",
                                            'cover' => "Fill the background"
                                        ]),
                                    Checkbox::make($name . '[styles][background_repeat]', 'Repeat?')
                                       ->checkedValue('repeat')->uncheckedValue('no-repeat'),
                                    Options::make($name . '[styles][background_position]', 'Position')
                                       ->options([
                                           'center' => "Center",
                                           'top' => "Top",
                                           'bottom' => "Bottom",
                                       ]),
                                    Checkbox::make($name . '[options][curtain]', 'Darken?')
                                       ->description('Darken the image so text will show more clearly')
                                       ->checkedValue(1)->uncheckedValue(0),
                                    Checkbox::make($name . '[options][parallax]', 'Parallax?')
                                       ->description('If checked, the image will scroll at a diffrent rate to the rest of the page. Image position will change.')
                                       ->checkedValue(1)->uncheckedValue(0),
                            ]),

                            HTML::make('<div class="border p-2"><strong>Colour:</strong>', '</div>')
                                ->children([
                                    Input::make($name . '[styles][background_color]', 'Colour')
                                        ->description('The colour will be behind any image specified above.'),
                                ]),
                            
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