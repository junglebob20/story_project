@extends('layouts.dashboard_default') 
@section('content')

@if (session('success'))
<div class="alert alert-success" role="alert">
    <strong>
        <i class="fa fa-check-circle" aria-hidden="true"></i>
    </strong> {{session('success')}}
</div>
@elseif (session('fail'))
<div class="alert alert-danger" role="alert">
    <strong>
        <i class="fa fa-check-circle" aria-hidden="true"></i>
    </strong> {{session('fail')}}
</div>
@endif

<div class="content-addimage">
    <div class="search-container">
        <form id="search_form" action="{{url('userslist')}}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="q" aria-label="Search" aria-describedby="basic-addon2"
                    value="{{$query or ''}}">
                <div id="search_input_btn" class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">Search</span>
                </div>
            </div>
        </form>
    </div>
    <button type="button" id="modal-open-add-user-btn" class="btn btn-dark">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>Add new user</button>
</div>
@if (count($items)>0)
<div class="content-imagedata">
  <table class="table">
    <thead>
      <tr>
        <th scope="col" class="table-col">@sortablelink('id')</th>
        <th scope="col" class="table-col">@sortablelink('username')</th>
        <th scope="col" class="table-col">@sortablelink('role')</th>
        <th scope="col" class="table-col">@sortablelink('created_at')</th>
        <th scope="col" class="table-col">@sortablelink('updated_at')</th>
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
  $(document).ready(function () {
    $('#search_input_btn').click(function(e){
            console.log(!$('#search_form > div > input').val());
            if(!$('#search_form > div > input').val()){
                $('#search_form').submit();
            }
            e.preventDefault();
        });
    $('.content-imagedata').on('click', '.user-edit', function (e) {
          var btn = $(this);
          var urlAjax = "user/" + btn.data('id') + "/edit";
          console.log(urlAjax);
          $.ajax({
              url: urlAjax,
              type: 'get',
              success: function (data, textStatus, jqXHR) {
                  $('body').append(data);
                  $('#modal-open-edit-user').modal('show');
                  $('#modal-open-edit-user').on('hide.bs.modal', function (e) {
                      $('#modal-open-edit-user').remove();
                  });
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.log("Error");
              }
          });
      });
      $('.content-imagedata').on('click', '.user-delete', function (e) {
          var btn = $(this);
          var urlAjax = "user/" + btn.data('id') + "/delete";
          $.ajax({
              url: urlAjax,
              type: 'get',
              success: function (data, textStatus, jqXHR) {
                  $('body').append(data);
                  $('#modal-open-delete-user').modal('show');
                  $('#modal-open-delete-user').on('hide.bs.modal', function (e) {
                      $('#modal-open-delete-user').remove();
                  });
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.log("Error");
              }
          });
      });
      $('#modal-open-add-user-btn').click(function (e) {
          $.ajax({
              url: "user/add",
              type: 'get',
              success: function (data, textStatus, jqXHR) {
                  $('body').append(data);
                  $('#modal-open-add-user').modal('show');
                  $('#modal-open-add-user').on('hide.bs.modal', function (e) {
                      $('#modal-open-add-user').remove();
                  });
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.log("Error");
              }
          });
      });
      $(".content-imagedata").scroll(function () {
            var position = $('.content-imagedata').scrollTop();
            var bottom = $('.content-imagedata').outerHeight();
            var scrollHeight = $(".content-imagedata")[0].scrollHeight;
            if (position + bottom == scrollHeight) {
                var offset = $('.content-imagedata > table > tbody > tr').length;
                $(".content-imagedata").addClass('lazy-loading');
                $.ajax({
                    url: "userslist_loading",
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
                        $('div.content-imagedata > table > tbody').append(data).show().fadeIn("slow");

                        $(".content-imagedata").removeClass('lazy-loading');
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