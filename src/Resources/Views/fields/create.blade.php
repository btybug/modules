@extends('layouts.admin')
@section('content')
    {!! Form::open(['class'=>'form-horizontal']) !!}
        <fieldset>

            <!-- Form Name -->
            <legend>Create Field</legend>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="name">Field Name</label>
                <div class="col-md-4">
                    <input id="name" name="name" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="lable">Field Lable</label>
                <div class="col-md-4">
                    <input id="lable" name="lable" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>   <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="lable">Icon</label>
                <div class="col-md-4">
                   {!! BBbutton('icons','icon','select Icon',['class'=>'form-control']) !!}

                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="tool_tip">Tool tip</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="tool_tip" name="tool_tip"></textarea>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="selectbasic">Field Type</label>
                <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control">
                        <option value="1">Text</option>
                        <option value="3">Password</option>
                        <option value="4">Textarea</option>
                        <option value="5">Select</option>
                        <option value="6">Checkbox</option>
                        <option value="7">Radio</option>
                    </select>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
                </div>
            </div>

        </fieldset>
    {!! Form::close() !!}
@include('resources::assests.magicModal')
    @stop
@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    @stop