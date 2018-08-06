<div class="header">
    <div class="header-logo">
            <h1>Admin panel</h1>
    </div>
    <div class="header-user-info">
        <div class="user-name" id="user_name">{{ Auth::user()->username }}</div>
        <div class="user-modal" id="user_modal">
            <div class="user-modal-wrapper">
            <a class="user-modal-link" data-id="{{Auth::user()->id}}">Edit</a>
                <a href="{{url('/logout')}}" class="user-modal-link">Logout</a>
            </div>
        </div>
    </div>
    <script>
        $('body').click(function(e){
            if($('.header-user-info').hasClass('modal-open-user')){
                $('.header-user-info').removeClass('modal-open-user');
            }
        });
        $('.user-modal-wrapper').click(function(e){
            e.stopPropagation();
        });
        $('#user_modal > div > a:nth-child(1)').click(function(e){
            e.preventDefault();
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
        $('#user_name').click(function(e){
            e.preventDefault();
            if(!$('.header-user-info').hasClass('modal-open-user')){
                $('.header-user-info').addClass('modal-open-user');
            }else{
                $('.header-user-info').removeClass('modal-open-user');
            }
            e.stopPropagation();
        });
    </script>
</div>