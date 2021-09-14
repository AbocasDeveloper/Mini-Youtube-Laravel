<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row">

            <div class="container">
                <div class="col-md-4">
                    <h2>Busqueda realizada: <strong>{{$search}}</strong></h2>
                <br>
                </div>

                <div class="col-md-8">
                    <form action="{{ url('/buscar/'.$search) }}" class="col-md-4 pull-righ" method="get">
                        <label for="filter">Ordenar</label>
                        <select name="filter" class="form-control">
                            <option value="new">Más nuevos</option>
                            <option value="old">Más antiguos</option>
                            <option value="alfa">A - Z</option>
                        </select>
                        <input type="submit" value="Ordenar" class="btn-filter btn btn-sm btn-primary">
                    </form>
                </div>

                <div class="clearfix"></div>
                @include('video.videosList')
            </div>
        </div>
    </div>
    @endsection
</body>
</html>