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

                <h2>Canal de <strong>{{$user->name. ' ' .$user->surname}}</strong></h2>

                <div class="clearfix"></div>
                @include('video.videosList')
            </div>
        </div>
    </div>
    @endsection
</body>
</html>