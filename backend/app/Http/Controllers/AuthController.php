<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['username', 'password']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Bad Credentials'], 401);
        }

        $device_ip = request(['device_ip']);
        $user = auth()->user();
        // dd($device_ip);
        $user->last_login = Carbon::now();
        $user->device_ip = $request->ip();
        $user->access_token = $token;
        $user->save();

        $user->registerLog('login');

        $response = $this->respondWithToken($token);
        $response->original['permissions'] = $user->permissions;

        return $response->original;
    }

    /**
     * Login a user via Oauth
     */
    public function loginOauth(Request $request)
    {
        $v = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'picture' => 'required',
            'provider'  => 'required',
            'id_oauth'  => 'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = User::where('email',$request->email)->first();
        $password  = $request->id_oauth;
        if (!$user) {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($password);
            $user->device_ip = $request->ip();
            $user->picture = $request->picture;
            $user->provider_oauth = $request->provider;
            $user->id_oauth = $request->id_oauth;
            $user->last_login = Carbon::now();
            $user->save();
        }

        $credentials = ['email' => $user->email, 'password' => $password];
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Bad Credentials'], 401);
        }

        $user->last_login = Carbon::now();
        $user->save();
        
        $response = $this->respondWithToken($token);
        return $response;
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json(['status' => 'success',  'user' => $user], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $new_token = auth()->refresh();
        return $this->respondWithToken($new_token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
