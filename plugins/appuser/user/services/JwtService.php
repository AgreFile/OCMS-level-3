<?php 
namespace AppUser\User\Services;

use Cookie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use AppUser\User\Models\User;

class JwtService
{
    public static function CreateNewJwtToken(int $userId)
    {
        $JwtTokenPayload = [
            'iss' => "AppUser/User", // Issuer
            'sub' => $userId, // Subject (user ID)
            'iat' => time(), // Issued at
            'exp' => time() + 3600 // Expiration
        ];

        $JwtToken = JWT::encode($JwtTokenPayload, env("JWT_SECRET"), "HS256");

        User::where("id", $userId)->update(["token" => $JwtToken]);

        return $JwtToken;
    }

    public static function DecodeJwtToken($jwt_token)
    {
        return JWT::decode($jwt_token, new Key(env("JWT_SECRET"), "HS256"));
    }

    public static function ValidateToken(string $jwt_token)
    {
        //checks if token is nothing or if it is a jwt token (with the 2 dots) (46 is ascii code for the dot character)
        if (trim($jwt_token) == "" || count_chars($jwt_token, 1)[46] != 2) {
            return;
        }

        try {
            $decodedJwtToken = JwtService::DecodeJwtToken($jwt_token);
        } catch (ExpiredException $expiredException) {
            return "expired_cookie";
        }

        $userId = $decodedJwtToken->sub;

        $userIdQuery = User::where("id", $userId)->get();

        if ($userIdQuery->isEmpty()) {
            return;
        }

        if ($userIdQuery[0]->token != $jwt_token) {
            return;
        }

        return true;
    }

    public static function GetUser(string $jwt_token)
    {
        if (!JwtService::ValidateToken($jwt_token)) {
            return;
        }

        $decodedJwtToken = JwtService::DecodeJwtToken($jwt_token); //JWT::decode($jwt_token, new Key(env("JWT_SECRET"), "HS256"));

        $userId = $decodedJwtToken->sub;

        $userIdQuery = User::where("id", $userId);

        return $userIdQuery;
    }

    public static function GetValidatedTokenFromCookie()
    {
        $tokenCookie = Cookie::get("token");
        if (!$tokenCookie) {
            return;
        }

        if (!JwtService::ValidateToken($tokenCookie)) {
            return;
        }

        return $tokenCookie;
    }

    public static function GetUserIdFromCookie()
    {
        $tokenCookie = Cookie::get("token");
        if (!$tokenCookie) {
            return;
        }

        if (!JwtService::ValidateToken($tokenCookie)) {
            return;
        }

        $decodedToken = JwtService::DecodeJwtToken($tokenCookie);

        return $decodedToken->sub;
    }

    public static function GetUserFromCookie()
    {
        $validatedToken = JwtService::GetValidatedTokenFromCookie();

        if (!$validatedToken || $validatedToken == "expired_cookie") {
            return;
        }

        return JwtService::GetUser($validatedToken);
    }
}
