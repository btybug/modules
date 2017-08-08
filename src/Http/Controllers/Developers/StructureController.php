<?php
/**
 * Copyright (c) 2016.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace Sahakavatar\Modules\Http\Controllers\Developers;

use Sahakavatar\Cms\Helpers\helpers;
use App\helpers\ExcelHelper;
use App\Http\Controllers\Controller;
use App\Models\Moduledb;
use Sahakavatar\Cms\Models\Templates\Units;
use Sahakavatar\Cms\Models\Widgets;
use Sahakavatar\Modules\Models\Models\AdminPages;
use Sahakavatar\Modules\Models\Models\Fields;
use Sahakavatar\Modules\Models\Models\Migrations;
use Illuminate\Http\Request;
use Validator;

/**
 * Class ModulesController
 * @package Sahakavatar\Modules\Models\Http\Controllers
 */
class StructureController extends Controller
{
    /**
     * @var dbhelper
     */
    public $dbhelper;

    /**
     * StructureController constructor.
     */
    public function __construct ()
    {
        parent::__construct();
        $this->data = [
            'pageTitle' => 'Database',
            'pageNote'  => 'Manage Database Tables',

        ];

        $this->dbhelper = new dbhelper;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $tables = \DB::select('SHOW TABLES');

        return view("modules::developers.structure.tables", compact(['tables']));
    }

