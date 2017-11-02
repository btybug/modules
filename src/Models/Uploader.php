<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 12/17/2016
 * Time: 5:24 AM
 */

namespace Btybug\Modules\Models;

use Carbon\Carbon;
use File;
use Sahakavatar\Cms\Models\Templates\Units;

class Uploader
{
    protected $path;
    protected $settings;
    protected $unit;
    protected $unitVariation;
    protected $method;
    protected $exstension;


    public function upload($file, $unit)
    {
        $this->unitVariation = Units::findVariation($unit);
        $this->unit = Units::findByVariation($unit);
        $this->settings = $this->unitVariation['settings'];
        $this->method = $this->settings['method'];
        $this->path = \Config::get('paths.uploader') . '/' . $this->settings['path'];
    }

    protected function sortDaile()
    {
        if (!File::isDirectory($this->path . '/' . Carbon::now()->format('Y-m-d'))) {
            File::makeDirectory($this->path . '/' . Carbon::now()->format('Y-m-d'));
        }
        return $this->path . '/' . Carbon::now()->format('Y-m-d');
    }

    protected function sortByExtension()
    {
        if (!File::isDirectory($this->path . '/' . $this->exstension)) {
            File::makeDirectory($this->path . '/' . $this->exstension);
        }
        return $this->path . '/' . $this->exstension;
    }

    protected function sortByUser()
    {
        if (!File::isDirectory($this->path . '/' . \Auth::user()->id)) {
            File::makeDirectory($this->path . '/' . \Auth::user()->id);
        }
        return $this->path . '/' . \Auth::user()->id;
    }

    protected function move($file)
    {
        $this->exstension = $file->file('file')->getClientOriginalExtension(); // getting image extension
        $oname = $file->file('file')->getClientOriginalName(); // getting image extension
        $fname = uniqid() . '.' . $this->exstension;
        $file->file('file')->move($this->method, $fname); // uploading file to given path
        return ['path' => $this->method . '/' . $fname, 'name' => $oname];
    }
}