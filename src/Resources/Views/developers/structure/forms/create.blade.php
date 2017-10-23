@extends('layouts.admin')
@section('content')
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <fieldset>

        <!-- Form Name -->
        <legend>Create Avesome Form</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Form Name</label>
            <div class="col-md-4">
                {!! Form::text('name',null,['class'=>'form-control input-md']) !!}
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group" id="hideble_lable">
            <label class="col-md-4 control-label" for="engine">Select Table</label>
            <div class="col-md-4">
                {!! Form::select('tables',[null=>'Select']+$tables,null,['class'=>'form-control','id'=>'tables_lists']) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12 control-label" for="engine"></label>
            <div class="col-md-12">
                <div class="col-md-12">
                    <h2>Columns</h2>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Select field</th>
                            <th>FieldType</th>
                            <th>Lenght/Values</th>
                            <th>Default</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="form_engine">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Multiple Checkboxes (inline) -->

    </fieldset>
    {!! Form::close() !!}
    <button type="button" id="add_colum" class="btn btn-info">Add Column</button>
    <button type="button" class="btn btn-success" id="submit_form">Create</button>

    @include('modules::developers._partials.mysql_error')
@stop
@section('JS')
    <script type="text/javascript">
        $(document).ready(function () {
            var i = 1;
            var table = 0;
            var colums;
            $('#add_colum').on('click', function () {
                if (!table) return false;
                var column = "<tr>" +
                    '<td><select name="column[' + i + '][column]" class="form-control">' + colums + '</select></td>' +
                    '<td><select name="column[' + i + '][type]" class="form-control"><option value=""></option></select></td>' +
                    '<td> <input type="text" name="column[' + i + '][lenght]" class="form-control"/></td>' +
                    '<td> <input type="text" name="column[' + i + '][default]" class="form-control"/></td>' +
                    '<td><span class="btn btn-warning delete_row"><i class="fa fa-trash" aria-hidden="true"></i></span></td>' +
                    "</tr>";
                $('#form_engine').append($(column));
                i++;
                $('#hideble_lable').hide();
            });

            $('body').on('click', '.delete_row', function () {
                $(this).parent().parent().remove();
                var count = $('#form_engine').find('tr').length;
                if (!count) {
                    $('#hideble_lable').show();
                }
                ;
            });
            $('#submit_form').on('click', function () {
                var data = $('form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/admin/modules/tables/create',
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
//                            document.location.href = '/admin/modules/tables';
                        }
                    }
                });
            })
            $('#tables_lists').on('change', function () {
                table = $(this).val();
                var data = {'table': table};
                $.ajax({
                    type: 'POST',
                    url: '/admin/modules/forms/getColumns',
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}',
                    },
                    datatype: 'json',
                    cache: false,
                    data: data,
                    success: function (data) {
                        if (data.error) {

                        } else {
                            colums = data.options;
                        }
                    }
                });
            })
        })
    </script>
@stop
