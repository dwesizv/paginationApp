@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped table-responsive" id="userTable">
            <thead>
                <tr>
                    <th scope="col">
                        # id 
                        <a href="{{ $order['yate.id']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['yate.id']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        nombre
                        <a href="{{ $order['yate.nombre']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['yate.nombre']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idtipo
                        <a href="{{ $order['tipo.nombre']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['tipo.nombre']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        iduser
                        <a href="{{ $order['users.name']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['users.name']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idastillero
                        <a href="{{ $order['astillero.nombre']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['astillero.nombre']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        descripción
                        <a href="{{ $order['yate.descripcion']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['yate.descripcion']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        precio
                        <a href="{{ $order['yate.precio']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['yate.precio']['desc'] }}">&#x25be;</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($yates as $yate)
                <tr>
                    <td>
                        {{ $yate->id }}
                    </td>
                    <td>
                        {{ $yate->nombre }}
                    </td>
                    <td>
                         {{ $yate->tnombre }} <!-- usando el método tipo (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                         {{ $yate->uname }} <!-- usando el método user (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                         {{ $yate->anombre }} <!-- usando el método astillero (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                        {{ substr($yate->descripcion, 0, 10) }}...
                    </td>
                    <td>
                        {{ $yate->precio }} €
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <nav>
            <ul class="pagination">
                <!-- página primera -->
                <li class="page-item">
                    <a class="page-link" href="" rel="first" aria-label="« First">&lsaquo;&lsaquo;</a>
                </li>
                <!-- página primera no activo -->
                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                    <span class="page-link" aria-hidden="true">&lsaquo;&lsaquo;</span>
                </li>
                <!-- página anterior -->
                <li class="page-item">
                    <a class="page-link" href="" rel="prev" aria-label="« Previous">&lsaquo;</a>
                </li>
                <!-- página anterior no activo -->
                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
                <!-- página numero actual -->
                <li class="page-item active" aria-current="page">
                    <span class="page-link">n</span>
                </li>
                <!-- página puntos suspensivos -->
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>
                <!-- página numero -->
                <li class="page-item">
                    <a class="page-link" href="">n</a>
                </li>
                <!-- página siguiente no activo -->
                <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
                <!-- página siguiente -->
                <li class="page-item">
                    <a class="page-link" href="" rel="next" aria-label="Next »">&rsaquo;</a>
                </li>
                <!-- página última no activo -->
                <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                    <span class="page-link" aria-hidden="true">&rsaquo;&rsaquo;</span>
                </li>
                <!-- página última -->
                <li class="page-item">
                    <a class="page-link" href="" rel="last" aria-label="Last »">&rsaquo;&rsaquo;</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <nav>
            <ul class="pagination">
                @foreach($links as $link)
                        @if($link['current'])
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{!! $link['text'] !!}</span>
                            </li>
                        @elseif($link['active'])
                                <li class="page-item">
                                    <a class="page-link" href="{{ $link['url'] }}">{!! $link['text'] !!}</a>
                                </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">{!! $link['text'] !!}</span>
                            </li>
                        @endif
                @endforeach
            </ul>
        </nav>
    </div>
@endsection