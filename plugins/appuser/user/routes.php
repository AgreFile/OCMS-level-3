<?php
use AppUser\User\Http\Controllers\UserController;
use AppUser\User\Http\Middleware\UserAuthorization;

Route::group(
    [
        "prefix" => "api/v1/user"
    ],
    function () {
        Route::post('register', [UserController::class, "registerUser"]);
        Route::post('login', [UserController::class, "loginUser"]);
        Route::post('logout', [UserController::class, "logOut"]);
        Route::get('users', [UserController::class, "Users"])->middleware(UserAuthorization::class);
    }
);