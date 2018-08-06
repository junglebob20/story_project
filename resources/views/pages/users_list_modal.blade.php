@if($modal=='add_user')
<div class="modal" id="modal-open-add-user" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="{{ url('user/add') }}" method="post">
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
                        <input type="password" name="password" class="form-control" id="password_input" placeholder="Enter Password" required="">
                    </div>
                    <div class="form-group">
                        <label for="re_password_input">Re-password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="re_password_input" placeholder="Enter Re-password"
                            required="">
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
@elseif ($modal=='edit_user')
<div class="modal" id="modal-open-edit-user" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="edit-form" action="{{ url('user/update') }}" method="post">
                <div class="modal-header">
                <h5 class="modal-title">Edit user - '{{$item->username}}'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username_input">Username</label>
                        <input type="text" name="username" class="form-control" id="username_input" placeholder="Enter Username"  value="{{$item->username}}">
                    </div>
                    <div class="form-group">
                        <label for="password_input">Password</label>
                        <input type="password" name="password" class="form-control" id="password_input" placeholder="Enter Password" >
                    </div>
                    <div class="form-group">
                        <label for="re_password_input">Re-password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="re_password_input" placeholder="Enter Re-password"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="user_role_select">Role</label>
                        <select id="user_role_select" name="role" class="form-control">
                            <option {{$item->role=='root' ? 'selected' : false}} value="root">Root</option>
                            <option {{$item->role=='admin' ? 'selected' : false}} value="admin">Admin</option>
                            <option {{$item->role=='user' ? 'selected' : false}} value="user">User</option>
                        </select>
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
@elseif ($modal=='delete_user')
<div class="modal" id="modal-open-delete-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="delete-form" action="{{ url('user/destroy') }}" method="post">
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
                <input type="hidden" name="id" value="{{$item->id}}">
            </form>
        </div>
    </div>
</div>
@elseif ($modal=='item_source')
    @if(count($items)>0)
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
    @endif
@endif