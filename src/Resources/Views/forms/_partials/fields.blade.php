<ul class="connectedSortable" data-style-old="left_part" data-draganddrop="formleft" data-bbplace="containerstyle_2">
    @if(isset($form))
        @foreach($form->fields as $field)
            <li data-type="field" @if(!is_null($field->unit)) data-uniq="{!! uniqid() !!}"
                data-button="{!! popup_options($field) !!}" @endif data-title="{!! $field->title !!}"
                data-config="{!! url('/admin/modules/tables/edit-column',[$field->table_name,$field->column_name]) !!}"
                data-el="{!! $field->id !!}">
            <!--{!! $field->id !!}-->
            {!! BBRenderField($field->id,$form) !!}
            <!--end{!! $field->id !!}-->
            </li>
        @endforeach
    @else

        @if(isset($fields) and count($fields))
            @foreach($fields as $value)
                <li data-type="field" @if(!is_null($value->unit)) data-uniq="{!! uniqid() !!}"
                    data-button="{!! popup_options($field) !!}" @endif data-title="{!! $value->title !!}"
                    data-config="{!! url('/admin/modules/tables/edit-column',[$value->table_name,$value->column_name]) !!}"
                    data-el="{!! $value->id !!}"> {!! BBRenderField($value->id) !!}</li>
            @endforeach
        @endif
    @endif

</ul>
<ul class="connectedSortable" data-style-old="right_part" data-bbplace="containerstyle_3"></ul>


                         