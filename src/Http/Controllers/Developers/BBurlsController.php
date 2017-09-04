<?php
/**
 * Created by PhpStorm.
 * User: hakob
 * Date: 11/22/2016
 * Time: 10:41 AM
 */

namespace Sahakavatar\Modules\Http\Controllers\Developers;

use App\Http\Controllers\Controller;
use Sahakavatar\Console\Services\FieldValidationService;
use Sahakavatar\Resources\Models\Files\FilesBB;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts;
use Sahakavatar\Cms\Models\Templates\Units;
use Sahakavatar\Cms\Services\CmsItemReader;
use Sahakavatar\Modules\Models\Fields;
use Sahakavatar\Console\Models\Forms;

class BBurlsController extends Controller
{
    public function BBunit($slug)
    {
        $unitData = explode('.', $slug);

        if (isset($unitData[0]) && isset($unitData[1])) {
            $widget_id = $unitData[0];
            $variationID = $unitData[1];

            $widget = \Sahakavatar\Cms\Models\Templates\Units::find($widget_id);
            if (!is_null($widget)) {
                $variation = $widget->findVariation($slug);

                if (!is_null($variation)) {
                    $settings = $variation->settings;
                    if ($widget->have_settings && !$settings) {
                        $settings = [];
                    }
                    $settings_html = view('resources::units._partials.unit_settings', compact(['settings']))->render();
                    return \Response::json(['error' => false, 'settings_html' => $settings_html, 'field' => $widget->render(compact(['variation', 'section', 'settings']))]);
                }
            }

        }
    }

    public function unitRender(Request $request)
    {
        return \Response::json(['html' => BBRenderUnits($request->id)]);
    }

    public function getHeading($id)
    {
        $data = FieldHelper::getHeading($id);
        return \Response::json(['error' => false, 'data' => $data]);
    }

    public function getFileSourcehedindKeys(Request $request)
    {
        $id = $request->get('id');
        $key = $request->get('key');
        return FieldHelper::getPluck($id, $key);
    }

    public function getUnitMain(Request $request)
    {
        $vid = $request->get('id');
        $data = explode('.', $vid);

        $unit = Widgets::find($data[0]);
        if ($unit) {
            $html = $unit->renderOptions();
            return \Response::json(['error' => false, 'html' => $html]);
        }
        return \Response::json(['error' => false, 'html' => "No settings providet from this widget!!!"]);

    }

    public function getUnitMainDefault(Request $request)
    {
        $type = $request->get('type');
        $widget = Widgets::where('default', 1)->where('main_type', 'fields')->first();
        if ($type == 'user_input') {
            $unit = Units::where('default', 1)->where('main_type', 'user_input')->first();
        } else {
            $unit = Units::where('default', 1)->where('main_type', 'data_source')->first();

        }
        if ($widget and $unit) {
            $variations = $widget->variations();
            if ($variations) {
                foreach ($variations as $variation) {
                    if ($variation->default) {
                        $id = $variation->id;
                    }
                }
            }
            $variations_unit = $unit->variations();
            if ($variations_unit) {
                foreach ($variations_unit as $variation) {
                    if ($variation->default) {
                        $unit_id = $variation->id;
                    }
                }
            }
            if ($widget) {
                $html = $widget->renderOptions();
                return \Response::json(['error' => false, 'html' => $html, 'id' => $id, 'unit_id' => $unit_id]);
            }

            return \Response::json(['error' => false, 'html' => "No settings providet from this widget!!!", 'id' => $id]);
        }
        return \Response::json(['error' => true, 'html' => "No defoult widget !!!"]);
    }

    public function getFormFieldOptions(Request $request)
    {
        $fild_id = $request->get('fieldid');
        $form_id = $request->get('formid');
        $fild = Fields::find($fild_id);

        $form = Forms::find($form_id);
        if (!is_null($form->widget)) {
            $idies = $form->widget;
            $json = @json_decode($form->json_data, true);
        } else {
            $widget = Widgets::where('default', 1)->where('main_type', 'fields')->first();
            $main = null;
            if ($widget) {
                $variations = $widget->variations();
                foreach ($variations as $variation) {
                    if ($variation->default) {
                        $json = null;
                        $idies = $variation->id;
                    }
                }
            }
        }
        if (isset($idies)) {
            return \Response::json(['error' => false, 'html' => BBRenderWidgetOption($idies, $json)]);
        }
        return \Response::json(['error' => true, 'message' => 'no widget!!!']);
    }

