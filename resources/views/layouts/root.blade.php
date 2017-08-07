<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Legacy17</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::Style("css/materialize.min.css") }}
        {{ HTML::Style("css/font-awesome.min.css") }}  
        {{ HTML::Style("css/app.css") }}   
        {{ HTML::Script("js/jquery.min.js") }}        
        {{ HTML::Script("js/materialize.min.js") }} 
        {{ HTML::Script("js/materialize-stepper.min.js") }} 
        {{ HTML::Script("js/particles.min.js") }}   
        {{ HTML::Script("js/app.js") }}         
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">            
        <style>
            .slider-fixed-item{
                position: relative;
                z-index: 9999;
                bottom: 150px;
                height: 0px;
            }
        </style>
    </head>
    <body> 
        <div id="particles-js"></div>
        @yield('content')        
    </body>
    <script>
        $('.slider').slider();
        $(function(){
            particlesJS.load('particles-js', 'json/particles.json', function(){
                console.log('Particles JS loaded')
            });
        });
    </script>
</html>