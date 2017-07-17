@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3> <strong>Create New Module :</strong> Create Quick Module</h3>
       {!! Form::open(['class' => 'form-horizontal','files' => true]) !!}
               <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="Module Name">Module Name</label>
            <div class="col-md-4">
                {!! Form::text('name',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="desc">Module Image</label>
            <div class="col-md-4">
                {!! Form::file('image',['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="module_author">Module Author</label>
            <div class="col-md-4">
                {!! Form::text('author',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="author_site">Author site</label>
            <div class="col-md-4">
                {!! Form::text('author_site',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="module_version">Module Version</label>
            <div class="col-md-4">
                {!! Form::text('version',null,['class' => 'form-control input-md']) !!}
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="desc">Module Description</label>
            <div class="col-md-4">
                {!! Form::textarea('description',null,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="template">Template </label>
            <div class="col-md-4">
                <div class="radio">
                    <label for="template-0">
                        <input type="radio" name="template" id="template-0" value="full" checked="checked">
                        Full CRUD
                    </label>
                    <p><i>Add,Edit,View in new page , Native php sorting and pagination</i></p>
                </div>
                <div class="radio">
                    <label for="template-1">
                        <input type="radio" name="template" id="template-1" value="blank">
                        Blank Module
                    </label>
                    <p><i>Create template controller , model and views files for your own custom module</i></p>

                </div>
            </div>
        </div>

        <!-- Appended Input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="class_controller">Class Controller</label>
            <div class="col-md-4">
                <div class="input-group">
                    {!! Form::text('class_controller',null,['class' => 'form-control input-md','placeholder'=>'Controller Class Name']) !!}
                    <span class="input-group-addon">Controller</span>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="create_module"></label>
            <div class="col-md-4">
                {!! Form::submit('Generate',['id' => 'create_module','class' => 'btn btn-success']) !!}
            </div>
        </div>
       {!! Form::close() !!}
    </div>
@stop
@section('JS')

@stop
