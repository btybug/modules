@extends('layouts.admin')
@section('content')
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <fieldset>

        <!-- Form Name -->
        <legend>Create New Table</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Table Name</label>
            <div class="col-md-4">
                {!! Form::text('name',null,['class'=>'form-control input-md']) !!}
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="engine">Storage Engine</label>
            <div class="col-md-4">
                {!! Form::select('engine_type',$engine,null,['class'=>'form-control']) !!}
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
                            <th>Column Name</th>
                            <th>DataType</th>
                            <th>Lenght/Values</th>
                            <th>Default</th>
                            <th>Null</th>
                            <th>Key Unique</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="table_engine">
                        <tr>
                            <td> {!! Form::text('column[0][name]',null,['class'=>'form-control']) !!}</td>
                            <td>{!! Form::select('column[0][type]',$tbtypes,null,['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('column[0][lenght]',null,['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('column[0][default]',null,['class'=>'form-control']) !!}</td>
                            <td>{!! Form::checkbox('column[0][nullable]') !!}</td>
                            <td>{!! Form::checkbox('column[0][unique]') !!}</td>

                            <td>
                                <span class='btn btn-warning'><i class='fa fa-trash' aria-hidden='true'></i></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Multiple Checkboxes (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="timestamps"></label>
            <div class="col-md-4">
                <label class="checkbox-inline" for="timestamps-0">
                    {!! Form::checkbox('timestamps',1,true) !!}
                    <span> Timestamps  (created_at,updated_at)</span>
                </label>
            </div>
        </div>

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
            $('#add_colum').on('click', function () {
                var column = "<tr>" +
                    '<td> <input type="text" name="column[' + i + '][name]" class="form-control"></input></td>' +
                    '<td><select name="column[' + i + '][type]" class="form-control">@foreach($tbtypes as $k=>$v) <option value="{!! $k !!}">{!! $v !!}</option> @endforeach</select></td>' +
                    '<td> <input type="text" name="column[' + i + '][lenght]" class="form-control"></input></td>' +
                    '<td> <input type="text" name="column[' + i + '][default]" class="form-control"></input></td>' +
                    '<td><input type="checkbox" name="column[' + i + '][nullable]"/></td>' +
                    '<td><input type="checkbox" name="column[' + i + '][unique]"/></td>' +
                    '<td><span class="btn btn-warning delete_row"><i class="fa fa-trash" aria-hidden="true"></i></span></td>' +
                    "</tr>";
                $('#table_engine').append($(column));
                i++;
            });

            $('body').on('click', '.delete_row', function () {
                $(this).parent().parent().remove();
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
        })
    </script>
@stop
