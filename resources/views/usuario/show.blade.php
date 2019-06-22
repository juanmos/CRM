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
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$usuario->full_name}}</h5>
                                                
                                                <sub class="text-muted f-14"><small>Telf: </small>{{$usuario->telefono}}</sub><br>
                                                <sub class="text-muted f-14"><small>Web: </small>{{$usuario->web}}</sub><br>
                                                <sub class="text-muted f-14"><small>Cedula: </small>{{$usuario->cedula}}</sub>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('empresa.usuario.edit',$usuario->id)}}" class="label theme-bg text-white f-12">Editar</a> </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-zap f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">235</h3>
                                                <span class="d-block text-uppercase">TOTAL VISITAS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-map-pin f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">26</h3>
                                                <span class="d-block text-uppercase">TOTAL TERMINADAS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Clientes</h5>
                                        <a href="{{route('cliente.listado',$usuario->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Asignar cliente</a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    @forelse ($usuario->clientes as $cliente )
                                                    <tr class="unread">
                                                        
                                                        <td>
                                                            <h6 class="mb-1"><i class="fas fa-user-tie"></i> {{$cliente->nombre}}</h6>
                                                            <p class="m-0"><i class="fas fa-phone-square-alt"></i> {{$cliente->telefono}}</p>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('cliente.show',[$cliente->id] )}}" class="label theme-bg text-white f-12">Ver</a>
                                                            <a href="{{route('cliente.show',[$cliente->id] )}}" class="label theme-bg2 text-white f-12">Visita</a>
                                                            <a href="{{route('cliente.desasignar',[$usuario->id,$cliente->id] )}}" class="label theme-danger text-white f-12">Quitar</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <p>No hay cliente asignados</p>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->                                                      
                            <div class="col-xl-8 col-md-8 m-b-30">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Agenda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Esta semana</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Anteriores</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div id="calendar"></div>

                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">2:37 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">3:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">4:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">3:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">2:37 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">4:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
      defaultDate: '2019-06-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      defaultView:'timeGridWeek',
      events: [
        {
          title: 'All Day Event',
          start: '2019-06-01',
        },
        {
          title: 'Long Event',
          start: '2019-06-07',
          end: '2019-06-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2019-06-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2019-06-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2019-06-11',
          end: '2019-06-13'
        },
        {
          title: 'Meeting',
          start: '2019-06-12T10:30:00',
          end: '2019-06-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2019-06-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2019-06-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2019-06-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2019-06-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2019-06-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2019-06-28'
        }
      ]
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