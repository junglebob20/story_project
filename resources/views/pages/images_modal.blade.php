@if($modal=='add_image')
<div class="modal" id="modal-open-add-img" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="addImage_form" action="{{url('image/add')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="img-uploader" id="img-uploader" style="display:none;">
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
    <script>
        $('input[name="image"]').change(function(){
            var urlAjax="image/thumbnail";
            var data=$('#addImage_form').serialize();
            console.log(data);
            $.ajax({
                    url: urlAjax,
                    type: 'post',
                    enctype: 'multipart/form-data',
                    data: data,
                    dataType : 'json',
                    processData: false,
                    contentType: false,
                    success: function(data, textStatus, jqXHR)
                    {
                        /*$('#img-uploader > div.uploaded-image').append(data);*/
                        console.log(data);
                        $('#img-uploader').show();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
        });
            $("#add_tags_select").select2({
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
</script>
@elseif ($modal=='edit_image')
<div class="modal" id="modal-open-edit-image" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-form" action="{{ url('image/update') }}" method="post" enctype="multipart/form-data">
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
                                <img src="{{ asset($item->path.'/'.$item->name.'.'.$item->ext) }}" alt="{{$item->name}}">
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
                                @foreach($item->tags as $k => $tag)
                                <option selected="selected" value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$item->id}}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
            $("#edit_tags_select").select2({
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
</script>
@elseif ($modal=='delete_image')
<div class="modal" id="modal-open-delete-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="delete-form" action="{{ url('image/destroy') }}" method="post">
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
                    <input type="hidden" name="id" value="{{$item->id}}">
                </form>
            </div>
        </div>
    </div>
@endif