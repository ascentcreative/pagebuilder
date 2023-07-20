<?php
namespace AscentCreative\Pagebuilder\Forms\Subforms;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Structure\Html;
use AscentCreative\Forms\Fields\ForeignKeySelect;
use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\ValueWithUnits;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Structure\Tabs;
use AscentCreative\Forms\Structure\Tab;
use AscentCreative\Files\Fields\FileUpload;

class Padding extends Subform {

    public $name;

    public function __construct($name) {

        parent::construct('sf_padding');
        $this->name = $name;

    }

    public function initialise() {

        return $this->children([
            
            HTML::make('<div class="border p-2"><strong>Padding:</strong>', '</div>')
                ->children([
                    HTML::make('<div class="flex">', '</div>')
                        ->children([
                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                ->children([
                                    ValueWithUnits::make($this->name . '[s][padding_top]', 'Top', ['px', '%', 'em']),
                                    ValueWithUnits::make($this->name . '[s][padding_bottom]', 'Bottom', ['px', '%', 'em']),
                                ]),
                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                ->children([
                                    ValueWithUnits::make($this->name . '[s][padding_left]', 'Left', ['px', '%', 'em']),
                                    ValueWithUnits::make($this->name . '[s][padding_right]', 'Right', ['px', '%', 'em']),
                                ])
                        ])

                ])
                            
        ]);

    }

}
