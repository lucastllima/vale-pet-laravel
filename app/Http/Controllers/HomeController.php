<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostImagem;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $post = Post::where('status', true)->orderBy('created_at')->with('user')->with('imagens')->get();
        // return $post;
        $path = public_path();
        // dd( url('/'));
        $pi = PostImagem::where('post_id', 2)->get();
        foreach($pi as $p)
        {
            $pathToYourFile = $path.'/uploads/post_imagens/'.$p->foto;// get file path from table
            // dd(file_exists($pathToYourFile));
            if(file_exists($pathToYourFile)) // make sure it exits inside the folder
            {
              unlink($pathToYourFile); // delete file/image
              // and delete the record from database
            }
        }

        return $pi;
       
        // return view('home');
    }
}
