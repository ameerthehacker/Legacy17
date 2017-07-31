@extends('layouts.root')

@section('content')

<div class="slider fullscreen">
    <ul class="slides"> 
        <li>
            <picture>
                <source media="(min-width: 320px)" srcset="/images/root/md/legacy.jpg">
                <source media="(min-width: 980px)" srcset="/images/root/lg/legacy.jpg">
                <img src="/images/root/lg/legacy.jpg" alt="Home Image">
            </picture>
            <div class="caption center-align">
                <h1>Legacy 17</h1>
                <h3>MEPCO Schlenk Engineering College</h3>
                <p class="flow-text">
                    One of the biggest cultural fests is here
                </p>
                {{ link_to_route('pages.about', 'About US', null, ['class' => 'waves-effect waves-light btn blue']) }} 
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>
        </li>
        <li>
            <picture>
                <source media="(min-width: 320px)" srcset="/images/root/md/orchestra.jpg">
                <source media="(min-width: 980px)" srcset="/images/root/lg/orchestra.jpg">
                <img src="/images/root/lg/orchestra.jpg" alt="Home Image">
            </picture>
            <div class="caption center-align">
                <h1>Orchestra</h1>
                <h3>The stage for musical warriors</h3>
                <p class="flow-text">
                    Rock the stage with your music!
                </p>
                {{ link_to_route('auth.login', 'Participate', null, ['class' => 'waves-effect waves-light btn blue']) }} 
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>
        </li>
        <li>
            <picture>
                <source media="(min-width: 320px)" srcset="/images/root/md/dance.jpg">
                <source media="(min-width: 980px)" srcset="/images/root/lg/dance.jpg">
                <img src="/images/root/lg/dance.jpg" alt="Home Image">
            </picture> 
            <div class="caption center-align">
                <h1>Dance</h1>
                <h3>Hit the stage and the audience hard</h3>
                <p class="flow-text">
                    Set the stage on fire with your dance!
                </p>
                {{ link_to_route('auth.login', 'Participate', null, ['class' => 'waves-effect waves-light btn blue']) }} 
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>     
        </li>
        <li>
            <picture>
                <source media="(min-width: 320px)" srcset="/images/root/md/more.jpg">
                <source media="(min-width: 980px)" srcset="/images/root/lg/more.jpg">
                <img src="/images/root/lg/more.jpg" alt="Home Image">
            </picture>      
            <div class="caption center-align">
                <h1>Even more...</h1>
                <h3>Almost 30 events to be organized</h3>
                <p class="flow-text">A record of 1000 participants from 54 colleges</p>
                {{ link_to_route('auth.login', 'Participate', null, ['class' => 'waves-effect waves-light btn blue']) }} 
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>     
        </li>
    </ul>    
    <div class="center-align slider-fixed-item">
        {{ link_to_route('auth.register', 'Register Now!', null, ['class' => 'waves-effect waves-light btn btn-large green']) }}
    </div> 
</div>
    
@endsection