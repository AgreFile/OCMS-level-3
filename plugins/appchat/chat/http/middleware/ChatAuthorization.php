<?php
 
namespace AppChat\Chat\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use AppUser\User\Services\JwtService;
use AppUser\User\Models\User;
use Exception;

class ChatAuthorization
{
    public function handle(Request $request, Closure $next): Response
    {
        //First check if user is logged in
        if (!JwtService::GetValidatedTokenFromCookie()) {
            throw new Exception("Unauthorized", 401);
        }
        //If user is in the chatroom
        if (User::find(JwtService::GetUserIdFromCookie())->chat_rooms->where("id",$request->input("chatroom_id"))->isEmpty()) {
            throw new Exception("Unauthorized", 401);
        }
 
        return $next($request);
    }
}