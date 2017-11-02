@extends('layouts.admin')
@section('content')

    <div class="main_container">
        {!! BBRenderForm($id) !!}
    </div>


@stop
@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    {!! HTML::style('css/form-builder.css?v=4.97') !!}
    {!! HTML::style('Btybug\Modules\Models\Resources\assets\css\modal_style.css') !!}
@stop

@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
@stop


