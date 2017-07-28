<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17 Admin</a>
            <ul class="left">
                <li>
                    <a href="#" id="btn-collapse-sidebar" data-activates="slide-out"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="right">            
                @if(Auth::Check())
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown">Hi, {{ Auth::user()->full_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>                                
                @endif
            </ul>
        </div>
    </nav>
</div>
<ul class="side-nav" id="slide-out">
    @if(Auth::user()->hasRole('root'))
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Confirmation</a>
                    <div class="collapsible-body">
                        <ul>
                            <li>{{ link_to_route('admin::requests', 'Requests') }}</li>                        
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
                    <a class="collapsible-header">Accomodations</a>
                    <div class="collapsible-body">
                        <ul>
                            <li>{{ link_to_route('admin::accomodations', 'Requests') }}</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    @endif
</ul>
