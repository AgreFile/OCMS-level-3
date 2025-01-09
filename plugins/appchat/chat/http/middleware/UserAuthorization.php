<?php
 
namespace AppChat\Chat\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use AppUser\User\Services\JwtService;
use Exception;

class UserAuthorization
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!JwtService::GetValidatedTokenFromCookie()) {
            throw new Exception("Unauthorized", 401);
        }

        return $next($request);
    }
}