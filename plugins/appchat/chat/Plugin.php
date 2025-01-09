<?php namespace AppChat\Chat;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Chat',
            'description' => 'No description provided yet...',
            'author' => 'AppChat',
            'icon' => 'icon-leaf'
        ];
    }

    public function register()
    {
    }

    public function registerNavigation()
    {
        return [
            'chat' => [
                'label' => 'Reaction Emojis',
                'url' => Backend::url('appchat/chat/emoji'),
                'icon' => 'icon-leaf',
                'permissions' => ['appchat.chat.*'],
                'order' => 500,
            ],
        ];
    }
}
