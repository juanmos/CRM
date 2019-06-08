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
                                        <h5>Empresas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('empresa.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear empresa</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($empresas->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Numero</th>
                                                        <th>Nombre</th>
                                                        <th>Direccion</th>
                                                        <th>Telefono</th>
                                                        <th>Ciudad</th>
                                                        <th>Usuarios</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($empresas as $empresa)
                                                    <tr class="unread"></tr>
                                                        <td>{{$empresa->id}}</td>
                                                        <td>{{$empresa->nombre}}</td>
                                                        <td>{{$empresa->direccion}}</td>
                                                        <td>{{$empresa->telefono}}</td>
                                                        <td>{{$empresa->ciudad->ciudad}}</td>
                                                        <td>{{$empresa->usuarios->count()}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('empresa.show',$empresa->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('empresa.edit',$empresa->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $empresas->links() }}
                                            @else
                                            <h4>No hay empresas registrados</h4>
                                            <a class="btn btn-primary" href="{{route('empresa.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear empresa</span></a>
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
