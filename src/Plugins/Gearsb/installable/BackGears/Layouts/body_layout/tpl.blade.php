<div class="row">
        <nav class="navbar navbar-default" role="navigation">


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if(BBgetConfigMenu("configMenu",isset($slug)?$slug:null))
                        @foreach( BBgetConfigMenu("configMenu",isset($slug)?$slug:null) as $key=>$item)
                            @if(!BBgetAdminPagesCilds($item['url']))
                    <li><a href="{!! url($item['url']) !!}">{!! $item['title'] !!}</a></li>
                       @else
                    <li class="dropdown">
                        <a href="{!! url($item['url']) !!}" class="dropdown-toggle" data-toggle="dropdown">{!! $item['title'] !!} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{!! url($item['url']) !!}">{!! $item['title'] !!}</a></li>

                        @foreach( BBgetAdminPagesCilds($item['url']) as $key=>$child)
                            <li><a href="{!! url($child->url) !!}">{!! $child->title !!}</a></li>
                                @endforeach
                        </ul>
                    </li>
                        @endif
                        @endforeach
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->

        </nav>

    <div class="col-md-12 container_placeholder">
        @yield('content')
    </div>
</div>
@push('css')
<style>
    .caret-up {
        width: 0;
        height: 0;
        border-left: 4px solid rgba(0, 0, 0, 0);
        border-right: 4px solid rgba(0, 0, 0, 0);
        border-bottom: 4px solid;

        display: inline-block;
        margin-left: 2px;
        vertical-align: middle;
    }

</style>
@endpush

@push('javascript')
<script>
    $(function(){
        $(".dropdown").hover(
                function() {
                    $('.dropdown-menu', this).stop(true,true).fadeIn("fast");
                    $(this).toggleClass('open');
                    $('b', this).toggleClass("caret caret-up");
                },
                function() {
                    $('.dropdown-menu', this).stop(true,true).fadeOut("fast");
                    $(this).toggleClass('open');
                    $('b', this).toggleClass("caret caret-up");
                });
    });

</script>
@endpush