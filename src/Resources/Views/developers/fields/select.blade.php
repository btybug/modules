@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
<select name="{!! $field->name !!}"
        id="{!! $field->slug !!}" class="form-control">
    @if(isset($field) && isset($field->json_data['options']))
        @foreach($field->json_data['options'] as $option)
            <option val="{!! $option !!}" @if(isset($field->json_data['default_value']) && $field->json_data['default_value'] != '' && $field->json_data['default_value'] == $option){!! 'selected' !!}@endif>{!! $option !!}</option>
        @endforeach
    @endif
</select>