<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // return response()->json([
        //     'request' => $request->all(),
        // ], Response::HTTP_OK);
        $user = User::where('email', $request->email)->first();
        // return response()->json([
        //     'user' => $user,
        //     'request' => $request->all(),
        // ], Response::HTTP_OK);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'request' => $request->all(),
        ], Response::HTTP_OK);
    }
}
