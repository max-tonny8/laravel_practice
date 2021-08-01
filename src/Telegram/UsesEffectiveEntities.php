<?php

namespace Tii\LaravelTelegramBot\Telegram;

use Longman\TelegramBot\Entities\Chat;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\User;

/**
 * @method getUpdate(): Update
 */
trait UsesEffectiveEntities
{

    protected function getEffectiveUser(): ?User
    {
        $update = $this->getUpdate();

        if (! $update) {
            return null;
        }

        $data = $update->getRawData();
        $type = $update->getUpdateType();

        $user = $data[$type]['from']
            ?? $data['poll_answer']['user']
            ?? null;

        return $user ? new User($user) : null;
    }

    protected function getEffectiveChat(): ?Chat
    {
        $update = $this->getUpdate();

        if (! $update) {
            return null;
        }

        $data = $update->getRawData();
        $type = $update->getUpdateType();

        $chat = $data[$type]['chat']
            ?? $data['callback_query']['message']['chat']
            ?? null;

        return $chat ? new Chat($chat) : null;
    }

    protected function getEffectiveMessage(): ?Message
    {
        $update = $this->getUpdate();

        if (! $update) {
            return null;
        }

        $data = $update->getRawData();
        $message = $data['edited_channel_post']
            ?? $data['channel_post']
            ?? $data['callback_query']['message']
            ?? $data['edited_message']
            ?? $data['message']
            ?? null;

        return $message ? new Message($message) : null;
    }

}