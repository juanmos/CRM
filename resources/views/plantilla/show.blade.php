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
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$plantilla->nombre}}</h5>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('plantilla.edit',$plantilla->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                        </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-8 col-md-6">
                                <div class="card Recent-Users">
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($plantilla->detalles->count()>0)
                                            <a href="#" class="btn btn-primary nuevoCampo"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Agregar campo</span></a>
                                            <table class="table table-hover">
                                                <tbody>
                                                    @foreach ($plantilla->detalles as $detalle )
                                                    <tr class="unread">
                                                        <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($usuario->foto)}}" alt="activity-user"></td>
                                                        <td>
                                                            <h6 class="mb-1">{{$usuario->nombre}} {{$usuario->apellido}}</h6>
                                                            <p class="m-0">{{$usuario->telefono}}</p>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-muted"><i class="fas fa-circle {{($usuario->activo)?'text-c-green' :'text-c-red' }} f-10 m-r-15"></i>{{$usuario->email}}</h6>
                                                        </td>
                                                        <td><a href="{{route('empresa.usuario.edit',[$empresa->id,$usuario->id] )}}" class="label theme-bg text-white f-12">Editar</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                                <p>No hay vista previa de la plantilla</p>
                                                <a href="#" class="btn btn-primary nuevoCampo"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Agregar campo</span></a>
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
<div class="modal fade bd-example-modal-md" name="modalNuevoCampo" id="modalNuevoCampo" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Campos personalizados</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">                    
                    <div class="form-group-select col-md-12 row">                        
                        <label class="col-md-4"><b>Tipo de campo:</b></label>                            
                        {!! Form::select('tipoCampo', ['1'=>'Texto corto','2'=>'Texto largo','3'=>'Numero','4'=>'Opciones'], 1 ,array("class"=>"selectpicker tipoCampo required col-md-8 full-width-fix","id"=>"tipoCampo")); !!}                            
                    </div>
                    <div class="form-group-select col-md-12 row">
                        <div class="col-md-4">
                            <label class="col-md-12"><b>Nombre del campo:</b></label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control col-md-12" id="nombreCampo" type="text" name="nombreCampo" value="" placeholder="Nombre del campo">
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                     
                        <button class="btn btnModal-Second pull-left" data-dismiss="modal">
                            <i class="fa fa-close"> </i> CERRAR
                        </button>
                        <button class="btn btn-primary pull-right" id="btnGuardaTipoCampo">
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="" id="campoId"/>
                        <input type="hidden" value="false" id="antecedentes"/>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-md" name="opcionesCampo" id="opcionesCampo" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                <div class="modal-header">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Opciones del campo</h4>
                  </div>
                </div>
                <div class="modal-body">
                    <div id="opcionesView">                        
                        <div class="col-md-12 row">
                            <label class="col-md-3"><b>1:</b></label>
                            <input type="text" class="form-control col-md-8 borderColorElement opcionCampo" name="opcionCampo[]"/>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btnModal-Second pull-left" data-dismiss="modal">
                            <i class="fa fa-close"> </i> CERRAR
                        </button>
                        <button class="btn btn-primary pull-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="" id="campoOpcionesId"/>
                        <input type="hidden" value="" id="antecedentesOpcionesId"/> 
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    var opcionCount=1;
    var opcionCountAnt=1;
    $(document).on('click','.nuevoCampo',function(){
        $('#modalNuevoCampo').modal('show');
        // $('#tipoCampo').val('');
        $('#ordenCampo').val('');
        $('#nombreCampo').val('');
        $('#campoId').val('');
        $('#antecedentes').val("false");
    });

    $(document).on('click','#btnGuardaTipoCampo',function(){
        var tipoCampo = $('select[name=tipoCampo]').val();
        if($('#antecedentes').val()=="true"){
            if ($('#nombreCampo').val() != "") {
                $.post("{{URL::to('configuracion/nuevocampoant')}}",{_token:"{{csrf_token()}}",tipoCampo:tipoCampo,orden:$('#ordenCampo').val() ,nombre:$('#nombreCampo').val(),id:$('#campoId').val()},function(json){
                    llenaAnt(json);           
                },'json');
                cleanFields();
            }else {
                alert("Ingrese todos los campos por favor.");
            }            
        }else{
            if ($('#nombreCampo').val() != "") {
                $.post("{{URL::to('configuracion/nuevocampo')}}",{_token:"{{csrf_token()}}",tipoCampo:tipoCampo,orden:$('#ordenCampo').val() ,nombre:$('#nombreCampo').val(),id:$('#campoId').val()},function(json){
                    llenaCampos(json);            
                },'json');
                cleanFields();
            }else {
                alert("Ingrese todos los campos por favor.");
            }            
        }                  
    });

    function cleanFields() {
        $('#modalNuevoCampo').modal('hide');
        // $('#tipoCampo').val('');
        $('#ordenCampo').val('');
        $('#nombreCampo').val('');
        $('#campoId').val('');
    }

    $(document).on('click','.btnEliminar',function(e){
        e.preventDefault();
        var r = confirm("Está seguro que desea eliminar el campo, ya no estará visible en sus fichas médicas");
        if (r == true) {
            $.post("{{URL::to('configuracion/eliminarcampo')}}",{_token:"{{csrf_token()}}",id:$(this).attr('myid')},function(json){
                llenaCampos(json);;
            },'json')
        }
    });

    $(document).on('click','.btnModificar',function(e){
        e.preventDefault();
        $.post("{{URL::to('configuracion/campo')}}",{_token:"{{csrf_token()}}",id:$(this).attr('myid')},function(json){
            $('#tipoCampo').val(json.campo.tipoCampo);
            $('#ordenCampo').val(json.campo.orden);
            $('#nombreCampo').val(json.campo.nombre);
            $('#campoId').val(json.campo.id);
            $('#modalNuevoCampo').modal('show');
            $('#antecedentes').val("false");
        },'json')
        
    });
    $(document).on('click','.btnEliminarAnt',function(e){
        e.preventDefault();
        var r = confirm("Está seguro que desea eliminar el antecedente, ya no estará visible en sus fichas médicas");
        if (r == true) {
            $.post("{{URL::to('configuracion/eliminarantecedente')}}",{_token:"{{csrf_token()}}",id:$(this).attr('myid')},function(json){
                llenaAnt(json);;
            },'json')
        }
    });

    $(document).on('click','.btnModificarAnt',function(){
        $.post("{{URL::to('configuracion/antecedente')}}",{_token:"{{csrf_token()}}",id:$(this).attr('myid')},function(json){
            $('#tipoCampo').val(json.campo.tipoCampo);
            $('#ordenCampo').val(json.campo.orden);
            $('#nombreCampo').val(json.campo.nombre);
            $('#campoId').val(json.campo.id);
            $('#modalNuevoCampo').modal('show');
            $('#antecedentes').val("true");
        },'json')
        
    });
    $(document).on('click','.btnOpciones',function(e){
        e.preventDefault();
        opcionCount=1;
        $('#campoOpcionesId').val($(this).attr('myid'));
        $('#antecedentesOpcionesId').val('false');
        if($(".opcionesId_"+$(this).attr('myid')+" option").length>0){
            $('#opcionesView').empty();
            opcionCount=0;
            $(".opcionesId_"+$(this).attr('myid')+" option").each(function(){
                opcionCount++;
                $('#opcionesView').append('<div class="col-md-12 row" id="row_'+opcionCount+'">\
                    <label class="col-md-2 text-right"><b>'+opcionCount+':</b></label>\
                    <div class="col-md-8"><input type="text" value="'+$(this).val()+'" class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/></div>\
                    <a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round bs-tooltip removeOpcion col-md-1" count="'+opcionCount+'"><i class="fa fa-times-circle"></i></a>\
                </div>');
            });
        }        
        $('#opcionesCampo').modal('show');
    })
    $(document).on('click','.btnOpcionesAnt',function(e){
        e.preventDefault();
        opcionCountAnt=1;
        $('#campoOpcionesId').val($(this).attr('myid'));
        $('#antecedentesOpcionesId').val('true');
        if($(".opcionesId_"+$(this).attr('myid')+" option").length>0){
            $('#opcionesView').empty();
            opcionCountAnt=0;
            $(".opcionesId_"+$(this).attr('myid')+" option").each(function(){
                opcionCountAnt++;
                $('#opcionesView').append('<div class="col-md-12 row" id="row_'+opcionCountAnt+'">\
                    <label class="col-md-2 text-right"><b>'+opcionCountAnt+':</b></label>\
                    <div class="col-md-8"><input type="text" value="'+$(this).val()+'"  class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/></div>\
                    <a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round bs-tooltip removeOpcion col-md-1" count="'+opcionCountAnt+'"><i class="fa fa-times-circle"></i></a>\
                </div>');
            });
        }        
        $('#opcionesCampo').modal('show');
    })
    $(document).on('focus','.opcionCampo',function(){
        opcionCount++;
        $('#opcionesView').append('<div class="col-md-12 row" id="row_'+opcionCount+'">\
            <label class="col-md-2 text-right"><b>'+opcionCount+':</b></label>\
            <div class="col-md-8"><input type="text"  class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/></div>\
            <a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round bs-tooltip removeOpcion col-md-1" count="'+opcionCount+'"><i class="fa fa-times-circle"></i></a>\
        </div>');
        
    });
    $(document).on('click','.removeOpcion',function(e){
        e.preventDefault();
        var count = $(this).attr('count');
        if(count>1){
            $('#row_'+count).remove();
        }else{
            alert('No puede eliminar el primer campo!')
        }
        
        if(count==opcionCount && count>1){
            opcionCount--;
        }
    })
    $(document).on('click','#btnGuardaOpcionesCampo',function(){
        var opciones = $('input[name="opcionCampo[]"]').map(function(){ 
                if(this.value!='')
                    return this.value; 
                else
                    return ;
            }).get();
        if($('#antecedentesOpcionesId').val()=="false"){
            $.post("{{URL::to('configuracion/opciones')}}",{_token:"{{csrf_token()}}",id:$('#campoOpcionesId').val(),'opciones[]':opciones},function(json){
                llenaCampos(json);
                $('#opcionesCampo').modal('hide');
            },'json')
        }else{
            $.post("{{URL::to('configuracion/opcionesant')}}",{_token:"{{csrf_token()}}",id:$('#campoOpcionesId').val(),'opciones[]':opciones},function(json){
                llenaAnt(json);
                $('#opcionesCampo').modal('hide');
            },'json')
        }
            
    })

    function llenaCampos(json){
        $('#tablaCampos').empty();
        json.campos.forEach(function(data){
            var campo='<tr><td>'+data.orden+'</td><td>'+data.nombre+'</td><td>';
            if(data.tipoCampo==1){
                campo+='<input type="text" class="form-control col-md-12 borderColorElement" />';
            }else if(data.tipoCampo==2){
                campo+='<textarea rows="4" class="form-control borderColorElement" ></textarea>';
            }else if(data.tipoCampo==3){
                campo+='<input type="text" class="form-control col-md-12 borderColorElement" />';
            }else if(data.tipoCampo==4){
                campo+='<select class="selectpicker borderColorElement opcionesId_'+data.id+' col-md-12 full-width-fix">';
                data.opciones.split(',').forEach(function(opcion){
                    campo+='<option value="'+opcion+'">'+opcion+'</opcion>';
                });
                campo+='</select>'
            }
            campo+='</td><td><a href="#" class="btn btn-primary btn-fab btn-fab-mini btn-round bs-tooltip btnModificar" myid="'+data.id+'" title="Editar"><i class="fa fa-pencil"></i></a>';
            if(data.tipoCampo==4){
                campo+='<a href="#" class="btn btn-secondary btn-fab btn-fab-mini btn-round bs-tooltip btnOpciones" myid="'+data.id+'" title="Opciones"><i class="fa fa-chevron-circle-down"></i></a>';
            }
            campo+='<a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round bs-tooltip btnEliminar" myid="'+data.id+'" title="Eliminar"><i class="fa fa-trash"></i></a></td></tr>';
            $('#tablaCampos').append(campo);
        })
    }
    function llenaAnt(json){
        $('#tablaCamposAnt').empty();
        json.antecedentes.forEach(function(data){
            var campo='<tr><td>'+data.orden+'</td><td>'+data.nombre+'</td><td>';
            if(data.tipoCampo==1){
                campo+='<input type="text" class="form-control col-md-12 borderColorElement" />';
            }else if(data.tipoCampo==2){
                campo+='<textarea rows="4" class="form-control borderColorElement" ></textarea>';
            }else if(data.tipoCampo==3){
                campo+='<input type="text" class="form-control col-md-12 borderColorElement" />';
            }else if(data.tipoCampo==4){
                campo+='<select class="selectpicker borderColorElement opcionesId_'+data.id+' col-md-12 full-width-fix">';
                data.opciones.split(',').forEach(function(opcion){
                    campo+='<option value="'+opcion+'">'+opcion+'</opcion>';
                });
                campo+='</select>'
            }
            campo+='</td><td><a href="#" class="btn btn-primary btn-fab btn-fab-mini btn-round bs-tooltip btnModificarAnt" myid="'+data.id+'" title="Editar"><i class="fa fa-pencil"></i></a>';
            if(data.tipoCampo==4){
                campo+='<a href="#" class="btn btn-secondary btn-fab btn-fab-mini btn-round bs-tooltip btnOpcionesAnt" myid="'+data.id+'" title="Opciones"><i class="fa fa-chevron-circle-down"></i></a>';
            }
            campo+='<a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round bs-tooltip btnEliminarAnt" myid="'+data.id+'" title="Eliminar"><i class="fa fa-trash"></i></a></td></tr>';
            $('#tablaCamposAnt').append(campo);
        })
    }
    var campos ={campos: JSON.parse($('#campos').val())};
    var ant={antecedentes:JSON.parse($('#camposAnt').val())};
    llenaCampos(campos);
    llenaAnt(ant);
</script>
@endpush