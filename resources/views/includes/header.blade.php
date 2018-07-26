<div class="header">
    <div class="header-logo">
            <h1>Admin panel</h1>
    </div>
    <div class="header-user-info">
        <div class="user-name" id="user_name">{{ Auth::user()->username }}</div>
        <div class="user-modal" id="user_modal">
            <div class="user-modal-wrapper">
                <a href="#" class="user-modal-link">Edit</a>
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