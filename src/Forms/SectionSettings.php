<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Fields\Checkbox;
// use AscentCreative\Forms\Fields\FileUpload;
use AscentCreative\Files\Fields\FileUpload;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\Code;
use AscentCreative\Forms\Fields\CompoundDate;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\ValueWithUnits;
use AscentCreative\Forms\Fields\DateTime;

use AscentCreative\PageBuilder\Forms\Subforms\Background;

use Illuminate\Support\Arr;

class SectionSettings extends Form {

    public function __construct($name, $data) {

        $this->children([
            
            Tabs::make('tabs', 'tabs')
                ->styled(false)
                ->children([
                    Tab::make('tab_layout', 'Layout')
                        ->children([

                            ValueWithUnits::make($name . '[i][max_width]', 'Content Width', ['px', '%'])
                                ->description('The width of the screen to use for the content. Leave blank for the default centralised portion, or enter values in % or px. <br/>
                                <strong>Examples:<br/></strong>
                                <code>100%</code> will use the full screen width.<br/>
                                <code>500px</code> will use the central 500px of the screen (or shrink if narrower)'),

                            // Input::make($name . '[o][class]', 'Template'),

                            ValueWithUnits::make($name . '[s][min_height]', 'Height', ['px', 'vh']),
                                // ->description('The width of the screen to use for the content. Leave blank for the default centralised portion, or enter values in % or px. <br/>
                                // <strong>Examples:<br/></strong>
                                // <code>100%</code> will use the full screen width.<br/>
                                // <code>500px</code> will use the central 500px of the screen (or shrink if narrower)'),

                            Options::make($name . '[s][justify_content]', 'Vertical Alignment')
                                ->options(['flex-start' =>'Top', 'center' => 'Middle', 'flex-end' => 'Bottom'])
                                ->includeNullItem(false)->default('center'),

                            Options::make($name . '[s][align_items]', 'Horizontal Alignment')
                                ->options(['flex-start' =>'Left', 'center' => 'Center', 'flex-end' => 'Right'])
                                ->includeNullItem(false)->default('center'),

                                ValueWithUnits::make($name . '[i][gap]', 'Child spacing', ['px', 'rem', '%'])
                                ->description('The size of the gap between each child element'),

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
                            Background::make($name)
                        ]),

                    Tab::make('tab_publish', 'Publishing / Visibility')
                        ->children([

                            Checkbox::make($name .'[o][visible][status]', 'Visible')
                                ->checkedValue(1)
                                ->uncheckedValue(0)
                                ->default(1),

                            DateTime::make($name . '[o][visible][from]', 'Visible From'),
                            DateTime::make($name . '[o][visible][to]', 'Visible To')
                            
                        ]),

                    Tab::make('tab_adv', 'Advanced')
                        ->children([
                            Code::make($name . '[o][custom_css]', 'Custom CSS'),
                        ]),
                ]),


            
        ]);


        if($data) {

            $dot = collect(Arr::dot(json_decode(json_encode($data), true)))
                        ->mapWithKeys(function($item, $key) use ($name) {
                            return [dotname($name) . '.' . $key => $item];
                        })->toArray();


            $data = json_decode(json_encode(Arr::undot($dot)));

        } else {
            $data = [];
        }

        $this->populate($data, $name);
        
    }

  


}