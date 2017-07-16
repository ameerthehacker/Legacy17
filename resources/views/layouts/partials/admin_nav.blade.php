<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo"><i class="fa fa-rocket"></i> Legacy17 Admin</a>
            <ul class="right">            
                @if(Auth::Check())
                    <li>{{ link_to_route('auth.logout', 'Logout') }}</li>                                  
                @endif
            </ul>
        </div>
    </nav>
</div>