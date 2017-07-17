@if(isset($field) && $field->json_data['label'] != '')
    <label for="{!! $field->slug !!}">{!! $field->json_data['label'] !!}</label>
@endif
<ul class="radio">
    @if(isset($field->json_data['options']))
        @foreach($field->json_data['options'] as $key => $option)
            <li>
                <input type="radio" id="option_{{ $field->slug . '_' . $key }}"
                       name="{{ $field->name }}"
                       value="{{ $option }}" @if(isset($field->json_data['default_value']) && $field->json_data['default_value'] != '' && $field->json_data['default_value'] == $option){{ 'checked' }}@endif>
                <label for="option_{{ $field->slug . '_' . $key }}">{{ $option }}</label>
                <div class="check"></div>
            </li>
        @endforeach
    @endif
</ul>