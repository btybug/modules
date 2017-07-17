@extends('layouts.admin')
@section('content')
    {!! Form::open(['class'=>'form-horizontal']) !!}
        <!-- Form Name -->
        <div class="row">
            <div class="col-xs-6">
                <h3>Edit Column</h3>
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
                        <td>{!! Form::text('column[0][default]',$column_info->COLUMN_DEFAULT,['class'=>'form-control']) !!}</td>
                        <td>{!! Form::select('column[0][nullable]',[0=>'required',1=>'not required'],($column_info->IS_NULLABLE=="NO")?0:1,['class'=>'form-control']) !!}</td>
                        <td>{!! Form::checkbox('column[0][unique]',true,($column_info->COLUMN_KEY=="UNI")?true:false ) !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    {!! Form::close() !!}

<hr/>
    {!! Form::open(['url' => url('admin/modules/tables/edit-column', [$table, $column]) ,'class'=>'form-horizontal']) !!}
        <!-- Form Name -->
        <div class="row">
            <div class="col-xs-6">
                <h3>Manage Fields</h3>
            </div>
            <div class="col-xs-6 text-right">
                <button type="submit" class="btn btn-success" id="submit_form">Update</button>
            </div>
        </div>

        <div class="row m-b-10">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-black text-white">
                        <th>Slug</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Label</th>
                        <th>Placeholder</th>
                        <th>Default Value</th>
                        <th>Options</th>
                        <th>Unit</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="field_list">
                    @if($fields->count())
                        @foreach($fields as $count => $field)
                            @include('modules::developers._partials.custom_field')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    {!! Form::close() !!}
    <a class="btn btn-danger add-new-field"><i class="fa fa-plus"></i>Add Field</a>

    <hr/>

    <div class="row">
        <div class="col-xs-6">
            <h3>Display Fields</h3>
        </div>
    </div>
    <div class="row m-b-10">
        <label class="col-md-12 control-label" for="engine"></label>
        <div class="col-md-6">
            @foreach($fields as $count => $field)
                <div class="form-group">
                    @include('modules::developers.fields.' . $field->type)
                </div>
            @endforeach
        </div>
    </div>

    {{--<div class="emailsettingiframe">--}}
        {{--<iframe src="{!!url('/admin/modules/tables/field/render-column-fields',[$table,$column])!!}" data-fieldifame="field"></iframe>--}}
    {{--</div>--}}




    @include('resources::assests.magicModal')
    @include('_partials.delete_modal')

    @include('modules::developers._partials.mysql_error')
    @include('resources::assests.magicModal')
@stop

@section('CSS')
    <style>
        #save_anime{
            display: none;
            background: rgba(0, 222, 27, 0.06);
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 9999;
            /*border: 1px solid;*/
            font-size: 190px;
        }
        #save_anime span{
            color: rgba(0, 0, 0, 0.71);
            position: absolute;
            left: 42%;
            top: 30%;
        }
    </style>
    {!! HTML::style('resources/assets/css/preview-template.css') !!}
    {!! HTML::style('resources/assets/js/select2/css/select2.min.css') !!}

@stop
@section('JS')
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script("resources/assets/js/select2/js/select2.full.min.js") !!}
     <script type="text/javascript">
       
       $(function() {

           $(".option-values").select2({
               tags: true
           });

           $('body').on('click', '.add-new-field', function() {
               $.ajax({
                   url: '/admin/modules/tables/field/add-new-field/' + $('#field_list tr').length,
                   type: 'GET',
                   dataType: 'JSON'
               }).done(function(data) {
                   $('#field_list').append(data.html);
               }).fail(function(data) {
                   alert('Could not add new field. Please try again.');
               });
           });

           $('body').on('change', '.field-input', function() {
               if($(this).parents('.field-row').find('.field-state').val() == 'current') {
                   $(this).parents('.field-row').find('.field-state').val('updated');
               }
           });

           $('.bb-button-realted-hidden-input').on('change', function() {
               if($(this).parents('.field-row').find('.field-state').val() == 'current') {
                   $(this).parents('.field-row').find('.field-state').val('updated');
               }
           });

           $('body').on('click', '.delete-new-field', function() {
               $(this).parents('.field-row').remove();
           });
        
            $('#savefielddata').click(function(){
                  var iframeselector = $('[ data-fieldifame="field"]').contents().find("#field_data_form")
                  var actioninput = $('[ data-fieldifame="field"]').contents().find("#save_action")
                  var getiframedata = iframeselector.serialize();
                  var actionurl = actioninput.val();
               $('#save_anime').show();
                    
                   $.ajax({
                          type: 'POST',
                          url: actionurl,
                          headers: '{!! csrf_token() !!}',
                          datatype: 'json',
                          cache: false,
                          data: getiframedata,
                          success: function (data) {
                              if (data.error) {
                                  alert(data.error)
                              }else{
                                  $('#save_anime').animate({
                                      left: '40%',
                                      top: '40%',
                                      opacity: '0',
                                      height: '0px',
                                      width: '0px',
                                      "font-size":'20px'
                                  },600).promise().done(function (e) {
                                      e.css({
                                          left: '0%',
                                          top: '0%',
                                          opacity: '1',
                                          height: '100%',
                                          width: '100%',
                                          display:'none',
                                          "font-size":'190px',
                                          'border-radius':'0%',

                                      })
                                  })

                              }
                          }
                      });
              
              
            })
            
            $('#saveSearchFieldData').click(function(){
                  var iframeselector = $('[data-fieldifame="searchfiled"]').contents().find("#search_field_data_form")
                  var actioninput = $('[data-fieldifame="searchfiled"]').contents().find("#save_action")
                  var getiframedata = iframeselector.serialize();
                  var actionurl = actioninput.val();

                   
                   $.ajax({
                          type: 'POST',
                          url: actionurl,
                          headers: '{!! csrf_token() !!}',
                          datatype: 'json',
                          cache: false,
                          data: getiframedata,
                          success: function (data) {
                              if (data.error) {
                                  alert(data.error)
                              }else{

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

            $('input[name=input_area]').on('change',function () {
                var type=$(this).val();
                $.ajax({
                    type: "post",
                    datatype: "json",
                    cache: false,
                    url: '/admin/modules/bburl/unit-main-default',
                    data: {'type':type
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
