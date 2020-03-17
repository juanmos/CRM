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
                                        <h5>Tipos de visitas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('tipoVisita.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de visita</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($tipos->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Duración</th>
                                                        <th>Plantilla previsita</th>
                                                        <th>Plantilla visita</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tipos as $tipo)
                                                    <tr class="unread"></tr>
                                                        <td>{{$tipo->tipo}}</td>
                                                        <td>{{$tipo->duracion!=null ? $tipo->duracion->duracion : '60'}} minutos</td>
                                                        <td>{{$tipo->plantillaPre->nombre}}</td>
                                                        <td>{{$tipo->plantillaVisita->nombre}}</td>
                                                        <td>
                                                            @if($tipo->empresa_id!=0)
                                                            <a href="{{ route('tipoVisita.edit',$tipo->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['tipoVisita.destroy',$tipo->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                            @else
                                                            <span class="label theme-danger text-white f-12">No se puede editar/borrar</span>
                                                            @endif
                                                            <a href="#" class="btn btn-primary btn-rounded btn-sm tipoVisitaDuracion" myid="{{$tipo->id}}" duracion="{{$tipo->duracion!=null ? $tipo->duracion->duracion : '60'}}" nombre="{{$tipo->tipo}}" data-toggle="modal" data-target="#modalDuracion">Duración</a>
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay tipo de visitas registrados</h4>
                                            <a class="btn btn-primary" href="{{route('tipoVisita.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de visita</span></a>
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
<div class="modal fade bd-example-modal-md" name="modalDuracion" id="modalDuracion" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>"tipo.visita.duracion","method"=>"POST"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Duración de tipo de visitas</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Tipo de visita: *</label>                            
                                {!! Form::text('nombre', "", ["class"=>"form-control","placeholder"=>"Nombre de la tarea","required"=>"required"]) !!}
                            </div>
                        </div>
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Duración del tipo de visita en minutos</label>
                                <input type="text" value="60" name="duracion" class="form-control" aria-describedby="emailHelp" placeholder="Duracioón en minutos">
                                {!! Form::select('duracion', [10=>'10 minutos', 15=>'15 minutos', 20=>'20 minutos',30=>'30 minutos',45=>'45 minutos',60=>'60 minutos',90=>'1 hora y 30 minutos', 120=>'2 horas', 180=>'3 horas' ], $selected, [$options]) !!}
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="" name="tipo_visita_id"/>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('.tipoVisitaDuracion').on('click',function(){
        $('input[name=tipo_visita_id]').val($(this).attr('myid'));
        $('input[name=duracion]').val($(this).attr('duracion'));
        $('input[name=nombre]').val($(this).attr('nombre'));
    })
})
</script>
@endpush