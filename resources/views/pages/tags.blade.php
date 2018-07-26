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
    <button type="button" data-toggle="modal" data-target="#modal-open-add-tag" class="btn btn-dark">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new tag</button>
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
                <th scope="col" class="table-col">Tag_name</th>
                <th scope="col" class="table-col">Created_at</th>
                <th scope="col" class="table-col">Updated_at</th>
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
                        <button type="button" data-id="{{$item->id}}" data-name="{{$item->name}}" data-toggle="modal" class="btn btn-primary tag-edit">
                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button" class="btn btn-primary tag-delete">
                            <i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="support-modal-wrapper">
    <div class="modal" id="modal-open-add-tag" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('tags_add') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tag_name_input">Tag_name</label>
                            <input type="text" name="name" class="form-control" id="tag_name_input" placeholder="Enter Tag" required="">
                        </div>
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
    <div class="modal" id="modal-open-edit-tag" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit-form" action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tag_name_input">Tag_name</label>
                            <input type="text" name="name" class="form-control" id="tag_name_input" placeholder="Enter Tag" required="">
                        </div>
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
        $('.tag-edit').click(function(e){
            var btn=$(this);
            var destinationModal=$('#modal-open-edit-tag');
            destinationModal.find('#edit-form').attr('action','tags_edit/'+btn.data('id'));
            destinationModal.find('#tag_name_input').attr('value',btn.data('name'));
            $('#modal-open-edit-tag').modal('show');
        });
    });
</script>
@stop