<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'abilities' => 'nullable|array'
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name,$request->post('abilities', []));

            return Response::json([
                'code' => 1,
                'token' => $token->plainTextToken,
                'user' => $user
            ], 201);
        }
        return Response::json(['code' => 0, 'message' => 'Invalid credentials'], 401);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        $PersonalAccessToken = PersonalAccessToken::findToken($token);

        if ($token === null) {
            $user->currentAccessToken()->delete();
            return;
        }
        // delete all the tokens for a user
        // $user->tokens()->delete();
        if ($PersonalAccessToken->tockenable_type == get_class($user) && $PersonalAccessToken->tokenable_id == $user->id) {
            $PersonalAccessToken->delete();
            // return Response::json(['code' => 1, 'message' => 'Token deleted'], 200);
        }
        return Response::json(['code' => 0, 'message' => 'Token not found'], 404);

    }


}
