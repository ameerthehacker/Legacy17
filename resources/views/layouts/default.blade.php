<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Legacy17</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::Style("css/materialize.min.css") }}
        {{ HTML::Style("css/font-awesome.min.css") }}                       
        {{ HTML::Script("js/jquery.min.js") }}        
        {{ HTML::Script("js/materialize.min.js") }} 
        {{ HTML::Style("css/app.css") }}        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">            
    </head>
    <body>
        @include('layouts.partials.default_nav')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>