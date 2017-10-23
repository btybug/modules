@extends('layouts.admin')
@section('content')
{!! Form::open(['class'=>'form-horizontal']) !!}
<fieldset>

    <!-- Form Name -->

    <div class="row legend">
        <div class="col-xs-6">
            <legend>Edit Column</legend>
        </div>
        <div class="col-xs-6 text-right">
            <button type="button" class="btn btn-success" id="submit_form">Update</button>
        </div>
    </div>

    <div class="row m-b-10">
        <label class="col-md-12 control-label" for="engine"></label>
        <div class="col-md-12">
            <h4>Column {!! $column !!}</h4>
            <table class="table table-bordered">
                <thead>
                <tr class="bg-black text-white">
                    <th>Column Name</th>
                    <th>DataType</th>
                    <th>Lenght/Values</th>
                    <th>Default</th>
                    <th>Create form</th>
                    <th>Key Unique</th>
                </tr>
                </thead>
                <tbody id="table_engine">
                <tr>
                    <td> {!! Form::text('column[0][name]',$column,['class'=>'form-control']) !!}</td>
                    <td>{!! Form::select('column[0][type]',$tbtypes,$dataType,['class'=>'form-control']) !!}</td>
                    <td>{!! Form::text('column[0][lenght]',$length,['class'=>'form-control']) !!}</td>
                    <td>{!! Form::text('column[0][default]',$column_info->COLUMN_DEFAULT,['class'=>'form-control'])
                        !!}
                    </td>
                    <td>{!! Form::select('column[0][nullable]',[0=>'required',1=>'not
                        required'],($column_info->IS_NULLABLE=="NO")?0:1,['class'=>'form-control']) !!}
                    </td>
                    <td>{!! Form::checkbox('column[0][unique]',true,($column_info->COLUMN_KEY=="UNI")?true:false ) !!}
                    </td>
                </tr>
                </tbody>
            </table>


        </div>
    </div>
</fieldset>
{!! Form::close() !!}


<div class="row legend">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success" id="savefielddata">Save</button>
    </div>
</div>
<div class="emailsettingiframe">
    <iframe src="{!!url('/admin/modules/tables/column-field-iframe',[$table,$column])!!}"
            data-fieldifame="field"></iframe>
</div>

{{--
<div class="row">--}}
    <!-- Preview -->
    {{--{!! Form::open(['url' =>
    '/admin/modules/tables/edit-column-field/'.$table.'/'.$column,'class'=>'form-horizontal','id'=>'field_data_form'])
    !!}--}}
    {{--@if($field)--}}
    {{--{!! Form::hidden('field_id',$field->id) !!}--}}

    {{--@endif--}}
    {{--{!! Form::hidden('unit_input_type',$json_data['unit_input_type']) !!}--}}
    {{----}}
    {{--
    <div class="col-md-5">--}}

        {{--
        <div class="editRowTitle">--}}
            {{--
            <ul class="nav nav-tabs">--}}
                {{--
                <li class="active"><a data-toggle="tab" href="#inputs">field input</a></li>
                --}}
                {{--
                <li><a data-toggle="tab" href="#field_style">field style</a></li>
                --}}
                {{--
                <li><a data-toggle="tab" href="#field_options">field options</a></li>
                --}}
                {{--
            </ul>
            --}}
            {{--
        </div>
        --}}
        {{--
        <div class="tab-content">--}}
            {{--
            <div id="inputs" class="tab-pane fade in active">--}}
                {{--
                <div class="editLeftCol">--}}
                    {{--
                    <div class="form-group">--}}
                        {{--<label class="col-md-4 control-label" for="radios">Input area</label>--}}
                        {{--
                        <div class="col-md-4">--}}
                            {{--<label class="radio-inline" for="radios-1">--}}
                                {{--<input type="radio" name="input_area" id="user_input_radio" --}}
                                           {{--value="user_input" {{ (isset($json_data['input_area']) &&
                                $json_data['input_area'] == 'user_input') ?'checked': isset($json_data['input_area']) ?
                                'checked':'' }}>--}}
                                {{--User Input--}}
                                {{--</label>--}}
                            {{--<label class="radio-inline" for="radios-2">--}}
                                {{--<input type="radio" name="input_area" id="select_options_radio" --}}
                                           {{--value="select_options" {{ (isset($json_data['input_area']) &&
                                $json_data['input_area'] == 'select_options') ?'checked': '' }} >--}}
                                {{--Select Options--}}
                                {{--</label>--}}
                            {{--
                        </div>
                        --}}
                        {{--
                    </div>
                    --}}
                    {{--
                    <div class="form-group">--}}
                        {{--<label class="col-md-4 control-label" id="unit_type_lable" --}}
                                   {{--for="name">{{ (isset($json_data['input_area']) && $json_data['input_area']==
                            'select_options') ? 'Select' : 'User' }}--}}
                            {{--input Type</label>--}}
                        {{--
                        <div class="col-md-8">--}}
                            {{--{!! BBbutton('units','some-unit','Select Input',[--}}
                            {{--'class' => 'btn btn-danger btn-md input-md',--}}
                            {{--'model' => $json_data,--}}
                            {{--'data-type' => (isset($json_data['input_area']) && $json_data['input_area']==
                            'select_options') ? 'data_source' : 'user_input'--}}
                            {{--]) !!}--}}
                            {{--
                        </div>
                        --}}
                        {{--
                    </div>
                    --}}
                    {{--<!-- Select Basic -->--}}
                    {{--
                    <div class="data-box">--}}
                        {{--<!-- check if Data source TYPE is File -->--}}
                        {{--@if(isset($json_data['data_source']))--}}
                        {{--
                        <div class="form-group">--}}
                            {{--<label class="col-md-4 control-label" for="name">Data Source</label>--}}
                            {{--
                            <div class="col-md-8">--}}
                                {{--<!-- check if Data source is data-source -->--}}
                                {{--{!! Form::select('data_source',[--}}
                                {{--''=>'-- Select Data source --',--}}
                                {{--'api'=>'From api',--}}
                                {{--'bb'=>'BB Functions',--}}
                                {{--'file'=>'File'],(isset($json_data['data_source']))?$json_data['data_source'] :
                                'file',['class'=>'form-control','id'=>'data_source']) !!}--}}

                                {{--
                            </div>
                            --}}
                            {{--
                        </div>
                        --}}

                        {{--
                        <div class="select_op_box">--}}
                            {{--@if($json_data['data_source'] == 'file')--}}
                            {{--
                            <div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="selectbasic">Files</label>--}}
                                {{--
                                <div class="col-md-8">--}}
                                    {{--{!! BBbutton('units','file-unit','Select File',['class' => 'btn btn-warning
                                    btn-md input-md','data-type' => 'files','model' => $json_data]) !!}--}}
                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}

                            {{--@if(isset($json_data['data_source_type_val']))--}}
                            {{--
                            <div class="form-group">--}}
                                {{--
                                <div class="col-xs-8 col-md-offset-4">--}}
                                    {{--{!! Form::select('data_source_type_val',['' => 'Select Data Value'] +
                                    (array)\App\helpers\FieldHelper::getHeading($json_data['file-unit']),$json_data['data_source_type_val'],['class'
                                    => 'form-control','id' =>'data_source_type_val']) !!}--}}
                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}
                            {{--@endif--}}


                            {{--@if(isset($json_data['data_source_type_key']))--}}
                            {{--
                            <div class="form-group">--}}
                                {{--
                                <div class="col-xs-8 col-md-offset-4">--}}
                                    {{--{!! Form::select('data_source_type_key',['' => 'Select Data Key'] +
                                    (array)\App\helpers\FieldHelper::getHeading($json_data['file-unit']),$json_data['data_source_type_key'],['class'
                                    => 'form-control','id' =>'data_source_type_key']) !!}--}}
                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}
                            {{--@if(isset($json_data['data_source_type_default']))--}}
                            {{--
                            <div class="form-group">--}}
                                {{--
                                <div class="col-xs-8 col-md-offset-4">--}}
                                    {{--{!! Form::select('data_source_type_default', ['' => 'Select Default'] +
                                    (array)\App\helpers\FieldHelper::getPluck($json_data['file-unit'],$json_data['data_source_type_key']),$json_data['data_source_type_default'],['class'
                                    => 'form-control','id' =>'data_source_type_default']) !!}--}}
                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}
                            {{--@endif--}}
                            {{--@endif--}}
                            {{--@endif--}}
                            {{--
                        </div>
                        --}}

                        {{--@endif--}}
                        {{--
                    </div>
                    --}}
                    {{--
                    <div class="form-group">--}}
                        {{--
                        <div class="col-xs-8 col-md-offset-4">--}}
                            {{--{!! Form::submit('Save Field',['class' => 'btn btn-primary']) !!}--}}
                            {{--
                        </div>
                        --}}
                        {{--
                    </div>
                    --}}
                    {{--
                </div>
                --}}
                {{--
            </div>
            --}}
            {{--
            <div id="field_style" class="tab-pane fade">--}}
                {{--
                <div class="editLeftCol">--}}
                    {{--
                    <div class="form-group">--}}
                        {{--<label class="col-md-4 control-label" for="name">Select Widget</label>--}}
                        {{--
                        <div class="col-md-8">--}}
                            {{--{!! BBbutton('widgets','field_widget','select Widget',[--}}
                            {{--'class' => 'btn btn-info btn-md input-md',--}}
                            {{--'data-type' =>'fields',--}}
                            {{--'model' => $json_data--}}
                            {{--]) !!}--}}
                            {{--
                        </div>
                        --}}
                        {{--
                    </div>
                    --}}
                    {{--
                </div>
                --}}
                {{--
            </div>
            --}}
            {{--
            <div id="field_options" class="tab-pane fade">--}}
                {{--
                <div class="editLeftCol">--}}
                    {{--
                    <div class="row  main_settings_area">--}}
                        {{--
                        <div class="col-xs-12 editIframe"> Field Option will come here</div>
                        --}}
                        {{--
                    </div>
                    --}}
                    {{--
                </div>
                --}}
                {{--
            </div>
            --}}
            {{--
        </div>
        --}}


        {{--
    </div>
    --}}

    {{--{!! Form::close() !!}--}}
    {{--
    <div class="col-md-7">--}}
        {{--
        <div class="row editRowTitle">--}}
            {{--
            <div class="col-xs-6">Preview</div>
            --}}
            {{--
            <div class="col-xs-6 text-right">--}}


                {{--
            </div>
            --}}
            {{--
        </div>
        --}}
        {{--
        <div class="row editRightCol">--}}
            <iframe class="col-md-12 editIframe" data-previewiframe="preview" --}}
                    {{--src="{!! url('/admin/modules/tables/render-column-field',[$table,$column]) !!}"></iframe>
            {{--
            <iframe class="col-md-12 editIframe" data-previewiframe="preview" --}}
                    {{--src="{!! url('/admin/modules/tables/render-column-field',[$table,$column]) !!}"></iframe>
            --}}
            {{--@if($field)--}}
            {{--
            <div class="hidden">--}}
                {{--
                <div class="form-group">--}}
                    {{--<label for="exampleInputName2"> <i id="lable_icon" class="{!! $field->icon or null !!}"></i>
                        <b--
                        }}
                        {{--class="input_lable_text">{!! $field->label !!}</b></label>--}}
                    {{--
                    <div id="inpur_result">--}}
                        {{--<input type="{!! $field->type or 'hidden' !!}" class="form-control">--}}
                        {{--
                    </div>
                    --}}
                    {{--<label id="tooltip_area" for="exampleInputName2"> {!! $field->tooltip or null !!}</label>--}}
                    {{--
                </div>
                --}}
                {{--{!! Form::open(['class'=>'form-horizontal col-md-12']) !!}--}}
                {{--@if($column!='id' and $column!='created_at' and $column!='updated_at' and $field)--}}
                {{--<input type="hidden" name="field_id" value="{!! $field->id!!}">--}}
                {{--
                <fieldset>--}}
                    {{--
                    <div class="col-md-12">--}}
                        {{--
                        <div class="col-md-12">--}}
                            {{--<!-- Text input-->--}}

                            {{--
                            <div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="name">Field Name</label>--}}
                                {{--
                                <div class="col-md-8">--}}
                                    {{--{!! Form::text('title',old('title'),['class'=>'form-control input-md']) !!}--}}

                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}

                            {{--<!-- Text input-->--}}
                            {{--
                            <div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="lable">Field Lable</label>--}}
                                {{--
                                <div class="col-md-8">--}}
                                    {{--{!! Form::text('label',old('lable'),['class'=>'form-control
                                    input-md','id'=>'lable']) !!}--}}
                                    {{--<input id="lable" name="lable" type="text" placeholder=""
                                               class="form-control input-md">--}}

                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>   <!-- Text input-->--}}
                            {{--
                            <div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="lable">Icon</label>--}}
                                {{--
                                <div class="col-md-8">--}}
                                    {{--{!! BBbutton('icons','icon','select Icon',['class'=>'form-control']) !!}--}}

                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}

                            {{--<!-- Textarea -->--}}
                            {{--
                            <div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="tool_tip">Tool tip</label>--}}
                                {{--
                                <div class="col-md-8">--}}
                                    {{--{!! Form::textarea('tooltip',old('tooltip'),['class'=>'form-control']) !!}--}}
                                    {{--
                                </div>
                                --}}
                                {{--
                            </div>
                            --}}


                            {{--
                        </div>
                        --}}

                        {{--
                    </div>
                    --}}
                    {{--
                </fieldset>
                --}}
                {{--@endif--}}
                {{--
                <button type="button" class="btn btn-success">Save Field</button>
                --}}
                {{--{!! Form::close() !!}--}}
                {{--
            </div>
            --}}
            {{--@endif--}}


            {{--
        </div>
        --}}


        {{--
    </div>
    --}}

    {{--
</div>--}}
@include('modules::developers._partials.mysql_error')
@include('resources::assests.magicModal')
@stop

@section('CSS')
{!! HTML::style('css/preview-template.css') !!}

@stop
@section('JS')
{!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
<script type="text/javascript">

    $(function () {

        $('#savefielddata').click(function () {

            var getiframedata = $('[ data-fieldifame="field"]').contents().find("#field_data_form").serialize();
            alert(getiframedata)

            $.ajax({
                type: 'POST',
                url: '/',
                headers: '{!! csrf_token() !!}',
                datatype: 'json',
                cache: false,
                data: formdata,
                success: function (data) {
                    if (data.error) {
                        alert(data.error)
                    } else {

                    }
                }
            });


        })
    })
</script>
<script type="text/javascript">


    $(document).ready(function () {
        getMain();

        var i = 1;
        $('#input_types').hide();
        $('body').on('click', '.delete_row', function () {
            $(this).parent().parent().remove();
        });
        $('#submit_form').on('click', function () {
            var data = $('form').serialize();
            $.ajax({
                type: 'POST',
                url: $('form').attr('action'),
                headers: '{!! csrf_token() !!}',
                datatype: 'json',
                cache: false,
                data: data,
                success: function (data) {
                    if (data.error) {
                        if (data.arrm) {
                            $('#mysql .error_message').empty();
                            $.each(data.message, function (k, v) {
                                var message = $('</p>');
                                var p = message.clone().text(v);
                                $('#mysql .error_message').append(p);
                            });
                            $('#mysql').modal('show');
                        } else {
                            $('#mysql .error_message').html(data.message);
                            $('#mysql').modal('show');
                        }
                    } else {
                        document.location.href = data.redirect;
                    }
                }
            });
        });

        var text = $('<input/>', {type: "text", class: "form-control"});
        var password = $('<input/>', {type: "password", class: "form-control"});
        var textarea = $('<textarea/>', {class: "form-control"});
        var select = $('<select/>', {type: "text", class: "form-control"});
        var radio = $('<input/>', {type: "radio"});
        var checkbox = $('<input/>', {type: "checkbox"});
        var inp_json = {
            ' ': "",
            text: text,
            password: password,
            textarea: textarea,
            select: select,
            radio: radio,
            checkbox: checkbox
        }
        $('#user_select').on('change', '.input_type_prev', function () {
            $('#inpur_result').html(inp_json[$(this).val()]);
        });

        function source(type) {
            switch (type) {
                case 'user_input':
                    $('#type_area').html(user);
                    var user_inputsC = user.clone();
                    user_inputsC.addClass('input_type_prev');

                    $.each(user_json, function (k, v) {
                        user_inputsC.append("<option value='" + k + "'>" + v + "</option>");
                    });
                    $('#inputs').html(user_inputsC);
                    break;
                case 'data_source':
                    var user_inputsC = user.clone();
                    user_inputsC.addClass('input_type_prev');
                    //var data_from = $('input[data-key="some-unit"]').clone();
                    var data_from = user_inputs.clone();
                    $.each(source_json, function (k, v) {
                        user_inputsC.append("<option value='" + k + "'>" + v + "</option>");
                    });
                    $.each(source_types, function (k, v) {
                        data_from.append("<option value='" + k + "'>" + v + "</option>");
                    });
                    $('#inputs').html(data_from);
                    $('#type_area').html(user_inputsC);
                    break;
                case 'empty':
                    $('#inputs').empty();
                    $('#type_area').empty();

            }

        }

        function survey(selector, callback) {
            var input = $("body " + selector);
            var oldvalue = input.val();
            setInterval(function () {
                if (input.val() != oldvalue) {
                    oldvalue = input.val();
                    callback();
                }
            }, 100);
        }

        $('[name=input_area]').on('change', function () {
            $('.data-box').html('');

            var select_op_box = $('<div/>', {
                class: 'select_op_box'
            });
            $('.data-box').append(select_op_box);

            var val = $(this).val();
            if (val == 'user_input') {
                $("[data-key=some-unit]").attr('data-type', 'user_input');
                $("#unit_type_lable").text('User input Type');
            } else {
                $("[data-key=some-unit]").attr('data-type', 'data_source');
                $("#unit_type_lable").text('Select input Type');
                var data_group = $('<div/>', {
                    "class": 'form-group'
                });
                var data_group_label = $('<label/>', {
                    "class": 'col-md-4 control-label',
                    "for": 'data_source',
                    "text": 'Data Source'
                });

                data_group.append(data_group_label);

                var data_group_col = $('<div/>', {
                    class: 'col-md-4'
                });
                data_group.append(data_group_col);
                var data_source = $('<select/>', {
                    "class": 'btn btn-warning btn-md input-md',
                    "id": 'data_source',
                    "name": 'data_source'
                });

                data_group_col.append(data_source);

                $.each({
                    '': '-- Select Data source --',
                    'api': 'From api',
                    'bb': 'BB Functions',
                    'file': 'File'
                }, function (k, v) {
                    $(data_source).append("<option value='" + k + "'>" + v + "</option>");
                });

                $('.select_op_box').append(data_group);
            }
        });


        var data_souce = $('#data_source').val();
        if (data_souce != 'user_input') {
//                data-name="file-unit"
            if (!$('input[name=file-unit]').val()) {
                dataSource();
            }
        }

        $('body').on('change', '#data_source', function () {
            dataSource();
        });

//            $("body").on('change', '[name="data_source_type"]', function () {
//
//            });

        $("body").on('click', '.file-item-dynamic', function () {
            var id = $("[name=file-unit]").val();

            $.ajax({
                type: 'GET',
                url: "{!! url('/admin/modules/bburl/get-heading') !!}" + '/' + id,
                datatype: 'json',
                cache: false,
                success: function (data) {
                    if (!data.error) {
                        $('#data_source_type_val').remove();
                        $('#data_source_type_key').remove();
                        var data_source_type_key = $('<select/>', {
                            "class": 'form-control',
                            "id": 'data_source_type_key',
                            "name": "data_source_type_key"
                        });
                        data_source_type_key.append($('<option>', {value: '', text: 'Select Data Key'}));

                        var data_source_type_val = $('<select/>', {
                            "class": 'form-control',
                            "id": 'data_source_type_val',
                            "name": "data_source_type_val",
                            "option": {'': "select"}
                        });
                        data_source_type_val.append($('<option>', {value: '', text: 'Select Data Value'}));

                        $.each(data.data, function (k, v) {
                            $(data_source_type_key).append("<option value='" + v + "'>" + v + "</option>");
                            $(data_source_type_val).append("<option value='" + v + "'>" + v + "</option>");
                        });

                        $('.select_op_box').append(data_source_type_val, data_source_type_key);

                    }

                }
            });

        });


        $("body").on('change', '#data_source_type_key', function () {
            var id = $("[name=file-unit]").val();
            var key = $(this).val();
            $.ajax({
                type: 'POST',
                url: "{!! url('/admin/modules/bburl/get-heading-keys') !!}",
                datatype: 'json',
                data: {id: id, key: key},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                cache: false,
                success: function (data) {
                    $('#data_source_type_default').remove();
                    var data_source_type_default = $('<select/>', {
                        "class": 'form-control',
                        "id": 'data_source_type_default',
                        "name": "data_source_type_default"
                    });
                    data_source_type_default.append($('<option>', {value: '', text: 'Select Default Value'}));

                    $.each(data, function (k, v) {
                        $(data_source_type_default).append("<option value='" + v + "'>" + v + "</option>");
                    });

                    $('.data-box').append(data_source_type_default);
                }
            });
        });

        function getformdata(e) {
            var getdata = $('#field_data_form').serialize();
            var geturls = $('[data-previewiframe="preview" ]').attr('src');
            $('[data-previewiframe="preview"]').attr('src', geturls + '?' + getdata + '&chnaged=' + e.attr('name'));
        }

        getformdata($(this));

        function getMain() {
            var id = $('input[data-name=field_widget]').val()
            $.ajax({
                type: "post",
                datatype: "json",
                cache: false,
                url: '/admin/modules/bburl/unit-main',
                data: {
                    'id': id
                },
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                success: function (data) {
                    if (!data.error) {
                        $('.main_settings_area').html(data.html);
                    }
                }
            });

        }

        $('input[name=input_area]').on('change', function () {
            var type = $(this).val();
            $.ajax({
                type: "post",
                datatype: "json",
                cache: false,
                url: '/admin/modules/bburl/unit-main-default',
                data: {
                    'type': type
                },
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                success: function (data) {
                    if (!data.error) {
                        $('input[data-name=some-unit]').val(data.unit_id);
                        $('.main_settings_area').html(data.html);
                        $('input[name=field_widget]').val(data.id);
                    }
                }
            });
        })

        $('body').on('change keyup', '#field_data_form select radio', function () {
            console.log($(this));
            getformdata($(this));
        }).on('click', '.item', function () {
            getMain();
//                getformdata();


        })

        $('body').on('change', 'input[type=radio]', function () {
            console.log($(this));
            getformdata($(this));
        }).on('click', '.item', function () {
            getMain();
//                getformdata();


        })

        function dataSource() {
//                $('.select_op_box').html('');
            var val = $('#data_source').val();

            switch (val) {
                case 'file':
//                        $("[data-key=some-unit]").attr('data-item', 'data_source');
                    //file functional
                    var data_group = $('<div/>', {
                        "class": 'form-group'
                    });
                    var data_group_label = $('<label/>', {
                        "class": 'col-md-4 control-label',
                        "for": 'selectbasic',
                        "text": 'Files'
                    });

                    data_group.append(data_group_label);

                    var data_group_col = $('<div/>', {
                        class: 'col-md-4'
                    });
                    data_group.append(data_group_col);
                    var data_group_BB_unit = $('<button/>', {
                        "class": 'btn btn-warning btn-md input-md BBbuttons',
                        "type": 'button',
                        "data-action": 'units',
                        "data-key": 'file-unit',
                        "data-type": "files",
                        "text": "Select File"
                    });

                    data_group_col.append(data_group_BB_unit);

                    var data_group_hidden = $('<input/>', {
                        "type": 'hidden',
                        "data-name": 'file-unit',
                        "name": 'file-unit'
                    });

                    data_group_col.append(data_group_hidden);
                    $('.select_op_box').append(data_group);
                    break;
                case 'bb':
                    $("[data-key=some-unit]").attr('data-item', 'data_source');
                    //bb functional
                    break;
                case 'api':
                    $("[data-key=some-unit]").attr('data-item', 'data_source');
                    //api functional
                    break;
                case 'user_input':
                    $("[data-key=some-unit]").attr('data-item', 'user_input');
                    $.ajax({
                        type: 'GET',
                        url: "{!! url('/admin/modules/bburl/unit') !!}" + '/' + val,
                        datatype: 'json',
                        cache: false,
                        success: function (data) {
                            if (!data.error) {
                                $('#inpur_result').html(data.field);
                                $('.data-box').html(data.settings_html);
                            }

                        }
                    });
                    break;
                default :
                    $("[data-key=some-unit]").attr('data-item', '');
                    break;
            }
        }
    })
</script>
@stop
