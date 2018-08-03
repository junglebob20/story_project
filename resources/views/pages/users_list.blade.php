@extends('layouts.dashboard_default') @section('content')
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
  <button type="button" id="modal-open-add-user-btn" class="btn btn-dark">
    <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new user</button>
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
        <th scope="col" class="table-col">Username</th>
        <th scope="col" class="table-col">Role</th>
        <th scope="col" class="table-col">Created_at</th>
        <th scope="col" class="table-col">Updated_at</th>
        <th scope="col" class="table-col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $k=>$item)
      <tr>
        <th scope="row">{{$item->id}}</th>
        <td>{{$item->username}}</td>
        <td>{{$item->role}}</td>
        <td>{{$item->created_at}}</td>
        <td>{{$item->updated_at}}</td>
        <td class="col-action">
          <div class="support-btns">
            <button type="button" data-id="{{ $item->id }}" class="btn btn-primary user-edit">
              <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
            <button type="button" data-id="{{ $item->id }}" class="btn btn-primary user-delete" >
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
  $(document).ready(function(){
      $('.user-edit').click(function(e){
        var btn=$(this);
            var urlAjax="user/"+btn.data('id')+"/edit";
            console.log(urlAjax);
                $.ajax({
                    url: urlAjax,
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-edit-user').modal('show');
                        $('#modal-open-edit-user').on('hide.bs.modal', function (e) {
                            $('#modal-open-edit-user').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
          });
      $('.user-delete').click(function(e){
        var btn=$(this);
        var urlAjax="user/"+btn.data('id')+"/delete";
                $.ajax({
                    url: urlAjax,
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-delete-user').modal('show');
                        $('#modal-open-delete-user').on('hide.bs.modal', function (e) {
                            $('#modal-open-delete-user').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
      });
      $('#modal-open-add-user-btn').click(function(e){
                $.ajax({
                    url: "user/add",
                    type: 'get',
                    success: function(data, textStatus, jqXHR)
                    {
                        $('body').append(data);
                        $('#modal-open-add-user').modal('show');
                        $('#modal-open-add-user').on('hide.bs.modal', function (e) {
                            $('#modal-open-add-user').remove();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        console.log("Error");
                    }
                });
            });
  });
</script> 
@stop