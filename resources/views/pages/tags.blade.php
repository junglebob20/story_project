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
    <button type="button" id="modal-open-add-tag-btn" class="btn btn-dark">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new tag</button>
</div>
<div class="content-search">
    <form id="search_form" action="{{url('tags')}}" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="q" aria-label="Search" aria-describedby="basic-addon2" value="{{$query or ''}}">
            <div id="search_input_btn" class="input-group-append">
                <span class="input-group-text" id="basic-addon2">Search</span>
            </div>
        </div> 
    </form>
</div>
@if (count($items)>0)
<div class="content-imagedata">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="table-col">@sortablelink('id')</th>
                <th scope="col" class="table-col">@sortablelink('name')</th>
                <th scope="col" class="table-col">@sortablelink('created_at')</th>
                <th scope="col" class="table-col">@sortablelink('updated_at')</th>
                <th scope="col" class="table-col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $k=>$item)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td>{{$item->name}}</td>
                <td>{{$item->created_at}}</td>
                <td>{{$item->updated_at}}</td>
                <td class="col-action">
                    <div class="support-btns">
                        <button type="button" data-id="{{$item->id}}" data-toggle="modal" class="btn btn-primary tag-edit">
                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button" data-id="{{$item->id}}" class="btn btn-primary tag-delete">
                            <i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endif
<script>
    function clickEventInit(){
        $('.tag-edit').click(function(e){
                var btn=$(this);
                $.ajax({
                    url: "tag_edit_form/"+btn.data('id'),
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-edit-tag').modal('show');
                        $('#modal-open-edit-tag').on('hide.bs.modal', function (e) {
                            $('#modal-open-edit-tag').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
            });
        $('.tag-delete').click(function(e){
            var btn=$(this);
            var urlAjax="tag/"+btn.data('id')+"/deleteForm";
            console.log(urlAjax);
                $.ajax({
                    url: urlAjax,
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-delete-tag').modal('show');
                        $('#modal-open-delete-tag').on('hide.bs.modal', function (e) {
                            $('#modal-open-delete-tag').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
        });
    }
    $(document).ready(function(){
        clickEventInit();
            $('#modal-open-add-tag-btn').click(function(e){
                $.ajax({
                    url: "tags_add_create",
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-add-tag').modal('show');
                        $('#modal-open-add-tag').on('hide.bs.modal', function (e) {
                            $('#modal-open-add-tag').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
            });
            
            $('#search_input_btn').click(function(){
                $('#search_form').submit();
            });


        $( ".content-imagedata" ).scroll(function() {
        if ($('.content-imagedata').scrollTop() >=  ($('.main-content').height()-$('.content-imagedata').height())*0.8 && !$( ".content-imagedata" ).hasClass('lazy-loading')){
            $( ".content-imagedata" ).addClass('lazy-loading');
            var offset=$('.content-imagedata > table > tbody > tr').length;
            $.ajax({
                    url: "tags_loading",
                    type: 'post',
                    data:{offset:offset,_token:'{{ csrf_token() }}'},
                    success: function(data)
                    {
                        
                        data.forEach(function(item){
                            jQuery('div.content-imagedata > table > tbody').append('<tr><th scope="row">'+item.id+'</th><td>'+item.name+'</td><td>'+item.created_at+'</td><td>'+item.updated_at+'</td><td class="col-action"><div class="support-btns"><button type="button" data-id="'+item.id+'" data-toggle="modal" class="btn btn-primary tag-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button><button type="button" data-id="'+item.id+'" class="btn btn-primary tag-delete"><i class="fa fa-trash" aria-hidden="true"></i>Delete</button></div></td></tr>');
                        });

                        $( ".content-imagedata" ).removeClass('lazy-loading');
                    },
                    error: function()
                    {
                        console.log("Error");
                    }
            });
            
        }
    });

    });
</script>
@stop