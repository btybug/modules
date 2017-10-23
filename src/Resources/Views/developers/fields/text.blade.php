@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
<input type="text"
       name="{!! $field->name !!}"
       id="{!! $field->slug !!}" class="form-control"
       placeholder="{!! isset($field) && $field->json_data['placeholder'] != '' ? $field->json_data['placeholder'] : '' !!}"
       value="{!! isset($field) && $field->json_data['default_value'] != '' ? $field->json_data['default_value'] : '' !!}"
/>