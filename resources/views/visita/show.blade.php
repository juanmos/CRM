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
                            <!--[ daily sales section ] start-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ultima visita</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 249.95</h3>
                                            </div>

                                            <div class="col-3 text-right">
                                                <p class="m-b-0">67%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ daily sales section ] end-->
                            <!--[ Monthly  sales section ] starts-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card Monthly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Valores pendientes</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>$ 2.942.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">36%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Monthly  sales section ] end-->
                            <!--[ year  sales section ] starts-->
                            <div class="col-md-12 col-xl-4">
                                <div class="card yearly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas anuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 8.638.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">80%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ year  sales section ] end-->
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$visita->cliente->nombre}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->cliente->telefono}}</sub><br>
                                                <sub class="text-muted f-14">Contacto: {{$visita->contacto->nombre}} {{$visita->contacto->apellido}}</sub><br>
                                                <sub class="text-muted f-14">Email: {{$visita->contacto->email}}</sub>
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('visita.edit',$visita->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                            <a href="{{route('cliente.show',$visita->cliente_id)}}" class="label theme-bg2 text-white f-12">Ver cliente</a>
                                        </h6>
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
                                                <h3 class="f-w-300">{{$visita->estado->estado}}</h3>
                                                <span class="d-block text-uppercase">ESTADO </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-map-pin f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">{{$visita->tipoVisita->tipo}}</h3>
                                                <span class="d-block text-uppercase">Tipo de visita </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <div class="col-xl-8 col-md-8 m-b-30">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Previsita</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Visita</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tareas</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        @if($visita->tipoVisita->plantilla->detalles->count()>0)
                                            <ul class="list-group list-group-sortable">    
                                                @foreach ($visita->tipoVisita->plantilla->detalles()->orderBy('orden')->get() as $detalle )
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-2">{{$detalle->label}}</h6>
                                                            @if($detalle->tipo_campo==1)
                                                            <input name="custom_{{$detalle->id}}" type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" />
                                                            @elseif($detalle->tipo_campo==2)
                                                            <textarea name="custom_{{$detalle->id}}"  rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}"></textarea>
                                                            @elseif($detalle->tipo_campo==3)
                                                            <input name="custom_{{$detalle->id}}"  type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}"/>
                                                            @elseif($detalle->tipo_campo==4)
                                                            <select name="custom_{{$detalle->id}}"  class="selectpicker borderColorElement mb-2 opcionesId_{{$detalle->id}} col-md-12 full-width-fix">
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                    <option value="{{$opcion}}">{{$opcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            @elseif($detalle->tipo_campo==6)
                                                                @if($detalle->opciones!=null)
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                    <input type="checkbox" name="custom_{{$detalle->id}}" value="{{$opcion}}"> {{$opcion}}
                                                                @endforeach
                                                                @else
                                                                    <input type="checkbox" name="custom_{{$detalle->id}}"> Check 
                                                                @endif
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary float-right" >Guardar</button>
                                            </ul>
                                        @endif

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
