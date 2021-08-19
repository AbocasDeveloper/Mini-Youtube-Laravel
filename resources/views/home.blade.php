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
            @if(count($videos) > 0)
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
                            @if(Auth::check() && Auth::user()->id == $video->user->id)
                                <div class="pull-left">
                                    <a href="{{ url('/editar-video/'.$video->id) }}" type="button" class="btn btn-warning">Editar</a>
                                </div>
                                <div class="pull-right">
                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#victorModal{{$video->id}}" role="button" class="btn btn-large btn-danger" data-toggle="modal">Eliminar</a>
                                
                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="victorModal{{$video->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">¿Estás seguro?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres borrar este video?</p>
                                                <p class="text-warning"><small>{{$video->title}}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                <a href="{{ url('/delete-video/'.$video->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                </div><br><br>
                            @endif

                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger">Aun no se ha subido ningún video a la aplicación</div>
            @endif
            </div>
        </div>

        {{-- Nos añade la paginación --}}
        {{$videos->links()}}
        

    </div>
</div>
</center>
@endsection
