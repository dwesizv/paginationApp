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
                        tipo
                        <a href="{{ $order['tipo.nombre']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['tipo.nombre']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        user
                        <a href="{{ $order['users.name']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['users.name']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        astillero
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
                        {{ $yate->tnombre }}
                    </td>
                    <td>
                        {{ $yate->uname }}
                    </td>
                    <td>
                        {{ $yate->anombre }}
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
        {{ $yates->onEachSide(2)->links() }}
    </div>
@endsection