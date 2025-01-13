<?php
 
namespace AppUser\User\Http\Controllers;

use Illuminate\Routing\Controller;
use AppUser\User\Models\User;
use AppUser\User\Services\JwtService;
use AppUser\User\Http\Resources\UserResource; 
use Response;
use Hash;
use Exception;

class UserController extends Controller
{
    public function registerUser()
    {
        $NewUser = new User();
        $NewUser->username = input("username"); 
        $NewUser->password = input("password"); 

        $NewUser->token = ""; // token gets updated in JwtService
        $NewUser->save();

        $JwtToken = JwtService::CreateNewJwtToken($NewUser->id);

        $response = Response::make();
        return $response->withCookie('token', $JwtToken, 3600, "/", null, true, true);
    }

    public function loginUser()
    {
        $UserQuery = User::where("username", input("username"))->first();

        if (!$UserQuery) {
            throw new Exception("User doesnt exist",400);
        }

        if (!Hash::check(input("password"), $UserQuery->password)) {
            throw new Exception("Incorrect password",400);
        }

        // REVIEW - Toto je tu 2 krát zbytočne
        $UserQuery = User::where("username", input("username"))->first();

        $JwtToken = JwtService::CreateNewJwtToken($UserQuery->id);

        $response = Response::make();
        return $response->withCookie('token', $JwtToken, 3600, "/", null, true, true);
    }

    public function logOut()
    {
        $userData = JwtService::GetUserFromCookie();

        if ($userData) {
            $userData->update(["token" => ""]);
            $response = Response::make("Successfully logged out", 200);
            return $response->withoutCookie("token");
        }else {
            $response = Response::make("Already logged out or your cookie was expired", 200);
            return $response->withoutCookie("token"); //just in case
        }
    }

    public function Users(){
        // REVIEW - Tip - Tu nepotrebuješ response()->json(), collection() by mala vracať json
        return response()->json(UserResource::collection(User::all()),200);
    }
}