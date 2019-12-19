<table class="table table-hover">
    <thead>
        <tr>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            
            <th>Estado</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Vendedor</th>
            <th>Tipo de visita</th>
            <th>Razoón cancelacion</th>
        </tr>
    </thead>
    <tbody id="entrydata">
        @foreach($visitas as $visita)
        <tr class="unread">
            <td>
                {{$visita->fecha_inicio}}
            </td>
            <td>
                {{$visita->fecha_fin}}
            </td>
            
            <td>{{$visita->estado->estado}}</td>
            <td>{{$visita->cliente->nombre}}</td>
            <td>{{($visita->contacto!=null)?$visita->contacto->nombre.' '.$visita->contacto->apellido:'Sin asignar'}}</td>
            <td>{{($visita->usuario_id!=null)?$visita->vendedor->nombre.' '.$visita->vendedor->apellido:'Sin asignar'}}</td>
            <td>{{$visita->tipoVisita->tipo}}</td>
            <td>{{$visita->razon_cancelacion}}</td>
        </tr>
        
        @endforeach
    </tbody>
</table>