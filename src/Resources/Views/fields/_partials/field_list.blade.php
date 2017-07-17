<div class="col-md-12">
    @if(count($fields))
        <ul id="sortable1" class="connectedSortable fields">
            @foreach($fields as $field)

                <li class="dragdiv connectedSortable height-40 text-center" data-title="{{ $field->title }}" data-uniq="{!! uniqId() !!}" data-el="{{ $field->id }}" >
                    {{ $field->title }}
                </li>
            @endforeach
        </ul>
    @else
        No Fields
    @endif
</div>