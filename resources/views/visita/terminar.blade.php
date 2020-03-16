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
                                        <div class="card-header-right">
                                            <div class="btn-group card-option">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="feather icon-more-horizontal"></i>
                                                </button>
                                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                                    <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                                                    <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Tipo</th>
                                                        <th>Vendedor</th>
                                                        <th>Acciones</th>
                                                </tr></thead>
                                                <tbody>
                                                    @foreach ($visitas as $visita)                                                       
                                                    <tr>
                                                        <td>
                                                            <h6 class="mb-1">{{$visita->cliente->nombre}}</h6>
                                                            <p class="m-0">Lugar: {{$visita->lugar_visita}}</p>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-1">{{date('d-m-Y',strtotime($visita->fecha_inicio))}}</h6>
                                                            <p class="m-0">{{date('h:i:s',strtotime($visita->fecha_inicio))}}</p>
                                                        </td>
                                                        <td>
                                                            @if($visita->estado_visita_id==5)
                                                            <span class="text-white label theme-bg f-12">Terminada</span>
                                                            @elseif($visita->estado_visita_id==2)
                                                            <span class="label theme-bg2 f-12 text-white">Confirmada</span>
                                                            @elseif($visita->estado_visita_id==1)
                                                            <span class="label bg-c-blue f-12 text-white">Creada</span>
                                                            @else
                                                            <span class="label bg-c-red f-12 text-white">Terminada</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <h6 class="m-b-0">{{$visita->tipoVisita->tipo}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-b-0">{{$visita->vendedor->full_name}}</h6>
                                                        </td>
                                                        <td>
                                                            
                                                            <a href="{{route('visita.show',$visita->id)}}" class="btn btn-primary">Ir a visita</a>
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

@endsection
@push('scripts')

<script>
 
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
@endpush
