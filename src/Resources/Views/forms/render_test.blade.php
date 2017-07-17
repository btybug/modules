@extends('layouts.admin')
@section('content')

<div class="main_container">
    {!! BBRenderForm($id) !!}
</div>


@stop
@section('CSS')
    {!! HTML::style('resources/assets/js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('resources/assets/js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('resources/assets/js/animate/css/animate.css') !!}
    {!! HTML::style('resources/assets/css/form-builder.css?v=4.97') !!}
    {!! HTML::style('app\Modules\Modules\Resources\assets\css\modal_style.css') !!}
@stop

@section('JS')
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
@stop


