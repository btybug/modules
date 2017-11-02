@extends('btybug::layouts.admin')
@section('content')
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <fieldset>

        <!-- Form Name -->
        <legend>Add column in {!! $table !!} table</legend>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="engine">Add after</label>
            <div class="col-md-4">
                {!! Form::select('after_column',$columns,null,['class'=>'form-control','id'=>'add_column']) !!}
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
                            <td>{!! Form::select('column[0][type]',$tbtypes,28,['class'=>'form-control']) !!}</td>
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
                    url: $('#add_column').attr('action'),
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
                            document.location.href = '/admin/modules/tables/edit/' + '{!! $table !!}';
                        }
                    }
                });
            })
        })
    </script>
@stop
