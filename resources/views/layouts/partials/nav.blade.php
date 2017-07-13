<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo">Legacy17</a>
            <ul class="right">
                <li>{{ link_to_route('pages.events', 'Events') }}</li>
                <li>{{ link_to_route('pages.about', 'About') }}</li>                 
                @if(Auth::Check())
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Hospitality</a></li>
                @else
                    <li>{{ link_to_route('auth.register', 'Register') }}</li>                                     
                @endif
            </ul>
        </div>
    </nav>
</div>