    /**
     * @param $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditTable ($table)
    {
        $colums = \DB::select('SHOW COLUMNS FROM ' . $table);
        $config_path = base_path('app/Modules/Modules/table_config.json');
//        $config = (json_decode(\File::get($config_path), true));
        $core = [];
//        if (isset($config[$table])) {
            foreach ($colums as $k => $colum) {

//                if ($colum->Null == "NO") {
//                    $colums[$k]->Null = 'required';
//                } else {
//                    $colums[$k]->Null = 'not required';
//                };
                unset($colums[$k]->Null);
                if (isset($config[$table][$colum->Field])) {
                    $core[$colum->Field] = 1;
                    $colums[$k]->field = $config[$table][$colum->Field]['field'];
                } else {
                    $colums[$k]->field = 'no';
                }
            }
//        }

        return view("modules::developers.structure.tables.columns", compact(['colums', 'table', 'core']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate ()
    {
        $this->data['default'] = ['NULL', 'USER_DEFINED', 'CURRENT_TIMESTAMP'];
        $this->data['tbtypes'] = Migrations::types();
        $this->data['engine'] = Migrations::engine();

        return view('modules::developers.structure.tables.create', $this->data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate (Request $request)
    {
        $data = $request->all();
        $v = Validator::make($data, [
            'name'        => 'required|alpha_num',
            'engine_type' => 'required'
        ]);
        if ($v->fails()) return \Response::json(['error' => true, 'arrm' => true, 'message' => $v->errors()]);

        return Migrations::migrate($data);
    }

    /**
     * @param $table
     * @param $column
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIframe ($table, $column)
    {
        $field = Fields::where('table_name', $table)->where('column_name', $column)->first();
        $variations = Widgets::where('default', 1)->where('main_type', 'fields')->first()->variations();
        $editable = null;
        $json_data = null;
        if ($field) {
            $json_data = $field->toArray();
        }
        if (isset($json_data['unit'])) {
            $vid = explode('.', $json_data['unit']);
            $unit = Units::find($vid[0]);
            $json_data['unit_input_type'] = $unit->input_type;
        }
        if ($variations) {
            foreach ($variations as $variation) {
                if ($variation->default) {
                    $json_data['widget'] = $variation->id;
                }
            }
        }

        return view('modules::developers.structure.tables.field_column_iframe', compact(['json_data', 'table', 'column', 'field']));
    }

    /**
     * @param $table
     * @param $column
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSearchIframe ($table, $column)
    {
        $field = Fields::where('table_name', $table)->where('column_name', $column)->where('search', true)->first();
        $editable = null;
        $json_data = null;
//        $keys = null;
        if ($field) {
            $json_data = json_decode($field->json_data, true);
        }
        $unit = Units::where('default', 1)->where('main_type', 'data_source')->first();

        $unit_variations = $unit->variations();
        foreach ($unit_variations as $unit_variation) {
            if ($unit_variation->default) {
                $def_unit_id = $unit_variation->id;
            }
        }
        if (! $json_data) {
            $json_data['unit_input_type'] = $unit->input_type;
            $variations = Widgets::where('default', 1)->where('main_type', 'fields')->first()->variations();
            if ($variations) {
                foreach ($variations as $variation) {
                    if ($variation->default) {
                        $json_data['widget'] = $variation->id;
                        $json_data['some-unit'] = $def_unit_id;
                    }
                }
            }
        }
        $json_data['unit_input_type'] = $unit->input_type;
        $json_data['data_source_table_name'] = $table;
        $json_data['data_source_columns'] = $column;
        $json_data['data_source'] = 'related';

        return view('modules::developers.structure.tables.search_column_iframe', compact(['table', 'column', 'json_data']));
    }

    /**
     * @param $table
     * @param $column
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditTableColumn ($table, $column)
    {
        $types = \App\Models\Fields::getFieldTypes();
        $fields = \App\Models\Fields::where('table_name', $table)->where('column_name', $column)->get();
        $state = 'current';

        $colums = \DB::select('SHOW COLUMNS FROM ' . $table);
        $db = env('DB_DATABASE');
        $column_info = (\DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '$db' AND table_name ='$table'  AND column_name ='$column'"));
        if ($column_info) $column_info = $column_info[0];
        $length = Migrations::getLendth($column_info);
        $dataType = Migrations::getDataType($column_info);
        $field = Fields::where('table_name', $table)->where('column_name', $column)->first();
        $tbtypes = Migrations::types();

        return view("modules::developers.structure.tables.edit_column", compact(['column', 'table', 'tbtypes', 'column_info', 'length', 'dataType', 'keys','types', 'fields', 'state']));
    }

    /**
     * @param $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddColumn ($table)
    {
        $this->data['default'] = ['NULL', 'USER_DEFINED', 'CURRENT_TIMESTAMP'];
        $this->data['tbtypes'] = Migrations::types();
        $this->data['engine'] = Migrations::engine();
        $this->data['table'] = $table;
        $this->data['table'] = $table;
        $columns = \DB::select('SHOW COLUMNS FROM ' . $table);
        foreach ($columns as $column) {
            $this->data['columns'][$column->Field] = $column->Field;
        }

        return view('modules::developers.structure.tables.add_column', $this->data);
    }

    /**
     * @param $table
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAddColumn ($table, Request $request)
    {
        $data = $request->all();

        return Migrations::addcolumn($table, $data);
    }

    /**
     * @param $table
     * @param $column
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditTableColumn ($table, $column, Request $request)
    {
        $data = $request->except('field');

        return Migrations::editMigrated($table, $column, $request->all());
    }

    /**
     * @param $table
     * @param $column
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditColumnField ($table, $column, Request $request)
    {
        $data = $request->except('_token');
        Fields::updateRecurcive($table, $column, $data);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForms ()
    {
        return view("modules::developers.structure.forms");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMenus ()
    {
        return view("modules::developers.structure.menus");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPages ()
    {
        $pageGrouped = AdminPages::where('parent_id', '=', '0')->get();

        return view("modules::developers.structure.pages", compact(['pageGrouped']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBackendTheme ()
    {
        return view("modules::developers.structure.backend-themes");
    }

    /**
     * @param $table
     * @param $column
     * @param Request $request
     * @return string
     */
    public function postLiveColumnField ($table, $column, Request $request)
    {
        $field = Fields::where('table_name', $table)->where('column_name', $column)->first();
        $data = ($request->all());
        if (isset($data['input_area']) and $data['input_area'] == 'user_input') {
            $unit = Units::where('default', 1)->where('main_type', 'user_input')->first();
            $unit_variations = $unit->variations();
        } else {
            $unit = Units::where('default', 1)->where('main_type', 'data_source')->first();
            $unit_variations = $unit->variations();
        }
        foreach ($unit_variations as $unit_variation) {
            if ($unit_variation->default) {
                $def_unit_id = $unit_variation->id;
            }
        }
        if (! count($data)) {
            $variations = Widgets::where('default', 1)->where('main_type', 'fields')->first()->variations();

            if ($variations) {
                foreach ($variations as $variation) {
                    if ($variation->default) {
                        $data['data_source'] = 'file';
                        $data['widget'] = $variation->id;
                        $data['some-unit'] = $def_unit_id;
                    }
                }
            }
        };
        if (isset($data['chnaged']) and $data['chnaged'] == 'input_area') {

            $data['some-unit'] = $def_unit_id;
            $data['unit_input_type'] = $unit->input_type;
        }
        if (! isset($data['widget']) or $data['widget'] == '') {
            $data['unit_input_type'] = $unit->input_type;
            $types = ['file', 'api', 'bb'];
            if (! isset($data['data_source'])) $data['data_source'] = 'file';
            if (in_array($data['data_source'], $types)) {
                $variations = Widgets::where('default', 1)->where('main_type', 'fields')->first()->variations();
                if ($variations) {
                    foreach ($variations as $variation) {
                        if ($variation->default) {
                            $data['widget'] = $variation->id;
                            $data['some-unit'] = $def_unit_id;
                        }
                    }
                }

            }
        }
        if ($field) {
            return $field->render($data);
        } else {
            $field = new Fields();

            return $field->render($data);
        }

    }

