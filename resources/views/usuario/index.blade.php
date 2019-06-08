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
                                        <h5>Usuarios</h5>
                                        <a class="btn btn-primary float-right" href="{{route('usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($usuarios->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Email</th>
                                                        <th>Telefono</th>
                                                        <th>Role</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($usuarios as $user)
                                                    <tr class="unread">
                                                        <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($user->foto)}}" alt="activity-user"></td>
                                                        <td>{{$user->nombre}} {{$user->apellido}}
                                                            <i class="fas fa-circle {{($user->activo)?'text-c-green':'text-c-red'}} f-10 m-r-15"></i>
                                                        </td>
                                                        <td>{{$user->email}}</td>
                                                        <td>{{$user->telefono}}</td>
                                                        <td>{{$user->getRoleNames()->implode(',')}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('usuario.show',$user->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('usuario.edit',$user->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay usuarios registrados</h4>
                                            <a class="btn btn-primary" href="{{route('usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
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
