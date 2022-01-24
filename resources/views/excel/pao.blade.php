<table border="1">
    <thead>
    <tr>
        <th>RUT</th>
        <th>NOMBRES</th>
        <th>APELLIDOS</th>
        <th>GENERO</th>
        <th>N° CONTACTO</th>
        <th>ETAPA</th>
        <th>SITUACION ACTUAL</th>
        @for ($i = 0; $i < $cantidad; $i++)
        <th>INICIO PAO {{$i+1}}</th>
        <th>TERMINO PAO {{$i+1}}</th>
        @endfor
        @for ($i = 0; $i < $cantidad_devo; $i++)
        <th>INICIO DEVOLUCION {{$i+1}}</th>
        <th>TERMINO DEVOLUCION {{$i+1}}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($profesionales as $profesional)
        <tr>
            <td>{{ $profesional->rut_completo }}</td>
            <td>{{ $profesional->nombres }}</td>
            <td>{{ $profesional->apellidos }}</td>
            <td>{{ $profesional->genero->nombre }}</td>
            <td>{{ $profesional->n_contacto }}</td>
            <td>{{ $profesional->etapa->nombre }}</td>
            <td>{{ ($profesional->situacionActual != null) ? $profesional->situacionActual->nombre : ''}}</td>
            @if ($profesional->especialidades != null && $profesional->especialidades->count() > 0)
                @foreach ($profesional->especialidades as $especialidad)
                    @if ($especialidad->paos->count() > 0)
                        @foreach ($especialidad->paos as $pao)
                            <td>{{ ($pao->periodo_inicio != '') ? Carbon\Carbon::parse($pao->periodo_inicio)->isoFormat('DD-MM-YYYY') : '' }}</td>
                            <td>{{ ($pao->periodo_termino != '') ? Carbon\Carbon::parse($pao->periodo_termino)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        @endforeach
                    @endif
                @endforeach
            @endif
            @if ($profesional->especialidades != null && $profesional->especialidades->count() > 0)
                @foreach ($profesional->especialidades as $especialidad)
                    @if ($especialidad->paos->count() > 0)
                        @foreach ($especialidad->paos as $pao)
                            @if ($pao->devoluciones->count() > 0)
                                @foreach ($pao->devoluciones as $devo)
                                <td>{{ ($devo->inicio_devolucion != '') ? Carbon\Carbon::parse($devo->inicio_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                                <td>{{ ($devo->termino_devolucion != '') ? Carbon\Carbon::parse($devo->termino_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>



