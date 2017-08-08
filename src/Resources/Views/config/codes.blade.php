@extends('layouts.admin')
@section('content')
    <section class="row upl-system" style="margin: 0 -5px;">
        <div class="box box-default color-palette-box">
            <div class="box-body">

                <div class="col-md-12">
                    <div class="col-md-8">
                        {!! Form::open(['url'=> url('admin/modules/config/codes'),'class'=>'form']) !!}
                        {!! Form::hidden('slug', $slug) !!}
                        {!! Form::hidden('path', $file_indexes[0]['full_path'], ['class' => 'file_path']) !!}
                        @php $text = @file_get_contents($file_indexes[0]['full_path']); @endphp
                        <textarea id="example_1" style="height: 350px; width: 100%;" name="editor">
                            @php
                                print_r($text);
                            @endphp
                        </textarea>

                        {!!Form::button('&nbsp;Save&nbsp;',['type' => 'submit','class'=>'btn btn-info btn-lg','onclick'=>'return confirm("are you sure")']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-4">
                        <h3>Plugin Files</h3>
                        @foreach($file_indexes as $file)
                            <p full-path="{!! $file['full_path'] !!}" class="set-text">{!! $file['path'] !!}</p>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop

@section('CSS')
    {{--{!! HTML::style('/public/css/code_editor/edit_area.css') !!}--}}
    <style>
        .tr-heigh {
            max-height: 35px !important;
            height: 150px !important;
            background-color: #ccc;
        }

        tr:hover {
            background-color: #ccc;
            color: #fff;
        }

        .right {
            float: right;
            margin-top: -42px;
        }

        .action .btn .btn-default {
            margin-bottom: 10px;
        }

        .right-action {
            float: right;
        }

        .input-group-btn {
            width: 200px;
        }

        .set-text {
            display: block;
            width: 400px;
            overflow: hidden;
            border: 1px solid black;
            padding: 5px 10px;
            text-overflow: ellipsis;
            color: white;
            background: #4A4141;
            cursor: pointer;
        }
    </style>

@stop

@section('JS')
    {!! HTML::script('js/code_editor/edit_area_full.js') !!}
    <script>
        $(".edit-pl").on('click', function () {
            var id = $("#selectPl").val();
            window.location.href = "{!! url('admin/plugins/edit/') !!}" + "/" + id;
            console.log(id);
        });

        $("body").on('click', '.set-text', function () {
            var name = $(this).attr('full-path');
            var token = $("#token").val();
            $.ajax({
                type: "get",
                url: "/admin/modules/config/file-content",
                data: '_token=' + token + '&file=' + name,
                cache: false,
                success: function (data) {
                    if (!data.error) {
                        editAreaLoader.setValue("example_1", data.data);
                        $('.file_path').val(name);
                    } else {
                        location.reload();
                    }
                }
            });

        });

        editAreaLoader.init({
            id: "example_1"	// id of the textarea to transform
            ,
            start_highlight: true	// if start with highlight
            ,
            allow_resize: "both"
            ,
            allow_toggle: true
            ,
            word_wrap: true
            ,
            toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help"
            ,
            language: "en"
            ,
            syntax: "php"
            ,
            load_callback: "my_load"
        });
    </script>
@stop