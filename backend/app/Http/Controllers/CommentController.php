<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    /**
     * Save a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
    	$v = Validator::make($request->all(), [
            'post_id'=>'required',
            'body'=>'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
   
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->post_id;
        $comment->body = $request->body;
    
        $comment->save();
   
        return response()->json(['status' => 'success'], 200);
    }

    public function commentByPost(Request $request)
    {
    	$v = Validator::make($request->all(), [
            'post_id'=>'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
   
        $comments = Comment::where('post_id',$request->post_id)->get();

        if ($comments->count() > 0) {
            $comments->map(function ($comment) {
                $user_information = [
                    'id'  => $comment->user->id,
                    'first_name'  => $comment->user->first_name,
                    'last_name'  => $comment->user->last_name,
                    'id_oauth'  => $comment->user->id_oauth,
                    'picture'  => $comment->user->picture,
                ];
                $comment->user_information = $user_information;
                unset($comment->user);
            });
        };

        return response()->json(['status' => 'success', 'comments' => $comments], 200);
    }
}
