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
                                                  <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($user->foto)}}" alt="activity-user">{{$user->nombre}} {{$user->apellido}}
                                                  </td>
                                                  <td>
                                                    <a href="{{ route('visita.index',[$user->id]) }}" class="label theme-bg2 text-white f-12">Ver</a>
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
                                        <h5>Visitas</h5>
                                        {{-- <a href="{{route('empresa.contacto.create',$empresa->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo usuario</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <div id="calendar"></div>
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

<div class="modal fade bd-example-modal-lg" name="modalBuscaCliente" id="modalBuscaCliente" tabindex="-1" role="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                {{-- <div class="modal-header"> --}}
                  <div class="card-header ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Buscar clientes</h4>
                  </div>
                {{-- </div> --}}
                <div class="modal-body">
                    {!! Form::open() !!}
                        <div class="row overflow-y-auto">                            
                            <div class="col-md-3">
                                <label>Buscar el cliente:</label>
                            </div>
                            <div class="col-md-9">                                
                                <input type="text" name="buscar" required id="buscar" class="form-control borderColorElement" value="" placeholder="Escriba el nombre de la empresa o el RUC">
                            </div>
                        </div>
                        <br/>
                        <div class="row overflow-y-auto height250">
                            <div ID="scroll" class="col-md-12 table-responsive">
                                <table id="table" class="table table-striped table-hover tabbable-wrap-content table-condensed" cellspacing="0" width="100%">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Teléfono</th>
                                            <th>Web</th>
                                            <th>Clasificación</th>
                                            <th class="qr_action">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="entrydata">                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {!! Form::close()!!}
                </div>
                <div class="modal-footer row">
                    <div class="col-md-12">
                        <button data-dismiss="modal" class="btn float-left btn-danger" data-dismiss="modal" id="cancelar">
                            <i class="far fa-times-circle"></i> CANCELAR
                        </button>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" name="modalAddCita" id="modalAddCita" tabindex="-1" role="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {{-- <div class="modal-header"> --}}
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">   
                      <i class="material-icons">clear</i>
                    </button>
                    <h4 class="card-title"> Datos de la visita</h4> 
                  </div>
                {{-- </div> --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Cliente: </label>
                                <div class="col-md-10">
                                    <input type="text" required name="nombre" class="form-control" id="nombreAdd" >
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Teléfono: </label>
                                <div class="col-md-10">
                                    <input type="text" name="telefono" class="form-control" id="telefono" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Web: </label>
                                <div class="col-md-11">
                                    <input type="email" required name="web" class="form-control" id="email" >
                                </div>
                            </div>
                            <input type="hidden" id="cliente_id" name="cliente_id"/>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group-select col-md-7">
                                    <label class="col-md-7 control-label ">Tipo: </label>
                                    <div class="col-md-12">
                                        {!! Form::select('tipoCitaId', $tiposVisita, 0 ,array("class"=>"form-control tipoCitaId required selectpicker full-width-fix")); !!}                                         
                                    </div>
                                </div>
                                <div class="form-group-select col-md-5">
                                    <label class="col-md-7 control-label ">Duración: </label>
                                    <div class="col-md-12">
                                        <select name="duracion" id="duracion" required class="form-control select2 selectpicker col-md-12 full-width-fix">
                                            @for($i =10; $i <= 60; $i = $i + 5)
                                                <option value="{{$i}}"> {{$i}} min</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-select">
                                <label class="col-md-7 control-label ">Hora: </label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="horaModal" id="horaModal" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($i = 1; $i < 13; $i++)
                                                @if($i < 10)
                                                    <option value="0{{$i}}" > 0{{$i}} </option>
                                                @else
                                                    <option value="{{$i}}" > {{$i}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="minModal" id="minModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($j = 0; $j <= 59; $j = $j+5)
                                                @if($j < 10)
                                                    <option value="0{{$j}}" > 0{{$j}} </option>
                                                @else
                                                    <option value="{{$j}}" > {{$j}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="periodo" id="periodo" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                            
                            <div class="form-group-select pickFecha" >
                                <label class="col-md-3 control-label">Fecha:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="diaModal" id="diaModal" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($i = 1; $i < 32; $i++)
                                                @if($i < 10)
                                                    <option value="0{{$i}}" > 0{{$i}} </option>
                                                @else
                                                    <option value="{{$i}}" > {{$i}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="mesModal" id="mesModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($j = 1; $j <= 12; $j++)
                                                @if($j < 10)
                                                    <option value="0{{$j}}" > 0{{$j}} </option>
                                                @else
                                                    <option value="{{$j}}" > {{$j}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <?php 
                                            $fecha = new DateTime();
                                            $anio=$fecha->format('Y');
                                            $anio1 = intval($anio) + 1;
                                        ?>
                                        <input type="hidden" id="mesAct" value="{{$fecha->format('m')}}">
                                        <input type="hidden" id="diaAct" value="{{$fecha->format('d')}}">
                                        
                                        <select name="anioModal" id="anioModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            <option value="{{$anio}}" > {{$anio}} </option>
                                            <option value="{{$anio1}}" > {{$anio1}} </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 color1" id="horariosDiv"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" id="buscaPaciente">
                           <i class="fa fa-search"> </i> CAMBIAR CLIENTE
                        </button>
                        <button type="button" class="btn btn-success float-right" name="aceptCreate" id="aceptCreate">
                            <i class="fa fa-save"> </i> ACEPTAR
                        </button>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('scripts')
<script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/interaction/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/list/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/core/locales-all.js")}}'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'dayGrid', 'timeGrid', 'list', 'interaction' ],
      locale:'es',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      defaultView:'timeGridWeek',
      hiddenDays: [ 0 ],
      minTime:'06:00:00',
      maxTime:'21:00:00',
      scrollTime:'08:00:00',
      dateClick: function(info) {
        console.log('Clicked on: ' + info.dateStr);
        //$('#modalBuscaCliente').modal('show');
        $('#modalAddCita').modal('show');
      },
      events: []
    });

    calendar.render();
  });

</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush
@push('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $('#buscar').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
        $(document).on('keyup', '#buscar', function(event){            
            if($(this).val().length == 0){
                $('#buscar').blur();
                lista();
                $('#buscar').focus();
            }else if($(this).val().length >= 3){
                if((event.keyCode == 8) || (event.keyCode == 32) || (event.keyCode == 35) || (event.keyCode == 36) || (event.keyCode == 37) || (event.keyCode == 39)){
                    $('#entrydata').empty();
                }else{
                    $('#buscar').blur();
                    lista();
                    $('#buscar').focus();
                }
            }else{
                $('#entrydata').empty();
            }
        });
        $(document).on('click','.seleccionarCliente',function(){
            $('#nombreAdd').val($(this).attr("nombre"));
            $('#apellido').val($(this).attr("apellido"));
            $('#telefono ').val($(this).attr("telefono"));
            $('#email').val($(this).attr('email'));
            $('#email').val(($(this).attr('email')!=null)?$(this).attr('email'):'');
            $('#cedula').val($(this).attr('cedula'));
            $('#pacienteId').val($(this).attr('myid'));
            $('#modalBuscaCliente').modal('hide');
            $('#modalAddCita').modal('show');
            $('#entrydata').empty();
            $('#buscar').val('');
        });

        $('#cancelar').on('click',function(){
            $('#entrydata').empty();
            $('#buscar').val('');
        })

        $(document).on('click','#selectCliente',function(e){ 
            e.preventDefault();
        });
        
        function lista (){
            var data = {buscar:$('#buscar').val(),vendedor_id:{{$usuario_id}}, _token:$('input[name="_token"]').val()};
            $.post("{{route('cliente.buscar')}}",data, function(json){
                $('#entrydata').empty();
                json.clientes.data.forEach(function(cliente){
                    var web=(cliente.web!=null)?cliente.web:'';
                    var telefono=(cliente.telefono!=null)?cliente.telefono:'';
                    var cedula=(cliente.cedula!=null)?cliente.cedula:'';
                    $('#entrydata').append('<tr class="seleccionarCliente" myid="'+cliente.id+'" nombre="'+cliente.nombre+'"><td>'+cliente.nombre+'</td><td>'+telefono+'</td><td>'+web+'</td><td>'+cliente.clasificacion.clasificacion+'</td><td><a id="selectCliente" class="btn btn-primary btn-sm" href="#">Seleccionar</a></td></tr>');    
                })
            } ,'json');            
        }
    })
</script>
@endpush