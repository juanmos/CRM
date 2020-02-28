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

                            <div class="col-xl-12 col-md-12">
                                <span>Metas de {{auth()->user()->full_name}}</span>
                            </div>


                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->

                            <div class="col-xl-12 col-md-12">


                                <div >

                                    <div >
                                        <div class="card Recent-Users">
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <a href="#" class="btn btn-primary nuevaMeta" data-toggle="modal" data-target="#modalTarea">
                                                        <span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Nueva meta</span>
                                                    </a>
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            @foreach($objetivos as $objetivo)
                                                            <tr>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-7">
                                                                            <span class="text-muted f-12">Meta:</span><br>
                                                                            <h6 class="m-0">{{$objetivo->texto}}</h6>
                                                                        </div>

                                                                        <div class="col-md-4 text-right">
                                                                            <h6 class="m-0 text-right">{{date('d-m-Y',strtotime($objetivo->fecha))}}</h6>

                                                                        </div>
                                                                        <div class="col-md-1 text-right">
                                                                           
                                                                        </div>
                                                                        <div class="col-md-12 openObjetivo" style="cursor:pointer" data-toggle="modal" data-target="#modalTarea" myid="{{json_encode($objetivo)}}">
                                                                            <div class="progress mt-4 mb-4" style="height: 20px;">
                                                                                <div class="progress-bar" role="progressbar" style="width: {{$objetivo->porcentaje}}%;" aria-valuenow="{{$objetivo->porcentaje}}" aria-valuemin="0" aria-valuemax="100">{{$objetivo->porcentaje}}%</div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>

                                                                </td>
                                                            </tr>

                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
<div class="modal fade bd-example-modal-md" name="modalTarea" id="modalTarea" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                {!! Form::open(["route"=>"objetivos.store","method"=>"POST","id"=>"form_objetivo"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Meta</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">
                    <div class="row">
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label class="col-md-4">Titulo: *</label>
                                <textarea class="form-control" name="texto" placeholder="Titulo de la meta" required id="texto" cols="3"></textarea>
                                {{-- {!! Form::text('texto', "", ["class"=>"form-control","placeholder"=>"Titulo de la meta","required"=>"required","id"=>'texto']) !!} --}}
                            </div>
                        </div>
                        
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Fecha</label>
                                <input type="text" id="fecha" value="" name="fecha" class="form-control date" aria-describedby="emailHelp" placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Porcentaje de cumplimiento</label>
                                <input type="text" id="porcentaje" value="" name="porcentaje" class="form-control" aria-describedby="emailHelp" placeholder="50">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        
                        <input type="hidden" value="POST" name="_method" id="method"/>
                        <input type="hidden" value="" name="objetivo_id" id="objetivo_id"/>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        var actionURL="{{route('objetivos.index')}}";
        $('.openObjetivo').on('click',function(){
            var objetivo = JSON.parse($(this).attr('myid'));
            $('#texto').val(objetivo.texto);
            $('#fecha').val(objetivo.fecha);
            $('#porcentaje').val(objetivo.porcentaje);
            $('#objetivo_id').val(objetivo.id);
            $('#form_objetivo').attr('action',actionURL+'/'+objetivo.id)
            $('#method').val('PUT');
        })
        $('.nuevaMeta').on('click',function(){
            $('#texto').val('');
            $('#fecha').val('');
            $('#porcentaje').val('');
            $('#objetivo_id').val('');
            $('#form_objetivo').attr('action',actionURL)
            $('#method').val('POST');
        })
        $('.tareaVisita').on('click',function(){
            $('#visita_id').val($(this).attr('visitaId'));
        })
        $('.addUser').on('click',function(){
            $('#add_usuario_id').val($(this).attr('myid'));
        })
        $('.date').datetimepicker({
            format: 'YYYY/MM/DD',
            inline: true,
            sideBySide: true,
            locale: 'es',
            icons: {
                date: "far fa-calendar-alt",
            }
        });
        
    });
</script>
@endpush
@push('styles')
@endpush
