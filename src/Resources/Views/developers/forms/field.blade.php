<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/html">
<!--<![endif]-->

<head>

    <meta charset="utf-8"/>
    <title>BB Admin Framework</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    {!! HTML::style("/css/bootstrap.css") !!}
    {!! HTML::style('js/jqueryui/css/jquery-ui.min.css') !!}
    {!! HTML::style('css/cms.css') !!}
    {!! HTML::script("js/jquery-2.1.4.min.js") !!}
    {!! HTML::script("js/jqueryui/js/jquery-ui.min.js") !!}
    {!! HTML::script("js/bootstrap.min.js") !!}
    {!! HTML::script("js/tinymice/tinymce.min.js") !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}


    {!! BBlinkFonts() !!}
    @yield('CSS')
    @stack('css')
</head>
<body>
{!! BBRenderWidget($field['field_widget'],$field) !!}
{!! HTML::style("/css/core_styles.css?v=1") !!}
</body>
@yield('JS')
@stack('javascript')
</html>
