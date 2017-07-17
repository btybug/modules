<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="panel panelSettingData">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i
                                class="glyphicon glyphicon-chevron-right"></i> Area 1 </a></h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="navstyle" class="col-xs-3">Nav style</label>
                           <div class="col-xs-9">
                               <select name="navstyle" class="form-control">
                                    <option value="">Default</option>
                                    <option value="navbarroundblue">round Blue</option>
                               </select>
                            </div>
                        </div>
                        
                    </div>
                     <div class="form-group">
                        <div class="row">
                            <label for="menustyle" class="col-xs-3">menu style</label>
                           <div class="col-xs-9">
                               <select name="menustyle" class="form-control">
                                    <option value="">Menu style 1 </option>
                                     <option value="menuround">Menu style 2 </option>
                               </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
  .panelSettingData { background-color: #3d3d3d; }
.panelSettingData .panel-heading { background-color: #1c1c1c; }
.panelSettingData label { color:#fff; }
.panelSettingData h4 a { color:#fff; }
.panelSettingData h4 a:hover, .panelSettingData h4 a:focus { text-decoration:none; }
.panelSettingData h4 a i { transition: all 0.3s; -moz-transition: all 0.3s; -webkit-transition: all 0.3s; -o-transition: all 0.3s; margin-right: 10px; }
.panelSettingData h4 a[aria-expanded="true"] i { -ms-transform: rotate(90deg); -webkit-transform: rotate(90deg); transform: rotate(90deg); }

.settingBtn { background-color: #292929; color:#fff; }
.settingBtn:hover, .settingBtn:focus { color:#fff; }
.form-control { background-color: #888383; border:none; color:#fff }
</style>