@extends('layouts.admin')
@section('content')
    <h2>table :{!! $table !!} |column:{!! $column !!}</h2>
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <fieldset>
        <!-- Form Name -->
        <div class="row legend">
            <div class="col-xs-6">
                <legend>Manage Fields</legend>
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
    </fieldset>
    {!! Form::close() !!}
    <a class="btn btn-danger add-new-field"><i class="fa fa-plus"></i>Add Field</a>
    @include('resources::assests.magicModal')
    @include('cms::_partials.delete_modal')

@stop
@section('JS')
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        $(document).ready(function () {
            $('body').on('click', '.add-new-field', function () {
                $.ajax({
                    url: '/admin/modules/tables/field/add-new-field/' + $('#field_list tr').length,
                    type: 'GET',
                    dataType: 'JSON'
                }).done(function (data) {
                    $('#field_list').append(data.html);
                }).fail(function (data) {
                    alert('Could not add new field. Please try again.');
                });
            });

            $('body').on('change', '.field-input', function () {
                if ($(this).parents('.field-row').find('.field-state').val() == 'current') {
                    $(this).parents('.field-row').find('.field-state').val('updated');
                }
            });

            $('.bb-button-realted-hidden-input').on('change', function () {
                if ($(this).parents('.field-row').find('.field-state').val() == 'current') {
                    $(this).parents('.field-row').find('.field-state').val('updated');
                }
            });

            $('body').on('click', '.delete-new-field', function () {
                $(this).parents('.field-row').remove();
            });
        });

    </script>
@stop