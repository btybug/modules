{!! Form::open() !!}
@foreach($form->fields as $field)
    {!! BBRfield($field) !!}
@endforeach
{!! Form::close() !!}