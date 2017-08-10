<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="{{ route('pages.root') }}" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17</a>
            <ul class="left hide-on-large-only">
                <li>
                    <a href="#" class="btn-collapse-sidebar" data-activates="slide-out"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="side-nav" id="slide-out">
                <li><a href="{{ route('pages.events') }}"><i class="fa fa-2x fa-tasks"></i> Events</a></li>
                <li><a href="{{ route('pages.about') }}"><i class="fa fa-2x fa-child"></i> About</a></li>
                @if(Auth::Check())
                    <li><a href="{{ route('pages.dashboard') }}"><i class="fa fa-2x fa-tachometer"></i> Dashboard</a></li>  
                    <li><a href="{{ route('pages.hospitality') }}"><i class="fa fa-2x fa-bed"></i> Hospitality</a></li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-2x fa-user"></i> {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>{{ link_to_route('auth.changePassword', 'Change Password') }}</li>
                                        <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('auth.login') }}"><i class="fa fa-2x fa-key"></i> Login</a></li>
                    <li><a href="{{ route('auth.register') }}"><i class="fa fa-2x fa-user"></i> Register</a></li>                                     
                @endif
            </ul>
            <ul class="right hide-on-med-and-down">
                <li><a href="{{ route('pages.events') }}"><i class="fa fa-tasks"></i> Events</a></li>
                <li><a href="{{ route('pages.about') }}"><i class="fa fa-child"></i> About</a></li>
                @if(Auth::Check())
                    <li><a href="{{ route('pages.dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a></li>  
                    <li><a href="{{ route('pages.hospitality') }}"><i class="fa fa-bed"></i> Hospitality</a></li>
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown"><i class="fa fa-user"></i> Hi, {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.changePassword', 'Change Password') }}</li>            
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('auth.login') }}"><i class="fa fa-key"></i> Login</a></li>
                    <li><a href="{{ route('auth.register') }}"><i class="fa fa-user"></i> Register</a></li>  
                @endif
            </ul>
        </div>
    </nav>
</div>
