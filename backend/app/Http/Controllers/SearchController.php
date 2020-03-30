<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$v = Validator::make($request->all(), [
            'search'=>'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
   
        $posts = Post::where('body','LIKE','%'.$request->search.'%')->orderBy('created_at', 'desc')->get();

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
                $comments_count = $post->comments->count();
                $post->comments_count = $comments_count;
                unset($post->user);
                unset($post->comments);
            });
        };

        return response()->json(['status' => 'success', 'posts' => $posts], 200);
    }
}
