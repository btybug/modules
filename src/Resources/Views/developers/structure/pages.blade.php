@extends('btybug::layouts.mTabs',['index'=>'developers_structure'])
@section('tab')
    <div class="col-md-12">
        <div class="col-md-8" style="border: 1px solid black;">
            <div role="tabpanel" class="m-t-10" id="admin_pages">
                <div class="row">
                    <div class="col-md-8 p-t-10">
                        {!! hierarchyAdminPagesListWithModuleName($pageGrouped) !!}
                    </div>
                </div>
            </div>
            {!! \Eventy::filter('admin_pages.widgets') !!}
        </div>
        <div class="col-md-4" style="border: 1px solid black;min-height: 500px;">
            <div class="module-info-panel"></div>
            {!! \Eventy::filter('admin_pages.widgets',2) !!}
        </div>
    </div>
@stop
@push('css')
    {!! HTML::style('/public/css/page.css?v=0.13') !!}
@endpush
@push('javascript')
    <script>
        $(document).ready(function () {
            $("body").on('click', '.module-info', function () {
                var id = $(this).attr('data-module');
                var item = $(this).find("i");
                $.ajax({
                    url: '/admin/modules/module-data',
                    data: {
                        id: id,
                        _token: $('#token').val()
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

            $("body").on('click', '.view-url', function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/admin/modules/pages-data',
                    data: {
                        id: id,
                        _token: $('#token').val()
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
@endpush
