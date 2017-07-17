<?php

           Route::get('/','Http\GearsController@getIndex');
//           Route::get('/free-styles','Http\FreeStylesController@getIndex');
           Route::get('/h-f','Http\HFController@getIndex');
           Route::get('/layouts','Http\LayoutController@getIndex');
           Route::get('/main-body','Http\MainBodyController@getIndex');
           Route::get('/themed-styles','Http\ThemedStylesController@getIndex');
            //units
            Route::get('/units','Http\UnitsController@getIndex');
            Route::post('/units/delete', 'Http\UnitsController@postDelete');
            Route::post('/units/unit-with-type','Http\UnitsController@postUnitWithType');
            Route::get('/units/units-variations/{slug}', 'Http\UnitsController@getUnitVariations');
            Route::post('/units/units-variations/{slug}', 'Http\UnitsController@postUnitVariations');
            Route::get('/units/delete-variation/{slug}', 'Http\UnitsController@getDeleteUnit');
            Route::post('/units/upload-unit', 'Http\UnitsController@postUploadUnit');

            Route::get('/units/live-settings/{slug}', 'Http\UnitsController@unitPreview');
            Route::get('/units/settings-iframe/{slug}/{settings?}', 'Http\UnitsController@unitPerviewIframe');
            Route::post('/units/settings/{id}/{save?}', 'Http\UnitsController@postSettings');
            Route::any('/units/make-default/{slug}', 'Http\UnitsController@getMakeDefault');
            Route::any('/units/make-default-variation/{slug}', 'Http\UnitsController@getDefaultVariation');