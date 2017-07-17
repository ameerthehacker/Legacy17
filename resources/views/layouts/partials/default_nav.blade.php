<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17</a>
            <ul class="right">
                <li>{{ link_to_route('pages.events', 'Events') }}</li>
                @if(Auth::Check())
                    <li>{{ link_to_route('pages.dashboard', 'Dashboard') }}</li>                                    
                    <li><a href="#">Hospitality</a></li>
                    <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                @else
                    <li>{{ link_to_route('auth.login', 'Login') }}</li>
                    <li>{{ link_to_route('auth.register', 'Register') }}</li>                                     
                @endif
                <li>{{ link_to_route('pages.about', 'About') }}</li>                
            </ul>
        </div>
    </nav>
</div>