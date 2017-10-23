@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div id="accordion">
            <h3>Admin Pages</h3>
            <div>
                <p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>URL</th>
                            <th>Parent</th>
                            <th>Layout</th>
                            <th>Created date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($admin_pages)
                            @foreach($admin_pages as $pages)
                                <tr>
                                    <td>
                                        {{ $pages->id }}
                                    </td>
                                    <td>
                                        {{ $pages->title }}
                                    </td>
                                    <td>
                                        {{ $pages->slug }}
                                    </td>
                                    <td>
                                        {{ $pages->url }}
                                    </td>
                                    <td>
                                        @if($pages->parent_id)
                                            <label class="alert alert-success">
                <p><b>Title :</b> {{ $pages->parent->title }}</p>
                <p><b>URL :</b> {{ $pages->parent->url }}</p>
                </label>
                @else
                    <label class="alert alert-info">NO PARENT</label>
                    @endif
                    </td>
                    <td>
                        @if($pages->layout_id)
                            <label class="alert alert-success">{{ $pages->layout_id }}</label>
                        @else
                            <label class="alert alert-info">default</label>
                        @endif
                    </td>
                    <td>
                        {{ $pages->created_at }}
                    </td>
                    <td>
                        @if(! $pages->is_default)
                            <a href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        @endif

                        <a href="#" class="btn btn-info"><i class="fa fa-info"></i></a>
                        <a href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @if (strpos($pages->url, '{param}') === false)
                            <a href="{!! url($pages->url) !!}" target="_blank" class="btn btn-primary"><i
                                        class="fa fa-eye"></i></a>
                        @endif

                    </td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td class="text-center warning" colspan="8">
                                No Pages
                            </td>
                        </tr>
                        @endif
                        </tbody>

                        </table>
                        </p>
            </div>

            <h3>Frontend Pages</h3>
            <div>
                <p>

                </p>
            </div>
        </div>
    </div>
@stop

@push('css')
    {!! HTML::style('/public/css/page.css?v=0.13') !!}
@endpush
@section('JS')
    <script>
        $(function () {
            $("#accordion").accordion({
                collapsible: true
            });
        });
    </script>
@stop
