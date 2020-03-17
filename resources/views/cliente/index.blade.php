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
                                        <h5>Clientes</h5>
                                        @if(!Request::is('cliente/listado/*'))
                                        <a class="btn btn-primary float-right" href="{{route('cliente.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('importaciones.upload','clientes')}}"><span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span><span class="pcoded-mtext">Cargar clientes</span></a>
                                        @endif
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        {{-- <div class="">
                                            {!! Form::open() !!}
                                                <div class="row overflow-y-auto">                            
                                                    <div class="col-md-3">
                                                        <label>Buscar cliente:</label>
                                                    </div>
                                                    <div class="col-md-7">                                
                                                        <input type="text" name="buscar" required id="buscar" class="form-control borderColorElement" value="" placeholder="Escriba el nombre de la empresa o el RUC">
                                                    </div>
                                                </div>
                                            {!! Form::close()!!}
                                        </div> --}}
                                        <div class="table-responsive">
                                            @if(Request::is('cliente/listado/*'))
                                            {!! Form::open(['route'=>["cliente.asignar.multiple",$usuario_id],'method'=>"POST"]) !!}
                                            @endif
                                            <table id="tableData" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>RUC/Cedula</th>
                                                        <th>Telefono</th>
                                                        <th>Vendedor</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="entrydata">
                                                    {{-- @foreach($clientes as $cliente)
                                                    <tr class="unread"></tr>
                                                        <td>{{$cliente->nombre}}</td>
                                                        <td>{{$cliente->facturacion->direccion}}</td>
                                                        <td>{{$cliente->telefono}}</td>
                                                        <td>{{($cliente->usuario_id!=null)?$cliente->vendedor->nombre.' '.$cliente->vendedor->apellido:'Sin asignar'}}</td>
                                                        <td>
                                                            @if(Request::is('cliente/listado/*'))
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="clientes[]" id="customCheck{{$cliente->id}}" value="{{$cliente->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$cliente->id}}">Seleccionar</label>
                                                            </div>
                                                            @else
                                                            <a href="{{ route('cliente.show',$cliente->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('cliente.edit',$cliente->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach --}}
                                                </tbody>
                                            </table>
                                            @if(Request::is('cliente/listado/*'))
                                            <button type="submit" class="btn btn-primary">Asignar</button>
                                            {!! Form::close() !!}

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
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script>
$(function() {
    $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        ajax: "{!! route('clientes.data',$usuario_id) !!}",
        "autoWidth": false,
        "columnDefs": [
            { "width": "10px", "targets": 0 },
            { "width": "40px", "targets": 1 },
            { "width": "100px", "targets": 2 },
            { "width": "70px", "targets": 3 },
            { "width": "70px", "targets": 4 }
        ],
        columns: [
            { data: 'nombre', name: 'nombre' , width: "30%"},
            { data: 'facturacion.ruc', name: 'facturacion.ruc' },
            { data: 'telefono', name: 'telefono' },
            { data: 'vendedor', render: function(dataField){
                if(dataField==null){
                    return 'Sin adignar'
                }else{
                    return `${dataField.nombre} ${dataField.apellido}`
                }
            } },
            { "data": "id", render: function (dataField) { 
                var link = '';
                @if(Request::is('cliente/listado/*'))
                    link+='<div class="custom-control custom-checkbox">';
                    link+='<input type="checkbox" class="custom-control-input" name="clientes[]" id="customCheck'+dataField+'" value="'+dataField+'">';
                    link+='<label class="custom-control-label" for="customCheck'+dataField+'">Seleccionar</label>';
                    link+='</div>';
                @else
                    link+='<a href="{{ url("cliente/")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>'
                    link+='<a href="{{ url("cliente") }}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>'
                @endif
                    return link;
                } 
            }
        ]
    });
});
</script>
<script>
    $(document).ready(function(e){
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
            }else if($(this).val().length >= 2){
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
        function lista (){
            var data = {buscar:$('#buscar').val(),vendedor_id:{{Auth::user()->id}}, _token:"{{csrf_token()}}" };
            $.post("{{route('cliente.buscar')}}",data, function(json){
                $('#entrydata').empty();
                $('.pagination').hide();
                json.clientes.data.forEach(function(cliente){
                    var web=(cliente.web!=null)?cliente.web:'';
                    var telefono=(cliente.telefono!=null)?cliente.telefono:'';
                    var direccion=(cliente.facturacion!=null)?cliente.facturacion.direccion:'';
                    var vendedor=(cliente.vendedor!=null)?cliente.vendedor.nombre+' '+cliente.vendedor.apellido:'Sin asignar';
                    $('#entrydata').append('<tr><td>'+cliente.nombre+'</td><td>'+direccion+'</td><td>'+telefono+'</td><td>'+vendedor+'</td><td><a href="{{ url("/")}}/cliente/'+cliente.id+'" class="label theme-bg2 text-white f-12">Ver</a><a href="{{ url("/")}}/cliente/'+cliente.id+'/edit" class="label theme-bg text-white f-12">Editar</a></td></tr>');    
                })
            } ,'json');            
        }
    })
</script>
@endpush
@push('styles')
<link rel="stylesheet" href='{{asset("assets/plugins/data-tables/css/datatables.min.css")}}'>
@endpush