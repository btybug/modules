@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
{!! Form::number($field->name, isset($field->json_data['default_value']) ? $field->json_data['default_value'] : 0 ,['class' => 'form-control', 'id' =>  $field->slug, 'placeholder' => isset($field) && $field->json_data['placeholder'] != '' ? $field->json_data['placeholder'] : '']) !!}
