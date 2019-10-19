@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                           
                            <!--[ year  sales section ] end-->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Importaciones</h5>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="col-12">
                                            <p>Aqui podras importar datos de tus clientes y tus usuarios para ayudarte a usar la plataforma de forma mas facil</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->
                            <div class="col-md-6 col-xl-6">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Importar clientes</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12">
                                                <p class="m-b-0">Carga todos los clientes de tu empresa desde un archivo Excel, validaremos los clientes por cedula/ruc para evitar repetidos. Puedes subir contactos, y datos de facturación</p>
                                            </div>
                                        </div>
                                        <div class="m-t-30">
                                            
                                            <a class="btn btn-secondary float-right" href="{{route('importaciones.upload','clientes')}}"><span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span><span class="pcoded-mtext">Cargar clientes</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Importar usuarios vendedores</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12">
                                                <p class="m-b-0">Importa todos los vendedores de tu empresa desde un archivo Excel, validaremos los usuarios por cedula y email para evitar usuarios repetidos.</p>
                                            </div>
                                        </div>
                                        <div class="m-t-30">
                                            
                                            <a class="btn btn-secondary float-right" href="{{route('importaciones.upload','usuarios')}}"><span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span><span class="pcoded-mtext">Cargar vendedores</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
