<?php
namespace AscentCreative\Pagebuilder\Forms\Subforms;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Structure\Html;
use AscentCreative\Forms\Fields\ForeignKeySelect;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\Checkbox;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Files\Fields\FileUpload;

class Background extends Subform {

    public $name;

    public function __construct($name) {

        parent::construct('sf_background');
        $this->name = $name;

    }

    public function initialise() {

        return $this->children([
                            HTML::make('<div class="border p-2 mb-2"><strong>Image:</strong>', '</div>')
                                ->children([
                                    FileUpload::make($this->name . '[s][background_image]', 'Image'),

                                    Options::make($this->name . '[s][background_size]', 'Size')
                                        ->options([
                                            'contain' => "Show the whole image",
                                            'cover' => "Fill the background"
                                        ])->default('cover'),
                                    // Checkbox::make($name . '[o][parallax]', 'Parallax?')
                                    //    ->checkedValue('1')->uncheckedValue('0')
                                    //    ->description('Scrolls the background image at a different speed to the main page (no effect on mobile)'),
                                    Checkbox::make($this->name . '[s][background_repeat]', 'Repeat?')
                                       ->checkedValue('repeat')->uncheckedValue('no-repeat'),
                                    Options::make($this->name . '[s][background_position]', 'Position')
                                       ->options([
                                           'center' => "Center",
                                           'top' => "Top",
                                           'bottom' => "Bottom",
                                       ])->default('center'),
                                    // Checkbox::make($name . '[options][curtain]', 'Darken?')
                                    //    ->description('Darken the image so text will show more clearly')
                                    //    ->checkedValue(1)->uncheckedValue(0),
                                    // Checkbox::make($name . '[options][parallax]', 'Parallax?')
                                    //    ->description('If checked, the image will scroll at a different rate to the rest of the page. Image position will change.')
                                    //    ->checkedValue(1)->uncheckedValue(0),
                            ]),

                            HTML::make('<div class="border p-2"><strong>Colour:</strong>', '</div>')
                                ->children([
                                    Colour::make($this->name . '[s][background_color]', 'Colour')
                                        ->manualInit(true)
                                        ->description('The colour will be behind any image specified above.'),
                                ]),
                            
                   

        ]);

    }

}
