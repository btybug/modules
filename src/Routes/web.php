<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['prefix' => 'config'], function () {
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/tables/{active?}', 'ConfigController@getTables');
        Route::get('/assets', 'ConfigController@getAssets');
        Route::get('/info', 'ConfigController@getInfo');
        Route::get('/forms', 'ConfigController@getForm');
        Route::get('/permission', 'ConfigController@getPermission');
        Route::get('/codes', 'ConfigController@getCodes');
        Route::get('/views', 'ConfigController@getViews');
        Route::get('/menus', 'ConfigController@getMenus');
        Route::get('/gears', 'ConfigController@getGears');
        Route::get('/buildb', 'ConfigController@getBuildB');
        Route::get('/buildb/pages', 'ConfigController@getBuildB');
//admin urls
        Route::get('/buildb/urls', 'ConfigController@getBuildBUrls');
        Route::get('/buildb/menus', 'ConfigController@getBuildBMenus');
        Route::get('/build', 'ConfigController@getBuild');
        Route::get('/gearsb', 'ConfigController@getGearsB');
        Route::get('/pages', 'ConfigController@getPages');
        Route::post('/tables', 'ConfigController@getTables');
        Route::post('/all', 'ConfigController@getAll');
        Route::post('/forms', 'ConfigController@getForm');
        Route::post('/permission', 'ConfigController@getPermission');
        Route::post('/codes', 'ConfigController@postCodes');
        Route::post('/views', 'ConfigController@getViews');
        Route::get('/pages', 'ConfigController@getPages');
        Route::get('/fields', 'ConfigController@getFields');
        Route::get('/file-content', 'ConfigController@getFileContent');
    });
    Route::post('/build/admin-urls/save-data', 'ConfigController@postUrlsSettings');

    Route::post('/menus/parents', 'ConfigController@postMenus');
    Route::get('/page-preview/{page_id}', 'ConfigController@getPagePreview');
    Route::post('/page-preview/{page_id}', 'ConfigController@postSavePageSettings');
    Route::post('/get-fields-html', 'ConfigController@getFieldsHtml');
    Route::get('/create-field', 'ConfigController@getCreateField');
    Route::get('/create-form/{slug}/{table}/{main?}', 'ConfigController@getCreateForm');
    Route::post('/create-form/{slug}/{table}', 'ConfigController@postCreateForm');
    Route::post('/get-fields/{slug}', 'ConfigController@postTableFields');
    Route::post('/select-fields', 'ConfigController@postSelectFields');
    //test
    Route::get('/create-test-form/{slug}', 'ConfigController@getCreatetestForm');
    Route::get('/menus/{slug}/{menu}', 'ConfigController@editDefaultMenu');
});
//test
Route::get('/testview', 'ConfigController@getTestView');
//gears
Route::group(['prefix' => 'gears'], function () {
    Route::get('/', 'GearsController@getDefoult');
    Route::get('/frontend-end', 'GearsController@getIndex');
    Route::get('/back-end', 'GearsController@getBackend');
    Route::post('/get-gears-lists', 'GearsController@getGearsLists');
    Route::post('/admin-pages-layout', 'GearsController@getPageLayout');

});


//modules
Route::get('/view/{slug?}', 'ModulesController@getView');
Route::get('/extra/{slug?}', 'ModulesController@getExtra');
Route::post('/upload', 'ModulesController@postUpload');
Route::post('/delete', 'ModulesController@postDelete');
Route::post('/core-enable', 'ModulesController@postCoreEnable');
Route::post('/enable', 'ModulesController@postEnable');
Route::post('/disable', 'ModulesController@postDisable');
Route::get('/', 'ModulesController@getIndex');
Route::get('/optimisation', function () {

    Artisan::call('plugin:optimaze');
    return redirect()->back()->with(['flash' => ['message' => 'modules optimisation successfully!!!']]);
});

//generate
Route::get('/generate', 'GenerateController@getIndex');
Route::post('/generate', 'GenerateController@postGenerateModule');


//DEVELOPERS
Route::group(['prefix' => 'tables'], function() {
    Route::get('/', 'Developers\StructureController@getIndex');
    Route::get('/edit/{table}', 'Developers\StructureController@getEditTable');
    Route::get('/add-column/{table}', 'Developers\StructureController@getAddColumn');
    Route::post('/add-column/{table}', 'Developers\StructureController@postAddColumn');
    Route::get('/edit-column/{table}/{column}', 'Developers\StructureController@getEditTableColumn');
    Route::post('/edit-column/{table}/{column}', 'Developers\FormsController@postFields');
    Route::get('/delete-column/{table}/{column}', 'Developers\StructureController@postDeleteColumn');
    Route::post('/edit-column-field/{table}/{column}', 'Developers\StructureController@postEditColumnField');
    Route::get('/render-column-field/{table}/{column}', 'Developers\StructureController@postLiveColumnField');
    Route::get('/column-field-iframe/{table}/{column}', 'Developers\StructureController@getIframe');
    Route::get('/column-field-search-iframe/{table}/{column}', 'Developers\StructureController@getSearchIframe');
    Route::post('/field-live-save/{table}/{column}', 'Developers\StructureController@saveFieldData');
    Route::post('/search-field-live-save/{table}/{column}', 'Developers\StructureController@saveSearchFieldData');
    Route::post('/field-live-preview', 'Developers\StructureController@postFieldLivePreview');
    Route::post('/search-field-live-preview', 'Developers\StructureController@postSearchFieldLivePreview');
    Route::get('/table-names', 'Developers\StructureController@postTableNames');
    Route::post('/get-table-columns', 'Developers\StructureController@postTableColumns');
    Route::get('/optimize', function () {
        Artisan::call('forms:optimize');
        return redirect('admin');
    });
    Route::get('/create', 'Developers\StructureController@getCreate');
    Route::post('/create', 'Developers\StructureController@postCreate');
    Route::get('/fields/{table}/{column}', 'Developers\FormsController@getFields');
//    Route::post('/fields/{table}/{column}', 'Developers\FormsController@postFields');
    Route::group(['prefix' => 'field'], function() {
        Route::get('/add-new-field/{count}', 'Developers\FormsController@addNewField');
        Route::post('/delete', 'Developers\FormsController@deleteField');
        Route::get('/render-column-fields/{table}/{column}', 'Developers\FormsController@renderColumnFields');
    });
});

