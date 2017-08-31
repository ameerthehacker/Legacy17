<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="{{ route('pages.root') }}" class="brand-logo center-align center"><i class="fa fa-rocket"></i> Legacy17 Admin</a>
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
                            <li>{{ link_to_route('auth.changePassword', 'Change Password') }}</li>
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>                                
                @endif
            </ul>
            <ul class="side-nav" id="slide-out">
                <li>
                    <a href="{{ route('admin::root') }}"><i class="fa fa-2x fa-home"></i> Home</a>
                </li>
                @if(Auth::user()->hasRole('developer'))
                    <li>
                        <a href="{{ route('admin::terminal') }}"><i class="fa fa-2x fa-cloud-upload"></i> Terminal</a>
                    </li>
                @endif
                @if(Auth::user()->hasRole('root') || Auth::user()->organizings->count()!=0)
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-users"></i> Registrations <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        @if(Auth::user()->hasRole('root'))
                                            <li>{{ link_to_route('admin::registrations', 'All Registrations') }}</li>
                                        @endif
                                        @foreach(App\Event::all() as $event)
                                            @if(Auth::user()->isOrganizing($event->id) || Auth::user()->hasRole('root'))
                                                <li>{{ link_to_route('admin::event.registrations',  $event->title, ['event_id' => $event->id]) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>   
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-check"></i> Confirmation <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        @if(Auth::user()->hasRole('root'))
                                            <li>{{ link_to_route('admin::requests.all', 'All Requests') }}</li>
                                            <li>
                                                <a href="{{ route('admin::requests') }}">
                                                    New Requests
                                                    <span class="new badge green">{{ $new_requests }}</span> 
                                                </a>
                                            </li>
                                        @endif
                                        @foreach(App\Event::all() as $event)
                                            @if(Auth::user()->isOrganizing($event->id) || Auth::user()->hasRole('root'))
                                                <li>{{ link_to_route('admin::event.requests',  $event->title, ['event_id' => $event->id]) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin::reports') }}"><i class="fa fa-2x fa-bar-chart-o"></i> Reports</a></li>
                @endif
                @if(Auth::user()->hasRole('root'))
                    <li class="collection-item">
                        <li>
                            <a href="{{ route('admin::events.index') }}"><i class="fa fa-2x fa-tasks"></i>  Events</a>
                        </li>   
                    </li>
                    <li class="collection-item">
                        <li>
                            <a href="{{ route('admin::users.index') }}"><i class="fa fa-2x fa-user"></i>  Manage Users</a>
                        </li>   
                        <li>
                            <a href="{{ route('admin::colleges.index') }}"><i class="fa fa-2x fa-graduation-cap"></i>  Manage Colleges</a>
                        </li>   
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
                                                <span class="new badge green">{{ $new_accomodations }}</span> 
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
