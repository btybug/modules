@extends('cms::layouts.admin')
@section('content')

    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Column Name</th>
                <th>DataType</th>
                {{--<th>Create Form</th>--}}
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>
                <th>Field Status</th>
                <th>Update Form</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($colums as $colum)
                <tr>
                    @foreach($colum as $k=>$v)
                        @if($k == 'field')
                            <th>{!! '1' !!}</th>
                        @elseif($k == 'Null' && $colum->field == 'never')
                            <th>N/A</th>
                        @else
                            <th>{!! $v !!}</th>
                        @endif
                    @endforeach
                    <th></th>
                    <th>
                        <a href="{!! url('admin/modules/tables/edit-column',[$table,$colum->Field]) !!}"
                           class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="{!! url('admin/modules/tables/fields',[$table,$colum->Field]) !!}"
                           class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                        @if(!isset($core[$colum->Field]))
                            <button data-href="{!! url('admin/modules/tables/delete-column',[$table,$colum->Field]) !!}"
                                    class="btn  btn-warning delete_table_column"><i class="fa fa-trash"
                                                                                    aria-hidden="true"></i></button>
                        @endif
                    </th>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{!! url('admin/modules/tables/add-column',$table) !!}" class="btn btn-success">Add Column</a>
    @include('resources::assests.deleteModal')
@stop
@section('JS')
    <script>
        $(document).ready(function () {
            $('.delete_table_column').on('click', function () {
                $('#delete_confirm').attr('href', $(this).attr('data-href'));
                $('.delete_modal .modal-body p').html('are you sure delete this column?');
                $('.delete_modal').modal();
            })
        })

    </script>
@stop
