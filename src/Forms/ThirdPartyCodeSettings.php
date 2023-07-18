<?php
namespace AscentCreative\PageBuilder\Forms;

use AscentCreative\Forms\Form;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Colour;
use AscentCreative\Forms\Fields\Code;
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

class ThirdPartyCodeSettings extends Form {

    public function __construct($name, $data) {

        $this->children([
            
            Tabs::make('tabs', 'tabs')
                ->styled(false)
                ->children([
                    Tab::make('tab_layout', 'Code')
                        ->children([

                          Code::make($name . '[code]', 'Embed Code')
                            ->description('IMPORTANT: Only paste code from trusted sites where you can be sure of what the code will do'),
                          

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