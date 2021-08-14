<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear video</title>
</head>
<body>
    @extends('layouts.app')

        @section('content')
        <div class="container">
            <div class="row">
                <h2>Crear nuevo video</h2>
                <hr>

                {{-- Tambien funcionaria con --> action="{{ url('/guardar-video') }}"  --}}
                <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
                    {!! csrf_field() !!}

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Miniatura</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="video">Archivo de video</label>
                        <input type="file" class="form-control" id="video" name="video">
                    </div>

                    <button type="submit" class="btn btn-primary">CREAR VIDEO</button>
                </form>
            </div>
        </div>

    @endsection
</body>
</html>