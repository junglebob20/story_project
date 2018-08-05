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
                            <div class="img-uploader" id="img-uploader">
                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="btn col-4">Image:</label>
                            <label for="addimage_btn" class="form-control btn col-7 select-image">Choose image</label>
                            <input style="display:none;" name="image" type="file" accept="image/*" class="form-control-file" id="addimage_btn">
                        </div>
                        <div class="form-group">
                            <label for="tag_add" class="btn col-4">Tags:</label>
                            <div class="tags_selector col-7">
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
        $('#addimage_btn').change(function(){
            var input=$(this)[0];
            if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        if($('#img-uploader > div.uploaded-image').length>0){
                            $('#img-uploader > div.uploaded-image > img').replaceWith('<img src="'+e.target.result+'" alt="Selected Image">');
                        }else{
                            $('#img-uploader').append('<div class="uploaded-image"><img src="'+e.target.result+'" alt="Selected Image"><div class="uploaded-image-delete"><i class="fa fa-trash" aria-hidden="true"></i></div></div>');
                        }
                    };

                    reader.readAsDataURL(input.files[0]);
                }     
        });
        $('#addImage_form').on('click', '.uploaded-image-delete', function() {
                var btn=$(this);
             console.log('32');
             btn.parent().remove();
             $("#addimage_btn").val("");
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
            <form id="edit-form" action="{{url('image/add')}}" method="post" enctype="multipart/form-data" enctype="multipart/form-data">
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
                                <div class="uploaded-image-delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="btn col-4">Image:</label>
                        <label for="addimage_btn" class="form-control btn col-7 select-image">Choose image</label>
                        <input style="display:none;" name="image" type="file" class="form-control-file" id="addimage_btn">
                    </div>
                    <div class="form-group">
                        <label for="edit_tags_select" class="btn col-4">Tags:</label>
                        <div class="tags_selector col-7">
                            <select id="edit_tags_select" class="form-control" name="tags[]" multiple="multiple">
                                @foreach($item->tags as $k => $tag)
                                <option selected="selected" value="{{$tag->tag_id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-danger" id="edit_form_error" style="display:none;"role="alert"></div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$item->id}}">
                </div>
                <div class="modal-footer">
                    
                    <button type="submit" id="edit_submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        $(document).ready(function () {
    $('#edit_submit').click(function(e){
        e.preventDefault();
        if($('#img-uploader-edit > div.uploaded-image').length<=0){
            $('#edit_form_error').append('<li>'+'Field Image is required'+'</li>');
        }
        if($('#edit-form > div.modal-body > div:nth-child(3) > div > span > span.selection > span > ul > li').length<=1){
            $('#edit_form_error').append('<li>'+'Field Tags is required'+'</li>');
        }
        if($('#edit_form_error > li').length>0){
            $('#edit_form_error').show();
        }
    });
            $('#addimage_btn').change(function(){
            var input=$(this)[0];
            if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        if($('#img-uploader-edit > div.uploaded-image').length>0){
                            $('#img-uploader-edit > div.uploaded-image > img').replaceWith('<img src="'+e.target.result+'" alt="Selected Image">');
                        }else{
                            $('#img-uploader-edit').append('<div class="uploaded-image"><img src="'+e.target.result+'" alt="Selected Image"><div class="uploaded-image-delete"><i class="fa fa-trash" aria-hidden="true"></i></div></div>');
                        }
                    };

                    reader.readAsDataURL(input.files[0]);
                }     
        });
        $('#edit-form').on('click', '.uploaded-image-delete', function() {
                var btn=$(this);
             console.log('32');
             btn.parent().remove();
             $("#addimage_btn").val("");
        });
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