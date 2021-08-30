<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;
use App\User;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createVideo(){
        return view('video.createVideo');
    }

    public function saveVideo(Request $request){

        //Validar formulario
        $validateData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required'
        ]);

        $video = new Video();
        //Conseguimos usuario identificado
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de la miniatura
        $image = $request->file('image');
        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            
            $video->image = $image_path;
        }

        //Subida de video
        $video_file = $request->file('video');
        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            
            $video->video_path = $video_path;
        }

        $video->save();

        return redirect()->route('home')->with(array(
            "message" => '¡¡El video se ha subido correctamente!!'
        ));
    }

    /**
     * Método que nos devuelve la imagen, que coincida con el nombre que le pasamos
     */
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }

    /**
     * Método que nos devuelve el video, que coincida con el nombre que le pasamos
     */
    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);

        return new Response($file, 200);
    }

    /**
     * Nos saca los detalles del video
     */
    public function getVideoDetail($video_id){
        $video = Video::find($video_id);

        return view('video.detail', array(
            'video' => $video
        ));
    }

    public function delete($video_id){

        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if($user && $video->user_id == $user->id){

            //Eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }

            //Eliminar ficheros (Portada y Video)
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            //Eliminar registro
            $video->delete();

            $message = array('message' => 'Video eliminado correctamente');
        }
        else{
            $message = array('message' => 'El video no ha podido eliminarse');
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($video_id){

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);

        if($user && $video->user_id == $user->id){
           
            return view('video.edit', array(
                'video' => $video
            ));
        }
        else{
            return redirect()->route('home');
        }
    }

    public function update($video_id, Request $request){
        //Validar formulario
        $validateData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required'
        ]);

        $video = Video::findOrFail($video_id);
        $user = \Auth::user();

        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de la miniatura
        $image = $request->file('image');
        if($image){
            
            //Eliminar fichero antiguo
            Storage::disk('images')->delete($video->image);

            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            
            $video->image = $image_path;
        }

        //Subida de video
        $video_file = $request->file('video');
        if($video_file){

            //Eliminar fichero antiguo
            Storage::disk('videos')->delete($video->video_path);

            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            //Asignamos el nuevo
            $video->video_path = $video_path;
        }

        $video->update();

        return redirect()->route('home')->with(array(
            "message" => '¡¡El video se ha actualizado correctamente!!'
        ));
    }

    public function search($search = null){

        //Para que funcione correctamente la busqueda
        if(is_null($search)){
            $search = \Request::get('search');

            //Redirigimos para que la ruta se vea correctamente y no como antes
            //(buscar?search=$search)
            return redirect()->route('videoSearch', array(
                'search' => $search
            ));
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->paginate(5);

        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));
    }
}
