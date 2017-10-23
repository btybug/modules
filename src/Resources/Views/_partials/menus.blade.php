@if(count($menus))
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">

            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                    <center>
                        <div class="">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="sidebar-nav">
                                        <div class="navbar navbar-default" role="navigation">
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse"
                                                        data-target=".sidebar-navbar-collapse">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                <span class="visible-xs navbar-brand">Sidebar menu</span>
                                            </div>
                                            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                                <ul class="nav navbar-nav">

                                                    @foreach($menus as $item)
                                                        <li data-href="{!! $item->url !!}"><a
                                                                    href="#">{!! $item->title !!}</a></li>

                                                    @endforeach
                                                </ul>
                                            </div><!--/.nav-collapse -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </center>
                </div>
            </div>
        </div>
    </div>
@endif
