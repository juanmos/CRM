<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand">
                {{-- <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div> --}}
                <span class="b-title"><img src="{{asset('assets/images/logo.png')}}" style="max-width:74%"/></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                {{-- <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li> --}}
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                    <a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Panel de control</span></a>
                </li>
                @if(Auth::user()->hasRole('SuperAdministrador'))
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('empresa.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Empresas</span></a>
                </li>
                @endif
                @if(!Auth::user()->hasRole('SuperAdministrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('cliente.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Clientes</span></a>
                </li>
                @endif
                @if(!Auth::user()->hasRole('SuperAdministrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('visita.index',null)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Calendario</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('tarea.index',null)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">Tareas vendedores</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Vendedor') || Auth::user()->hasRole('JefeVentas'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('tarea.index',Auth::user()->id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">Mis tareas</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('JefeVentas'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('empresa.usuario.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Vendedores</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador'))
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración</label>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">
                        
                        <li class=""><a href="{{route('tipoVisita.index')}}" class="">Tipos de visita</a></li>
                        <li class=""><a href="{{route('clasificacion.index')}}" class="">Clasificaciones</a></li>
                        <li class=""><a href="{{route('plantilla.index')}}" class="">Plantillas</a></li>
                        <li class=""><a href="{{route('configuracion.edit',Auth::user()->empresa_id)}}" class="">Configuraciones</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('SuperAdministrador'))
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración general</label>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="{{route('usuario.index')}}" class="">Usuarios</a></li>
                        <li class=""><a href="{{route('plantilla.index')}}" class="">Plantillas</a></li>˜
                    </ul>
                </li>
                @endif
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Cerrar sesión</span></a>
                </li>
                {{-- 
                <li class="nav-item pcoded-menu-caption">
                    <label>Configuraciones</label>
                </li>
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="form_elements.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Partidos politicos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Candidatos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Puestos politicos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Recintos electorales</span></a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Chart & Maps</label>
                </li>
                <li data-username="Charts Morris" class="nav-item"><a href="chart-morris.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Chart</span></a></li>
                <li data-username="Maps Google" class="nav-item"><a href="map-google.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-map"></i></span><span class="pcoded-mtext">Maps</span></a></li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Pages</label>
                </li>
                <li data-username="Authentication Sign up Sign in reset password Change password Personal information profile settings map form subscribe" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">Authentication</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="auth-signup.html" class="" target="_blank">Sign up</a></li>
                        <li class=""><a href="auth-signin.html" class="" target="_blank">Sign in</a></li>
                    </ul>
                </li>
                <li data-username="Sample Page" class="nav-item"><a href="sample-page.html" class="nav-link"><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Sample page</span></a></li>
                <li data-username="Disabled Menu" class="nav-item disabled"><a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="feather icon-power"></i></span><span class="pcoded-mtext">Disabled menu</span></a></li> --}}
            </ul>
        </div>
    </div>
</nav>