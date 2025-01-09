<?php namespace AppUser\User\Models;

use AppChat\Chat\Models\Reaction;
use Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;

    public $table = 'appuser_user_users';

    public $hasMany = [
        "messages" => [\AppChat\Chat\Models\Message::class]
    ];

    public $belongsToMany = [
        "chat_rooms" => [\AppChat\Chat\Models\ChatRoom::class,"table"=> "user_chat_room"]
    ];

    protected $hashable = ["password"];

    public $rules = [
        'password' => ['required:create'],
        'username' => ['required:create', "between:3,32", "alpha_dash", "unique"],
    ];
}
