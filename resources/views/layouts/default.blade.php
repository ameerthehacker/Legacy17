<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::Style("css/materialize.min.css") }}
        {{ HTML::Script("js/jquery.min.js") }}        
        {{ HTML::Script("js/materialize.min.js") }}                
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>