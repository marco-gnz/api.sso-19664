<table border="1">
    <thead>
        <tr>
            <th style="background: lightblue; font-weight: bold;">RUT</th>
            <th style="background: lightblue; font-weight: bold;">NOMBRE</th>
            <th style="background: lightblue; font-weight: bold;">GENERO</th>
            <th style="background: lightblue; font-weight: bold;">ETAPA</th>
            <th style="background: lightblue; font-weight: bold;">SITUACION ACTUAL</th>
            @for ($i = 0; $i < $total_especialidades; $i++)
            <th style="background: mediumseagreen;   font-weight: bold;">CENTRO FORMACION</th>
            <th style="background: mediumseagreen; font-weight: bold;">TIPO FORMACION</th>
            <th style="background: mediumseagreen; font-weight: bold;">NOMBRE FORMACION</th>
            <th style="background: mediumseagreen; font-weight: bold;">INICIO FORMACION</th>
            <th style="background: mediumseagreen; font-weight: bold;">TERMINO FORMACION</th>
            @endfor
            @for ($i = 0; $i < $total_devoluciones; $i++)
            <th style="background: darkseagreen; font-weight: bold;">INICIO DEVOLUCION</th>
            <th style="background: darkseagreen; font-weight: bold;">TERMINO DEVOLUCION</th>
            <th style="background: darkseagreen; font-weight: bold;">CONTRATO</th>
            <th style="background: darkseagreen; font-weight: bold;">ESTABLECIMIENTO</th>
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
                <td>{{ $profesional->apellidos }} {{ $profesional->nombres }}</td>
                <td>{{ ($profesional->genero != null) ? $profesional->genero->nombre : '' }}</td>
                <td>{{ ($profesional->etapa != null) ? $profesional->etapa->sigla : ''}}</td>
                <td>{{ ($profesional->situacionActual != null) ? $profesional->situacionActual->nombre : ''}}</td>
                @if ($profesional->especialidades->count() > 0)
                    @php
                    $totalE = 0
                    @endphp
                    @foreach ($profesional->especialidades as $especialidad)
                        @php
                        $totalE++;
                        @endphp
                            <td>{{$especialidad->centroFormador->nombre}}</td>
                            <td>{{$especialidad->perfeccionamiento->tipo->nombre}}</td>
                            <td>{{$especialidad->perfeccionamiento->nombre}}</td>
                            <td>{{ ($especialidad->inicio_formacion != null) ? Carbon\Carbon::parse($especialidad->inicio_formacion)->isoFormat('DD-MM-YYYY') : 'NO' }}</td>
                            <td>{{ ($especialidad->termino_formacion != null) ? Carbon\Carbon::parse($especialidad->termino_formacion)->isoFormat('DD-MM-YYYY') : 'NO' }}</td>
                    @endforeach
                    @for ($i = 0; $i < $total_especialidades-$totalE; $i++)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endfor
                @else
                    @for ($i = 0; $i < $total_especialidades; $i++)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endfor
                @endif

                @if ($profesional->devoluciones->count() > 0)
                @php
                $total = 0
                @endphp
                @foreach ($profesional->devoluciones as $devo)
                    @php
                    $total++;
                    @endphp
                    <td>{{ ($devo->inicio_devolucion != null) ? Carbon\Carbon::parse($devo->inicio_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                    <td>{{ ($devo->termino_devolucion != null) ? Carbon\Carbon::parse($devo->termino_devolucion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                    <td>{{ ($devo->tipoContrato != null) ? $devo->tipoContrato->nombre : '' }}</td>
                    <td>{{ ($devo->establecimiento != null) ? $devo->establecimiento->sigla: '' }}</td>
                @endforeach
                    @for ($i = 0; $i < $total_devoluciones-$total; $i++)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endfor
                @else
                    @for ($i = 0; $i < $total_devoluciones; $i++)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endfor
                @endif
                @if ($profesional->destinaciones->count() > 0)
                    @php
                    $totalD = 0
                    @endphp
                    @foreach ($profesional->destinaciones as $destinacion)
                        @php
                        $totalD++;
                        @endphp
                        <td>{{ ($destinacion->inicio_periodo != null) ? Carbon\Carbon::parse($destinacion->inicio_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        <td>{{ ($destinacion->termino_periodo != null) ? Carbon\Carbon::parse($destinacion->termino_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                        <td>{{ ($destinacion->establecimiento != null) ? $destinacion->establecimiento->sigla : '' }}</td>
                        <td>{{ ($destinacion->gradoComplejidadEstablecimiento != null) ? $destinacion->gradoComplejidadEstablecimiento->grado : '' }}</td>
                        <td>{{ ($destinacion->unidad != null) ? $destinacion->unidad->nombre : '' }}</td>
                    @endforeach
                    @for ($i = 0; $i < $total_destinaciones-$totalD; $i++)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endfor
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
