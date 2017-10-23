<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>update file </title>
    {!! HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') !!}
    {!! HTML::style("/js/font-awesome/css/font-awesome.min.css") !!}
    {!! HTML::script('js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
</head>

<body>

<input type="hidden" id="save_action" value="{!! url('/admin/modules/tables/field-live-save',[$table,$column]) !!}">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            {!! Form::open(['url' => url('/admin/modules/tables/field-live-preview'),'class'=>'form-horizontal','id'=>'field_data_form']) !!}
            <ul class="nav nav-tabs editemailnav">
                <li class="active"><a data-toggle="tab" href="#inputs">field input</a></li>
            </ul>

            <div class="tab-content editLeftCol">
                <div id="inputs" class="tab-pane fade in  active">

                    {!! Form::hidden('widget',$json_data['widget']) !!}
                    <div class="form-group">
                        <label class="col-xs-4 col-md-4 control-label" id="unit_type_lable"
                               for="name">{{ (isset($json_data['input_area']) && $json_data['input_area']== 'select_options') ? 'Select' : 'User' }}
                            input Type</label>
                        <div class="col-xs-8 col-md-8">
                            {!! BBbutton('units','some-unit','Select Input',['class' => 'btn btn-danger btn-md input-md','model' => $json_data]) !!}
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
        <div class="col-md-7">
            <div class="row editRowTitle">
                <div class="col-xs-12"> Preview</div>
            </div>
            <div class="row editRightCol">
                <div class="col-md-12 editIframe" data-previewiframe="preview">

                    {!! BBRenderWidget($json_data['widget'],$json_data) !!}
                </div>
            </div>
        </div>
    </div>
</div>


@include('resources::assests.magicModal')
{!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#savefielddata').on('click', function () {
            saveAnin();
        })

        function saveAnin() {
            $('.save_anime').show();
//            $('.save_anime').hide().slide();

        }

        $('#field_data_form').on('change', 'input[type], select', function () {
            getformdata($(this))
        }).on('keyup', 'input[type="text"] ', function () {
            getformdata($(this))
        })
        $('body').on('click', '.item', function () {
            getformdata($(this))
        })


        function getformdata(e) {
            var formdata = $('#field_data_form').serialize();
            var nameofield = e.attr('name');
            formdata = formdata + '&trigger=' + nameofield
            $.ajax({
                type: 'POST',
                url: $('#field_data_form').attr('action'),
                headers: '{!! csrf_token() !!}',
                datatype: 'json',
                cache: false,
                data: formdata,
                success: function (data) {
                    if (data.error) {
                        alert(data.error)
                    } else {
                        $('[data-previewiframe="preview"]').html(data.html)
                    }
                }
            });
        }

        $('[name=input_area]').on('change', function () {
            $('.data-box').html('');

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
                    'related': 'Related',
                    'file': 'File'
                }, function (k, v) {
                    $(data_source).append("<option value='" + k + "'>" + v + "</option>");
                });

                $('.data-box').append(data_group);

                var select_op_box = $('<div/>', {
                    class: 'select_op_box'
                });
                $('.data-box').append(select_op_box);
            }
        });

        function dataSource() {
            $('.data-source-box').remove();
            $('.columns_list').remove();
            $('.select_op_box').html('');
//            $('#data_source_type_val').remove();
//            $('#data_source_type_key').remove();
//            $('#data_source_type_default').remove();
            var val = $('#data_source').val();

            var data_group = $('<div/>', {
                "class": 'form-group data-source-box'
            });
            switch (val) {
                case 'file':
                    $('.file-box').remove();
//                        $("[data-key=some-unit]").attr('data-item', 'data_source');
                    //file functional
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
                    var data_group_label = $('<label/>', {
                        "class": 'col-md-4 control-label',
                        "for": 'bbfunction',
                        "text": 'Insert BB'
                    });

                    data_group.append(data_group_label);

                    var data_group_col = $('<div/>', {
                        class: 'col-md-4'
                    });
                    data_group.append(data_group_col);
                    var data_group_BB_input = $('<input/>', {
                        "class": 'btn btn-warning btn-md input-md',
                        "type": 'text',
                    });

                    data_group_col.append(data_group_BB_input);
                    $('.select_op_box').append(data_group);
                    //bb functional
                    break;
                case 'api':
                    $("[data-key=some-unit]").attr('data-item', 'data_source');
                    //api functional
                    break;
                case 'related':
                    $("[data-key=some-unit]").attr('data-item', 'data_source');
                    $.ajax({
                        type: 'GET',
                        url: "{!! url('/admin/modules/tables/table-names') !!}",
                        datatype: 'json',
                        cache: false,
                        success: function (data) {
                            if (!data.error) {
                                var data_group_label = $('<label/>', {
                                    "class": 'col-md-4 control-label',
                                    "for": 'bbfunction',
                                    "text": 'Select Table'
                                });

                                data_group.append(data_group_label);

                                var data_group_col = $('<div/>', {
                                    class: 'col-md-4'
                                });
                                data_group.append(data_group_col);

                                var data_source_related = $('<select/>', {
                                    "class": 'form-control',
                                    "id": 'data_source_table_name',
                                    "name": "data_source_table_name"
                                });

                                data_source_related.append($('<option>', {value: '', text: 'Select Table Name'}));

                                $.each(data.data, function (k, v) {
                                    $(data_source_related).append("<option value='" + v + "'>" + v + "</option>");
                                });

                                data_group_col.append(data_source_related);
                                $('.select_op_box').append(data_group);
                            }
                        }
                    });
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

        $('body').on('change', '#data_source', function () {
            dataSource();
        });


        $("body").on('click', '.file-item-dynamic', function () {
            var id = $("[name=file-unit]").val();
            $('.file-box').remove();

            $.ajax({
                type: 'GET',
                url: "{!! url('/admin/modules/bburl/get-heading') !!}" + '/' + id,
                datatype: 'json',
                cache: false,
                success: function (data) {
                    if (!data.error) {

                        var form_group = $('<div/>', {
                            class: 'form-group file-box'
                        });

                        var form_group_col = $('<div/>', {
                            class: 'col-xs-8 col-md-offset-4'
                        });
                        form_group.append(form_group_col);

                        var data_source_type_key = $('<select/>', {
                            "class": 'form-control',
                            "id": 'data_source_type_key',
                            "name": "data_source_type_key"
                        });

                        form_group_col.append(data_source_type_key);

                        data_source_type_key.append($('<option>', {value: '', text: 'Select Data Key'}));


                        var form_group_val = $('<div/>', {
                            class: 'form-group file-box'
                        });

                        var form_group_col_val = $('<div/>', {
                            class: 'col-xs-8 col-md-offset-4'
                        });
                        form_group_val.append(form_group_col_val);

                        var data_source_type_val = $('<select/>', {
                            "class": 'form-control',
                            "id": 'data_source_type_val',
                            "name": "data_source_type_val",
                            "option": {'': "select"}
                        });

                        form_group_col_val.append(data_source_type_val);
                        data_source_type_val.append($('<option>', {value: '', text: 'Select Data Value'}));

                        $.each(data.data, function (k, v) {
                            $(data_source_type_key).append("<option value='" + v + "'>" + v + "</option>");
                            $(data_source_type_val).append("<option value='" + v + "'>" + v + "</option>");
                        });

                        $('.data-source-box').append(form_group_val, form_group);

                    }

                }
            });

        });


        $("body").on('change', '#data_source_table_name', function () {
            var val = $(this).val();
            $.ajax({
                type: 'POST',
                url: "{!! url('/admin/modules/tables/get-table-columns') !!}",
                datatype: 'json',
                data: {val: val},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                cache: false,
                success: function (data) {
                    $('.columns_list').remove();
                    var data_group = $('<div/>', {
                        "class": 'form-group columns_list'
                    });
                    var data_group_label = $('<label/>', {
                        "class": 'col-md-4 control-label',
                        "for": 'data_source_columns',
                        "text": 'Select Column'
                    });

                    data_group.append(data_group_label);

                    var data_group_col = $('<div/>', {
                        class: 'col-md-4'
                    });
                    data_group.append(data_group_col);

                    var data_source_related = $('<select/>', {
                        "class": 'form-control',
                        "id": 'table_column',
                        "name": "data_source_columns"
                    });

                    data_source_related.append($('<option>', {value: '', text: 'Select Column'}));

                    $.each(data.data, function (k, v) {
                        $(data_source_related).append("<option value='" + v + "'>" + v + "</option>");
                    });

                    data_group_col.append(data_source_related);
                    $('.select_op_box').append(data_group);
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
                    var form_group = $('<div/>', {
                        class: 'form-group file-box'
                    });

                    var form_group_col = $('<div/>', {
                        class: 'col-xs-8 col-md-offset-4'
                    });
                    form_group.append(form_group_col);

                    var data_source_type_default = $('<select/>', {
                        "class": 'form-control',
                        "id": 'data_source_type_default',
                        "name": "data_source_type_default"
                    });

                    form_group_col.append(data_source_type_default);

                    data_source_type_default.append($('<option>', {value: '', text: 'Select Default Value'}));

                    $.each(data, function (k, v) {
                        $(data_source_type_default).append("<option value='" + v + "'>" + v + "</option>");
                    });

                    $('.data-source-box').append(form_group);
                }
            });
        });
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

    })
</script>
</body>
{!! HTML::style("/css/core_styles.css") !!}

</html>
