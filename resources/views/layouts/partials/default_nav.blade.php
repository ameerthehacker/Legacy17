<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17</a>
            <ul class="left hide-on-large-only">
                <li>
                    <a href="#" class="btn-collapse-sidebar" data-activates="slide-out"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="side-nav" id="slide-out">
                <li>{{ link_to_route('pages.events', 'Events') }}</li>
                <li>{{ link_to_route('pages.about', 'About') }}</li>                  
                @if(Auth::Check())
                    <li>{{ link_to_route('pages.dashboard', 'Dashboard') }}</li>  
                    <li>{{ link_to_route('pages.hospitality', 'Hospitality') }}</li>
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown">Hi, {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>
                @else
                    <li>{{ link_to_route('auth.login', 'Login') }}</li>
                    <li>{{ link_to_route('auth.register', 'Register') }}</li>                                     
                @endif
            </ul>
            <ul class="right hide-on-med-and-down">
                <li>{{ link_to_route('pages.events', 'Events') }}</li>
                <li>{{ link_to_route('pages.about', 'About') }}</li>                  
                @if(Auth::Check())
                    <li>{{ link_to_route('pages.dashboard', 'Dashboard') }}</li>  
                    <li>{{ link_to_route('pages.hospitality', 'Hospitality') }}</li>
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown">Hi, {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>
                @else
                    <li>{{ link_to_route('auth.login', 'Login') }}</li>
                    <li>{{ link_to_route('auth.register', 'Register') }}</li>                                     
                @endif
            </ul>
        </div>
    </nav>
</div>
