<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 11/27/2016
 * Time: 6:03 AM
 */

namespace Sahakavatar\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class Form_Fields extends Model
{
    protected $table = 'form_fields';
    protected $guarded = ['id'];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo(Forms::class, 'form_id');
    }

    public function field()
    {
        return $this->belongsTo(Fields::class, 'field_id');
    }
}