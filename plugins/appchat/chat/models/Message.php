<?php 
namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use AppChat\Chat\Models\Reaction;
use Model;

class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'appchat_chat_messages';

    public $belongsTo = [
        'chat_room' => [ChatRoom::class],
        'user' => [User::class]
    ];

    public $belongsToMany = [
        "reactions" => [Reaction::class, "table"=> "reaction_message"]
    ];

    public $attachOne = [
        "file_attacment" => \System\Models\File::class
    ];

    public $rules = [];
}
