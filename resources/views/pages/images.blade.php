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
                        @foreach($item->tags as $k=>$tag)
                            <div class="tag-wrap">
                                <span id="unclickable-label" class="aui-label">{{$tag->name}}</span>
                            </div>
                        @endforeach
                    </div>
                </td>
                <td class="col-action">
                    <div class="support-btns">
                        <button type="button" class="btn btn-primary tag-edit" data-id="{{$item->id}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button" class="btn btn-primary tag-delete" data-id="{{$item->id}}">
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
            <form id="addImage_form" action="{{url('/image')}}" method="post" enctype="multipart/form-data">
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
                            <div class="tags_selector col-6">
                                <select id="add_tags_select" class="form-control" name="tags[]" multiple="multiple">

                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-open-edit-image" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="edit-form" action="" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="img-uploader" id="img-uploader-edit">
                                <div class="uploaded-image">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="btn col-5">Image:</label>
                            <label for="addimage_btn" class="form-control btn col-6 select-image">Choose image</label>
                            <input style="display:none;" name="image" type="file" class="form-control-file" id="addimage_btn">
                        </div>
                        <div class="form-group">
                            <label for="edit_tags_select" class="btn col-5">Tags:</label>
                            <div class="tags_selector col-6">
                                <select id="edit_tags_select" class="form-control" name="tags[]" multiple="multiple">

                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-open-delete-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="delete-form" action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endif
<script>
    $(document).ready(function(){

        $("#add_tags_select,#edit_tags_select").select2({
            tags: true,
            placeholder: "Select a tags",
            containerCssClass: "tags_container",
            dropdownCssClass : 'tags_dropdown',
            ajax:{
                    url: "{{ url('/tags_search') }}",
                    type: 'get',
                    data: function (params) {
                        var query = {
                        name: params.term
                    }
                    // Query parameters will be ?search=[term]&type=public
                    return query;
                    },
                    processResults: function(data)
                    {
                        return {
                            results: data
                        };
                    }
                }
        });
        $("#add_tags_select").on("select2:open", function(event) {
            $('input.select2-search__field').attr('placeholder', 'Add New Tag');
        });

        $('.tag-edit').click(function(e){
                var btn=$(this);
                $.ajax({
                    url: "image/"+btn.data('id'),
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        console.log(data);
                        var destinationModal=$('#modal-open-edit-image');
                        destinationModal.find('#edit-form').attr('action','image_edit/'+data.id);
                        //destinationModal.find('#tag_name_input').attr('value',data.name);
                        data.tags.forEach(function(tag){
                            destinationModal.find('#edit_tags_select').append('<option selected="selected">'+tag.text+'</option>');
                        });
                        destinationModal.find('#img-uploader-edit > div.uploaded-image').append('<img src="'+data.path+'/'+data.name+'.'+data.ext+'" alt="'+data.name+'">');
                        destinationModal.modal('show');
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
        });

        $('.tag-delete').click(function(e){
            var btn=$(this);
            var destinationModal=$('#modal-open-delete-image');
            destinationModal.find('#delete-form').attr('action','image/delete/'+btn.data('id'));
            destinationModal.modal('show');
        });

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