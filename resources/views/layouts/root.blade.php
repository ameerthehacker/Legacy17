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
        {{ HTML::Script("js/particles.min.js") }}   
        {{ HTML::Script("js/app.js") }}         
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">            
        <style>
            .slider-fixed-item{
                position: relative;
                z-index: 9999;
                bottom: 200px;
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
            particlesJS.load('particles-js', 'js/particles.json', function(){
            });
        });
    </script>
    @if(env('APP_ENV', 'local') == 'production')
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-90758540-3', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
</html>