<tr class="field-row">
    <td>{!! isset($field) && isset($field->slug) ? $field->slug : '' !!}</td>
    <td> {!! Form::text("field[$count][name]", isset($field) && isset($field->name) ? $field->name : null, ['class'=>'form-control field-input', 'placeholder' => 'Field Name']) !!}</td>
    <td> {!! Form::select("field[$count][type]",$types,  isset($field) && isset($field->type) ? $field->type : null, ['class'=>'form-control field-input']) !!}</td>
    <td> {!! Form::text("field[$count][label]", isset($field) && $field->json_data['label'] != '' ? $field->json_data['label'] : null,['class'=>'form-control field-input', 'placeholder' => 'Field Label']) !!}</td>
    <td> {!! Form::text("field[$count][placeholder]", isset($field) && $field->json_data['placeholder'] != '' ? $field->json_data['placeholder'] : null,['class'=>'form-control field-input', 'placeholder' => 'Field Placeholder']) !!}</td>
    <td> {!! Form::text("field[$count][default_value]",isset($field) && $field->json_data['default_value'] != '' ? $field->json_data['default_value'] : null,['class'=>'form-control field-input', 'placeholder' => 'Field Default Value']) !!}</td>
    <td>
        <select name="field[{!! $count !!}][options][]" class="form-control field-input option-values"
                multiple="multiple">
            @if(isset($field) && isset($field->json_data['options']))
                @foreach($field->json_data['options'] as $option)
                    <option val="{!! $option !!}" selected>{!! $option !!}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td class="field-unit-column">
        {!! BBbutton('units',"field[$count][bb_field_units]",'Select unit for settings',[
             'class'=>'select_style input-md btn btn-info form-control select-meta-unit',
             'data-except' => json_encode([],true),
             "data-type" => 'backend',
             'data-sub' => "general",
             'model' => isset($field) && isset($field->unit) ? $field->unit : null
         ]) !!}
    </td>
    <td>
        <a data-href="{!! url('/admin/modules/tables/field/delete') !!}"
           data-key="{!! isset($field) && isset($field->id) ? $field->id : '' !!}" data-type="Field"
           class="{!! isset($field) && isset($field->id) ? 'delete-button' : 'delete-new-field' !!} btn btn-danger"><i
                    class="fa fa-trash-o" aria-hidden="true"></i></a>
    </td>
    {!! Form::hidden("field[$count][state]", $state, ['class' => 'field-state']) !!}
    {!! Form::hidden("field[$count][slug]", isset($field) && isset($field->slug) ? $field->slug : '') !!}
</tr>