    /**
     * @param $table
     * @param $column
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteColumn ($table, $column)
    {
        Migrations::deleteColumn($table, $column);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFieldLivePreview (Request $request)
    {
        $data = $this->defoulter($request);
        if (isset($data['some-unit'])) $data['unit'] = $data['some-unit'];

        return \Response::json(['error' => false, 'html' => BBRenderWidget($data['widget'], $data)]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function defoulter ($request)
    {
        $data = $request->all();
        $trigger = $request->get('trigger');
        if ($trigger and $trigger == 'input_area') {
            if (isset($data['data_source'])) {
                $unit = Units::where('default', 1)->where('main_type', 'data_source')->first();
            } else {
                $unit = Units::where('default', 1)->where('main_type', 'user_input')->first();

            }
        } else {
            $unit_v = $data['some-unit'];
            $unit_exp = explode('.', $data['some-unit']);
            $unit = Units::find($unit_exp[0]);
        }
        $unit_variations = $unit->variations();
        foreach ($unit_variations as $unit_variation) {
            if ($unit_variation->default) {
                $data['some-unit'] = $unit_variation->id;
            }
        }
        $data['unit_input_type'] = $unit->input_type;

        return $data;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSearchFieldLivePreview (Request $request)
    {
        $data = $this->searchDefoulter($request);

        return \Response::json(['error' => false, 'html' => BBRenderWidget($data['widget'], $data)]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function searchDefoulter ($request)
    {
        $data = $request->all();
        $unit_v = $data['some-unit'];
        $unit_exp = explode('.', $data['some-unit']);
        $unit = Units::find($unit_exp[0]);

        $unit_variations = $unit->variations();
        foreach ($unit_variations as $unit_variation) {
            if ($unit_variation->default) {
                $data['some-unit'] = $unit_variation->id;
            }
        }
        $data['unit_input_type'] = $unit->input_type;

        return $data;
    }

    /**
     * @param $table
     * @param $column
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveFieldData ($table, $column, Request $request)
    {
        $data = $request->except(['_token']);
        $unit_exp = explode('.', $data['some-unit']);
        $unit = Units::find($unit_exp[0]);
        $fields = Fields::where('table_name', $table)->where('column_name', $column)->update([
            'type'   => $unit->input_type,
            'widget' => $data['widget'],
            'unit'   => $data['some-unit']]);
        if (! $fields) {
            Fields::create([
                'table_name'  => $table,
                'column_name' => $column,
                'type'        => $unit->input_type,
                'widget'      => $data['widget'],
                'field'       => 'no',
                'unit'        => $data['some-unit']
            ]);
        }

        return \Response::json(['error' => false]);
    }

    /**
     * @param $table
     * @param $column
     * @param Request $request
     */
    public function saveSearchFieldData ($table, $column, Request $request)
    {
        dd($request->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTableNames (Request $request)
    {
        $table_names = $this->dbhelper->getTableNames();

        return \Response::json(['data' => $table_names, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTableColumns (Request $request)
    {
        $table = $request->get('val');
        $cols = $this->dbhelper->getTableColsByName($table);

        return \Response::json(['data' => $cols, 'error' => false]);
    }
}
