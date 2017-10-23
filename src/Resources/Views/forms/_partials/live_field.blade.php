<li data-type="field" @if(!is_null($field->unit)) data-button="{!! popup_options($field) !!}"
    @endif data-title="{!! $field->title !!}"
    data-config="{!! url('/admin/modules/tables/edit-column',[$field->table_name,$field->column_name]) !!}"
    data-el="{!! $field->id !!}"></li>