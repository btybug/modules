@if(count($themes))
    @foreach($themes as $theme)
        <div class="row themes m-b-10">
            <div class="col-xs-12 p-l-0 p-r-0">
                @if(isset($theme->image))
                    <img src="{!! url('resources/templates/'.$theme->type.'/'.$theme->slug. '/images/'. $theme->image)!!}"  style="height: 167px;" class="img-responsive"/>
                @else
                    <img src="{!! url('resources/assets/images/template-2.png')!!}" class="img-responsive"/>
                @endif
            </div>
            <div class="col-xs-12 templates-header p-t-10 p-b-10">
                <span class="pull-left templates-title f-s-15 col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0  "><i class="fa fa-bars f-s-13 m-r-5" aria-hidden="true"></i>  {!! $theme->name or $theme->slug !!}</span>
                <div class="pull-right templates-buttons col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right ">
                    <i class="fa fa-user f-s-13 author-icon" aria-hidden="true"></i>
                    {!! @$theme->author !!}, {!! BBgetDateFormat($theme->created_at) !!}

                    <a href="{!! url($theme->settings_url) !!}" class="addons-settings  m-l-10 m-r-10"><i class="fa fa-cog f-s-14"></i> </a>

                    @if(isset($active->slug) && $theme->slug == $active->slug)
                        <span class="label label-success m-r-10"><i class="fa fa-check"></i> Active</span>
                    @else
                        <a href="{!! url('/admin/modules/theme/front-themes-activate',$theme->slug) !!}" class="label label-info m-r-10 activate-theme"  style="cursor: pointer;">Activate</a>
                    @endif
                    <a href="javascript:void(0)" slug="{!! $theme->slug !!}" class="addons-delete del-tpl"><i class="fa fa-trash-o f-s-14 "></i> </a>
                </div>
            </div>
        </div>

    @endforeach
@else
    <div class="col-xs-12 themes-no">
        NO Themes
    </div>
@endif
