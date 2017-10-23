<div class="panel panel-darkblack">
    <div class="panel-heading bg-black-darker text-white">{!! $page->title !!} Page Information</div>
    <div class="panel-body">
        <p><strong> Title :</strong> {!! $page->title !!}</p>
        <p><strong> Created Date:</strong> {!! BBgetDateFormat($page->created_at) !!}</p>
        <p><strong> URL :</strong> {!! $page->url !!}</p>
        <p><strong> Parent :</strong> {!! $page->parent->title or "None" !!}</p>
        <p><strong> Page Layout :</strong> <select>
                <option>Select Layout</option>
            </select></p>
    </div>
</div>