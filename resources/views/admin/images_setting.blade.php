@extends('layouts.app2')

@section('content')

<style type="text/css">
  .row-mas {
  columns: 5;
  column-gap: 1rem;
}

.row-mas .item {
  display: block;
  width: 100%;
  margin-bottom: 3rem;
    position: relative;
}
.row-mas .item img {
  width: 100%;
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

form.delete_img_parent {
    position: absolute;
    top: -20px;
    left: -15px;
}
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-image"></i>
            </span> Images Setting
        </h3>
    </div>
    @include('admin.inc.notify')
    <div class="row justify-content-center">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" action="{{ route('add_image_settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image" class="form-label">Images</label>
                            <input name="image[]" type="file" class="form-control" id="image" multiple required>
                        </div>
                      
                        <button type="submit" class="btn btn-gradient-primary me-2">Add Images</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if($images->count() > 0)
                        <div class="row-mas">
                            @foreach($images as $image)
                                <div class="item">
                                    <img src="{{ url($image->image) }}" alt="Image">
                                    <form action="{{ route('delete_image_settings', $image->id) }}" method="POST" class="delete_img_parent">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 10px;">X</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No images found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
