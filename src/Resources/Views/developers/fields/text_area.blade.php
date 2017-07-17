@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
{!! Form::textarea($field->name, isset($field) && $field->json_data['default_value'] != '' ? $field->json_data['default_value'] : '', [
    'id' => $field->slug,
    'class' => 'form-control',
    'placeholder' => isset($field) && $field->json_data['placeholder'] != '' ? $field->json_data['placeholder'] : '',
    'value' => isset($field) && $field->json_data['default_value'] != '' ? $field->json_data['default_value'] : ''
]) !!}