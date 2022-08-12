<?php

use AscentCreative\Transact\Transact;

use Illuminate\Support\Facades\Validator;


Route::middleware(['web'])->group(function() {
  
    // Route::get('/donate', function() {
    //     return view('donate::index');
    // });

    Route::post('/donate-test', function() {

        Validator::validate(request()->all(),
            [
                'amount'=>'required',
                'name'=>'required',
            ]);

        $dp = AscentCreative\Donate\Models\DonationProfile::create([
            'donor_name'=>request()->name,
            'donor_email'=>request()->email,
            'amount'=>request()->amount,
            'recur'=>request()->recur,
        ]);

        
        if(request()->recur == 'S') {
            return Transact::start($dp);
        } else {
            return Transact::subscribe($dp);
        }
        
    })->name('donate.transact');


      /** Admin Routes */
      Route::prefix('admin/donate')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

        // settings modal:
        Route::get('settings', function() {

            $settings = app(\AscentCreative\Donate\Settings\DonateSettings::class);
            $form = new \AscentCreative\Donate\Forms\Admin\Settings();

            $form->populate($settings);

            return view('donate::admin.settings.modal', ['form'=>$form]);
        });

        Route::post('settings', function() {
            
            $form = new \AscentCreative\Donate\Forms\Admin\Settings();
            $form->validate(request()->all());

            $settings = app(\AscentCreative\Donate\Settings\DonateSettings::class);
            $settings->fill(request()->all());
            $settings->save();

        }); 


      });


  
});

