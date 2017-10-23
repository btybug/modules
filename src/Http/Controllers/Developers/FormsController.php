<?php

namespace Sahakavatar\Modules\Http\Controllers\Developers;

use App\Http\Controllers\Controller;
use App\Models\Fields;
use App\Models\Moduledb;
use Illuminate\Http\Request;
use Sahakavatar\Modules\Models\Models\AdminPages;
use Sahakavatar\Modules\Models\Models\Forms;
use Sahakavatar\Modules\Models\Models\Migrations;
use Validator;
use view;

/**
 * Class ModulesController
 * @package Sahakavatar\Modules\Models\Http\Controllers
 */
class FormsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'pageTitle' => 'Database',
            'pageNote' => 'Manage Database Tables',

        );
    }

    public function getIndex()
    {
        dd(1);
        $tables = \DB::select('SHOW TABLES');
        return view("modules::developers.structure.tables", compact(['tables']));
    }

    public function getEditTable($table)
    {
        $colums = \DB::select('SHOW COLUMNS FROM ' . $table);
        return view("modules::developers.structure.tables.columns", compact(['colums', 'table']));
    }

    public function getCreate()
    {
        $tables = [];
        $SHOW_TABLES = (\DB::select('SHOW TABLES'));
        foreach ($SHOW_TABLES as $table) {
            foreach ($table as $k => $v) {
                $tables[$v] = $v;
            }
        }
        $columns = array();
        $this->data['default'] = array('NULL', 'USER_DEFINED', 'CURRENT_TIMESTAMP');
        $this->data['tbtypes'] = Migrations::types();
        $this->data['tables'] = $tables;

        return view('modules::developers.structure.forms.create', $this->data);
    }

    public function postCreate(Request $request)
    {
        $data = $request->all();
        $v = Validator::make($data, [
            'name' => 'required|alpha_num',
            'engine_type' => 'required'
        ]);
        if ($v->fails()) return \Response::json(['error' => true, 'arrm' => true, 'message' => $v->errors()]);
        return Migrations::migrate($data);
    }

    public function getColumns(Request $request)
    {
        $table = ($request->get('table'));
        if ($table) {
            $colums = \DB::select('SHOW COLUMNS FROM ' . $table);
        }
        $options = View::make("modules::developers._partials.column_options", compact('colums'))->render();
        return \Response::json(['error' => false, 'options' => $options]);
    }

    public function getForms()
    {
        return view("modules::developers.structure.forms");
    }

    public function getMenus()
    {
        return view("modules::developers.structure.menus");
    }

    public function getPages()
    {
        $pageGrouped = AdminPages::where('parent_id', '=', '0')->get();
        return view("modules::developers.structure.pages", compact(['pageGrouped']));
    }

    public function getBackendTheme()
    {
        return view("modules::developers.structure.backend-themes");
    }

    public function postModuleData(Request $request)
    {
        $id = $request->get('id');
        $module = Moduledb::find($id);

        if (!$module) return \Response::json(['error' => true]);

        $info = Moduledb::Info($module);
        $html = view::make('backend::admin_pages._partials.module_info', compact(['module', 'info']))->render();

        return \Response::json(['error' => false, 'html' => $html]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPagesData(Request $request)
    {
        $id = $request->get('id');
        $page = AdminPages::find($id);

        if (!$page) return \Response::json(['error' => true]);

        $html = view::make('backend::admin_pages._partials.pages_info', compact(['page']))->render();

        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function getFields($table, $column)
    {
        $types = Fields::getFieldTypes();
        $fields = Fields::where('table_name', $table)->where('column_name', $column)->get();
        $state = 'current';

        return view("modules::developers.forms.fields", compact(['table', 'column', 'types', 'fields', 'state']));
    }

    public function postSave(Request $request)
    {
        $html = $request->get('html');
        $json = $request->get('json');
        $form_id = $request->get('formid');
        $fieldstyle = $request->get('fieldstyle');

        $fields = [];
        $data = json_decode($json, true);
        if (isset($data['item'])) {
            if (count($data['item'])) {
                foreach ($data['item'] as $key => $value) {
                    if ($value === 'f')
                        $fields[$key] = $key;
                }
            }
        }
        $form = Forms::find($form_id);
        if (!$form) return back()->with('message', 'Not Found');

        $response = $form->update(['json_data' => $json, 'widget' => $fieldstyle]);
        if ($response) {
            $form->fields()->sync($fields);
            Forms::synchronizeBlade($form, $html);
            return \Response::json(['error' => 'false']);
        }

        return \Response::json(['error' => 'true', 'message' => 'Something goes wrong!!!']);
    }

    public function renderForm($id)
    {
        return view("modules::forms.render_test", compact(['id']));
    }

    public function addNewField(Request $request)
    {
        $count = $request->count + 1;
        $state = 'new';
        $types = Fields::getFieldTypes();
        $html = view::make("modules::developers._partials.custom_field", compact(['count', 'state', 'types']))->render();
        return \Response::json(['html' => $html]);
    }

    public function postFields(Request $request)
    {
        if ($request->field && !empty($request->field)) {
            foreach ($request->field as $field) {
                if ($field['state'] != 'current') {
                    if ($field['state'] == 'new') {
                        $fieldObject = new Fields;
                        $fieldObject->slug = uniqid();
                    } else if ($field['state'] == 'updated') {
                        $fieldObject = Fields::where('table_name', $request->table)
                            ->where('column_name', $request->column)
                            ->where('slug', $field['slug'])
                            ->first();
                    }
                    $fieldObject->type = $field['type'];
                    $fieldObject->name = $field['name'];
                    $fieldObject->table_name = $request->table;
                    $fieldObject->column_name = $request->column;
                    $fieldObject->unit = $field['bb_field_units'] && $field['bb_field_units'] != '' ? $field['bb_field_units'] : NULL;
                    $fieldObject->json_data = [
                        'label' => $field['label'],
                        'placeholder' => $field['placeholder'],
                        'default_value' => $field['default_value']
                    ];
                    if (isset($field['options']) && !empty($field['options'])) {
                        $fieldObject->json_data = array_merge($fieldObject->json_data, ['options' => $field['options']]);
                    }
                    $fieldObject->save();
                }
            }
        }
        return redirect()->back()->with('message', "Form fields have been updated successfully.");
    }

    public function deleteField(Request $request)
    {
        $field = Fields::find($request->slug);
        $deleted = count($field) ? $field->delete() : false;
        return \Response::json(['success' => $deleted]);
    }

    public function renderColumnFields(Request $request)
    {
//        dd($request->table, $request->column);
        return view("modules::developers.forms.render_field");
    }
}
