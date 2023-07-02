<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\user;


class JwtVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = explode(' ', $request->header('Authorization')); // ['Bearer', 'TOKEN']
        $head = isset($authorizationHeader[0]) ? $authorizationHeader[0] : false;
        $jwt = isset($authorizationHeader[1]) ? $authorizationHeader[1] : false;

        if (!$head || !$jwt) {
            return response()->json([
                'status' => 0,
                'reply' => 'Geçersiz kullanıcı!'
            ]);
        }
        try {
            $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));

            $user = user::find($decoded->id);

            if ($user->token != $jwt) {
                return response()->json([
                    'status' => 0,
                    'reply' => 'Geçersiz Kullanıcı!'
                ], 400);
            }
            $request->request->add(['id' => $decoded->id]);
            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'reply' => 'Geçersiz Kullanıcı!'
            ], 400);
        }
    }
}
