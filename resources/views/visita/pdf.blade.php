@extends('layouts.pdf')

@section('content')
<div class="pcoded-main-container" style="margin-left:0">
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
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <span class="d-block text-uppercase">datos del cliente </span>
                                                <h5 class="m-0">{{$visita->cliente->nombre}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->cliente->telefono}}</sub><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <span class="d-block text-uppercase">Datos del contacto </span>
                                                @if($visita->contacto!=null)
                                                <h5 class="m-0">{{$visita->contacto->nombre}} {{$visita->contacto->apellido}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->contacto->telefono}}</sub><br>
                                                <sub class="text-muted f-14">Email: {{$visita->contacto->email}}</sub>
                                                @else
                                                <sub class="text-muted f-14">No has seleccionado un contacto</sub>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <span class="d-block text-uppercase">Datos del usuario </span>
                                                @if($visita->vendedor!=null)
                                                <h5 class="m-0">{{$visita->vendedor->nombre}} {{$visita->vendedor->apellido}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->vendedor->telefono}}</sub><br>
                                                <sub class="text-muted f-14">Email: {{$visita->vendedor->email}}</sub>
                                                @else
                                                <sub class="text-muted f-14">No has seleccionado un vendedor</sub>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Previsita y visita ] end -->
                            <div class="col-xl-8 col-md-8 m-b-30">
                                
                                <h5>Previsita</h5>
                                <div class="tab-pane " id="previsita" >
                                    @if($visita->tipoVisita->plantillaPre->detalles->count()>0)
                                    {!! Form::open(["method"=>"POST","route"=>["visita.save.previsita",$visita->id] ]) !!}
                                        <ul class="list-group list-group-sortable">    
                                            @foreach ($visita->tipoVisita->plantillaPre->detalles()->with(['visita'=>function($query) use($visita){$query->where('id',$visita->id);}])->orderBy('orden')->get() as $detalle )
                                            <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-2">{{$detalle->label}}</h6>
                                                        @if($detalle->tipo_campo==1)
                                                        <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}" name="custom_{{$detalle->id}}" type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif />
                                                        @elseif($detalle->tipo_campo==2)
                                                        <textarea name="custom_{{$detalle->id}}"  rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif>{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}</textarea>
                                                        @elseif($detalle->tipo_campo==3)
                                                        <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}" name="custom_{{$detalle->id}}"  type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif/>
                                                        @elseif($detalle->tipo_campo==4)
                                                        <select name="custom_{{$detalle->id}}"  class="form-control opcionesId_{{$detalle->id}} " @if($visita->estado_visita_id==6)disabled="disabled"@endif>
                                                            @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                <option value="{{$opcion}}" {{($detalle->visita->count()>0)?($detalle->visita[0]->respuestas->valor==$opcion)?'selected="selected"':'':''}}>{{$opcion}}</option>
                                                            @endforeach
                                                        </select>
                                                        @elseif($detalle->tipo_campo==6)
                                                        
                                                            @if($detalle->opciones!=null)
                                                            @foreach(explode('|',$detalle->opciones) as $opcion)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="visita_{{$detalle->id}}[]" id="visita_{{$detalle->id.'_'.$opcion}}" class="custom-control-input" value="{{$opcion}}" {{($detalle->visita->count()>0)?
                                                                    ( array_search($opcion,array_column(array_column($detalle->visita->toArray(),"respuestas"),"valor"),true )!==FALSE )  ?'checked="checked"':'':''}} @if($visita->estado_visita_id==6)disabled="disabled"@endif> 
                                                                <label class="custom-control-label" for="visita_{{$detalle->id.'_'.$opcion}}">{{$opcion}}</label>
                                                                
                                                            </div>
                                                            @endforeach
                                                            @else
                                                                <input type="checkbox" name="custom_{{$detalle->id}}" class="custom-control-input" @if($visita->estado_visita_id==6)readonly="readonly"@endif> Check 
                                                            @endif
                                                        
                                                        @else
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                        {!! Form::hidden('pest', 'pre') !!}
                                    {!! Form::close() !!}
                                    @endif

                                </div>
                                <h5>Visita</h5>
                                <div class="tab-pane " id="visita" >
                                    @if($visita->tipoVisita->plantillaVisita->detalles->count()>0)
                                    {!! Form::open(["method"=>"POST","route"=>["visita.save.visita",$visita->id] ]) !!}
                                        <ul class="list-group list-group-sortable">    
                                            @foreach ($visita->tipoVisita->plantillaVisita->detalles()->with(['visita'=>function($query) use($visita){$query->where('id',$visita->id);}])->orderBy('orden')->get() as $detalle )
                                            <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-2">{{$detalle->label}}</h6>
                                                        @if($detalle->tipo_campo==1)
                                                        <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}"  name="visita_{{$detalle->id}}" type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif />
                                                        @elseif($detalle->tipo_campo==2)
                                                        <textarea name="visita_{{$detalle->id}}"  rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif>{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}</textarea>
                                                        @elseif($detalle->tipo_campo==3)
                                                        <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}"  name="visita_{{$detalle->id}}"  type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif/>
                                                        @elseif($detalle->tipo_campo==4)
                                                        <select name="visita_{{$detalle->id}}"  class="form-control opcionesId_{{$detalle->id}} " @if($visita->estado_visita_id==6)disabled="disabled"@endif>
                                                            @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                <option value="{{$opcion}}" {{($detalle->visita->count()>0)?($detalle->visita[0]->respuestas->valor==$opcion)?'selected="selected"':'':''}}>{{$opcion}}</option>
                                                            @endforeach
                                                        </select>
                                                        @elseif($detalle->tipo_campo==6)
                                                        
                                                            @if($detalle->opciones!=null)
                                                            @foreach(explode('|',$detalle->opciones) as $opcion)
                                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                                <input type="checkbox" name="visita_{{$detalle->id}}[]" id="visita_{{$detalle->id.'_'.$opcion}}" class="custom-control-input" value="{{$opcion}}" {{($detalle->visita->count()>0)?
                                                                    ( array_search($opcion,array_column(array_column($detalle->visita->toArray(),"respuestas"),"valor"),true )!==FALSE )  ?'checked="checked"':'':''}} @if($visita->estado_visita_id==6)disabled="disabled"@endif> 
                                                                <label class="custom-control-label" for="visita_{{$detalle->id.'_'.$opcion}}">{{$opcion}}</label>
                                                            </div>
                                                            @endforeach
                                                            @else
                                                                <input type="checkbox" name="visita_{{$detalle->id}}" class="custom-control-input" @if($visita->estado_visita_id==6)readonly="readonly"@endif> Check 
                                                            @endif
                                                        </div>
                                                        @else
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        
                                        {!! Form::hidden('pest', 'post') !!}
                                        
                                    {!! Form::close() !!}
                                    @endif

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
