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
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-3 col-md-3">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Vendedores</h5>
                                            </div>
                                        </div>
                                        <table class="table table-hover">
                                          <tbody>
                                              @foreach($usuarios as $user)
                                              <tr class="unread">
                                                  <td><img class="rounded-circle" style="width:40px;" src="{{asset($user->foto)}}" alt="activity-user">{{$user->nombre}} {{$user->apellido}}
                                                  </td>
                                                  <td>
                                                    <a href="{{ route('tarea.index',[$user->id]) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                  </td>
                                              </tr>                                              
                                              @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-9 col-md-9">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Tareas de visitas</h5>
                                        {{-- <a href="{{route('empresa.contacto.create',$empresa->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo usuario</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            
                                            @foreach ($visitas as $visita)
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="heading{{$visita->id}}">
                                                            <a href="#!" data-toggle="collapse" data-target="#collapse{{$visita->id}}" aria-expanded="false" aria-controls="collapse{{$visita->id}}" class="row" style="color:#000">
                                                                <span class="col-md-8 mb-0 f-16">{{$visita->cliente->nombre}}<br><small class="f-12">Fecha: {{$visita->fecha_inicio}}</small></span>
                                                                <span class="col-md-3 f-12"><span class="float-right"> {{$visita->estado->estado}}<br>Tipo: {{$visita->tipoVisita->tipo}}</span></span>
                                                                <span class="col-md-1"><i class="fa fa-eye"></i></span>
                                                            </a>
                                                    </div>
                                                    <div id="collapse{{$visita->id}}" class="card-body collapse" aria-labelledby="heading{{$visita->id}}" data-parent="#accordionExample" style="">
                                                        <a href="#" class="btn btn-primary float-right tareaVisita" visitaId="{{$visita->id}}" data-toggle="modal" data-target="#modalTarea" >
                                                            <span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Nueva tarea</span>
                                                        </a>
                                                        <table class="table table-hover">
                                                            <tbody>
                                                                @foreach($visita->tareas as $tarea)
                                                                <tr>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-md-7">
                                                                                <span class="text-muted f-12">Tarea:</span><br>
                                                                                <h6 class="m-0">{{$tarea->nombre}}</h6>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-4 text-right">
                                                                                <h6 class="m-0 text-right text-c-{{($tarea->realizado)?'green' :'purple'}}" id="tarea_estado_{{$tarea->id}}">{{($tarea->realizado)? 'Realizado': 'Por hacer'}}</h6>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-1 text-right">
                                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                                    <input type="checkbox" name="tarea_{{$tarea->id}}" id="tarea_{{$tarea->id}}" class="custom-control-input form-control tareaCheckbox" value="{{$tarea->id}}" {{($tarea->realizado)?'checked="checked"':''}}>    
                                                                                    <label class="custom-control-label tareaCheckbox" for="tarea_{{$tarea->id}}"></label>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <span class="text-muted f-12">Descripción:</span><br>
                                                                                <h6 class="m-0">{{$tarea->detalle}}</h6>
                                                                            </div>
                                                                            <div class="col-md-4"> 
                                                                                <h6 class="m-0 text-muted text-right">
                                                                                    <img class="rounded-circle  m-r-10" style="width:40px;" src="{{asset($tarea->usuarioCrea->foto)}}" alt="activity-user">
                                                                                    {{$tarea->usuarioCrea->full_name}}
                                                                                </h6>                                                                                
                                                                                <span class="m-0 text-muted text-right float-right f-12">{{date('d-m-Y',strtotime($tarea->fecha))}} {{date('H:i:s',strtotime($tarea->fecha))}}</span>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Tareas sin visitas</h5>
                                        {{-- <a href="{{route('empresa.contacto.create',$empresa->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo usuario</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalTarea">
                                                <span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Nueva tarea</span>
                                            </a>
                                            <table class="table table-hover">
                                                <tbody>
                                                    @foreach($tareas as $tarea)
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-7">
                                                                    <span class="text-muted f-12">Tarea:</span><br>
                                                                    <h6 class="m-0">{{$tarea->nombre}}</h6>
                                                                </div>
                                                                
                                                                <div class="col-md-4 text-right">
                                                                    <h6 class="m-0 text-right text-c-{{($tarea->realizado)?'green' :'purple'}}" id="tarea_estado_{{$tarea->id}}">{{($tarea->realizado)? 'Realizado': 'Por hacer'}}</h6>
                                                                    
                                                                </div>
                                                                <div class="col-md-1 text-right">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" name="tarea_{{$tarea->id}}" id="tarea_{{$tarea->id}}" class="custom-control-input form-control tareaCheckbox" value="{{$tarea->id}}" {{($tarea->realizado)?'checked="checked"':''}}>    
                                                                        <label class="custom-control-label tareaCheckbox" for="tarea_{{$tarea->id}}"></label>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <span class="text-muted f-12">Descripción:</span><br>
                                                                    <h6 class="m-0">{{$tarea->detalle}}</h6>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <h6 class="m-0 text-muted text-right">
                                                                        <img class="rounded-circle  m-r-10" style="width:40px;" src="{{asset($tarea->usuarioCrea->foto)}}" alt="activity-user">
                                                                        {{$tarea->usuarioCrea->full_name}}
                                                                    </h6>                                                                                
                                                                    <span class="m-0 text-muted text-right float-right f-12">{{date('d-m-Y',strtotime($tarea->fecha))}} {{date('H:i:s',strtotime($tarea->fecha))}}</span>
                                                                </div>
                                                            </div>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
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
<div class="modal fade bd-example-modal-md" name="modalTarea" id="modalTarea" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>"tarea.store","method"=>"POST"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Nueva tarea</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Nombre de la tarea:</label>                            
                                {!! Form::text('nombre', "", ["class"=>"form-control","placeholder"=>"Nombre de la tarea"]) !!}
                            </div>
                        </div>
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Descripción de la tarea</label>
                                <input type="text" id="detalle" value="" name="detalle" class="form-control" aria-describedby="emailHelp" placeholder="Descripción">
                            </div>
                        </div> 
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Fecha</label>
                                <input type="text" id="fecha" value="" name="fecha" class="form-control datetime" aria-describedby="emailHelp" placeholder="Fecha">
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
                        <input type="hidden" value="{{$usuario_id}}" name="usuario_id"/>
                        <input type="hidden" value="" name="visita_id" id="visita_id"/>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('.tareaCheckbox').on('change',function(){
            var valor=$(this).prop('checked');
            $.post("{{route('tarea.completada')}}",{'valor':(valor)?1:0,id:$(this).prop('id').split('_')[1],_token:"{{csrf_token()}}"},function(json){
                if(valor){
                    $('#tarea_estado_'+json.id).html('Realizado');
                    $('#tarea_estado_'+json.id).removeClass('text-c-purple');
                    $('#tarea_estado_'+json.id).addClass('text-c-green');
                }else{
                    $('#tarea_estado_'+json.id).html('Por hacer');                    
                    $('#tarea_estado_'+json.id).removeClass('text-c-green');
                    $('#tarea_estado_'+json.id).addClass('text-c-purple');
                }
                
            },'json');
        })
        $('.tareaVisita').on('click',function(){
            $('#visita_id').val($(this).attr('visitaId'));
        })
        
    });
</script>
@endpush
@push('styles')
@endpush
