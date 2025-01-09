<?php
use AppChat\Chat\Http\Controllers\ChatController;
use AppChat\Chat\Http\Middleware\ChatAuthorization;
use AppChat\Chat\Http\Middleware\UserAuthorization;

Route::group(
    [
        "prefix" => "api/v1/chat"
    ],
    function () {
        Route::post('createchat', [ChatController::class, "CreateChat"])->middleware(UserAuthorization::class);
        Route::get('chatrooms', [ChatController::class, "Chatrooms"])->middleware(UserAuthorization::class);

        Route::post('sendmessage', [ChatController::class, "SendMessage"])->middleware(ChatAuthorization::class);
        Route::get('messages', [ChatController::class, "Messages"])->middleware(ChatAuthorization::class);
        
        Route::get('reactions', [ChatController::class, "Reactions"]); //this gets all of the available emojis a user can react with
        Route::post('messagereact', [ChatController::class, "ReactToAMessage"])->middleware(ChatAuthorization::class);
        
        Route::post('changechatroomname', [ChatController::class, "ChangeChatRoomName"])->middleware(ChatAuthorization::class);
    }
);