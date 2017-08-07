@extends('layouts.root')

@section('content')

<div class="slider fullscreen">
    <ul class="slides" style="background: firebrick"> 
        <li>
            <img src="#">
            <div class="caption center-align">
                <h1>Legacy 17</h1>
                <h3>MEPCO Schlenk Engineering College (Autonomous)</h3>
                <p class="flow-text">
                    One of the biggest cultural fests is here
                </p>
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>
        </li>
        <li>
            <div class="caption center-align">
                <h1>Orchestra</h1>
                <h3>The stage for musical warriors</h3>
                <p class="flow-text">
                    Rock the stage with your music!
                </p>
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>
        </li>
        <li>
            <div class="caption center-align">
                <h1>Dance</h1>
                <h3>Hit the stage and the audience hard</h3>
                <p class="flow-text">
                    Set the stage on fire with your dance!
                </p>
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>     
        </li>
        <li>    
            <div class="caption center-align">
                <h1>Even more...</h1>
                <h3>Almost 30 events to be organized</h3>
                <p class="flow-text">A record of 1000 participants from 54 colleges</p>
                <p class="flow-text"><i class="fa fa-calendar"></i> 8 September 2017</p>                
            </div>     
        </li>
    </ul>    
    <div class="center-align slider-fixed-item">
        {{ link_to_route('auth.login', 'Participate', null, ['class' => 'waves-effect waves-light btn blue']) }}  
        {{ link_to_route('auth.register', 'Register', null, ['class' => 'waves-effect waves-light btn green']) }}
    </div> 
</div>
    
@endsection