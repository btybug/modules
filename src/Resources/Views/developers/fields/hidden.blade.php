<input type="hidden" class="form-control" name="{{ $row->field }}"
       placeholder="{{ $row->display_name }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@elseif(isset($options->default)){{ old($row->field, $options->default) }}@else{{ old($row->field) }}@endif">
@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
{!! Form::hidden($field->name, isset($field->json_data['default_value']) ? $field->json_data['default_value'] : null, ['id' => $field->slug]) !!}