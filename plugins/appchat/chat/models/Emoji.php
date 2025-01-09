<?php namespace AppChat\Chat\Models;

use Model;

/**
 * Emoji Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Emoji extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_emoji';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
