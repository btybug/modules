@extends('layouts.admin')
@section('content')
    @inject('dbhelper', 'Sahakavatar\Cms\Helpers\helpers')
    @include('resources::assests.magicModal')
    <input type="hidden" id="form_id" value="{!! $form->id or null !!}">
<div class="builderWrapper">
    <div class="builderHeader row">
         <div class="col-xs-6 col-sm-6 p-t-10">
             {!! BBbutton('widgets','form_layout','<i class="buidericon bildericon-fieldlayout"></i> Form Layout',['class' => 'btn btn-default btn-sm btn-builder-blue','data-type' => 'forms']) !!}
             {!! BBbutton('widgets','widget','<i class="glyphicon glyphicon-tint"></i> Fields Style',['class' => 'btn btn-default btn-sm btn-builder-green','data-type' => 'fields']) !!}
           <button class="btn btn-default btn-sm btn-builder-gray" data-toggle="modal" data-target="#settingform"><i class="fa fa-cog"></i> Settings</button>
         </div>
        <div class="col-xs-6 col-sm-6 text-right p-0">

                     <input type="text" class="builderfrom" placeholder="Form name" value="Form Name 0001">

                     <a href="#" class="btn btn-link btn-link-gray" data-value="{!!$form->id or null!!}" data-save="form" ><i class="fa fa-check" aria-hidden="true"></i> Save</a>
                     <a href="#" class="btn-red-close " data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></a>
                     <input type="hidden" id="panelID" value="">

            </div>
    </div>


    <div class="buildercontainer">
        <nav class="navbar navbar-default hide">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Form name</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control form_name" placeholder="Form name">
                        </div>
                        <button  type="button" class="btn btn-default setting_button"><i class="fa fa-cog" aria-hidden="true"></i>Setting</button>
                        <button class="btn btn-default edit_button"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    </form>

                    <div class="nav navbar-nav navbar-right">
                        <a  href="{!! url('#') !!}" class="btn btn-default first_button">Discard </a>
                        <a href="#" class="btn btn-default second_button">Save</a>

                    </div>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3 p-0 builderleft_section">
               <ul class="nav nav-tabs nav-justified builder-tabs" data-fieldtab="">
                  <li class="active"><a href="#builderFields" aria-controls="builderFields" role="tab" data-toggle="tab" data-dragdata="builderFields" data-val="0"> <i class="buidericon bildericon-field"></i>  Fields</a></li>
                  <li><a href="#builderTool" aria-controls="builderTool" role="tab" data-toggle="tab" data-dragdata="builderTool" data-val="general" > <i class="buidericon bildericon-tool"></i> Tool</a></li>
                </ul>
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="builderFields">

                   <div class="for_dropdown_and_fields p-10">
                    <div class="form-group listoffield">
                        @if(count($fields))
                            <ul id="sortable1" class="connectedSortable fields" data-sortlist="field">
                                @foreach($fields as $field)
                                    <li class="dragdiv connectedSortable height-40 text-center" data-button="edit,delete" data-type="field" data-title="{{ $field->column_name }}" data-uniq="{!! uniqId() !!}" data-el="{!! $field->id  !!}" >
                                    <span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span>    {{ $field->column_name }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                          <ul id="sortable1" class="connectedSortable fields" data-sortlist="field">
                              No Fields
                          </ul>
                        @endif
                       {{--<ul class="p-10 hide" data-sortlist>--}}
                        {{--<li data-name="Field name" data-required="false" data-id="0">--}}
                          {{--<span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span> Field Name--}}
                        {{--</li>--}}
                        {{----}}
                      {{--</ul> --}}

                        <div id="fields_box"></div>

                        <hr class="builderhr" />
                        <h5><strong>Unconfigured Fields</strong></h5>
                        @if(count($unconfigured))
                            <ul class="unconfigured_fields" >
                                @foreach($unconfigured as $f)
                                    <li class="dragdiv  height-40 text-center" data-button="edit,delete" data-type="field" data-title="{{ $f->Field }}" data-uniq="{!! uniqId() !!}" >
                                      <span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span>
                                        <a href="{!! url('admin/modules/tables/edit-column',[$table,$f->Field]) !!}" target="_blank" class="btn btn-default btn-sm btn-builder-blue btn-configure" title="Configure">
                                            <i class="fa fa-cogs"></i>
                                        </a>  {{ $f->Field }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            No Fields
                        @endif
                    </div>
                </div>
                 </div>
                 <div role="tabpanel" class="tab-pane " id="builderTool">
                     <div class="form-group listoffield p-10">
                         @if(count($units))
                             <ul id="sortable1" class=" fields" data-sortlist="tool">
                                 @foreach($units as $unit)
                                     @foreach($unit->variations() as $variation)
                                         <li class="dragdiv connectedSortable height-40 text-center" data-button="edit,delete" data-type="tool"  data-title="{{ $unit->title }}" data-uniq="{!! uniqId() !!}" data-el='{!! $variation->id  !!}'>
                                             <span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span> {{ $unit->title }}/ {{$variation->title}}
                                         </li>
                                     @endforeach
                                 @endforeach
                             </ul>
                         @else
                            <ul id="sortable1" class=" fields" data-sortlist="tool">
                                 No generals
                             </ul>
                         @endif
                       {{--<ul class="p-10 hide" data-sortlist>--}}
                        {{--<li data-name="Field name" data-required="false" data-id="0">--}}
                          {{--<span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span> Field Name--}}
                        {{--</li>--}}
                      {{--</ul> --}}

                   </div>
                 </div>

              </div>
            </div>
            <div class="builderright_section" >
                   <div class="builder-selectviewrow">
                           <div class="btn-group">
                            <button type="button" class="btn btn-link btn-xs btn-lightgray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-desktop" aria-hidden="true"></i>  Desktop view 1620 px <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a href="#" data-responsive="1620" data-title="Desktop view 1620 px">Desktop view 1620 px</a></li>
                              <li><a href="#" data-responsive="1024" data-title="Table view 1620 px">Table view 1024 px</a></li>
                              <li><a href="#" data-responsive="420" data-title="Moble view 1620 px">Moble view 420 px</a></li>
                            </ul>
                          </div>

								    </div>

                <div class="forwidth builder-canvas" data-builder="canvas">
                    <div class="radio_bt_div hide">
                        <input type="radio" name="column" value="columns_1" checked="checked" class="radio_bt" id="radiobt_2"><span class="choose_cols">Columns - 1</span>
                        <input type="radio" name="column" value="columns_2" class="radio_bt"  id="radiobt_1"><span class="choose_cols">Columns - 2</span>
                        <div class="style_options_for_left_side">{!! BBbutton('styles','containerstyle_2','Columns - 1 Style',['class'=>'form-control input-md','data-type'=>'container']) !!}</div>
                        <div class="style_options_for_right_side">{!! BBbutton('styles','containerstyle_3','Columns - 2 Style',['class'=>'form-control input-md','data-type'=>'container']) !!}</div>
                        <div class="style_options_for_right_side">   {!! BBbutton('widgets','widget','select Widget',[ 'class' => 'form-control','data-type' =>'fields','id'=>'select_form_widget','model'=>$form]) !!}</div>
                    </div>

                    <div class="row">
                            <div class="div_for_cols" data-droplayout="drop">
                               @if(BBRenderForm($form->id))
                                    {!! BBRenderForm($form->id) !!}
                                @else
                                    @include('modules::forms._partials.fields')
                                @endif
                            </div>

                    <div class="div_for_hidden">
                        <h3 style="text-align: center;">Hidden area</h3>
                        <ul class="connectedSortable" id="sortable4">
                            @if(count($hiddenFields))
                                @foreach($hiddenFields as $value)
                                    <li class="height-40 text-center"> {!! BBRenderField($value->id,$form) !!}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                   </div>
                </div>
              
              
                <input type="text" name="json" data-export="json" value='{!! $form->json_data !!}' data-getjson='{!! $form->json_data !!}' />
            </div>
        </div>
    </div>
</div>
   
   
<div class="modal fade edit_field_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! $title or null !!}</h4>
            </div>
            <div class="modal-body">
                <?php
                if ($form->widget) {
                    echo BBRenderWidgetOption($form->widget);
                } else {
                    $widget = \Sahakavatar\Cms\Models\Widgets::where('default', 1)->where('main_type', 'fields')->first();
                    $main = null;
                    if ($widget) {
                        $variations = $widget->variations();
                        foreach ($variations as $variation) {
                            if ($variation->default) {
                                echo BBRenderWidgetOption($variation->id);
                            }
                        }
                    }
                }
                ?>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <!--- Setting Modal  ---->
    <div class="modal fade custom-modal" tabindex="-1" role="dialog" id="settingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row toolbarNav">
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                                     data-tool-tab="btnpanel">
                                    <div class="btn-group" role="group"><a href=".general" aria-controls="General"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue active">General</a>
                                    </div>
                                    <div class="btn-group" role="group"><a href=".validation" aria-controls="validation"
                                                                           role="tab" data-toggle="tab"
                                                                           class="btn btn-default btn-dblue">Validation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right"><a data-dismiss="modal" aria-label="Close"
                                                            class="btn btn-default btn-default-gray"
                                                            data-action="discard">Discard</a> <a href="#"
                                                                                                 class="btn btn-danger btn-danger-red"
                                                                                                 data-action="apply">Apply</a>
                            <input type="hidden" id="panelID" value="">
                        </div>
                    </div>
                    <div class='row row-eq-height'>
                        <div class='col-xs-6 left-side'>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane general active p-10" id="general"
                                     data-formsetting="setting">
                                </div>
                                <div role="tabpanel" class="tab-pane validation p-10" id="validation">
                                    <div class="form-inline col-md-12 p-0" data-have="required">
                                        <label for="exampleInputEmail1"> Required</label>
                                        <div class="checkbox radio ml-20">
                                            <input type="radio" name="required" id="required" value="Yes"
                                                   data-field="required">
                                            <label for="required" class="control-label">Yes</label>
                                        </div>
                                        <div class="checkbox radio ml-20">
                                            <input type="radio" name="required" id="required-no" value="No"
                                                   data-field="required">
                                            <label for="required-no" class="control-label">No</label>
                                        </div>
                                    </div>
                                    <div class="form-inline col-md-10  p-0" data-have="icon">
                                        <label for="exampleInputEmail1">Indicator</label>
                                        <select class="form-control customFormSelect ml-20"
                                                data-field="validateindicator" data-width="auto">
                                            <option value="">Browser Icon</option>
                                            <option data-icon="glyphicon glyphicon-asterisk"
                                                    value="glyphicon glyphicon-asterisk">asterisk
                                            </option>
                                            <option data-icon="glyphicon glyphicon-star"
                                                    value="glyphicon glyphicon-star">Star
                                            </option>
                                            <option data-icon="glyphicon glyphicon-star-empty"
                                                    value="glyphicon glyphicon-star-empty">Star Empty
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-inline col-md-10 p-0" data-have="validation">
                                        <label for="exampleInputEmail1"> Validate As</label>
                                        <select class="form-control customFormSelect ml-20" data-field="validateas"
                                                data-width="auto" multiple='true'>
                                            <option selected="selected" value="">Any Format</option>
                                            <option value="email">Email</option>
                                            <option value="url">URL</option>
                                            <option value="alpha_dash">Phone Number</option>
                                            <option value="numeric">Numbers Only</option>
                                            <option value="alpha">Text Only</option>
                                            <option value="min:6">Min Value 6</option>
                                            <option value="min:100">Max Value 100</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-10  p-0" data-have="errormessage">
                                        <label for="errorMessage">Error Message</label>
                                        <input type="text" class="form-control" id="errorMessage"
                                               placeholder="Please enter a value" data-field="errorMessage">
                                    </div>

                                    <div class="form-group col-md-10  p-0" data-have="tooltip">
                                        <label for="tooltip">Tooltip</label>
                                        <input type="text" class="form-control" id="tooltip"
                                               placeholder="Please enter a value" data-field="tooltip">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class='col-xs-6 right-side popuppreview p-t-40'>
                            <div data-frompre='preview'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    </div>
    <!--- end Setting Modal  ---->
    <div data-optionsfield="setting" class="hide">
        {!! Form::select('dbtable',$dbhelper->getTableNames(),null,['data-optionsfield' => 'dbtable']) !!}

        <select class="selectclass" data-choseclass="fieldClass">
            <option value="13">Main Variation</option>
            <option value="20">classname</option>
            <option value="21">classname</option>
        </select>


    </div>
    </div>



<div class="modal fade bigfullModal bigmodalwhite" id="settingform" tabindex="-1" role="dialog" aria-labelledby="settingform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-red-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title p-t-10" id="myModalLabel"><i class="buidericon bildericon-fieldlayoutbig m-r-10"></i>    Setting From</h4>
      </div>
      <div class="modal-body p-10">
        <ul class="nav nav-tabs col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Email Settings</a></li>
                <li><a data-toggle="tab" href="#menu1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>General Settings</a></li>
                <li><a data-toggle="tab" href="#menu2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Menu 3</a></li>
                <li><a data-toggle="tab" href="#menu3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Menu 4</a></li>
            </ul>
             <div class="tab-content col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div id="home" class="tab-pane fade in active">
                    <h3>Email Settings</h3>
                    <p>
                        @include('modules::forms._partials.form_email_settings')
                    </p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>General Settings</h3>
                    <p>
                        @include('modules::forms._partials.form_general_settings')
                    </p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 4</h3>
                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>
            </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade bigfullModal" id="previewform" tabindex="-1" role="dialog" aria-labelledby="previewform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-red-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title p-t-10" id="myModalLabel"><i class="buidericon bildericon-fieldlayoutbig m-r-10"></i> Preview <span data-modalpreview="text"></span></h4>
      </div>
      <div class="modal-body previewiframe">
        <iframe data-iframe="preview"></iframe>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade bigfullModal" id="formlayoutpopup" tabindex="-1" role="dialog" aria-labelledby="formlayoutpopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-red-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title p-t-10" id="myModalLabel"><i class="buidericon bildericon-fieldlayoutbig m-r-10"></i>     Form Layout</h4>
      </div>
      <div class="modal-body">
        <div class="builder-modalleft">
          <h5>Select Layout</h5>
          <ul class="filedcolumntype" role="tablist">
            <li class="active"><a href="#formlayout001" aria-controls="formlayout001" role="tab" data-toggle="tab"><img src="/resources/assets/images/form-list.jpg">
              <span >Layout 0001</span></a></li>
            <li><a href="#formlayout002" aria-controls="formlayout002" role="tab" data-toggle="tab"><img src="/resources/assets/images/form-list2.jpg"><span>Layout 0002</span></a></li>
          </ul>
        </div>
        <div class="builder-modalright">
            <h5>Select Variation</h5>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="formlayout001">
                      <ul class="formlisting">
                        <li><a href="#"><img src="/resources/assets/images/form-list.jpg">
                          </a><span ><a href="#" class="editlist"><i class="fa fa-pencil" aria-hidden="true"></i></a>Layout 0001</span></li>
                        <li><a href="#"><img src="/resources/assets/images/form-list.jpg"></a>
                          <span><a href="#" class="editlist"><i class="fa fa-pencil" aria-hidden="true"></i></a>Layout 0002</span>
                        </li>
                      </ul>

                </div>
                <div role="tabpanel" class="tab-pane " id="formlayout002">
                      <ul class="formlisting">
                        <li><a href="#"><img src="/resources/assets/images/form-list2.jpg">
                          </a><span ><a href="#" class="editlist"><i class="fa fa-pencil" aria-hidden="true"></i></a>Layout 0001</span></li>
                        <li><a href="#"><img src="/resources/assets/images/form-list2.jpg"></a>
                          <span><a href="#" class="editlist"><i class="fa fa-pencil" aria-hidden="true"></i></a>Layout 0002</span>
                        </li>
                        <li><a href="#"><img src="/resources/assets/images/form-list2.jpg"></a>
                            <span><a href="#" class="editlist"><i class="fa fa-pencil" aria-hidden="true"></i></a>Layout 0003</span>
                        </li>
                      </ul>

                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="layerswindow editlayerswindow hide" data-window="editlayers" >
		<div class="windowHeader">
				<div class="iconRight">
            <a data-layersaction="edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
            <a data-layersaction="delete" ><i class="fa fa-trash" aria-hidden="true"></i></a>
						<a href="#" class="windowCloseLink builderlayersbtn" data-layersactions="save"><i class="bbthemeIcon themeDonerow"></i></a><a href="#" class="windowDoneLink builderlayersbtn" data-layeraction="close"><i class="bbthemeIcon themecloserow"></i></a>
				</div>
				<div class="listrow colItem-sidebarvertical  active clearfix">
						<div class="listRowName">
								<span class="listrowicon"><i class="bbthemeIcon bbthemeIcon-edit" data-name="" data-role="previewicon"></i></span> <span data-role="previewText">User Name </span>
						</div>
				</div>
		</div>
		<div class="windowcontainer collapse" data-layercontainer="layers" >
      <form data-editoption="">
				
				</form>
		</div>
</div>
<!-- Append dragable ui-->
<div class="listoffield " data-sortadehelper>
  <ul></ul>
</div>
<div class="listofpreview" data-sortadehelperpreview>
  <ul></ul>
</div>
<script type="template" data-role="iframehead">
      {!! HTML::style('fonts/FontAwesome/font-awesome.css') !!}
      {!! HTML::style('css/admin.css?v=0.392') !!}
      {!! HTML::style('css/dashboard-css.css?v=0.2') !!}
      {!! HTML::style('css/admin-theme.css?v2.91') !!}
     
</script>
<script type="template" data-role="addinbody">
    {!! HTML::style('css/core_styles.css') !!}
</script>
@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    {!! HTML::style('js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    {!! HTML::style('js/animate/css/animate.css') !!}
    {!! HTML::style('css/form-builder.css?v=4.97') !!}
    {{--{!! HTML::style('css/builder-tool.css') !!}--}}
    {!! HTML::style('app/Modules/Modules/Resources/assets/css/table-create.css') !!}
    <style>
        #left_side{
            width: 100%;
        }

        #right_side{
            width: 0;
        }
        /*modal*/
        .site_wrap_23 .nav-tabs li{
            float: none;
            text-align: center;
        }
        .site_wrap_23 .nav-tabs {
            border:none;
        }
        .site_wrap_23 .nav-tabs  a{
            color: #5c789c;
            font-size: 16px;
            font-weight: bold;
            padding: 17px;
        }
        .site_wrap_23 .nav-tabs  li.active a{
            background-color: #ad4d5e;
            color: #ffffff;
        }
        .site_wrap_23 .nav-tabs  a:hover{
            background-color: #e3e6ec;
            color: #5c789c;
        }

        .site_wrap_23 .div_modal{
            position: absolute;
            background-color: #ffffff;
            width: 100%;
            height: 1000px;
            top: 83px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            padding: 18px;
        }

        .site_wrap_23 .div_modal .for_close_icon{
            position: absolute;
            right: 19px;
            top: 10px;
        }
        .site_wrap_23 .div_modal .for_close_icon i{
            font-size: 26px;
            color: #d6d9e0;
        }
        .site_wrap_23 button:focus, .site_wrap_23 button:hover, .site_wrap_23 input:hover, .site_wrap_23 input:focus, .site_wrap_23 .navbar-left button:focus, .site_wrap_23 .navbar-right button:focus {
            outline: none;
        }
        .site_wrap_23{
            position: relative;
            background-color:#FFF;

        }
        .site_wrap_23 .navbar-header, .site_wrap_23 .navbar-collapse {
            padding: 12px 12px 7px 12px;
        }
        .site_wrap_23 .navbar.navbar-default, .site_wrap_23 .navbar-default .navbar-brand{
            background-color: #2c2c2c;
        }
        .site_wrap_23 .navbar{
            border: none;
            margin-bottom:0;
        }
        .site_wrap_23 .navbar-right{
            padding: 9px;
        }
        .site_wrap_23 .navbar-right button{
            margin-left: 12px;
            min-width:100px;
            border-color: transparent;;
            font-weight: bold;
            color:#ffffff;

        }
        .site_wrap_23 .navbar-left button {
            min-width:100px;
            border-color: transparent;
            font-weight: bold;
        }
        .site_wrap_23 .navbar-left .setting_button{
            background-color: #767474;
            color:#ffffff;
        }
        .site_wrap_23 button:hover{
            opacity: 0.8;
        }
        .site_wrap_23 .for_dropdown_and_fields ul li:hover, .site_wrap_23 .left_section select:hover{
            opacity: 0.9;
        }
        .site_wrap_23 .navbar-left .edit_button {
            background-color: #ffffff;
            color: #5c789c;
        }
        .site_wrap_23 .navbar-right .first_button{
            background-color: #767474;
        }
        .site_wrap_23 .navbar-right .second_button{
            background-color: #ad4d5e;
        }
        .site_wrap_23 .navbar-left button{
            margin-left: 12px;
        }

        .site_wrap_23 .form_name{
            width: 300px;
        }

        .site_wrap_23 .left_section form{
            color: #ffffff;
        }
        .site_wrap_23 .left_section form:focus{
            outline: none;
        }
        .site_wrap_23 .left_section select{
            background-color: #5c789c;
            border-color:transparent;
            width: 100%;
            padding: 12px;
            font-weight: bold;
            position: relative;
            font-size: 16px;
            border-radius: 5px;
        }

        .site_wrap_23  select:active, .site_wrap_23 select:hover {
            outline: none
        }
        .site_wrap_23 .left_section select:focus > option:checked, .site_wrap_23 .left_section select:focus > option:hover {
            color: #ffffff;
        }
        .site_wrap_23 .left_section select:focus > option{
            background: #d6d9e0;
            padding: 10px !important;
            color: #000000;
            font-size: 16px;
        }
        .site_wrap_23 .right_section .choose_cols{
            color: #ffffff;
            font-weight: bold;
            font-size: 15px;
        }
        .site_wrap_23 .right_section .radio_bt_div{
            padding: 7px 12px 7px 0;
            background-color: #5c789c;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
        }
        .site_wrap_23 .right_section .radio_bt{
            margin: 0 6px 0 21px;
        }
        .site_wrap_23 .right_section{
            padding-left: 0!important;
            padding-right: 0!important;
        }
        .site_wrap_23 .forwidth{
            width: 100%;
        }
        .left_part {
            background-color: #d6d9e0;
            min-height: 700px;
        }
        .right_part{
            background-color: #e3e6ec;
            min-height: 700px;
            transition: right 0.4s;
            transition: left 0.4s;
        }
        .site_wrap_23 .div_for_cols{
            width: 100%;
            position: absolute;
            top:63px;
        }
        .site_wrap_23 .div_for_hidden{
            background-color: grey;
            min-height: 300px;
            width: 100%;
            margin-top: 715px;
        }

        .site_wrap_23 .for_margin{
            margin-top: 38px;
        }
        .site_wrap_23 .for_dropdown_and_fields{
            width: 80%;
        }
        .site_wrap_23 .fields{
            margin-top: 15px;
        }
        .site_wrap_23 .fields li{
            background-color: #ad4d5e;
            padding:12px;
            border: 1px solid #ffffff;
            border-radius: 5px;
            list-style-type: none;
        }
        .site_wrap_23 .fields li:hover{
            cursor: pointer;
        }
        .site_wrap_23 .fields li a{
            color: #ffffff;
            font-weight: bold;
        }
        .site_wrap_23 .fields li a:hover{
            text-decoration: none;
        }
        /*.site_wrap_23 .style_options{*/
        /*display: inline-block;*/
        /*margin-left: 50px;*/
        /*}*/
        .site_wrap_23 .style_options_for_left_side, .site_wrap_23 .style_options_for_right_side{
            display: inline-block;
            margin-left: 50px;

        }
        .site_wrap_23 .style_options_for_left_side button, .site_wrap_23 .style_options_for_right_side button{
            background-color: #ffffff;
            color: #5c789c;
            border: none;
            padding: 6px 26px;
            font-weight: bold;
        }
        .site_wrap_23 .navbar-left button i, .site_wrap_23 .navbar-right button i{
            margin-right: 5px;
        }

    </style>
@stop

@section('JS')
    {!! HTML::script("js/UiElements/bb_styles.js?v.5") !!}
    <script>

        $(document).ready(function() {
          var editchangeInterval = '';
          var buttonaction = {
              edit:"<a data-layersaction='edit'><i class='fa fa-pencil'></i></a>",
              delete:"<a data-layersaction='delete'><i class='fa fa-trash'></i></a>",
              configure:"<a data-layersaction='configure'><i class='fa fa-cogs'></i></a>"
          }
          
          var formjson = {}
          
          function editfrom(){
            if ($('[data-fielditem]').length > 0){
                $('[data-fielditem]').each(function(){
                    var replasehtml = $('<li></li>').append($(this).html());
                    var dataattr = $(this).data()
                       $.each(dataattr, function(key, val){
                            replasehtml.attr('data-'+key, val);
                       })
                    $(this).replaceWith(replasehtml)
               })
              } 
             if ($('[data-fieldgroup]').length > 0){
                 $('[data-fieldgroup]').each(function(){
                      $(this).replaceWith('<ul class="connectedSortable" data-style-old="left_part" data-draganddrop="formleft" data-bbplace="containerstyle_2">'+$(this).html()+'</ul>')
                 })
             }
            
            
          }
          
          function updateitemjson (){
            
             formjson['item'] = {}
             $('[data-draganddrop] li').each(function(){
                    var fieldis = $(this).attr("data-el");
                    var type =$(this).attr("data-type");  
                    
                    if(type=='tool'){
                          type = 't'
                    }else{
                        type = 'f'  
                    }
                    if(fieldis){          
                        updatekey(fieldis, type, 'item', '', 'noupdated'); 
                    }

             })
             
              $('[data-export="json"]').val(JSON.stringify(formjson));
         }
          editfrom(); 
          
          var getjson = $('[data-export="json"]').data('getjson')
         
          if(getjson != ''){
            if(typeof getjson ==='object'){
              formjson = getjson
            }else{
                formjson = JSON.parse(getjson)
            }
             
          }else{
            updatekey('formid', $('#form_id').val());
            updateitemjson();
            rearangekey();
          }
          
          function rearangekey(){
            var fieldsitemkey = {}
            $('[data-draganddrop]').each(function(){
                var indexid = 'column'+$('[data-draganddrop]').index($(this))
                var generatekeys = {}
                  $(this).children('li').each(function(i, el){
                        var itemkey ={}
                        var udes = $(this).data('el');
                        var type = $(this).data('type')
                         if(type=='tool'){
                            type = 't'
                          }else{
                              type = 'f'  
                          }
                        itemkey['id'] = udes
                        itemkey['type'] = type
                        generatekeys[i]= itemkey;
                    });
                fieldsitemkey[indexid] = generatekeys; 
             })
            updatekey('fielditem', fieldsitemkey );
          }
          
          function updatekey(key, value, mainkey, submainkey, updated){
              if(mainkey){
                  if(!formjson[mainkey]){
                      formjson[mainkey]= {}
                  }  
                  
                  if(submainkey){
                    if(!formjson[mainkey][submainkey]){
                        formjson[mainkey][submainkey] = {}
                    }  
                    
                    formjson[mainkey][submainkey][key] = value;
                    
                  }else{
                    formjson[mainkey][key] = value;   
                  }
                
              }else{
                  formjson[key] = value;     
              }
              if(!updated){
               
                $('[data-export="json"]').val(JSON.stringify(formjson))
              }
          }
          function deletekey(key, mainkey, subkey){
                if(mainkey){
                  if(formjson[mainkey]){
                       if(subkey){
                            if(formjson[mainkey][subkey]){
                              delete formjson[mainkey][subkey][key]; 
                            }
                        }else{
                            delete formjson[mainkey][key]; 
                       }
                    }
                }else{
                    delete formjson[key];
                }
                $('[data-export="json"]').val(JSON.stringify(formjson))
          } 

          $('body').on('click', '[data-draganddrop] li', function(){
                $('[data-draganddrop] li').removeClass('active')
                
                $(this).addClass('active')
                var getbuttondata = $(this).data('button');
                var getid = $(this).data('el')
                if(getbuttondata && getbuttondata!=""){
                $('[data-window="editlayers"] .windowHeader .iconRight [data-layersaction]').remove();
                if(getbuttondata){
                  getbuttondata = getbuttondata.replace(/\s+/g,'').split(',') ;
                  $.each(getbuttondata, function(i,k){
                      var buttonhtml = $(buttonaction[k]);
                      if(getid){
                        buttonhtml.data('el', getid)
                       }
                      buttonhtml.appendTo('[data-window="editlayers"] .windowHeader .iconRight')
                  })
                }
                var title = $(this).data('title');
                $('[data-window="editlayers"] [data-role="previewText"]').html(title)
                $('[data-window="editlayers"]').removeClass('hide');
                $('[data-window="editlayers"] .windowHeader').removeClass('activeedit')
                $('[data-layercontainer="layers"]').collapse('hide');
                $('[data-layercontainer="layers"] [data-editoption]').html('');
                $('[data-layercontainer="layers"] [data-editoption]').data('editoption', getid );
               }else{
                   $('[data-window="editlayers"]').addClass('hide')
               }
          }).on('click', '[data-layeraction="close"]', function(){
                $('[data-layercontainer="layers"]').collapse('hide')
                $('[data-window="editlayers"] .windowHeader').removeClass('activeedit')
          }).on('click','[data-layersaction]', function(e){
                var type = $(this).data('layersaction')
                var uncid = $(this).data('el')
                if(type=='edit'){
                    $('[data-layercontainer="layers"]').collapse('show')
                    $('[data-window="editlayers"] .windowHeader').addClass('activeedit')
                    
                    editpopup(uncid)
                }
                if(type=="delete"){

                  bootbox.confirm("Are you sure delete item ", function(result){
                    if(result){
                      var getype = $('[data-draganddrop="formleft"] li[data-el="'+uncid+'"]').data('type');
                      var tiltes = $('[data-draganddrop="formleft"] li[data-el="'+uncid+'"]').data('title');
                      if(getype){
                        $('[data-draganddrop="formleft"] li[data-el="'+uncid+'"]').html('<span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span>'+tiltes).appendTo('[data-sortlist="'+getype+'"]');
                      }
                      $('[data-layercontainer="layers"]').collapse('hide')
                      $('[data-window="editlayers"] .windowHeader').removeClass('activeedit');
                      $('[data-window="editlayers"]').addClass('hide')
                      deletekey(uncid, 'item');
                      
                      rearangekey()
                    }
                  });
                }
                
          }).on('click', '[data-responsive]', function(){
              var width = $(this).data('responsive');
             var targetiframe = $('[data-iframe="preview"]')
            
             
             var targethtml = $('<div></div>').html($('[data-droplayout="drop"]').html());
              targethtml.find('[data-draganddrop] > li').each(function(){
                      $(this).replaceWith($(this).html())
              })
              targethtml.find('[data-draganddrop]').each(function(){
                      $(this).replaceWith($(this).html())
              })
             
             
              $('#previewform').modal('show');
              var title = $(this).data('title')
              $('[data-modalpreview]').html(title);
              targetiframe.width(width)
              targetiframe.contents().find('head').html()
             
              
              var appnedinbody = $('[data-role="addinbody"]').html()
              targetiframe.contents().find('body').html(targethtml.html() + appnedinbody );
            
          }).on('keyup', '[data-layercontainer="layers"] [data-editoption] input[type="text"], [data-layercontainer="layers"] [data-editoption] textarea', function(){
              clearInterval(editchangeInterval);
              editchangeInterval = setInterval(function(){ editchange() }, 300)   
            
          }).on('keyup', '[data-layercontainer="layers"] [data-editoption] select, [data-layercontainer="layers"] [data-editoption] [type="radio"], [data-layercontainer="layers"] [data-editoption] [type="checkbox"]', function(){
              clearInterval(editchangeInterval);
              editchangeInterval = setInterval(function(){ editchange() }, 300)   
          }).on('click','[data-layersactions="save"]',function(){
              clearInterval(editchangeInterval);
              editchangeInterval = setInterval(function(){ editchange('save') }, 300)  
          }).on('click', '[data-save="form"]',function(){
              var gethtml = $('<div></div>').html($('[data-droplayout="drop"]').html());
              gethtml.find('[data-draganddrop] > li').each(function(){
                      var replasehtml = $('<div data-fielditem></div>').append($(this).html());
                      var dataattr = $(this).data()
                       $.each(dataattr, function(key, val){
                            replasehtml.attr('data-'+key, val);
                       })
                      $(this).replaceWith(replasehtml);
              })
              gethtml.find('[data-draganddrop]').each(function(){
                      $(this).replaceWith('<div data-fieldgroup>'+$(this).html()+'</div>');
              })
             
              var fromsavedata  = {html:gethtml.html(), json:JSON.stringify(formjson),formid:formjson.formid }
              if(formjson.fieldstyle){
                  fromsavedata['fieldstyle'] = formjson.fieldstyle;
              }
              
              $.ajax({
                      'type':'post',
                       url: " {!!url('/admin/modules/forms/save')!!}",
                       cache: false,
                       data: fromsavedata,
                       headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                      },
                       success:function(data) {
                        if(!data.error){
                            

                        }
                      },
                      error: function(errorThrown){
                            console.log(errorThrown);
                    }
              });
              
              
          })
          
          
          
          $('[data-iframe="preview"]').contents().find('head').html($('[data-role="iframehead"]').html())
              
          
          function editchange(save){
                var savekey = '';
              
              if(save){
                  savekey = 'save=true&';
              }
                var fieldstyle = '';  
                if(formjson.fieldstyle){
                    fieldstyle = 'fieldstyle='+formjson.fieldstyle+'&';
                }
                var fieldid = $('[data-layercontainer="layers"] [data-editoption]').data('editoption');
                var formid = $('#form_id').val();
            
                var formdata = fieldstyle+savekey+'formid='+formid+'&fieldid='+fieldid+'&'+$('[data-layercontainer="layers"] [data-editoption]').serialize();
                
                $.ajax({
                       'type':'post',
                       url: "{!!url('/admin/modules/bburl/get-field-options-live')!!}",
                       cache: false,
                       data: formdata,
                       headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                      },
                       success:function(data) {
                        if(!data.error){
                             $('[data-draganddrop]').find('li[data-el='+fieldid+']').html('<!--'+fieldid+'-->'+data.html+'<!--end'+fieldid+'-->');

                        }
                      },
                      error: function(errorThrown){
                            console.log(errorThrown);
                           }
                      });
               clearInterval(editchangeInterval); 
          }
        
            function editpopup(fieldid){
                  $('[data-layercontainer="layers"] [data-editoption]').html('');
                    $.ajax({
                       'type':'post',
                       url: "{!!url('/admin/modules/bburl/get-form-field-options')!!}",
                       cache: false,
                       datatype: "json",
                       data: {'formid': $('#form_id').val(), 'fieldid': fieldid },
                       headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                      },
                       success:function(data) {
                        if(!data.error){
                             $('[data-layercontainer="layers"] [data-editoption]').html(data.html);
                          }
                      },
                      error: function(errorThrown){
                            console.log(errorThrown);
                           }
                      });
                    
                    
                    
            }

          function draganddrop (){
                var idiesright=[];
                var items= $('[data-draganddrop]').first().find('.dragdiv ');
                $.each(items,function (k,v) {
                    idiesright.push($(v).attr('data-el'))
                })
                var idiesleft=[];
                var itemsleft= $('[data-draganddrop]').not(':first').find('.dragdiv ');
                $.each(itemsleft,function (k,v) {
                    idiesleft.push($(v).attr('data-el'))
                })


                var idies = $.merge(idiesleft, idiesright);
                 $( "[data-sortlist]" ).sortable({
                    connectWith: ".connectedSortable",
                    appendTo: $('[data-sortadehelper] ul'),
                    helper: "clone"
                 }).disableSelection();

                 $( "[data-draganddrop]" ).sortable({
                                    connectWith: ".connectedSortable",
                                    appendTo: $('[data-sortadehelperpreview] ul'),
                                    helper: "clone",
                                    receive: function( event, ui ) {
                                        var id=ui.item.attr("data-uniq");
                                        var getcolumn = $('[data-draganddrop]').index(ui.item.closest('[data-draganddrop]'));
                                        var wrecome= $('[data-draganddrop]').index($(ui.sender));
                                        var fieldis = ui.item.attr("data-el");
                                        var type = ui.item.attr("data-type");
                                        var table_name= $('[data-fieldtab] .active a').data('val')
                                        $('[data-sortlist]').find('li[data-uniq='+id+']').empty().html($('li[data-uniq="'+id+'"]').attr('data-title'));
                                        
                                      
                                        if(type=="field"){
                                            var ajaxdata = {'table_name': table_name, 'id': ui.item.attr("data-el"), 'formid': $('#form_id').val()}
                                        }else{
                                            var ajaxdata = {'table_name': table_name, 'id': ui.item.attr("data-el") }
                                        }
                                       
                                        updateitemjson ()
                                         
                                      
                                        if(formjson.fieldstyle){
                                            ajaxdata['fieldstyle'] = formjson.fieldstyle;
                                        }
                                        console.log(table_name);
                                        $.ajax({
                                            'type':'post',
                                            url: "{!! url('/admin/modules/config/select-fields') !!}",
                                            cache: false,
                                            datatype: "json",
                                            data: ajaxdata,
                                            headers: {
                                                'X-CSRF-TOKEN': $("input[name='_token']").val()
                                            },
                                            success:function(data) {
                                                if(!data.error){
                                                    $('[data-draganddrop]').find('li[data-uniq='+id+']').html('<!--'+fieldis+'-->'+data.html+'<!--end'+fieldis+'-->');
                                                }
                                            },
                                            error: function(errorThrown){
                                                console.log(errorThrown);
                                            }
                                        });

                                    },
                                    update: function( event, ui ) {
                                      rearangekey()
                                    }
                                  
                                }).disableSelection();

          }


          draganddrop ()


         $('.layerswindow').draggable({handle:".windowHeader"});



            $('body').on('click','.edit_field_btn',function () {
                $('.edit_field_modal').modal();
            })





            $('input:radio[name=column]').change(function() {
                var right_content = $( "#sortable3" ).html();
                $( "#sortable3" ).empty();
                if (this.value == 'columns_2') {
                    $("#sortable2").css({ left: 0, width: '50%', position:'absolute'});
                    $("#sortable3").css({ opacity:1, display:'block', left: '50%', width: '50%', position:'absolute'});
                }
                else if (this.value == 'columns_1') {
                    $("#sortable2").css({ left: 0, width: '100%', position:'absolute'});
                    $("#sortable3").css({ opacity:0, width: 0, position:'absolute'});
                    $( "#sortable2" ).append( right_content );
                }

            });


            $(".setting_button").click(function(){
                $(".div_modal").slideToggle( "slow");
            });
            $(".for_close_icon").click(function(){
                $(".div_modal").slideToggle( "slow");
            });

          


$('body').on('click','.item',function () {
   if($(this).find('input[data-action=templates]').data('action')){
       var form_id=$('#form_id').val();
       var widget=$('input[data-name=widget]').val();
       var data={'id':form_id,'widget':widget}

       $.ajax({
           'type':'post',
           url: "{!! url('/admin/modules/config/get-fields-html') !!}",
           cache: false,
           datatype: "json",
           data: data,
           headers: {
               'X-CSRF-TOKEN': $("input[name='_token']").val()
           },
           success:function(data) {
               if(!data.error){
                //$('.div_for_cols').html(data.html)
               }
           },
           error: function(errorThrown){
               console.log(errorThrown);
           }
       });
   }else if($(this).find('input[data-actiontype]').data('actiontype')=="forms"){
      var getwidgetsid = $(this).find('input[data-action=widgets]').data('value');
      updatekey('layoutid',getwidgetsid)
      $.ajax({
           'type':'post',
           url: "/admin/modules/bburl/layout",
           cache: false,
           datatype: "json",
           data: formjson,
           headers: {
               'X-CSRF-TOKEN': $("input[name='_token']").val()
           },
           success:function(data) {
               if(!data.error){
                 var gethtml = $('<div>').html($('[data-droplayout="drop"]').html())
                 var newlayouthtml = $('<div></div>').append(data.data);
                 $('<ul class="connectedSortable" data-style-old="left_part" data-draganddrop="formleft" data-bbplace="containerstyle_2"></ul>').appendTo(newlayouthtml.find('[data-dropplase]'))
                 gethtml.find('[data-draganddrop] > li').appendTo(newlayouthtml.find('[data-dropplase]').first().find('[data-draganddrop]'))
                 $('[data-droplayout="drop"]').html(newlayouthtml)
                 draganddrop ()
               }
           },
           error: function(errorThrown){
               console.log(errorThrown);
           }
       });
        
   }else if($(this).find('input[data-actiontype]').data('actiontype')=="fields"){
     var getwidgetsid = $(this).find('input[data-action=widgets]').data('value');
      updatekey('fieldstyle',getwidgetsid)
      $.ajax({
           'type':'post',
           url: "/admin/modules/config/get-fields-html",
           cache: false,
           datatype: "json",
           data: formjson,
           headers: {
               'X-CSRF-TOKEN': $("input[name='_token']").val()
           },
           success:function(data) {
               if(!data.error){
                 var gethtml = $('<div>').html($('[data-droplayout="drop"]').html())
                 var newlayouthtml = $('<div></div>').append(data.html);
                 newlayouthtml.find('[data-draganddrop] > li').each(function(){
                       var targetli =  $(this)
                       var targetel = targetli.data('el')
                      
                       $('[data-draganddrop] li[data-el="'+targetel+'"]').html(targetli.html())
                 })
                 
                 draganddrop ()
               }
           },
           error: function(errorThrown){
               console.log(errorThrown);
           }
       });
     
     
   }else{
      clearInterval(editchangeInterval);
      editchangeInterval = setInterval(function(){ editchange() }, 300) 
      
   };

})
            //hidden input sortable
            $( "#sortable4" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();

        });




    </script>
@stop
@stop