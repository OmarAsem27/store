<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        if (!in_array($user->type, $types)) {
            abort(403);
        }
        // $response = $next($request);
        // $content = strtoupper($response->getContent());
        // return $response->setContent($content);
        return $next($request);
    }
}
