<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('includes.head')
    <link rel="stylesheet" href="css/admin_panel.css">
</head>
<body>

<div class="wrapper">
    @include('includes.header')
    <div class="main-wrapper">
        @include('includes.sidebar')
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>