    public function getFieldOptionsLive(Request $request)
    {
        $fild_id = $request->get('fieldid');
        $form_id = $request->get('formid');
        $field_style_widget = $request->get('fieldstyle', null);
        $form = Forms::find($form_id);
        $field = Fields::find($fild_id);
        $settings = $request->except(['_token', 'fieldid', 'formid']);
        if ($field_style_widget) {
            $form->widget = $field_style_widget;
        }

        if (is_null($form->widget)) {
            $widget = Widgets::where('default', 1)->where('main_type', 'fields')->first();
            $main = null;
            if ($widget) {
                $variations = $widget->variations();
                foreach ($variations as $variation) {
                    if ($variation->default) {
                        $main = $variation->id;
                    }
                }
            }
        } else {
            $main = $form->widget;
            $slug = explode('.', $main);
            $widget = Widgets::find($slug[0]);
        }
        $variation = Widgets::findVariation($main);
        if ($variation) {
            $rel_settings = $variation->settings;
            $new_settings = array_merge($rel_settings, $settings);
            $html = $widget->render(['settings' => $new_settings, 'data_field' => $field->toArray()]);
            return \Response::json(['error' => false, 'html' => $html]);
        }


    }

    public function BBlayout(Request $request)
    {
        $data = $request->all();
        $html = BBRenderWidget($data['layoutid']);
        return \Response::json(['error' => false, 'data' => $html]);
    }

    public function getTableLists()
    {
        return BBGetTables();
    }

    public function getTableColums(Request $request)
    {
        $table = $request->get('table');
        return BBGetTableColumn($table);
    }

    public function getColumnRules(FieldValidations $validations, Request $request)
    {
        $data = $request->except('_token');
        $validator = \Validator::make($data, ['table' => 'required', 'column' => 'required']);
        if ($validator->fails()) return \Response::json(['error' => true, 'message' => $validator->messages()]);
        return $validations->getBaseValidationRulse($data['table'], $data['column']);
    }

    public function getFileData(Request $request)
    {
        $data = $request->all();
        $result = FilesBB::findFile($data['value'])->getColumns();

        return \Response::json(['error' => false, 'data' => $result]);
    }

    public function getFileListing(Request $request)
    {
        $data = $request->all();
        $result = FilesBB::findFile($data['id'])->getColumnsListing($data);

        return \Response::json(['error' => false, 'data' => $result]);
    }

    public function getFieldUnitListing(Request $request)
    {
        $data = $request->all();

        $units = CmsItemReader::getAllGearsByType('units')
            ->where('type', $data['value'])
            ->run();
        $result = [];
        if (count($units)) {
            foreach ($units as $unit) {
                $result[$unit->slug] = $unit->title;
            }
        }

        return \Response::json(['error' => false, 'data' => $result]);
    }

    public function getFieldUnit(Request $request)
    {
        $value = $request->get('value');
        $options = $request->get('options', []);
        $unit = CmsItemReader::getAllGearsByType('units')
            ->where('slug', $value)
            ->first();
        if ($unit && count($unit->variations())) {
            $variation = array_first($unit->variations());
            return \Response::json(['error' => false, 'html' => $unit->render(['settings' => $options]), 'options' => $unit->renderSettings()]);
        }

        return \Response::json(['error' => true]);
    }

    public function getPageLayoutConfigToArray(Request $request)
    {
        $value = $request->get('variation_id');
        if ($value) {
            switch ($request->get('data_action')) {
                case 'units':
                    $data = Units::findByVariation($value)->toArray();
                    break;
                //TODO : need remove page_sections
                case 'page_sections':
                    $data = ContentLayouts::findByVariation($value)->toArray();
                    break;
                case 'layouts':
                    $data = ContentLayouts::findByVariation($value)->toArray();
                    break;
                default:
                    $data = [];
            }
        } else {
            return \Response::json(['error' => true, 'message' => 'variation_id is mandatory!!!']);
        }
        return \Response::json(['error' => false, 'data' => $data]);
    }

    public function getPageSectionConfigToArray(Request $request)
    {
        $value = $request->get('variation_id');
        if ($value) {
            $data = Units::findByVariation($value);
        if(!$data)return \Response::json(['error' => true, 'message' => 'Undefined unit!!!']);
        } else {
            return \Response::json(['error' => true, 'message' => 'variation_id is mandatory!!!']);
        }
        return \Response::json(['error' => false, 'data' => $data->toArray()]);
    }

    public function getBBFunctionOutput(Request $request)
    {

        $result = 'Invalid function';
        $error = true;
        if (function_exists($request->bb_function)) {
            $output = call_user_func($request->bb_function)->toArray();
            if (is_array($output)) {
                $result = $output;
                $error = false;
            }
        }
        return \Response::json(['error' => $error, 'result' => $result]);
    }

    public function getBBfunction(Request $request)
    {
        $function = $request->get('bb');
        $data = $request->except('_token', 'bb');
        return \Response::json(['error' => false, 'data' => $function($data['id'])]);
    }

    public function getSectionRenderAndData(Request $request)
    {
        $slug = $request->get('slug');

        return \Response::json(['error' => false, 'section' => BBRenderSections($slug)]);
    }
}