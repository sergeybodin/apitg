@include('mail.layouts.styles')
@include('mail.layouts.footer')

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        @yield('styles')
    </head>
    <body>
    <div class="wrapper">
        <div class="content">
            @yield('content')
        </div>
        <p class="footer">
            @yield('footer')
        </div>
    </div>
    </body>
</html>

