<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
    
        return response()->json(['posts' => $posts], 200);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'body' => 'required',
            'main_category' => 'required',
            'sub_category'  => 'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = auth()->user();

        $post = new Post();
        $post->body = $request->body;
        $post->user_id = $user->id;
        $post->main_category = $request->main_category;
        $post->sub_category = $request->sub_category;
        $post->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function postByCategory(Request $request)
    {
    	$v = Validator::make($request->all(), [
            'main_category'=>'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
   
        $posts = Post::where('main_category',$request->main_category)->get();

        if ($posts->count() > 0) {
            $posts->map(function ($post) {
                $user_information = [
                    'id'  => $post->user->id,
                    'first_name'  => $post->user->first_name,
                    'last_name'  => $post->user->last_name,
                    'id_oauth'  => $post->user->id_oauth,
                    'picture'  => $post->user->picture,
                ];
                $post->user_information = $user_information;
                unset($post->user);
            });
        };

        return response()->json(['status' => 'success', 'posts' => $posts], 200);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $post = Post::find($request->id);
        $user_information = [
            'id'  => $post->user->id,
            'first_name'  => $post->user->first_name,
            'last_name'  => $post->user->last_name,
            'id_oauth'  => $post->user->id_oauth,
            'picture'  => $post->user->picture,
        ];
        $post->user_information = $user_information;
        unset($post->user);
        return response()->json(['status' => 'success', 'post' =>  $post], 200);
    }
}
