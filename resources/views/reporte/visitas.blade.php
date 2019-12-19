@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('includes.mensaje')
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
                                        <h5>Reporte de Visitas</h5>                                        
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="">
                                            {!! Form::open(['method'=>'POST','route'=>'reporte.visitas.filtrar']) !!}
                                                <div class="row overflow-y-auto">                            
                                                    <div class="col-md-3">
                                                        <label>Fecha inicio:</label>
                                                        <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control borderColorElement datepicker" value="{{$fecha_inicio}}" placeholder="Escriba el nombre de la empresa o el RUC">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Fecha fin:</label>
                                                        <input type="text" name="fecha_fin" id="fecha_fin" class="form-control borderColorElement datepicker" value="{{$fecha_fin}}" placeholder="Escriba el nombre de la empresa o el RUC">
                                                    </div>
                                                     <div class="col-md-3">
                                                        <label>Estado:</label>
                                                        {!! Form::select('estado_id', $estados, $estado_id, ['class'=>'form-control']) !!}
                                                    </div>
                                                    <div class="col-md-3">    
                                                        <label>Cliente:</label>                            
                                                        <input type="text" name="cliente" id="cliente" class="form-control borderColorElement" value="{{$cliente}}" placeholder="Escriba el nombre del cliente">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                                        <button type="submit" formaction="{{route('reporte.visitas.exportar')}}" class="btn btn-secondary">Exportar</button>
                                                    </div>
                                                </div>
                                            {!! Form::close()!!}
                                        </div>
                                        <div class="table-responsive">
                                        @if($visitas->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Estado</th>
                                                        <th>Vendedor</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="entrydata">
                                                    @foreach($visitas as $visita)
                                                    <tr class="unread">
                                                        <td>
                                                            {{$visita->fecha_inicio}}<br>
                                                            {{$visita->fecha_fin}}
                                                        </td>
                                                        <td>{{$visita->cliente->nombre}}</td>
                                                        <td>{{$visita->estado->estado}}</td>
                                                        <td>{{($visita->usuario_id!=null)?$visita->vendedor->nombre.' '.$visita->vendedor->apellido:'Sin asignar'}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('visita.show',$visita->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                            {{ $visitas->appends(['fecha_inicio' => $fecha_inicio,'fecha_fin'=>$fecha_fin,'estado_id'=>$estado_id,'cliente'=>$cliente])->links() }}
                                        @else
                                            <h4>No hay visitas encontradas</h4>
                                            
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
@endsection
@push('scripts')
<!-- Datepicker Js -->
<script src="{{asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js')}}">
</script>
<script type="text/javascript">
    $(window).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd'
        });
    });
</script>
@endpush
@push('styles')
<!-- Datepicker css -->

<link href="{{asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<script>
    var page = {
        bootstrap: 3
    };

    function swap_bs() {
        page.bootstrap = 3;
    }
</script>
<style>
    .datepicker>.datepicker-days {
        display: block;
    }

    ol.linenums {
        margin: 0 0 0 -8px;
    }
</style>
@endpush