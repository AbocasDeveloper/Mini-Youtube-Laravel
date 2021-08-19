<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
</head>
<body>
    <hr><h4>COMENTARIOS</h4>

    {{-- FORMULARIO PARA AGREGAR UN COMENTARIO --}}
    @if(Auth::check())
        <form action="{{ url('/comment') }}" method="post" class="col-md-12 input-lg">
            {!! csrf_field() !!}

            <input type="hidden" name="video_id" value="{{$video->id}}" required>

            <p>
                <textarea class="form-control" name="body" required></textarea>
            </p>

            <input type="submit" value="COMENTAR" class="btn btn-primary">
            <hr><br><br>
        </form>
        <div class="clearfix"></div><hr><br><br><br><br>
    @endif

    @if(isset($video->comments))
        <div id="comments-list">
            @foreach($video->comments as $comment)
                <div class="comment-item" col-md-12 pull-left>
                    <div class="panel panel-default video-data">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <strong>{{$comment->user->name.' '.$comment->user->surname}}</strong> {{ \FormatTime::LongTimeFilter($comment->created_at) }}
                            </div>
                        </div>
                        <div class="panel-body">
                            {{$comment->body}}
                            
                            @if(Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))
                        
                                <div class="pull-right">
                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#victorModal{{$comment->id}}" role="button" class="btn btn-large btn-danger" data-toggle="modal">Eliminar</a>
                                
                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="victorModal{{$comment->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">¿Estás seguro?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres borrar este comentario?</p>
                                                <p class="text-warning"><small>{{$comment->body}}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                <a href="{{ url('/delete-comment/'.$comment->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                </div><br><br>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


</body>
</html>