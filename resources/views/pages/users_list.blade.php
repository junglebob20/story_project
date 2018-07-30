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
  <button type="button" data-toggle="modal" data-target="#modal-open-add-user" class="btn btn-dark">
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
<div class="support-modal-wrapper">
  <div class="modal" id="modal-open-add-user" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ url('user_add') }}" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Create New user</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="username_input">Username</label>
              <input type="text" name="username" class="form-control" id="username_input" placeholder="Enter Username" required="">
            </div>
            <div class="form-group">
              <label for="password_input">Password</label>
              <input type="text" name="password" class="form-control" id="password_input" placeholder="Enter Password" required="">
            </div>
            <div class="form-group">
              <label for="re_password_input">Re-password</label>
              <input type="text" name="password_confirmation" class="form-control" id="re_password_input" placeholder="Enter Re-password" required="">
            </div>
            <div class="form-group">
              <label for="role_input">Role</label>
              <select name="role" class="form-control" id="role_input">
                <option value="root">Root</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
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
  <div class="modal" id="modal-open-edit-user" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="edit-form" action="" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Edit user</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="username_input">Username</label>
              <input type="text" name="username" class="form-control" id="username_input" placeholder="Enter Username" required="">
            </div>
            <div class="form-group">
              <label for="password_input">Password</label>
              <input type="text" name="password" class="form-control" id="password_input" placeholder="Enter Password" required="">
            </div>
            <div class="form-group">
              <label for="re_password_input">Re-password</label>
              <input type="text" name="password_confirmation" class="form-control" id="re_password_input" placeholder="Enter Re-password" required="">
            </div>
            <div class="form-group">
              <label for="user_role_select">Role</label>
              <select id="user_role_select" name="role" class="form-control">
                <option value="root">Root</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
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
  <div class="modal" id="modal-open-delete-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="delete-form" action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Delete user</h5>
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
      $('.user-edit').click(function(e){
              var btn=$(this);
              $.ajax({
                  url: "user/"+btn.data('id'),
                  type: 'get',
                  success: function(data, textStatus, jqXHR)
                  {
                    console.log(data);
                      var destinationModal=$('#modal-open-edit-user');
                      destinationModal.find('#edit-form').attr('action','user_edit/'+data.id);
                      destinationModal.find('#username_input').attr('value',data.username);
                      destinationModal.find('#user_role_select option[value="'+data.role+'"]').prop('selected', true);
                      destinationModal.modal('show');
                  },
                  error: function(jqXHR, textStatus, errorThrown)
                  {
                      console.log("Error");
                  }
              });
          });
      $('.user-delete').click(function(e){
          var btn=$(this);
          var destinationModal=$('#modal-open-delete-user');
          destinationModal.find('#delete-form').attr('action','user_delete/'+btn.data('id'));
          destinationModal.modal('show');
      });
  });
</script> 
@stop