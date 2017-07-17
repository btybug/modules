@extends('layouts.admin')
@section('content')
    <div class="container">
        <a href="{!! url('/admin/modules/config/create-field') !!}" class="btn btn-success">Create Field</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Column</th>
                <th>Table</th>
                <th>Data source</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
@foreach($fields as $field)
    <tr>
        <td>{!! $field->id !!}</td>
        <td>{!! $field->title !!}</td>
        <td>{!! $field->column_name !!}</td>
        <td>{!! $field->table_name !!}</td>
        <td>{!! $field->data_source !!}</td>
        <td>{!! $field->type !!}</td>
        <td>
            <a href="{!! url('admin/modules/tables/edit-column',[$field->table_name,$field->column_name]) !!}" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

        </td>
    </tr>
    @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('JS')

@stop