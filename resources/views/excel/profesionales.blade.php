<table border="1">
    <thead>
        <tr>
            <th style="background: lightblue; font-weight: bold;">RUT</th>
            <th style="background: lightblue; font-weight: bold;">NOMBRE</th>
            <th style="background: lightblue; font-weight: bold;">GENERO</th>
            <th style="background: lightblue; font-weight: bold;">PLANTA</th>
            <th style="background: lightblue; font-weight: bold;">ETAPA</th>
            <th style="background: lightblue; font-weight: bold;">SITUACION ACTUAL</th>
            <th style="background: lightblue; font-weight: bold;">ESTABLECIMIENTOS</th>
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
            <th style="background: darkgoldenrod; font-weight: bold;">TOTAL A DEVOLVER - PAO</th>
            <th style="background: darkgoldenrod; font-weight: bold;">LLEVA - PAO</th>
            <th style="background: darkgoldenrod; font-weight: bold;">LE FALTA - PAO</th>
            <th style="background: darkgoldenrod; font-weight: bold;">FINALIZA - PAO</th>
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
                <td>{{ $profesional['rut_completo'] }}</td>
                <td>{{ $profesional['nombre_completo'] }}</td>
                <td>{{ $profesional['genero'] }}</td>
                <td>{{ $profesional['planta'] }}</td>
                <td>{{ $profesional['etapa']}}</td>
                <td>{{ $profesional['situacionActual'] }}</td>
                <td>{{ $profesional['establecimientos']}}</td>
                @if (count($profesional['especialidades']) > 0)
                    @php
                    $totalE = 0
                    @endphp
                    @foreach ($profesional['especialidades'] as $especialidad)
                        @php
                        $totalE++;
                        @endphp
                            <td>{{$especialidad['centro_formador']['nombre']}}</td>
                            <td>{{$especialidad['perfeccionamiento']['tipo']['nombre']}}</td>
                            <td>{{$especialidad['perfeccionamiento']['nombre']}}</td>
                            <td>{{ ($especialidad['inicio_formacion'] != null) ? Carbon\Carbon::parse($especialidad['inicio_formacion'])->isoFormat('DD/MM/YYYY') : 'NO' }}</td>
                            <td>{{ ($especialidad['termino_formacion'] != null) ? Carbon\Carbon::parse($especialidad['termino_formacion'])->isoFormat('DD/MM/YYYY') : 'NO' }}</td>
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

                @if (count($profesional['devoluciones']) > 0)
                @php
                $total = 0
                @endphp
                @foreach ($profesional['devoluciones'] as $devo)
                    @php
                    $total++;
                    @endphp
                    <td>{{ ($devo['inicio_devolucion'] != null) ? Carbon\Carbon::parse($devo['inicio_devolucion'])->isoFormat('DD/MM/YYYY') : '' }}</td>
                    <td>{{ ($devo['termino_devolucion'] != null) ? Carbon\Carbon::parse($devo['termino_devolucion'])->isoFormat('DD/MM/YYYY') : '' }}</td>
                    <td>{{ $devo['tipo_contrato']['nombre'] }}</td>
                    <td>{{ $devo['establecimiento']['nombre'] }}</td>
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
                <td>{{$profesional['total_a_realizar']}}</td>
                <td>{{$profesional['total_devolucion']}}</td>
                <td>{{$profesional['le_faltan']}}</td>
                <td>{{$profesional['termina']}}</td>
                @if ($profesional['destinaciones'] > 0)
                    @php
                    $totalD = 0
                    @endphp
                    @foreach ($profesional['destinaciones'] as $destinacion)
                        @php
                        $totalD++;
                        @endphp
                        <td>{{ ($destinacion['inicio_periodo'] != null) ? Carbon\Carbon::parse($destinacion['inicio_periodo'])->isoFormat('DD/MM/YYYY') : '' }}</td>
                        <td>{{ ($destinacion['termino_periodo'] != null) ? Carbon\Carbon::parse($destinacion['termino_periodo'])->isoFormat('DD/MM/YYYY') : '' }}</td>
                        <td>{{ ($destinacion['establecimiento'] != null) ? $destinacion['establecimiento']['nombre'] : '' }}</td>
                        <td>{{ ($destinacion['grado_complejidad_establecimiento'] != null) ? $destinacion['grado_complejidad_establecimiento']['grado'] : '' }}</td>
                        <td>{{ ($destinacion['unidad'] != null) ? $destinacion['unidad']['nombre'] : '' }}</td>
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
