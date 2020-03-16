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
                            @if(!Auth::user()->hasRole('Vendedor'))
                            <div class="col-xl-12 col-md-12">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Vendedores
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($usuarios as $user)
                                    <a href="" myid="{{$user->id}}" nombre="{{$user->full_name}}" class="dropdown-item f-12 cambiaVendedor">
                                        <h6>{{$user->full_name}}</h6>
                                    </a>                                             
                                    @endforeach
                                </div>
                                <a href="" class="btn btn-secondary pull-right visitaTodos">Ver todos</a>
                            </div>
                            @endif
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            
                            <div class="col-xl-12 col-md-12">
                            
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Visitas - <span id="user_selected">{{Auth::user()->full_name}}</span></h5>
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
@include('includes.modalNuevaVisita')
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/interaction/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/list/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/core/locales-all.js")}}'></script>
<script>
  var calendar=null;
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
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
      defaultView:'{{Auth::user()->empresa->configuracion->defaultView}}',
      hiddenDays: [ 0 ],
      minTime:"{{Auth::user()->empresa->configuracion->min_time}}",
      maxTime:'{{Auth::user()->empresa->configuracion->max_time}}',
      scrollTime:'08:00:00',
      slotDuration:'00:15:00',
      dateClick: function(info) {
          if($('#usuario_id').val()!=''){
            var fecha=moment(info.dateStr);
            $('#modalBuscaCliente').modal('show');
            $('#mesModal').val(fecha.format('MM'))
            $('#diaModal').val(fecha.format('DD'));
            $('#anioModal').val(fecha.format('YYYY'));
            $('#horaModal').val(fecha.format('HH'));
            $('#minModal').val(fecha.format('mm'));
          }else{
              alert('Debes seleccionar un vendedor para crear la visita')
          }
        
      },
      eventDrop: function(event) {
            if (!confirm("La visita a "+event.event.title + " se reagendara para el: " + moment(event.event.start).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_inicio:moment(event.event.start).format('YYYY-MM-DD HH:mm:ss'),fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
        eventResize: function(event) {
            if (!confirm("La visita a "+event.event.title + " terminara ahora: " + moment(event.event.end).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
      eventSources: [
        {
          url: "{{route('visita.vendedor',$usuario_id)}}", // use the `url` property
        }
      ]
    });

    calendar.render();
  });
  $(document).on('click','.cambiaVendedor',function(e){
      e.preventDefault();
      calendar.getEventSources().forEach(function(es){
          es.remove();
      })
     // calendar.fullCalendar( 'removeEventSources' );
      calendar.addEventSource( "{{url('e/visitas/by/vendedor/')}}/"+$(this).attr('myid') );
      {{-- $("tr").css('background-color','transparent')
      $(this).closest('tr').css('background-color','cornsilk') --}}
      $('#dropdownMenuButton').html($(this).attr('nombre'))
      $('#user_selected').html($(this).attr('nombre'))
      $('#usuario_id').val($(this).attr('myid'));
  })
  $(document).on('click','.visitaTodos',function(e){
    e.preventDefault();
     calendar.getEventSources().forEach(function(es){
          es.remove();
      })
     // calendar.fullCalendar( 'removeEventSources' );
      calendar.addEventSource( "{{route('visita.todos')}}" );
      $('#dropdownMenuButton').html('Todos los vendedores')
      $('#user_selected').html('Todos los vendedores')
      $('#usuario_id').val(null);
  })
</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush
