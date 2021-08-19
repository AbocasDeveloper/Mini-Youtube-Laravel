<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar video {{$video->title}}</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
    <div class="row">
        <h2>Editar - {{$video->title}}</h2>
        <hr>
        <form action="{{ route('updateVideo', ['video_id' => $video->id]) }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
                <input type="text" class="form-control" id="title" name="title" value="{{$video->title}}">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{$video->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Miniatura</label><br>
                @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb col-md-6 pull-left">
                        <div class="video-image-mask">
                            <img src="{{ url('/miniatura/'.$video->image) }}" class="video-image"/>
                        </div><br>
                    </div>
                @else
                    <div class="alert alert-warning">Actuamente el video no tiene miniatura</div>
                @endif
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <div class="form-group">

                <label for="video">Archivo de video</label><br>
                @if(Storage::disk('videos')->has($video->video_path))
                    <video controls id="video-player">
                        <source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}"></source>
                        Tu navegador no es compatible con HTML5
                    </video>
                @else
                    <div class="alert alert-warning">Actuamente no hay video subido</div>
                @endif
                <input type="file" class="form-control" id="video" name="video">
            </div>

            <button type="submit" class="btn btn-primary">EDITAR VIDEO</button><br><br>
        </form>
    </div>
    </div>
    @endsection
</body>
</html>