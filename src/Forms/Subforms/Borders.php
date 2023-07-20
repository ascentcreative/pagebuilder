<?php
namespace AscentCreative\Pagebuilder\Forms\Subforms;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\ForeignKeySelect;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\ValueWithUnits;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Files\Fields\FileUpload;

class Borders extends Subform {

    public $name;

    public function __construct($name) {

        parent::construct('sf_borders');
        $this->name = $name;

    }

    public function initialise() {

        return $this->children([
                            HTML::make('<div class="border p-2 mb-2"><strong>Borders:</strong>', '</div>')
                                ->children([

                                    Options::make($this->name . '[s][border_style]', 'Style')
                                        ->nullItemLabel('None')
                                        ->options([
                                            'solid' => 'Solid',
                                            'dashed' => 'Dashed'
                                        ]),
                                    ValueWithUnits::make($this->name . '[s][border_width]', 'Thickness', ['px', 'em']),
                                    Colour::make($this->name . '[s][border_color]', 'Colour')
                                        ->manualInit(true),
                                        // ->description('The colour will be behind any image specified above.'),
                                 
                            ]),                       
                   
        ]);

    }

}
