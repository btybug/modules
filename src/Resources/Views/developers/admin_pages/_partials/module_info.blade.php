<div class="panel panel-darkblack">
    <div class="panel-heading bg-black-darker text-white">{!! $module->title !!} Module Information</div>
    <div class="panel-body">
        <p><strong> Title :</strong> {!! $module->name !!}</p>
        <p><strong> Created Date:</strong> {!! BBgetDateFormat($module->created_at) !!}</p>
        <p><strong> Author :</strong> {!! @$module->author !!}</p>
        <p><strong> Version :</strong> {!! @$module->version !!}</p>
        @if($info)
            <p><strong> Size :</strong> {!! $info['size'] !!} MB</p>
            <p><strong> Files count :</strong> {!! $info['count'] !!} Files</p>
            <p><strong> Controllers count :</strong> {!! $info['controllers'] !!}</p>
            <p><strong> Views count :</strong> {!! $info['views'] !!}</p>
        @endif
    </div>
</div>