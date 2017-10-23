<div class="p-t-10">
    {!! Form::open(['url' => 'admin/create/form/settings/'.@$form->id, 'method' => 'post']) !!}
    {!! Form::hidden('id',@$form->id) !!}
    <table width="100%" class="table table-bordered bg-white m-0">
        <thead>
        <tr class="bg-black-darker text-white p-10">
            <th colspan="2">After Submit Form</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td width="19%">Success Message</td>
            <td width="81%">{!! Form::textarea('success_message', @$settings['success_message'], ['size' =>'30x5','class'=>'form-control']) !!}</td>
        </tr>
        <tr>
            <td width="19%">Message Type</td>
            <td width="81%">{!! Form::select('message_type',['popup' => 'Pop Up', 'inline' => 'In Line','alert' => 'Alert'] , @$settings['message_type'], ['class' => 'form-control']) !!} </td>
        </tr>

        <tr>
            <td width="19%">Event / Trigger</td>
            <td width="81%">{!! Form::select('event',[], @$settings['event'], ['class' => 'form-control']) !!} </td>
        </tr>

        <tr>
            <td>Redirect Page</td>
            <td>{!! Form::text('redirect_page',@$settings['redirect_page'],['class'=>'form-control']) !!}</td>
        </tr>

        <tr>
            <td>Open New Tab</td>
            <td>{!! Form::text('open_new_tab',@$settings['open_new_tab'],['class'=>'form-control']) !!}</td>
        </tr>
        <tr>
            <td>Is Ajax</td>
            <td>
                Yes {!! Form::radio('is_ajax', 1,(@$settings['is_ajax']==1)?true:null) !!}
                No {!! Form::radio('is_ajax', 0, (@$settings['is_ajax']==0)?true:null)  !!}
            </td>
        </tr>

        {!! Form::hidden('model', 'App\Modules\Settings\Models\Common') !!}
        {!! Form::hidden('function', 'formSubmit') !!}


        <tr>
            <td></td>
            <td>{!! Form::submit('Save',['class' => 'btn btn-success btn-md']) !!}</td>
        </tr>
        </tbody>
    </table>


    {!! Form::close() !!} </div>
