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
        @if($item->roles[0]->pivot->role_id=='1')
          <td>{{$roles[0]->name}}</td>
        @elseif($item->roles[0]->pivot->role_id=='2')
          <td>{{$roles[1]->name}}</td>
        @elseif($item->roles[0]->pivot->role_id=='3')
          <td>{{$roles[2]->name}}</td>
        @endif
        <td>{{$item->created_at}}</td>
        <td>{{$item->updated_at}}</td>
        <td class="col-action">
          <div class="support-btns">
            <button type="button" class="btn btn-primary">
              <i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
            <button type="button" class="btn btn-primary" >
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
                @foreach($roles as $k=>$role)
                  <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
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
</div>
@endif @stop