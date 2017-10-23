@extends('layouts.admin')
@section('content')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 right">
        <article>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div id="styles" class="panel_bd_styles leftpanelwithoutscroll">


                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 m-b-10 buttons">
                <div class="pull-right">
                    <button class="save_btn"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
                </div>
            </div>
            {!! Form::open(['id'=>'form_data', 'class'=>'form-horizontal']) !!}
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 create">
                <div class="formdatainfo" data-put="forminfo">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="well well-sm">This modules not tegistred pages will be redirected</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="customradio radio">
                                        <input type="radio" id="404" checked data-typepage="404" name="redirect"
                                               @if(isset($settings->val) and $settings->val==404) checked
                                               @endif value="404"><label for="404">404</label>
                                    </div>
                                    <div class="customradio radio">
                                        <input type="radio" id="505" data-typepage="505" name="redirect"
                                               @if(isset($settings->val) and $settings->val==505) checked
                                               @endif value="505"><label for="505">505</label>
                                    </div>
                                    <div class="customradio radio">
                                        <input type="radio" id="custom_url" data-typepage="custom_url" name="redirect"
                                               @if(isset($settings->val) and $settings->val!=505 and $settings->val!=404) checked
                                               @endif value="custom"><label for="custom_url">Custom url</label>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div data-targetpage="custom_url" class="hide">
                                        <label for="redirectto" class="col-sm-4 control-label p-r-5"><i
                                                    class="fa fa-file-text" aria-hidden="true"></i>Redirect to</label>
                                        <div class="col-sm-8"><input type="text" name="redirectto" id="redirectto"
                                                                     value="{!! $settings->val or null !!}"
                                                                     class="form-control"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 create">
                <div class="formdatainfo formfixed" data-put="forminfo">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                            <div class="form-group">
                                <div class="col-sm-11">
                                    <input type="text" name="url" id="url" value="admin/modlu" readonly
                                           class="form-control">
                                </div>
                                <div class="col-sm-1">
                                    <span class="led-radius " data-fieldname="page"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="customradio radio">
                                        <input type="radio" id="havepage" checked data-typepage="havepage" name="page"
                                               value="on"><label for="havepage">Have Page</label>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div>
                                        <label for="pagename" class="col-sm-4 control-label p-r-5"><i
                                                    class="fa fa-file-text" aria-hidden="true"></i>Page name </label>
                                        <div class="col-sm-8"><input type="text" name="pagename" id="pagename"
                                                                     value="Abokamal" class="form-control"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="led-box">
                                        <div class="led-red"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="info"></div>
            {!! Form::hidden('slug',$module) !!}
            {!! Form::close() !!}

        </article>
    </div>
@stop
{{--@include('tools::common_inc')--}}
@section('CSS')
    {!! HTML::style('css/create_pages.css') !!}
    {!! HTML::style('css/menu.css?v=0.16') !!}
    {!! HTML::style('css/tool-css.css?v=0.23') !!}
    {!! HTML::style('css/page.css?v=0.15') !!}
    {!! HTML::style('css/admin_pages.css') !!}
    {!! HTML::style('js/tag-it/css/jquery.tagit.css') !!}
@stop

@section('JS')
    {!! HTML::script('js/create_pages.js') !!}
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('js/admin_pages.js') !!}
    {!! HTML::script('js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('js/icon-plugin.js?v=0.4') !!}
    {!! HTML::script('js/tag-it/js/tag-it.js') !!}
    {!! HTML::script('js/jstree.min.js') !!}
    <script>

        $(document).ready(function () {
            $('#html1').jstree();
            $("body").on('click', '.add-new-adminpage', function () {
                $('#adminpage').modal();
            });
            if ($('#tagits').length > 0) {
                var getExt = $('#tagits').data('allwotag').split(',')

                $('#tagits').tagit({
                    availableTags: getExt,
                    // This will make Tag-it submit a single form value, as a comma-delimited field.
                    autocomplete: {delay: 0, minLength: 0},
                    singleField: true,
                    singleFieldNode: $('.tagitext'),
                    beforeTagAdded: function (event, ui) {
                        if (!ui.duringInitialization) {
                            var exis = getExt.indexOf(ui.tagLabel);
                            if (exis < 0) {
                                $('.tagit-new input').val('');
                                //alert('PLease add allow at tag')
                                return false;
                            }
                        }

                    }
                })
            }

            function formfixed() {
                var getwindowscroll = $(window).scrollTop();
                var getwindowwidth = $(window).width();
                var formfixedh = $('.formfixed').height();
                if (980 < getwindowwidth) {
                    var getoffset = $('.formfixed').closest('.create').offset().top;
                    if (getoffset < getwindowscroll) {
                        var getcss = getwindowscroll - getoffset;
                        $('.formfixed').css('top', getcss)
                        $('.formfixed').addClass('formfixedatrop');
                        $('.formfixed').closest('.create').css('padding-top', formfixedh);
                    } else {
                        $('.formfixed').css('top', 0)
                        $('.formfixed').removeClass('formfixedatrop');
                        $('.formfixed').closest('.create').css('padding-top', 0);
                    }
                } else {
                    $('.formfixed').css('top', 0)
                    $('.formfixed').removeClass('formfixedatrop');
                    $('.formfixed').closest('.create').css('padding-top', 0);
                }
            }

            formfixed();
            $(window).scroll(formfixed);

            $('[data-dropmenu="menu"]').click(function (e) {
                e.preventDefault()
                var targetli = $(this).closest('li');
                if (targetli.hasClass('active')) {
                    $(this).next('ul').slideUp()
                    targetli.removeClass('active')

                } else {
                    $(this).next('ul').slideDown()
                    targetli.addClass('active')
                }
            })
            $('[data-getinfo]').click(function (e) {
                var getdata = $(this).closest('li').data();
                $('[data-fieldname="page"]').removeClass('led-radiusgreen')
                $.each(getdata, function (key, val) {
                    if (key == 'page') {
                        $('[data-fieldname="page"]').addClass('led-radiusgreen')
                    }
                    if ($('[name="' + key + '"]').is('[type="radio"]')) {
                        $('[name="' + key + '"]').val(val)
                    } else {
                        $('[name="' + key + '"]').val(val)
                    }
                })
            })


            $('[data-typepage]').change(function () {
                uodatepaged();
            })
            uodatepaged()

            function uodatepaged() {
                var gettype = $('[data-typepage]:checked').data('typepage');
                $('[data-targetpage]').addClass('hide')
                $('[data-targetpage="' + gettype + '"]').removeClass('hide')
            }

            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/backend/build/admin-pages/module-data',
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                        item.removeClass('fa-info-circle');
                        item.addClass('fa-refresh');
                        item.addClass('fa-spin');
                    },
                    success: function (data) {
                        item.removeClass('fa-refresh');
                        item.removeClass('fa-spin');
                        item.addClass('fa-info-circle');
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });
            $("body").on('click', '.save_btn', function () {
                $.ajax({
                    type: 'POST',
                    url: '/admin/modules/config/build/admin-urls/save-data',
                    data: $('#form_data').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        } else {
                            if (data.message) {
                                var alertmessage = ''
                                $.each(data.message, function (key, val) {
                                    alertmessage = '<b class="text-danger"> ' + key + '</b> ' + val + '<br>';
                                    $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                                });
                                bootbox.alert(alertmessage);
                            }
                        }
                    },
                });
            });

            $("body").on('click', '.view-url', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/backend/build/admin-pages/pages-data',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('.module-info-panel').html('');
                    },
                    success: function (data) {
                        if (!data.error) {
                            $('.module-info-panel').html(data.html);
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
@stop