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

class ImageSettings extends Form {

    public function __construct($name, $data) {

        $this->children([
            
            Tabs::make('tabs', 'tabs')
                ->styled(false)
                ->children([
                    Tab::make('tab_layout', 'Layout')
                        ->children([

                            ValueWithUnits::make($name . '[s][width]', 'Width', ['px', '%'])
                                ->description('The width of the screen to use for the image. Leave blank to match the container size. <br/>
                                <strong>Examples:<br/></strong>
                                <code>100%</code> will use the full screen width.<br/>
                                <code>500px</code> will use the central 500px of the screen (or shrink if narrower)'),

                            ValueWithUnits::make($name . '[s][height]', 'Height', ['px', '%'])
                                ->description('The width of the screen to use for the image. Leave blank to match the container size. <br/>
                                <strong>Examples:<br/></strong>
                                <code>100%</code> will use the full screen width.<br/>
                                <code>500px</code> will use the central 500px of the screen (or shrink if narrower)'),

                            Options::make($name . '[i][object_fit]', 'Display')
                                ->options([
                                    'contain'=>'Scale to fit',
                                    'fill'=>'Stretch to fit',
                                    'cover'=>'Crop to fit',
                                ]),
                          

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