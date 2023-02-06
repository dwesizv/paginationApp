@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 8px;">
        <table class="table table-striped table-responsive" id="userTable">
            <thead>
                <tr>
                    <th scope="col">
                        # id 
                        <a href="{{ $order['id']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['id']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        nombre
                        <a href="{{ $order['nombre']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['nombre']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idtipo
                        <a href="{{ $order['idtipo']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['idtipo']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        iduser
                        <a href="{{ $order['iduser']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['iduser']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        idastillero
                        <a href="{{ $order['idastillero']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['idastillero']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        descripción
                        <a href="{{ $order['descripcion']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['descripcion']['desc'] }}">&#x25be;</a>
                    </th>
                    <th scope="col">
                        precio
                        <a href="{{ $order['precio']['asc'] }}">&#x25b4;</a>
                        <a href="{{ $order['precio']['desc'] }}">&#x25be;</a>
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
                        {{ $yate->idtipo }} {{ $yate->tipo->nombre }} <!-- usando el método tipo (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                        {{ $yate->iduser }} {{ $yate->user->name }} <!-- usando el método user (belongsTo) de la clase Yate -->
                    </td>
                    <td>
                        {{ $yate->idastillero }} {{ $yate->astillero->nombre }} <!-- usando el método astillero (belongsTo) de la clase Yate -->
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