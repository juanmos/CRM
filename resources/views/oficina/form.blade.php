@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    @if($oficina!=null)
                                    <h5 class="m-b-10">Editar oficina</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo oficina</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('cliente.index')}}">Cliente</a></li>
                                    @if($oficina!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nuevo</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                
                <form action="{{($oficina!=null)?route('oficina.update',[$oficina->id]):route('oficina.store',$cliente_id)}}" method="POST" enctype="multipart/form-data">
                
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($oficina!=null)?'PUT':'POST'}}"/>
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la oficina</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="exampleInputPassword1">Ciudad</label>
                                                        {!! Form::select('ciudad_id', $ciudades, ($oficina!=null)?$oficina->ciudad_id : 1 ,["class"=>"form-control"]) !!}
                                                    </div> 
                                                    <div class="form-group col-md-12 ">
                                                        <label for="exampleInputEmail1">Dirección</label>
                                                        <input type="text" value="@if($oficina!=null){{$oficina->direccion}}@endif" name="direccion" class="form-control" aria-describedby="emailHelp" placeholder="Dirección">
                                                    </div>
                                                    <div class="form-group col-md-12 ">
                                                        <label for="exampleInputPassword1">Tipo oficina</label>
                                                        {!! Form::select('matriz', ["1"=>"Matriz","0"=>"Sucursal",], ($oficina!=null)?$oficina->oficina_id : 1 ,["class"=>"form-control"]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Mapa</label>
                                                
                                            </div>  
                                            
                                            
                                            <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=foto]').change(function(e) {

        var tgt = e.target || window.event.srcElement,
        files = tgt.files;

        var filename = files[0].name;
        var extension = files[0].type;
        var fileExtension = filename.split('.')[filename.split('.').length - 1].toLowerCase();   

        var file = $(this)[0].files[0];
        if (file) {
            {{-- orientation(file, function(base64img, value) {                
                console.log(rotation[value]);
                var rotated = $('#image_preview').attr('src', base64img);
                if (value) {
                    rotated.css('transform', rotation[value]);
                }
            }); --}}
        }            

        if (FileReader && files && files.length) {
            if (fileExtension === 'png' || fileExtension === 'jpeg' || fileExtension === 'jpg') {
                var fr = new FileReader();
                fr.onload = function () {
                    $("#foto_nueva").attr("src",fr.result);
                }
                fr.readAsDataURL(files[0]);   
            }else {
                alert('Formato de imagen inválido, solo se permite PNG, JPG o JPEG');
                $('input[name=foto]').val('');
            }         
        }        
    });
})
</script>
@endpush