@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    @if($empresa!=null)
                                    <h5 class="m-b-10">Editar empresa</h5>
                                    @else
                                    <h5 class="m-b-10">Nueva empresa</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresa</a></li>
                                    @if($empresa!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{($empresa!=null)?route('empresa.update',$empresa->id):route('empresa.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($empresa!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la empresa</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Empresa</label>
                                                <input type="text" value="@if($empresa!=null){{$empresa->nombre}}@endif" name="nombre" class="form-control" aria-describedby="emailHelp" placeholder="Empresa">
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">RUC</label>
                                                <input type="text" value="@if($empresa!=null){{$empresa->ruc}}@endif" name="ruc" class="form-control" id="exampleInputPassword1" placeholder="RUC">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Dirección</label>
                                                <input type="text" value="@if($empresa!=null){{$empresa->direccion}}@endif" name="direccion" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad</label>
                                                {{-- <input type="text" value="@if($empresa!=null){{$empresa->activo}}@endif" name="activo" class="form-control" id="exampleInputPassword1" placeholder="Activo"> --}}
                                                {!! Form::select('ciudad_id', $ciudad, ($empresa!=null)?$empresa->ciudad_id : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($empresa!=null){{$empresa->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Costo</label>
                                                <input type="text" value="@if($empresa!=null){{$empresa->costo}}@endif" name="costo" class="form-control" id="exampleInputPassword1" placeholder="Costo">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Activo</label>
                                                {!! Form::select('activo', ["0"=>"Inactivo","1"=>"Activo"], ($empresa!=null)?$empresa->activo : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">En pruebas</label>
                                                {!! Form::select('pruebas', ["0"=>"Empresa de pago","1"=>"Empresa de preubas"], ($empresa!=null)?$empresa->pruebas : 0 ,["class"=>"form-control"]) !!}
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

