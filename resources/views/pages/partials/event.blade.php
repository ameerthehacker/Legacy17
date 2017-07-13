<div class="card">
    <div class="card-image waves-effect waves-light waves-block">
        <img src="{{ $event->image_url }}" alt="{{ $event->title }} image" class="activator">
    </div>
    <div class="card-content">
        <span class="card-title activator">
            {{ $event->title }}
            <i class="material-icons right activator">more_vert</i>            
        </span>
    </div>
    <div class="card-reveal">   
        <span class="card-title">
            <i class="material-icons right">close</i>                    
            {{ $event->title }} Rules
        </span>
        {!! $event->rules !!}        
        @if(Auth::check())
            {{ link_to('#', 'Register', ['class' => 'btn waves-effect waves-light green']) }}        
        @else
            {{ link_to_route('auth.login', 'Login to Register', null,  ['class' => 'btn waves-effect waves-light red']) }}
        @endif
    </div>
</div>