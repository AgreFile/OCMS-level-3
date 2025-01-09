<?php namespace AppChat\Chat\Models;

use AppUser\User\Models\Users;
use Model;
use AppChat\Chat\Models\Message;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Reaction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_reactions';

    public $belongsToMany = [
        "messages" => [Message::class, "table"=> "reaction_message"]
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
