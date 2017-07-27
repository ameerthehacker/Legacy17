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
                    <li>{{ link_to_route('auth.logout', 'Logout') }}</li>                                  
                @endif
            </ul>
        </div>
    </nav>
</div>
<ul class="side-nav" id="slide-out">
    @if(Auth::user()->hasRole('root'))
        <li>{{ link_to_route('admin::requests', 'Requests') }}</li>
    @endif
</ul>