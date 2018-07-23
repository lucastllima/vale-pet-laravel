<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Response;

use App\User;
use App\Post;
use App\PostImagem;
use App\Raca;
use App\Cidade;

class PostController extends Controller
{
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth) //Injeção de dependencia
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function posts()
    {
        $post = [];

        $post = Post::where('status', true)
                        ->orderBy('created_at', 'desc')
                        ->with('user')
                        ->with('imagens')
                        ->with('cidade')
                        ->with('raca')
                        ->get();
 
        return $post;

    }

    public function meus_posts($id)
    {
        $post = [];
        // $post = User::posts()->orderBy('created_at')->with('imagem')->get();
        // $post = Post::where('status', true)
        //         ->where('user_id', $id)
        //         ->orderBy('created_at')
        //         ->with('imagem')
        //         ->with('cidade')
        //         ->get();

        $post = Post::where('status', true)
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->with('cidade')
            ->get();

        foreach($post as $p)
        {
            $p->imagem = $p->imagens()->first()->makeHidden(['post_id', 'id']);
        }
 
        return $post;

    }

    public function alterar_situacao_post(Request $r, $id)
    {
        $post = Post::find($id);
        if(isset($post))
        {
            if($r->situacao == 1)
                $post->situacao = 0;
            else
                $post->situacao = 1;

            $post->save();
             
        }else{
            return ['error' => 'Animal não encontrado!'];
        }
        $posts = Post::where('status', true)
            ->where('user_id', $r->user_id)
            ->orderBy('created_at', 'desc')
            ->with('cidade')
            ->get();

        foreach($posts as $p)
        {
            $p->imagem = $p->imagens()->first()->makeHidden(['post_id', 'id']);
        }

        return $posts;
    }

    public function remover_post(Request $r, $id)
    {
        $path = public_path();
        $post = Post::find($id);
        if(isset($post))
        {
            $pi = PostImagem::where('post_id', $post->id)->get();
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
            $post->delete();
        }else{
            return ['error' => 'Animal não encontrado!'];
        }

        $posts = Post::where('status', true)
            ->where('user_id', $r->user_id)
            ->orderBy('created_at')
            ->with('cidade')
            ->get();

        foreach($posts as $p)
        {
            $p->imagem = $p->imagens()->first()->makeHidden(['post_id', 'id']);
        }

        return $posts;
    }

    public function inserir_post(Request $r)
    {
        $validator = Validator::make(Input::all(), Post::$rules_api, Post::$messages);
        if ($validator->fails()) {     
          $messages = $validator->messages()->first();
          return ['error' => $messages];
        }else{
            $p = new Post();
            $p->fill($r->all());
            $p->save();
            
            foreach($r->imagens as $image){
                $file = uniqid().'.jpg';
                $p->base64_to_jpeg($image, base_path().'/public/uploads/post_imagens/'.$file);

                $li = new PostImagem();
                $li->post_id = $p->id;
                $li->foto = $file;
                $li->save();

            }

            return ['sucesso' => 'Animal inserido com sucesso.'];
        
        }

    }

    public function atualizar_post(Request $r, $id)
    {
        $post = Post::find($id);
        if(isset($post))
        {
            $validator = Validator::make(Input::all(), Post::rules_update_api($id), Post::$messages);
            if ($validator->fails()) {     
              $messages = $validator->messages()->first();
              return ['error' => $messages];
            }else{
                $post->fill($r->all());
                $post->save();

                return ['sucesso' => 'Animal atualizado com sucesso.'];
            }   
        }else{
            return ['error' => 'Animal não encontrado!'];
        }
    }

    public function obter_racas($tipo)
    {
        $racas = [];

        $racas = Raca::where('tipo', $tipo)
                        ->orderBy('nome', 'asc')
                        ->get();
 
        return $racas;
    }

    public function obter_cidades()
    {
        $cidades = Cidade::orderBy('nome', 'asc')->get();

        return $cidades;
    }

    public function buscar_post(Request $r)
    {
        $posts = [];
        if($r->raca_id == -1)
        {
            $posts = Post::where('tipo_animal', $r->tipo_animal)
                                ->where('status', true);

            if(isset($r->idade_animal))
            $posts = $posts->where('idade_animal', $r->idade_animal);

            if(isset($r->sexo_animal))
            $posts = $posts->where('sexo_animal', $r->sexo_animal);

            $posts = $posts->orderBy('created_at', 'desc')
                ->with('user')
                ->with('imagens')
                ->with('cidade')
                ->with('raca')
                ->get();
        }else{
            
            $posts = Post::where('tipo_animal', $r->tipo_animal)
                            ->where('status', true)
                            ->where('raca_id', $r->raca_id);

                    if(isset($r->idade_animal))
                    $posts = $posts->where('idade_animal', $r->idade_animal);

                    if(isset($r->sexo_animal))
                    $posts = $posts->where('sexo_animal', $r->sexo_animal);

                    $posts = $posts->orderBy('created_at', 'desc')
                    ->with('user')
                    ->with('imagens')
                    ->with('cidade')
                    ->with('raca')
                    ->get();
        }

        return $posts;
    }
}
