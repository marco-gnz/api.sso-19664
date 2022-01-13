<table>
    <thead>
        <tr>
            <th>RUT</th>
            <th>NOMBRES</th>
            <th>APELLIDOS</th>
            <th>GENERO</th>
            <th>N° CONTACTO</th>
            <th>ETAPA</th>
            @for ($i = 0; $i < $cantidad_destinacion; $i++)
            <th>INICIO DESTINACIÓN</th>
            <th>TERMINO DESTINACIÓN</th>
            <th>UNIDAD</th>
            <th>ESTABLECIMIENTO</th>
            <th>° COMPLEJIDAD</th>
            @endfor
            @for ($i = 0; $i < $cantidad_formacion; $i++)
            <th>INICIO FORMACION</th>
            <th>TERMINO FORMACION</th>
            <th>CENTRO FORMADOR</th>
            <th>PERFECCION</th>
            <th>TIPO</th>
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
                @foreach ($profesional->destinaciones as $destinacion)
                <td>{{ ($destinacion->inicio_periodo != '') ? Carbon\Carbon::parse($destinacion->inicio_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                <td>{{ ($destinacion->termino_periodo != '') ? Carbon\Carbon::parse($destinacion->termino_periodo)->isoFormat('DD-MM-YYYY') : '' }}</td>
                <td>{{ ($destinacion->unidad != '') ? $destinacion->unidad->nombre : '' }}</td>
                <td>{{ ($destinacion->establecimiento != '') ? $destinacion->establecimiento->sigla : '' }}</td>
                <td>{{ ($destinacion->gradoComplejidadEstablecimiento != '') ? $destinacion->gradoComplejidadEstablecimiento->grado : '' }}</td>
                @endforeach
                @foreach ($profesional->especialidades as $especialidad)
                <td>{{ ($especialidad->inicio_formacion != '') ? Carbon\Carbon::parse($especialidad->inicio_formacion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                <td>{{ ($especialidad->termino_formacion != '') ? Carbon\Carbon::parse($especialidad->termino_formacion)->isoFormat('DD-MM-YYYY') : '' }}</td>
                <td>{{ ($especialidad->centroFormador != '') ? $especialidad->centroFormador->nombre : '' }}</td>
                <td>{{ ($especialidad->perfeccionamiento != '') ? $especialidad->perfeccionamiento->nombre : '' }}</td>
                <td>{{ ($especialidad->perfeccionamiento != '') ? $especialidad->perfeccionamiento->tipo->nombre : '' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
