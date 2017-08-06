<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17 Admin</a>
            <ul class="left">
                <li>
                    <a href="#" class="btn-collapse-sidebar" data-activates="slide-out"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="right">            
                @if(Auth::Check())
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown"><i class="fa fa-user"></i> Hi, {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>                                
                @endif
            </ul>
            <ul class="side-nav" id="slide-out">
                <li>
                    <a href="{{ route('admin::root') }}"><i class="fa fa-2x fa-home"></i> Home</a>
                </li>
                @if(Auth::user()->hasRole('root'))
                    <li class="collection-item">
                        <li>
                            <a href="{{ route('admin::registrations') }}"><i class="fa fa-2x fa-users"></i>  All Registrations</a>
                        </li>   
                    </li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-check"></i> Confirmation <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>{{ link_to_route('admin::requests.all', 'All Requests') }}</li>
                                        <li>
                                            <a href="{{ route('admin::requests') }}">
                                                New Requests
                                                <span class="new badge green">{{ $new_accomodations }}</span> 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->hasRole('hospitality'))
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-bed"></i> Accomodations <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>{{ link_to_route('admin::accomodations.all', 'All Requests') }}</li>  
                                        <li>
                                            <a href="{{ route('admin::accomodations') }}">
                                                New Requests
                                                <span class="new badge green">{{ $new_requests }}</span> 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
