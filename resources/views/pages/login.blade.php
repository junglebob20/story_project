<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('includes.head')
        <link rel="stylesheet" href="css/login_page.css">
    </head>
    <body>
    <div class="wrapper">
        <div class="login-wrapper">
            <h1>Admin panel</h1>
            <form id="login_form" action="{{ url('/logincheck')}}" method="get">
                <div class="form-group">
                    <label for="login_input_username">Username</label>
                    <input type="text" class="form-control" name="username" id="login_input_username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="login_input_password">Password</label>
                    <input type="password" class="form-control" name="password" id="login_input_password" placeholder="Password">
                </div>
                @if (session('status'))
                <div id="login_alert_message" class="alert alert-primary" style="display:block;" role="alert">{{ session('status') }}</div>
                @endif
                <button id="submit_form-btn" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div> 
    </body>
</html>
