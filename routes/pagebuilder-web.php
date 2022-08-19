<?php

use AscentCreative\Transact\Transact;

use Illuminate\Support\Facades\Validator;


Route::middleware(['web'])->group(function() {
  

    Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

        // rows have an initial block type.
        Route::post('/pagebuilder/makerow/{type}/{name}/{idx}', function($type, $name, $idx) {
            return view('pagebuilder::make.row')->with('blockType', $type)->with('name', $name)->with('idx', $idx)->with('value', null);
        });

        // make a block to add to an existing row.
        Route::get('/stack/make-block/{type}/{name}/{cols}', function($type, $name, $cols) {
            return view('stackeditor::make.block')->with('blockType', $type)->with('name', $name)->with('cols', $cols); 
        });

        Route::get('/pagebuilder/iframe/{data}', function($data) {
            return view('pagebuilder::iframe', ['data'=>$data]);
        });

        Route::get('/pagebuilder/iframe-init', function() {
            return view('pagebuilder::iframe-init');
        });

        Route::post('/pagebuilder/iframe', function() {
            return view('pagebuilder::iframe', ['data'=>request()->all()]);
        });

    

    });

  
});

