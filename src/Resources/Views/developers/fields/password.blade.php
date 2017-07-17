@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
{!! Form::password($field->name, ['class' => 'form-control', 'id' =>  $field->slug, 'placeholder' => isset($field) && $field->json_data['placeholder'] != '' ? $field->json_data['placeholder'] : '']) !!}