<?php

use AscentCreative\Transact\Transact;

use Illuminate\Support\Facades\Validator;


Route::middleware(['web'])->group(function() {
  

    Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

        // rows have an initial block type.
        Route::post('/pagebuilder/makerow/{template}/{name}/{idx}', function($template, $name, $idx) {

            $defaults = [
                'containers' => [
                    uniqid() => [
                        'blocks' => [
                            uniqid() => [
                                'template' => $template,
                            ]
                        ]
                    ]
                ]
            ];

            $defaults = array_merge($defaults, config('pagebuilder.defaults.row'));

            $defaults = json_decode(json_encode($defaults));
            // dd($defaults);

            return view('pagebuilder::make.row')->with('defaults', $defaults)->with('template', $template)->with('name', $name)->with('idx', $idx)->with('value', null);


        });

        // make a block to add to an existing row.
        Route::post('/pagebuilder/makeblock', function() {
            return view('pagebuilder::make.block'); //->with('blockType', $type)->with('name', $name)->with('cols', $cols); 
        });

        Route::get('/pagebuilder/iframe/{data}', function($data) {
            return view('pagebuilder::iframe', ['data'=>$data]);
        });
        Route::post('/pagebuilder/iframe', function() {
            return view('pagebuilder::iframe', ['data'=>request()->all()]);
        });

    

    });

  
});

