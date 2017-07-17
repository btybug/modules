<optgroup label="Select Column">
    @foreach($colums as $option)
        <option value="{!! $option->Field !!}">{!! $option->Field !!}</option>
    @endforeach
</optgroup>