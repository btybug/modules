<?php echo "<?php";?>


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationCategories extends Migration
{


public function up()
{
Schema::create('{!! $data['name'] !!}', function (Blueprint $table) {
<?php $columns = $data['column']; ?>
$table->engine = '{!! \App\Modules\Developers\Models\Migrations::engine()[$data['engine_type']] !!}';
<?php  $types = \App\Modules\Developers\Models\Migrations::types();?>
@foreach ($columns as $column)
    <?php $type = $types[$column['type']]; $name = $column['name'];$lenght = \App\Modules\Developers\Models\Migrations::formate($type, $column['lenght']);?>
    @if ($type == 'decimal' || $type == 'double')
        $table->{!! $type !!}({!! $name !!}{!! isset($lenght[0]) ? ','."$lenght[0]" : null !!}{!! isset($lenght[1]) ? ','.$lenght[1] : ','. 0 !!} @else$table->{!! $type !!}('{!! $name !!}'{!! empty($lenght)?null:','.$lenght !!} )@endif
    <?php  $attributes = \App\Modules\Developers\Models\Migrations::unsets($column)?>
    @foreach ($attributes as $k => $v)
        <?php if ($k == 'unique' or $k == 'nullable') {
            $v = '';
        }?>
        @if ($k == 'default' and !empty($v))
        @else
            ->{!! $k !!}({!! $v !!})
        @endif
    @endforeach
    ;
@endforeach
@if (isset($data['timestamps']) and $data['timestamps'])
    $table->timestamps();
@endif
});
}

public function down()
{
Schema::drop('{!! $data['name'] !!}');
}
}
