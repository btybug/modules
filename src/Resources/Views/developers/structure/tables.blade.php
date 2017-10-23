@extends('cms::layouts.mTabs',['index'=>'developers_structure'])

@section('tab')

    <div class="container">
        <a href="{!! url('admin/modules/tables/create') !!}" class="btn btn-info">New</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Table</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tables as $table)
                <tr>
                    <td>
                        @foreach($table as $k=>$v)
                            {!! $v !!}
                        @endforeach
                    </td>
                    <td>
                        @foreach($table as $k=>$v)
                            <a href="{!! url('admin/modules/tables/edit',$v) !!}" class="btn btn-warning"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop
@section('JS')

@stop
