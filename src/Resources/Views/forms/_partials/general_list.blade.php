<div class="col-md-12">
    @if(count($units))
        <ul id="sortable1" class="connectedSortable fields">
            @foreach($units as $unit)
            @foreach($unit->variations() as $variation)

                <li class="dragdiv connectedSortable height-40 text-center" data-title="{{ $unit->title }}" data-uniq="{!! uniqId() !!}" data-el='{!! $variation->id  !!}'>
                   <span class="listoficon bbicongreen"><i class="glyphicon glyphicon-minus"></i></span> {{ $unit->title }}/ {{$variation->title}}
                </li>
            @endforeach
            @endforeach
        </ul>
    @else
        No Fields
    @endif
</div>