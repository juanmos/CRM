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
                                        <h5>Clientes</h5>
                                        <a class="btn btn-primary float-right" href="{{route('cliente.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($clientes->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Direccion</th>
                                                        <th>Telefono</th>
                                                        <th>Vendedor</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($clientes as $cliente)
                                                    <tr class="unread"></tr>
                                                        <td>{{$cliente->nombre}}</td>
                                                        <td>{{$cliente->facturacion->direccion}}</td>
                                                        <td>{{$cliente->telefono}}</td>
                                                        <td>{{($cliente->usuario!=null)?$cliente->usuario->nombre.' '.$cliente->usuario->apellido:'Sin asignar'}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('cliente.show',$cliente->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('cliente.edit',$cliente->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clientes->links() }}
                                            @else
                                            <h4>No hay clientes registrados</h4>
                                            <a class="btn btn-primary" href="{{route('cliente.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->

                            

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
