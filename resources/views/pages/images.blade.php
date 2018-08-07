@extends('layouts.dashboard_default')
@section('content')

@if (session('success'))
  <div class="alert alert-success" role="alert">
    <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> {{session('success')}}
  </div>
  @elseif (session('fail'))
  <div class="alert alert-warning" role="alert">
    <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> {{session('fail')}}
  </div>
  @endif

<div class="content-addimage">
    <div class="search-container">
        <form id="search_form" action="{{url('images')}}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="q" aria-label="Search" aria-describedby="basic-addon2" value="{{$query or ''}}">
                <div id="search_input_btn" class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">Search</span>
                </div>
            </div> 
        </form>
    </div>
    <button type="button" id="modal-open-add-img-btn" class="btn btn-dark">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new image</button>
</div>
@if (count($items)>0)
<div class="content-imagedata">
    <div class="table-data col-9">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="table-col">@sortablelink('id')</th>
                    <th scope="col" class="table-col">Image</th>
                    <th scope="col" class="table-col">@sortablelink('name')</th>
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
                            <button type="button" class="btn btn-primary image-download" data-id="{{$item->id}}">
                                    <a href="{{asset('storage/imagesSource'.'/'.$item->name.'.'.$item->ext)}}" download></a>
                                <i class="fa fa-download" aria-hidden="true"></i>Download</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="right-column col-3">
        <div class="tags-list">
            <div class="tags-list-header">Tags Cloud</div>
            <div class="tags-wrapper">
                @foreach($tags as $k=>$tag)
                    <div class="tag-wrap">
                    <a class="aui-label" href="{{$request->fullUrlWithQuery(['tag_name' => $tag->name])}}">{{$tag->name}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
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
</div>
@endif
<script>
    $(document).ready(function () {
        $('#search_input_btn').click(function(e){
            
            if(!$('#search_form > div > input').val()){
                $('#search_form').submit();
            }
            e.preventDefault();
        });
        $("#add_tags_select").on("select2:open", function (event) {
            $('input.select2-search__field').attr('placeholder', 'Add New Tag');
        });
        $('.content-imagedata').on('click', '.tag-edit', function (e) {
            var btn = $(this);
            var urlAjax = "image/" + btn.data('id') + "/edit";
            console.log(urlAjax);
            $.ajax({
                url: urlAjax,
                type: 'get',
                success: function (data, textStatus, jqXHR) {
                    $('body').append(data);
                    $('#modal-open-edit-image').modal('show');
                    $('#modal-open-edit-image').on('hide.bs.modal', function (e) {
                        $('#modal-open-edit-image').remove();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error");
                }
            });
        });
        $('.content-imagedata').on('click', '.tag-delete', function (e) {
            var btn = $(this);
            var urlAjax = "image/" + btn.data('id') + "/delete";
            console.log(urlAjax);
            $.ajax({
                url: urlAjax,
                type: 'get',
                success: function (data, textStatus, jqXHR) {
                    $('body').append(data);
                    $('#modal-open-delete-image').modal('show');
                    $('#modal-open-delete-image').on('hide.bs.modal', function (e) {
                        $('#modal-open-delete-image').remove();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error");
                }
            });
        });
        $('#modal-open-add-img-btn').click(function (e) {
            var btn = $(this);
            var urlAjax = "image/add";
            console.log(urlAjax);
            $.ajax({
                url: urlAjax,
                type: 'get',
                success: function (data, textStatus, jqXHR) {
                    $('body').append(data);
                    $('#modal-open-add-img').modal('show');
                    $('#modal-open-add-img').on('hide.bs.modal', function (e) {
                        $('#modal-open-add-img').remove();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error");
                }
            });
        });
        $('.content-imagedata').on('click', '.img-item', function (e) {
            var img_item = $(this).clone();
            console.log(img_item);
            $('#modal-open-img').find('.modal-body').empty().prepend(img_item);
        });
        $('#modal-open-img').on('shown.bs.modal', function (e) {
            $('#modal-open-img').attr('style', 'display: flex!important;justify-content: center;align-items: center;');
            $('#modal-open-img').find('.modal-dialog').attr('style', 'max-width: 542px;margin: 0;');
            $('#modal-open-img').find('img').attr('style', 'width: 100%;height: 100%;');
        });
        $(".table-data").scroll(function () {
            var position = $('.table-data').scrollTop();
            var bottom = $('.table-data').outerHeight();
            var scrollHeight = $(".table-data")[0].scrollHeight;
            if (position + bottom == scrollHeight) {
                var offset = $('.table-data > table > tbody > tr').length;
                $(".table-data").addClass('lazy-loading');
                $.ajax({
                    url: "images_loading",
                    type: 'post',
                    data: {
                        @if($request->q)
                            q:'{{$request->q}}',
                        @endif
                        @if($request->sort && $request->order)
                            sort:'{{$request->sort}}',
                            order:'{{$request->order}}',
                        @endif
                        offset: offset,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        $('div.table-data > table > tbody').append(data).show().fadeIn("slow");

                        $(".table-data").removeClass('lazy-loading');
                    },
                    error: function () {
                        console.log("Error");
                    }
                });
            }
        });
    });
</script>
@stop