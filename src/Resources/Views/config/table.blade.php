@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Table</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($module->tables))
                    @foreach($module->tables as $k=>$table)
                        <tr data-href="{!! url('/admin/modules/config/tables/Users',$k) !!}"
                            class="@if($k==$active) info  @endif clickable-row">
                            <td>
                                {!! $table!!}
                            </td>
                            <td>
                                <a href="{!! url('/admin/modules/tables/edit',$table) !!}" class="btn btn-info"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        @if($createForm)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Create FORM for {!! $createForm->table !!}</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{ $createForm->title }}
                                </td>
                                <td>
                                    {{ $createForm->table }}
                                </td>
                                <td>
                                    {{ BBgetDateFormat($createForm->created_at) }}
                                </td>
                                <td>
                                    <a href="{!! url('/admin/modules/config/create-form',[$slug,$module->tables[$active],'main']) !!}"
                                       class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" style="overflow: hidden;">
                        <div class="col-md-6">
                            <h4><span>Edit FORMS   </span></h4>
                        </div>
                        <div class="col-md-6">
                            <a href="{!! url('/admin/modules/config/create-form',[$slug,$module->tables[$active]]) !!}"
                               class="pull-right btn btn-sm btn-warning">create new</a>
                        </div>
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
        @else
            <div class="col-md-6">
                No form For this table
            </div>
        @endif
    </div>
@stop
@section('CSS')
    <style>
        .clickable-row {
            cursor: pointer
        }
    </style>
@stop
@section('JS')
    <script>

        $(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.document.location = $(this).data("href");
            });
        });
    </script>
@stop
