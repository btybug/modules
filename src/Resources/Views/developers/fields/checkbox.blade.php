@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
{!! Form::checkbox($field->name, isset($field->json_data['default_value']) ? $field->json_data['default_value'] : null, ['class' => 'form-control', 'id' => $field->slug]) !!}