@extends('layouts.pagesPreview')

@section('content')
    <div class="previewlivesettingifream">
        @if($data['page'] and $data['url'])
            <iframe src="{{ $data['url'].'?pl='. $data['layout'].'&pl_live_settings=page_live&page_id='.$data['page_id'] }}" id="iframeinfor"></iframe>
            <div class="iframenotclickable"></div>
        @else
            Admin Page can't be rendered
        @endif
    </div>
  <div class="withoutifreamsetting animated bounceInRight hide" data-settinglive="settings">
    <form id="add_custome_page" action="#" method="post">
        @if(isset($settingsHtml))
            @include($settingsHtml,$settings)
        @endif
    </form>
  </div>
<div  id="previewImageifreamimage"></div>
@stop

@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/preview-template.css') !!}
    {!! HTML::style("/js/animate/css/animate.css") !!}
    {!! HTML::style("/css/preview-template.css") !!}
@stop

@section('JS')
    {!! HTML::script("js/html2canvas/js/html2canvas.js") !!}
    {!! HTML::script("js/canvas2image/js/canvas2image.js") !!}
     {!! HTML::script("js/bootbox/js/bootbox.min.js") !!}
     {!! HTML::script("js/UiElements/ui-page-preview-setting.js") !!}
     
   
    <script>
        $(document).ready(function(){
            
          
            $('body').on('change','.change-layout',function(){
                var layoutID = $(this).val();
                var currentUrl = window.location.href;
                var res = currentUrl.split('/');
                var last = res[res.length - 1];

                var page = last.substring(-1, last.indexOf('?'));
                res[res.length - 1] = page + "?pl=" + layoutID;
                res = res.join('/');

                window.location.href = res;
            });
        });
    </script>
@stop