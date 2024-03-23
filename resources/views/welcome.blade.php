<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased">
        <div style="position: relative; height: 100vh; width: 100vw; ">
            @if (Route::has('login'))
                <div class="" style="position:absolute; top:50%; left:50%; transform:translateX(-50%);transform:translateY(-50%)">
                    @auth
                        <a href="{{ url('/home') }}" class="">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="font-size: 30px; color:brown;font-weight:500; margin-right:30px; text-decoration:none">Log in</a>
                        <a href="{{ route('register') }}" style="font-size: 30px; color:brown;font-weight:500; text-decoration:none">Register</a>
                    @endauth
                </div>
            @endif
            <div style="position:absolute; bottom:10px;right:10px;font-weight:600">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </body>
</html>
