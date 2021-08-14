@extends('layouts.app')

@section('content')
<center>
<div class="container">
    <div class="row">

        <div class="container">
            @if(session('message'))
                <hr>
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                <hr>
            @endif

            <div id="videos-list">
            @foreach($videos as $video)
                <div class="video-item col-md-10 pull-left panel panel-default">
                    <div class="panel-body">
                        @if(Storage::disk('images')->has($video->image))
                            <div class="video-image-thumb col-md-6 pull-left">
                                <div class="video-image-mask">
                                    <img src="{{ url('/miniatura/'.$video->image) }}" class="video-image"/>
                                </div>
                            </div>
                        @endif

                        <div class="data">
                            <h4 class="video-title"><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}">{{$video->title}}</a></h4><hr>
                            <p>{{ $video->user->name. ' ' .$video->user->surname}}</p>
                        </div>

                        <!-- BOTONES DE ACCIÓN -->
                        <a href="" class="btn btn-success">VER</a>
                        @if(Auth::check() && Auth::user()->id == $video->user->id)
                            <a href="" class="btn btn-warning">EDITAR</a>
                            <a href="" class="btn btn-danger">ELIMINAR</a>
                        @endif

                    </div>
                </div>
            @endforeach
            </div>
        </div>

        {{-- Nos añade la paginación --}}
        {{$videos->links()}}
        

    </div>
</div>
</center>
@endsection
