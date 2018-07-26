@extends('layouts.dashboard_default')
@section('content')
<div class="content-addimage">
@if (session('success'))
  <div class="image-status" style="color:green;">
    <i class="fa fa-check-circle" aria-hidden="true"></i>
    {{session('success')}}
  </div>
  @elseif (session('fail'))
  <div class="image-status" style="color:red;">
    <i class="fa fa-check-circle" aria-hidden="true"></i>
    {{session('fail')}}
  </div>
  @else
  <div class="image-status">

  </div>
  @endif
    <button type="button" data-toggle="modal" data-target="#modal-open-add-img" class="btn btn-dark">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new image</button>
</div>
<div class="content-search">
    <form action="">
        <div class="form-group">
            <label for="search_input">Search:</label>
            <input type="text" class="form-control" id="search_input" placeholder="Search">
        </div>
    </form>
</div>
@if (count($items)>0)
<div class="content-imagedata">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="table-col">Id</th>
                <th scope="col" class="table-col">Image</th>
                <th scope="col" class="table-col">Name</th>
                <th scope="col" class="table-col">Tags</th>
                <th scope="col" class="table-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $k=>$item)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td>
                    <img data-toggle="modal" data-target="#modal-open-img" class="img-item" src="{{ asset($item->path.'/'.$item->name.'.'.$item->ext) }}" alt="{{ $item->name }}">
                </td>
                <td>{{ $item->name }}</td>
                <td>
                    <div class="tags-wrapper">
                        <div class="tag-wrap">
                            <span id="unclickable-label" class="aui-label">tag_name1</span>
                        </div>
                        <div class="tag-wrap">
                            <span id="unclickable-label" class="aui-label">tag_name2</span>
                        </div>
                        <div class="tag-wrap">
                            <span id="unclickable-label" class="aui-label">tag_name3</span>
                        </div>
                    </div>
                </td>
                <td class="col-action">
                    <div class="support-btns">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="support-modal-wrapper">
    <div class="modal" id="modal-open-img" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-open-add-img" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addImage_form" action="http://127.0.0.1:8000/image" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="display:none;">
                            <div class="img-uploader" id="img-uploader">
                                <div class="uploaded-image">
                                    <img src="" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="btn col-5">Image:</label>
                            <label for="addimage_btn" class="form-control btn col-6 select-image">Choose image</label>
                            <input style="display:none;" name="image" type="file" class="form-control-file" id="addimage_btn">
                        </div>
                        <div class="form-group">
                            <label for="tag_add" class="btn col-5">Tags:</label>
                            <input type="text" name="tag_add" class="form-control col-6" id="tag_add" placeholder="Enter tag" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    $(document).ready(function(){
        console.log($('.img-item'));
            $('.img-item').click(function(){
                var img_item=$(this).clone();
                console.log(img_item);
                $('#modal-open-img').find('.modal-body').empty().prepend(img_item);
            });
            $('#modal-open-img').on('shown.bs.modal', function (e) {
                $('#modal-open-img').attr('style','display: flex!important;justify-content: center;align-items: center;');
                $('#modal-open-img').find('.modal-dialog').attr('style','max-width: 542px;margin: 0;');
                $('#modal-open-img').find('img').attr('style','width: 100%;height: 100%;');
            });
    });
</script>
@stop