Route::get('/backend-theme', 'Developers\StructureController@getBackendTheme');
Route::get('/forms', 'Developers\StructureController@getForms');

Route::post('/module-data', 'Developers\StructureController@postModuleData');

Route::get('/menus', 'Developers\StructureController@getMenus');

//pages
Route::post('/pages/pages-data', 'Developers\AdminPagesController@postPagesData');
Route::post('/pages/module-data', 'Developers\AdminPagesController@postModuleData');
Route::post('/pages/create', 'Developers\AdminPagesController@postCreate');
Route::get('/pages/list', 'Developers\AdminPagesController@getIndex');

//forms
Route::get('/forms/render/{id}', 'Developers\FormsController@renderForm');
Route::get('/forms/create', 'Developers\FormsController@getCreate');
Route::post('/forms/getColumns', 'Developers\FormsController@getColumns');
Route::post('/forms/save', 'Developers\FormsController@postSave');

// themes
Route::group(['prefix' => '/theme', 'middleware' => ['admin:Users']], function () {
    Route::get('/', 'ThemeController@getIndex');
    Route::get('/front-themes-activate/{slug}', 'ThemeController@activateFrontTheme');
    Route::get('/variations/{slug}', 'ThemeController@getTplVariations');
    Route::post('/variations/{slug}', 'ThemeController@postTplVariations');
    Route::get('/settings-live-layout/{slug}', 'ThemeController@layoutPreview');
    Route::post('/front-layout-settings/{slug}', 'ThemeController@frontLayoutSettings');
    Route::get('/settings-iframe-layout/{slug}', 'ThemeController@iframeLayout');
    Route::post('/editvariation', 'ThemeController@postEditVariation');
    Route::post('/templates-with-type', 'ThemeController@postTemplatesWithType');
    Route::post('/upload', 'ThemeController@postUpload');
    Route::post('/delete', 'ThemeController@postDelete');
});
Route::group(['prefix' => '/bburl'], function () {
    Route::any('/unit/{slug}', 'Developers\BBurlsController@BBunit');
    Route::any('/get-heading/{id}', 'Developers\BBurlsController@getHeading');
    Route::any('/get-heading-keys', 'Developers\BBurlsController@getFileSourcehedindKeys');
    Route::post('/unit-main', 'Developers\BBurlsController@getUnitMain');
    Route::post('/unit-main-default', 'Developers\BBurlsController@getUnitMainDefault');
    Route::post('/get-form-field-options', 'Developers\BBurlsController@getFormFieldOptions');
    Route::post('/get-field-options-live', 'Developers\BBurlsController@getFieldOptionsLive');
    Route::any('/layout', 'Developers\BBurlsController@BBlayout');
    Route::post('/get-tables-lists','Developers\BBurlsController@getTableLists');
    Route::post('/get-table-columns','Developers\BBurlsController@getTableColums');
    Route::post('/get-column-rules','Developers\BBurlsController@getColumnRules');
    Route::post('/get-file-data','Developers\BBurlsController@getFileData');
    Route::post('/get-file-list','Developers\BBurlsController@getFileListing');
    Route::post('/get-field-units','Developers\BBurlsController@getFieldUnitListing');
    Route::post('/get-field-unit','Developers\BBurlsController@getFieldUnit');
    Route::post('/get-page-layout-config-toarray','Developers\BBurlsController@getPageLayoutConfigToArray');
    Route::post('/get-page-section-config-toarray','Developers\BBurlsController@getPageSectionConfigToArray');
    Route::post('/get-bb-output', 'Developers\BBurlsController@getBBFunctionOutput');
    Route::post('/get-output-bb', 'Developers\BBurlsController@getBBFunction');
    Route::post('/get-section-render-and-data', 'Developers\BBurlsController@getSectionRenderAndData');
});


Route::group(['prefix' => '/tests'], function () {
    Route::get('/form-test', 'TestController@getFormTest');
});

Route::group(['prefix' => '/admin/plugins'], function () {
    Route::get('/setting/{slug}', 'PluginsController@getSettings');
});