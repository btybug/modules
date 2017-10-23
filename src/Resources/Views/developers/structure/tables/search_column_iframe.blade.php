<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>update file </title>
    {!! HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') !!}
    {!! HTML::style("/js/font-awesome/css/font-awesome.min.css") !!}
    {!! HTML::script('js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
    {!! HTML::style("/css/core_styles.css") !!}
</head>

<body>
<input type="hidden" id="save_action"
       value="{!! url('/admin/modules/tables/search-field-live-save',[$table,$column]) !!}">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            {!! Form::open(['url' => url('/admin/modules/tables/search-field-live-preview'),'class'=>'form-horizontal','id'=>'search_field_data_form']) !!}
            {!! Form::hidden('field_widget',$json_data['field_widget']) !!}
            {!! Form::hidden('data_source_table_name',$json_data['data_source_table_name']) !!}
            {!! Form::hidden('data_source_columns',$json_data['data_source_columns']) !!}
            {!! Form::hidden('data_source','related') !!}
            <div class="form-group">
                <label class="col-xs-4 col-md-4 control-label" for="search-unit">Unit</label>
                <div class="col-xs-8 col-md-8">
                    {!! BBbutton('units','some-unit','Select Unit',[
               'class' => 'btn btn-danger btn-md input-md',
               'data-type' => 'data_source'
               ]) !!}
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
                    {!! BBRenderWidget($json_data['field_widget'],$json_data) !!}
                </div>
            </div>
        </div>
    </div>

</div>
@include('resources::assests.magicModal')
{!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
<script type="text/javascript">
    $(document).ready(function () {

        $('#search_field_data_form').on('change', 'input[type], select', function () {
            getformdata($(this))
        }).on('keyup', 'input[type="text"] ', function () {
            getformdata($(this))
        })
        $('body').on('click', '.bbourpopup .item', function () {
            getformdata($(this))
        })


        function getformdata(e) {
            var formdata = $('#search_field_data_form').serialize();

            $.ajax({
                type: 'POST',
                url: $('#search_field_data_form').attr('action'),
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
    })
</script>
</body>
</html>
