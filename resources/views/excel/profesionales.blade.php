<table border="1">
    <thead>
        <tr>
            <th style="background: red;">RUT</th>
            <th style="font-weight: bold;">NOMBRES</th>
            <th>APELLIDOS</th>
            <th>GENERO</th>
            <th>N° CONTACTO</th>
            <th>ETAPA</th>
            <th>SITUACION ACTUAL</th>
            @for ($i = 0; $i < $total_pao; $i++)
            <th>INICIO PAO</th>
            <th>TERMINO PAO</th>
            @endfor
            @for ($i = 0; $i < $total_devoluciones; $i++)
            <th>INICIO DEVOLUCION</th>
            <th>TERMINO DEVOLUCION</th>
            <th>CONTRATO</th>
            <th>ESTABLECIMIENTO</th>
            <th>ESCRITURA</th>
            @endfor
            @for ($i = 0; $i < $total_destinaciones; $i++)
            <th>INICIO DESTINACION</th>
            <th>TERMINO DESTINACION</th>
            <th>ESTABLECIMIENTO</th>
            <th>COMPLEJIDAD</th>
            <th>UNIDAD</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @foreach ($profesionales as $profesional)
            <tr>
                <td>{{ $profesional->rut_completo }}</td>
                <td>{{ $profesional->nombres }}</td>
                <td>{{ $profesional->apellidos }}</td>
                <td>{{ $profesional->genero->nombre }}</td>
                <td>{{ $profesional->n_contacto }}</td>
                <td>{{ $profesional->etapa->nombre }}</td>
                <td>{{ ($profesional->situacionActual != null) ? $profesional->situacionActual->nombre : ''}}</td>
                @foreach ($profesional->especialidades as $especialidad)
                    @if ($especialidad->paos->count() > 0)
                        @foreach ($especialidad->paos as $pao)
                        <td>{{ ($pao->periodo_inicio != null) ? Carbon\Carbon::parse($pao->periodo_inicio)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                        <td>{{ ($pao->periodo_termino != null) ? Carbon\Carbon::parse($pao->periodo_termino)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                        @endforeach
                    @else
                    @for ($i = 0; $i < $total_pao; $i++)
                        <td></td>
                        <td></td>
                        @endfor
                    @endif
                @endforeach
                @foreach ($profesional->especialidades as $especialidad)
                @if ($especialidad->paos->count() > 0)
                    @foreach ($especialidad->paos as $pao)
                        @foreach ($pao->devoluciones as $devo)
                            <td>{{ ($devo->inicio_devolucion != null) ? Carbon\Carbon::parse($devo->inicio_devolucion)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                            <td>{{ ($devo->termino_devolucion != null) ? Carbon\Carbon::parse($devo->termino_devolucion)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                            <td>{{ ($devo->tipoContrato != null) ? $devo->tipoContrato->nombre : 'j' }}</td>
                            <td>{{ ($devo->establecimiento != null) ? $devo->establecimiento->sigla: 'j' }}</td>
                            <td>{{ ($devo->escritura) ? $devo->escritura->n_resolucion : 'NO' }}</td>
                        @endforeach
                    @endforeach
                @else
                    @for ($i = 0; $i < $total_devoluciones; $i++)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endfor
                @endif
                @endforeach
                @if ($profesional->destinaciones->count() > 0)
                    @foreach ($profesional->destinaciones as $destinacion)
                        <td>{{ ($destinacion->inicio_periodo != null) ? Carbon\Carbon::parse($destinacion->inicio_periodo)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                        <td>{{ ($destinacion->termino_periodo != null) ? Carbon\Carbon::parse($destinacion->termino_periodo)->isoFormat('DD-MM-YYYY') : 'j' }}</td>
                        <td>{{ ($destinacion->establecimiento != null) ? $destinacion->establecimiento->sigla : 'j' }}</td>
                        <td>{{ ($destinacion->gradoComplejidadEstablecimiento != null) ? $destinacion->gradoComplejidadEstablecimiento->grado : 'j' }}</td>
                        <td>{{ ($destinacion->unidad != null) ? $destinacion->unidad->nombre : 'j' }}</td>
                    @endforeach
                @else
                    @for ($i = 0; $i < $total_destinaciones; $i++)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endfor
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
