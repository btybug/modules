@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Create FORM</h4>
                    <a href="{!! url('/admin/modules/config/create-form',$slug) !!}" class="btn btn-warning"><i class="fa fa-edit"></i>Edit Form</a>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Update FORMS</h4>
                    <a href="{!! url('/admin/modules/config/create-form',$slug) !!}" class="btn btn-success">Create new</a>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@stop
@section('JS')

@stop
