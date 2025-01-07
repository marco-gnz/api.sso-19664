<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>S19 | Cartola resumen</title>
    <link rel="shortcut icon" href="{{ public_path('img/gob.svg') }}">

    <style type="text/css">
        @page {
            margin: 1%;
        }

        body {
            margin: auto;
            padding: 0%;
            font-family: "Times New Roman", Times, serif;
            width: 100%;
        }

        .filtro {
            filter: grayscale(4%);
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 13px;
        }

        .information {
            background-color: #ffffff;
            color: black;
        }

        .information .logo {
            margin: 5px;
        }

        .datos {
            /* margin-left: 40rem; */
            padding: 0rem;
        }

        table,
        th,
        td {
            text-align: justify;
            width: 100%;
            margin-right: 10px;
        }

        .logo {
            position: relative;

            top: 0px;
            left: 20px;
            width: 50;
            height: 50;
            border-radius: 1%;
            margin: 30%;
            display: block;
        }

        .detalle {
            text-align: justify;
        }

        .title {
            text-align: left;
            font-weight: bold;
            font-size: 16px;
        }

        .section-borde {
            border: 1px solid #d1d1d1;
            margin-top: 10px; /* Reducir el espacio superior */
        }

        .section-position {
            margin-left: 10px;
        }

        table.table-datos-contractuales {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            margin-left: -5px;
        }

        table.table-datos-contractuales th,
        table.table-datos-contractuales td {
            text-align: left; /* Mantén la alineación a la izquierda */
            border: 0.1px solid black;
            padding: 5px; /* Ajusta el espaciado interno de las celdas según tus preferencias */
            white-space: nowrap; /* Evita el salto de línea dentro de las celdas */
        }
        @media print {
            .page-break {
                page-break-before: always;
            }
        }

        .seccion-footer {
            position: fixed;
            left: 0;
            width: 100%;
            background-color: rgb(255, 255, 255);
            color: black;
            text-align: center;
        }
    </style>

<body>
    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 10%;">
                    <img class="center logo" src="{{ public_path('img/logo-sso.jpeg') }}">
                </td>
                <td align="left" style="width: 60%;">
                    <h6 style="font-size: 11px;">DIRECCIÓN<br>
                        <small style="font-size: 9px;" class="text-muted ml-4">SUBDIRECCIÓN DE RECURSOS
                            HUMANOS</small><br>
                        <small style="font-size: 9px;" class="text-muted ml-4">DEPTO. GESTIÓN DE LAS PERSONAS</small>
                    </h6>
                </td>
            </tr>
        </table>
    </div>
    <div class="titulo">
        <h4 align="center">Cartola Resumen Profesional</h4>
    </div>
    <div class="datos">
        <section class="section-borde">
            <div class="section-position">
                <h3 class="title">Antecedentes personales</h3>
                <table>
                    <tbody>
                        <tr>
                            <th>Rut</th>
                            <td>{{ $profesional->rut_completo }}</td>
                        </tr>
                        <tr>
                            <th>Nombres</th>
                            <td>{{ $profesional->nombre_completo }}</td>
                        </tr>
                        <tr>
                            <th>N° de contacto</th>
                            <td>{{ $profesional->n_contacto ?  $profesional->n_contacto  : ''}}</td>
                        </tr>
                        <tr>
                            <th>Correo de contacto</th>
                            <td>{{ $profesional->email ?  $profesional->email  : ''}}</td>
                        </tr>
                        <tr>
                            <th>Planta</th>
                            <td>{{ $profesional->planta ?  $profesional->planta->nombre  : ''}}</td>
                        </tr>
                        <tr>
                            <th>Situación actual</th>
                            <td>{{ $profesional->situacionActual ?  $profesional->situacionActual->nombre  : ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="section-borde">
            <div class="section-position">
                <h3 class="title">Formaciones</h3>
                @if (count($profesional->especialidades) > 0)
                    <table class="table-datos-contractuales">
                        <thead>
                            <th>Centro</th>
                            <th>Tipo</th>
                            <th>Perfeccionamiento</th>
                            <th>Periodo</th>
                        </thead>
                        <tbody>
                            @foreach ($profesional->especialidades as $especialidad)
                                <tr>
                                    <td>{{$especialidad->centroFormador ? $especialidad->centroFormador->nombre : ''}}</td>
                                    <td>{{$especialidad->perfeccionamiento ? $especialidad->perfeccionamiento->tipo->nombre : ''}}</td>
                                    <td>{{$especialidad->perfeccionamiento ? $especialidad->perfeccionamiento->nombre : ''}}</td>
                                    <td>{{ $especialidad->inicio_formacion != null ? Carbon\Carbon::parse($especialidad->inicio_formacion)->format('d/m/Y') : '--' }}
                                        -
                                        {{ $especialidad->termino_formacion != null ? Carbon\Carbon::parse($especialidad->termino_formacion)->format('d/m/Y') : '--' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No registra formaciones</p>
                @endif
            </div>
        </section>
        <section class="section-borde">
            <div class="section-position">
                <h3 class="title">PAO</h3>
                <table class="table-datos-contractuales">
                    <tbody>
                        <tr>
                            <th>A devolver</th>
                            <td>{{$profesional->statusdestino()->total_a_realizar}}</td>
                        </tr>
                        <tr>
                            <th>Lleva</th>
                            <td>{{$profesional->statusdestino()->total_devolucion}}</td>
                        </tr>
                        <tr>
                            <th>Le faltan</th>
                             <td>{{$profesional->statusdestino()->le_faltan}}</td>
                        </tr>
                        <tr>
                            <th>Finaliza el</th>
                            <td>{{$profesional->statusdestino()->termina}}</td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="title">Devoluciones e interrupciones</h3>
                <table class="table-datos-contractuales">
                    @if (count($timeLine) > 0)
                        <thead>
                            <th>D / I</th>
                            <th>Perfeccionamiento</th>
                            <th>Periodo</th>
                            <th>Hora / Motivo</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            @foreach ($timeLine as $evento)
                                <tr style="background-color: {{$evento['color']}}">
                                    <td>{{ $evento['dev_inte_value'] }}</td>
                                    <td>{{ $evento['perfeccionamiento'] }}</td>
                                    <td>{{ $evento['fecha_inicio'] }} - {{ $evento['fecha_termino'] }}</td>
                                    <td>{{ $evento['hor_mot'] }}</td>
                                    <td>{{$evento['total']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                         @else
                            <p>No existen registros...</p>
                        @endif
                </table>
                <p><strong>D</strong>: Devolución <strong>I</strong>: Interrupción</p>
            </div>
        </section>
        <div class="seccion-footer">
            <p>Fecha de impresión {{ Carbon\Carbon::now()->format('d-m-Y H:i:s') }} </p>
        </div>
    </div>
</body>
</head>
