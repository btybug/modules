<?php
/**
 * Created by PhpStorm.
 * User: Comp1
 * Date: 1/20/2017
 * Time: 11:01 AM
 */

namespace App\Modules\Modules\Models;

use App\Models\ContentLayouts\ContentLayouts;
use App\Models\ExtraModules\Structures;
use App\Modules\Modules\Models\AdminPages;
use PhpParser\Node\Stmt\Foreach_;

class Routes
{
    public $array;

    public static function getRoutes()
    {
        return \Route::getRoutes();
    }

    public static function getModuleRoutes($method, $sub)
    {
        $routes = array();
        $new_array = [];
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $value) {
            if ($value->getPrefix() != $value->getPath() and $value->getPrefix() != '/' . $value->getPath()) {

                $routes[$value->getMethods()[0]][$value->getPath()] = [];
                if (!isset($routes[$value->getMethods()[0]][$value->getPrefix()])) {
                    $routes[$value->getMethods()[0]][$value->getPrefix()] = [];
                }
            }

        }
        foreach ($routes[$method] as $key => $val) {
            if (isset($key[0]) and $key[0] == '/') {
                $key = substr($key, 1);
            }
            $routes[$method][$key] = $val;
//            if (isset($routes[$method]['/' . $key])) {
//                unset($routes['GET']['/' . $key]);
//            }

        }
        if (!isset($routes[$method]['admin'])) {
            $routes[$method]['admin'] = [];
        }
        ksort($routes[$method]);
        $routes[$method] = (self::keysort($routes[$method], $sub));
        $_this = new static();
        $_this->array = collect($routes[$method][$sub]);
        return $_this;
    }

    public static function optimizePages()
    {
        //Get all routes
        $routes = self::getRoutes()->getRoutesByMethod();
        //Get only routes by GET method
        $routeCollection = $routes['GET'];
        foreach ($routeCollection as $key => $val) {
            //check if route is admin related
            if (str_contains($val->getPath(), "admin")) {
                //check if route starts with / or no
                if (starts_with($val->getPath(), "/")) {
                    $withSlash = $val->getPath();
                    $withoutSlash = ltrim($val->getPath(), '/');
                } else {
                    $withoutSlash = $val->getPath();
                    $withSlash = "/" . $val->getPath();
                }

                // get admin pages which have that route url
                $page = AdminPages::where('url', $withSlash)->orWhere('url', $withoutSlash)->first();

                //if no page with url, create page
                if (!$page) {
                    $data = explode('/', $withoutSlash);
                    if (count($data) == 2) {
                        $parent = AdminPages::where('url', "/admin")->orWhere('url', "admin")->first();
//                        AdminPages::create([
//                            'module_id' => '',
//                            'title' => $data[1],
//                            'url' => $withoutSlash,
//                            'slug' => uniqid(),
//                            'parent_id' => $parent->id,
//                            'is_default' => 0,
//                        ]);
                    } else {
                        $data = explode('/', $withoutSlash);
                        $count = count($data);

//                        AdminPages::create([
//                            'module_id' => '',
//                            'title' => last($count),
//                            'url' => $withoutSlash,
//                            'slug' => uniqid(),
//                            'parent_id' => $parent->id,
//                            'is_default' => 0,
//                        ]);
                        dd($withoutSlash, $count, 'mej@');
                    }


//                    dd($withoutSlash,$parent,$data,'mej@');
                }
//                dd($withSlash,$withoutSlash,$page);
            }
//            $page = AdminPages::where('url',$key)->first();
//            dd($page,$key);
        }
        dd($routeCollection, 'verj');
    }


    public static function keysort($array, $url, $count = 0)
    {
        foreach ($array as $key => $value) {
            $count++;
            if (self::is_child($url, $key)) {
                $array[$url][$key] = [];
                unset($array[$key]);
            }
        }
        if (isset($array[$url]) and count($array[$url])) {
            foreach ($array[$url] as $k => $v) {
                $array[$url] = self::keysort($array[$url], $k);
            }
        }
        return $array;
    }

    public function html()
    {
        $array = $this->array;
        return $this->keysort_html($array->toArray());
    }

    protected function keysort_html($array, $count = 0, $url = null)
    {
        $html = '';
        if (!$url) {
            $html .= '<ul>';
        }
        if ($count < count($array)) {
            $count++;
            if (!$url) {
                $keys = array_keys($array);
                $url = $keys[0];
            } else {
                $keys = array_keys($array);
                $be = array_search($url, $keys);
                $url = $keys[$be + 1];
            }

            if (count($array[$url])) {
                $dropmenu = 'true';
            } else {
                $dropmenu = 'false';
            }

            $html .= '<li data-name="' . $url . '" data-icon="glyphicon glyphicon-arrow-right" data-id="' . uniqid() . '" data-url="' . $url . '" data-child="' . $dropmenu . '" data-jstree=\'{"icon":"glyphicon glyphicon-arrow-right"}\'>';
            $html .= '<span class="arrowicon"><i class="fa fa-plus" aria-hidden="true"></i></span><span class="jstree-anchor">' . $url . '</span>';
            if (count($array[$url])) {
                $html .= $this->keysort_html($array[$url]);
                $html .= '</ul>';
            }
            $html .= '</li>';
            $html .= $this->keysort_html($array, $count, $url);
        }

        return $html;
    }

    public static function is_child($parent, $child)
    {
        if ($parent == $child) return false;
        $parent = self::clean_urls($parent);
        $child = self::clean_urls($child);
        return (self::array_sort_with_count($child, count($parent)) == $parent);
    }

    public static function clean_urls($url)
    {
        if (isset($url[0]) and $url[0] == '/') {
            $url = substr($url, 1);
        }
        return explode('/', $url);
    }

    public static function array_sort_with_count(array $array, $count)
    {
        $cunk = array_chunk($array, $count);
        if (count($cunk)) {
            return $cunk[0];
        }
        return false;
    }

    public static function registrePages($slug)
    {
        $module = Structures::find($slug);

        if ($module) {
            if ($module->type == 'plugin') {
                $url = strtolower('admin/' . $module->module . '/' . $module->namespace);
            }
            if ($module->type == 'extra') {
                $url = strtolower('admin/' . $module->namespace);
            }
            $routes = self::getRoutesStratWith($url, "GET");
            $message = [];
            $activeLayout = ContentLayouts::active()->activeVariation();
            if(count($routes)){
                foreach ($routes as $key => $value) {
                    if ($value[1] !== false) {
                        if (!$value[0]) {
                            $parent_id = 0;
                            $pr_url = substr($value[1], 0, strrpos($value[1], "/"));
                            if ($pr_url != 'admin' && $pr_url != '/admin') {
                                $parent = AdminPages::where('url', $pr_url)->orWhere('url', '/' . $pr_url)->first();
                                if ($parent) $parent_id = $parent->id;
                            }

                            $page = AdminPages::where('url', '/' . $key)->first();
                            if (!$page) {
                                $exp = explode('/', $key);
                                BBRegisterAdminPages($slug, end($exp), '/' . $key, $activeLayout->id, $parent_id);
                                $message['success'][$key] = end($exp);
                            } else {
                                $message['exist'][$key] = 'registred as ' . $page->title;
                            }
                        } else {
                            $page = AdminPages::where('url', '/' . $key)->first();
                            if (!$page) {
                                $parent = AdminPages::where('url', $value[1])->orWhere('url', '/' . $value[1])->first();
                                if ($parent) {
                                    $exp = explode('/', $key);
                                    BBRegisterAdminPages($slug, end($exp), '/' . $key, $activeLayout->id, $parent->id);
                                    $message['success'][$key] = end($exp);
                                } else {
                                    $message['warning'][$key] = 'invalid url created not following rules!!!';
                                }
                            } else {
                                $message['exist'][$key] = 'registred as ' . $page->title;
                            }
                        }
                    } else {
                        $message['warning'][$key] = 'invalid url created not following rules!!!';
                    }
                }
            }

            return $message;
        }
        return false;
    }

    public static function getRoutesStratWith($start, $method)
    {
        $routes = array();
        $routeCollection = self::getRoutes();
        foreach ($routeCollection as $value) {
            if (strpos($value->getPath(), $start) === 0) {
                $routes[$value->getPath()] = $value->getPrefix();
                $routes[$value->getMethods()[0]][BBmakeUrlPermission($value->getPath(), '/')] = ($value->getPrefix() == $value->getPath() || $value->getPrefix() == ('/' . $value->getPath())) ? [0, BBmakeUrlPermission($value->getPrefix(), '/')] : [1, BBmakeUrlPermission($value->getPrefix(), '/')];
            }

        }
        return (isset($routes[$method])) ? $routes[$method] : $routes;
    }

    public static function test()
    {
        $test = AdminPages::find(4)->children;
        dd($test);
    }

}