@extends('admin.layout')

@section('admin-title')
    Figure Categories
@endsection

@section('admin-content')
    {!! breadcrumbs([
        'Admin Panel' => 'admin',
        'Figure Categories' => 'admin/world/figure-categories',
        ($category->id ? 'Edit' : 'Create') . ' Figure Category' => $category->id ? 'admin/world/figure-categories/edit/' . $category->id : 'admin/world/figure-categories/create',
    ]) !!}

    <h1>{{ $category->id ? 'Edit' : 'Create' }} Figure Category
        @if ($category->id)
            ({!! $category->displayName !!})
            <a href="#" class="btn btn-danger float-right delete-category-button">Delete Figure Category</a>
        @endif
    </h1>

    {!! Form::open(['url' => $category->id ? 'admin/world/figure-categories/edit/' . $category->id : 'admin/world/figure-categories/create', 'files' => true]) !!}

    <div class="card mb-3">
        <h2 class="card-header h3">Basic Information</h2>
        <div class="card-body">
            <div class="form-group">
                {!! Form::label('Name') !!}
                {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Summary (Optional)') !!}
                {!! Form::text('summary', $category->summary, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <h2 class="card-header h3">Images</h2>
        <div class="card-body row">
            <div class="form-group col-md-6">
                @if ($category->thumb_extension)
                    <a href="{{ $category->thumbUrl }}" data-lightbox="entry" data-title="{{ $category->name }}"><img src="{{ $category->thumbUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
                @endif
                {!! Form::label('Thumbnail Image (Optional)') !!} {!! add_help('This thumbnail is used on the category index.') !!}
                <div>{!! Form::file('image_th') !!}</div>
                <div class="text-muted">Recommended size: 200x200</div>
                @if (isset($category->thumb_extension))
                    <div class="form-check">
                        {!! Form::checkbox('remove_image_th', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Thumbnail As-Is', 'data-on' => 'Remove Thumbnail Image']) !!}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                @if ($category->image_extension)
                    <a href="{{ $category->imageUrl }}" data-lightbox="entry" data-title="{{ $category->name }}"><img src="{{ $category->imageUrl }}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
                @endif
                {!! Form::label('Category Image (Optional)') !!} {!! add_help('This image is used on the category page as a header.') !!}
                <div>{!! Form::file('image') !!}</div>
                <div class="text-muted">Recommended size: None (Choose a standard size for all category header images.)</div>
                @if (isset($category->image_extension))
                    <div class="form-check">
                        {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Header Image As-Is', 'data-on' => 'Remove Current Header Image']) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header h3">
            {!! Form::label('Description (Optional)') !!}
        </div>
        <div class="card-body">
            <div class="form-group" style="clear:both">
                {!! Form::textarea('description', $category->description, ['class' => 'form-control wysiwyg']) !!}
            </div>
        </div>
    </div>

    <div class="form-group" style="clear:both">
        {!! Form::label('Description (Optional)') !!}
        {!! Form::textarea('description', $category->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($category->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.delete-category-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/world/figure-categories/delete') }}/{{ $category->id }}", 'Delete Figure Category');
            });
            $('.selectize').selectize();
        });
    </script>
@endsection
