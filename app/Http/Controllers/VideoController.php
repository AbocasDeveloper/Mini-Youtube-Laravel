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
}
