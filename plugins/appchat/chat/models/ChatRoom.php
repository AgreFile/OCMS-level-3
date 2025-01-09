<?php namespace AppChat\Chat\Models;

use Model;
use AppUser\User\Models\User;

class ChatRoom extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'appchat_chat_chat_rooms';

    public $hasMany = [
        'messages' => [Message::class]
    ];

    public $belongsToMany = [
        "users" => [User::class,"table"=> "user_chat_room"]
    ];

    public $rules = [
        
    ];
}
