<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="col-md-11 col-md-offset-2">
        <h2>{{$video->title}}</h2>

        <div class="col-md-8">
            <!--VIDEO-->
            <video controls id="video-player">
                <source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}"></source>
                Tu navegador no es compatible con HTML5
            </video>

            <!--DESCRIPCION-->
            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    <div class="panel-title">
                    Subido por <strong>{{$video->user->name.' '.$video->user->surname}}</strong> {{ \FormatTime::LongTimeFilter($video->created_at) }}
                    </div>
                </div>
                <div class="panel-body">
                    {{$video->description}}
                </div>
            </div>
            <!--COMENTARIOS-->
        </div>
    </div>
    @endsection
</body>
</html>