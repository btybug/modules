
<div class="p-t-10 ">
  {!! Form::open(['url' => 'admin/create/form/settings/'.@$form->id, 'method' => 'post']) !!}
  {!! Form::hidden('id',@$form->id) !!}
  <table width="100%" class="table table-bordered bg-white m-0" >
    <thead>
      <tr class="bg-black-darker text-white p-10">
        <th>E-mail Settings</th>
      </tr>
    </thead>
    <tr>
      <td>
         <div class="semi-bold">Admin Email</div>
          <div class="p-0">
               @if(isset($email_templates['admin'])) 
                 <div class="p-10">
                 {!! $email_templates['admin']->name !!}
                 <a class="btn btn-default btn-warning btn-xs m-l-20" href="/admin/settings/email/updateemail/{!! $email_templates['admin']->id !!}">
                    <i class="fa fa-cog set-iconz"></i>
                  </a>
                </div>  
               @else   
               <div class="p-10"> No Email Found </div>
               @endif
           </div> 
          
       </td>
    </tr>
    <tr>
      <td> 
         <div class="semi-bold">User Email</div>
          <div class="p-0">
               @if(isset($email_templates['user'])) 
                 <div class="p-10">
                 {!! $email_templates['user']->name !!}
                 <a class="btn btn-default btn-warning btn-xs m-l-20" href="/admin/settings/email/updateemail/{!! $email_templates['user']->id !!}">
                    <i class="fa fa-cog set-iconz"></i>
                  </a>
                </div>  
               @else   
               <div class="p-10"> No Email Found </div>
               @endif
           </div> 
       </td>
    </tr>
    <tr>
      <td>{!! Form::submit('Save',['class' => 'btn btn-success btn-md']) !!}</td>
    </tr>
  </table>
  {!! Form::close() !!} </div>
