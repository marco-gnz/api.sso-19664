<table border="1">
    <thead>
        <tr>
            <th style="background: lightblue; font-weight: bold;">RUT</th>
            <th style="background: lightblue; font-weight: bold;">NOMBRES</th>
            <th style="background: lightblue; font-weight: bold;">APELLIDOS</th>
            <th style="background: lightblue; font-weight: bold;">GENERO</th>
            <th style="background: lightblue; font-weight: bold;">N° CONTACTO</th>
            <th style="background: lightblue; font-weight: bold;">ETAPA</th>
            <th style="background: lightblue; font-weight: bold;">SITUACION ACTUAL</th>
            @for ($i = 0; $i < $total_pao; $i++)
            <th style="background: mediumseagreen; font-weight: bold;">INICIO PAO</th>
            <th style="background: mediumseagreen; font-weight: bold;">TERMINO PAO</th>
            @endfor
            @for ($i = 0; $i < $total_devoluciones; $i++)
            <th style="background: darkseagreen; font-weight: bold;">INICIO DEVOLUCION</th>
            <th style="background: darkseagreen; font-weight: bold;">TERMINO DEVOLUCION</th>
            <th style="background: darkseagreen; font-weight: bold;">CONTRATO</th>
            <th style="background: darkseagreen; font-weight: bold;">ESTABLECIMIENTO</th>
            <th style="background: darkseagreen; font-weight: bold;">ESCRITURA</th>
            @endfor
            @for ($i = 0; $i < $total_destinaciones; $i++)
            <th style="background: oldlace; font-weight: bold;">INICIO DESTINACION</th>
            <th style="background: oldlace; font-weight: bold;">TERMINO DESTINACION</th>
            <th style="background: oldlace; font-weight: bold;">ESTABLECIMIENTO</th>
            <th style="background: oldlace; font-weight: bold;">COMPLEJIDAD</th>
            <th style="background: oldlace; font-weight: bold;">UNIDAD</th>
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
                        <td>{{ ($pao->periodo_inicio != null) ? Carbon\Carbon::parse($pao->periodo_inicio)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        <td>{{ ($pao->periodo_termino != null) ? Carbon\Carbon::parse($pao->periodo_termino)->isoFormat('DD-MM-YYYY') : '' }}</td>
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
                            <td>{{ ($devo->inicio_devolucion != null) ? Carbon\Carbon::parse($devo->inicio_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                            <td>{{ ($devo->termino_devolucion != null) ? Carbon\Carbon::parse($devo->termino_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
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
                        <td>{{ ($destinacion->inicio_periodo != null) ? Carbon\Carbon::parse($destinacion->inicio_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        <td>{{ ($destinacion->termino_periodo != null) ? Carbon\Carbon::parse($destinacion->termino_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        <td>{{ ($destinacion->establecimiento != null) ? $destinacion->establecimiento->sigla : '' }}</td>
                        <td>{{ ($destinacion->gradoComplejidadEstablecimiento != null) ? $destinacion->gradoComplejidadEstablecimiento->grado : '' }}</td>
                        <td>{{ ($destinacion->unidad != null) ? $destinacion->unidad->nombre : '' }}</td>
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
